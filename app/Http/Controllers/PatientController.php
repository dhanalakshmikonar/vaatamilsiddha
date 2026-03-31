<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Support\SimpleSpreadsheetExporter;
use App\Support\SimpleSpreadsheetImporter;
use App\Support\TherapyOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->get();

        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $medicines = Medicine::orderBy('name')->get();

        return view('patients.create', [
            'medicines' => $medicines,
            'medicinesData' => $this->formatMedicinesForView($medicines),
            'therapyOptions' => TherapyOptions::all(),
            'historyFields' => $this->patientHistoryFields(),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file'],
        ]);

        $extension = strtolower($request->file('file')->getClientOriginalExtension());

        if (!in_array($extension, ['csv', 'xlsx'], true)) {
            return redirect('/patients')->with('error', 'Only .csv and .xlsx files are supported.');
        }

        try {
            $rows = SimpleSpreadsheetImporter::parse($request->file('file')->getRealPath(), $extension);
        } catch (RuntimeException $exception) {
            return redirect('/patients')->with('error', $exception->getMessage());
        }

        if (count($rows) < 2) {
            return redirect('/patients')->with('error', 'Upload a file with a header row and at least one patient row.');
        }

        $headers = array_map(fn ($header) => strtolower(trim((string) $header)), $rows[0]);
        $imported = 0;

        foreach (array_slice($rows, 1) as $row) {
            $data = array_combine($headers, array_pad($row, count($headers), null));

            if (!isset($data['name']) || trim((string) $data['name']) === '') {
                continue;
            }

            $therapy = $this->resolveTherapyKey($data['therapy'] ?? null);
            $fees = TherapyOptions::amount($therapy);
            $appointmentAmount = (float) ($data['appointment_amount'] ?? $data['appointment'] ?? 0);

            Patient::create([
                'name' => trim((string) $data['name']),
                'age' => (int) ($data['age'] ?? 0),
                'gender' => trim((string) ($data['gender'] ?? 'Other')),
                'phone' => trim((string) ($data['phone'] ?? '')),
                'place' => trim((string) ($data['place'] ?? '')),
                'entity' => trim((string) ($data['entity'] ?? '')),
                'payment_mode' => trim((string) ($data['payment_mode'] ?? '')),
                'fees' => $fees,
                'therapy' => $therapy,
                'appointment_amount' => $appointmentAmount,
                'patient_history' => $this->normalizePatientHistory([]),
                'visit_date' => !empty($data['visit_date']) ? $data['visit_date'] : now()->toDateString(),
                'diagnosis' => trim((string) ($data['diagnosis'] ?? '')),
                'total_amount' => $fees + $appointmentAmount,
            ]);

            $imported++;
        }

        return redirect('/patients')->with('success', $imported . ' patient rows imported successfully.');
    }

    public function clearImported()
    {
        DB::transaction(function () {
            $patients = Patient::with('patientMedicines.medicine')->get();

            foreach ($patients as $patient) {
                foreach ($patient->patientMedicines as $item) {
                    if ($item->medicine) {
                        $item->medicine->increment('stock', $item->quantity);
                    }
                }

                $patient->delete();
            }
        });

        return redirect('/patients')->with('success', 'All imported patient records were deleted successfully.');
    }

    public function export()
    {
        $patients = Patient::with('patientMedicines.medicine')
            ->latest()
            ->get();

        $rows = [[
            'Name',
            'Age',
            'Gender',
            'Phone',
            'Place',
            'Entity',
            'Payment Mode',
            'Therapy',
            'Therapy Amount',
            'Appointment Amount',
            'Visit Date',
            'Diagnosis',
            'Medicines',
            'Total Amount',
        ]];

        foreach ($patients as $patient) {
            $medicineSummary = $patient->patientMedicines
                ->map(function ($item) {
                    $medicineName = $item->medicine?->name ?: 'Unknown';
                    return $medicineName . ' x ' . $item->quantity;
                })
                ->implode(', ');

            $rows[] = [
                $patient->name,
                $patient->age,
                $patient->gender,
                $patient->phone,
                $patient->place,
                $patient->entity,
                $patient->payment_mode,
                TherapyOptions::label($patient->therapy),
                $patient->fees,
                $patient->appointment_amount,
                $patient->visit_date,
                $patient->diagnosis,
                $medicineSummary,
                $patient->total_amount,
            ];
        }

        return SimpleSpreadsheetExporter::download(
            'patients_export_' . now()->format('Ymd_His') . '.xlsx',
            $rows,
            'Patients'
        );
    }

    public function store(Request $request)
    {
        $data = $this->validatePatient($request);

        DB::transaction(function () use ($data) {
            [$items, $medicineTotal] = $this->prepareMedicineItems($data);
            $fees = TherapyOptions::amount($data['therapy'] ?? null);
            $appointmentAmount = (float) ($data['appointment_amount'] ?? 0);
            $totalAmount = $medicineTotal + $fees + $appointmentAmount;

            $patient = Patient::create([
                'name' => $data['name'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'phone' => $data['phone'] ?? null,
                'place' => $data['place'] ?? null,
                'entity' => $data['entity'] ?? null,
                'payment_mode' => $data['payment_mode'] ?? null,
                'fees' => $fees,
                'therapy' => $data['therapy'] ?? null,
                'appointment_amount' => $appointmentAmount,
                'patient_history' => $this->normalizePatientHistory($data['patient_history'] ?? []),
                'visit_date' => $data['visit_date'],
                'diagnosis' => $data['diagnosis'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            foreach ($items as $item) {
                $medicine = $item['medicine'];
                unset($item['medicine']);

                $patient->patientMedicines()->create($item);
                $medicine->decrement('stock', $item['quantity']);
            }
        });

        return redirect('/patients');
    }

    public function edit($id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);
        $medicines = Medicine::orderBy('name')->get();

        return view('patients.edit', [
            'patient' => $patient,
            'medicines' => $medicines,
            'medicinesData' => $this->formatMedicinesForView($medicines),
            'existingMedicineItems' => $this->formatExistingItemsForView($patient),
            'therapyOptions' => TherapyOptions::all(),
            'historyFields' => $this->patientHistoryFields(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);
        $data = $this->validatePatient($request);

        DB::transaction(function () use ($patient, $data) {
            foreach ($patient->patientMedicines as $existingItem) {
                if ($existingItem->medicine) {
                    $existingItem->medicine->increment('stock', $existingItem->quantity);
                }
            }

            [$items, $medicineTotal] = $this->prepareMedicineItems($data);
            $fees = TherapyOptions::amount($data['therapy'] ?? null);
            $appointmentAmount = (float) ($data['appointment_amount'] ?? 0);
            $totalAmount = $medicineTotal + $fees + $appointmentAmount;

            $patient->update([
                'name' => $data['name'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'phone' => $data['phone'] ?? null,
                'place' => $data['place'] ?? null,
                'entity' => $data['entity'] ?? null,
                'payment_mode' => $data['payment_mode'] ?? null,
                'fees' => $fees,
                'therapy' => $data['therapy'] ?? null,
                'appointment_amount' => $appointmentAmount,
                'patient_history' => $this->normalizePatientHistory($data['patient_history'] ?? []),
                'visit_date' => $data['visit_date'],
                'diagnosis' => $data['diagnosis'] ?? null,
                'total_amount' => $totalAmount,
            ]);

            $patient->patientMedicines()->delete();

            foreach ($items as $item) {
                $medicine = $item['medicine'];
                unset($item['medicine']);

                $patient->patientMedicines()->create($item);
                $medicine->decrement('stock', $item['quantity']);
            }
        });

        return redirect('/patients');
    }

    public function destroy($id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);

        DB::transaction(function () use ($patient) {
            foreach ($patient->patientMedicines as $item) {
                if ($item->medicine) {
                    $item->medicine->increment('stock', $item->quantity);
                }
            }

            $patient->delete();
        });

        return redirect('/patients')->with('success', 'Patient deleted successfully.');
    }

    public function show($id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);

        return view('patients.view', [
            'patient' => $patient,
            'historyFields' => $this->patientHistoryFields(),
        ]);
    }

    private function validatePatient(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'gender' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
            'place' => ['nullable', 'string', 'max:255'],
            'entity' => ['nullable', 'string', 'max:255'],
            'payment_mode' => ['nullable', 'string', 'max:100'],
            'therapy' => ['nullable', 'string', 'in:' . implode(',', TherapyOptions::keys())],
            'appointment_amount' => ['nullable', 'numeric', 'min:0'],
            'patient_history' => ['nullable', 'array'],
            'no_patient_history' => ['nullable', 'boolean'],
            'patient_history.*' => ['nullable', 'in:y,n,-'],
            'visit_date' => ['required', 'date'],
            'diagnosis' => ['nullable', 'string'],
            'medicine_id' => ['nullable', 'array'],
            'medicine_id.*' => ['nullable', 'integer', 'exists:medicines,id'],
            'quantity' => ['nullable', 'array'],
            'quantity.*' => ['nullable', 'integer', 'min:1'],
        ]);
    }

    private function prepareMedicineItems(array $data): array
    {
        $medicineIds = $data['medicine_id'] ?? [];
        $quantities = $data['quantity'] ?? [];
        $items = [];
        $totalAmount = 0;

        foreach ($medicineIds as $index => $medicineId) {
            $quantity = isset($quantities[$index]) ? (int) $quantities[$index] : 0;

            if (!$medicineId || $quantity < 1) {
                continue;
            }

            $medicine = Medicine::findOrFail($medicineId);

            if ($medicine->stock < $quantity) {
                throw ValidationException::withMessages([
                    "quantity.$index" => "Only {$medicine->stock} units available for {$medicine->name}.",
                ]);
            }

            $unitPrice = (float) ($medicine->selling_price ?: $medicine->cost);
            $lineTotal = $unitPrice * $quantity;

            $items[] = [
                'medicine_id' => $medicine->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'total_price' => $lineTotal,
                'medicine' => $medicine,
            ];

            $totalAmount += $lineTotal;
        }

        return [$items, $totalAmount];
    }

    private function formatMedicinesForView($medicines): array
    {
        $formatted = [];

        foreach ($medicines as $medicine) {
            $formatted[] = [
                'id' => $medicine->id,
                'name' => $medicine->name,
                'cost' => (float) $medicine->cost,
                'selling_price' => (float) ($medicine->selling_price ?? 0),
                'stock' => (int) $medicine->stock,
            ];
        }

        return $formatted;
    }

    private function formatExistingItemsForView(Patient $patient): array
    {
        $formatted = [];

        foreach ($patient->patientMedicines as $item) {
            $formatted[] = [
                'medicine_id' => $item->medicine_id,
                'quantity' => $item->quantity,
            ];
        }

        return $formatted;
    }

    private function resolveTherapyKey(mixed $value): ?string
    {
        $normalized = trim(strtolower((string) $value));

        if ($normalized === '') {
            return null;
        }

        foreach (TherapyOptions::all() as $key => $option) {
            $label = strtolower($option['label']);

            if ($normalized === $key || $normalized === $label) {
                return $key;
            }
        }

        return null;
    }

    private function patientHistoryFields(): array
    {
        return [
            'diabetes_mellitus' => 'Diabetes mellitus',
            'hypertension' => 'Hypertension',
            'hypothyroidism' => 'Hypothyroidism',
            'alcohol' => 'Alcohol',
            'tobacco' => 'Tobacco',
            'smoke' => 'Smoke',
        ];
    }

    private function normalizePatientHistory(array $history): array
    {
        $normalized = [];

        foreach (array_keys($this->patientHistoryFields()) as $field) {
            $value = strtolower((string) ($history[$field] ?? '-'));
            $normalized[$field] = in_array($value, ['y', 'n', '-'], true) ? $value : '-';
        }

        return $normalized;
    }
}


