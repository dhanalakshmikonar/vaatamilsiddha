<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Support\SimpleSpreadsheetExporter;
use App\Support\SimpleSpreadsheetImporter;
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

            Patient::create([
                'name' => trim((string) $data['name']),
                'age' => (int) ($data['age'] ?? 0),
                'gender' => trim((string) ($data['gender'] ?? 'Other')),
                'phone' => trim((string) ($data['phone'] ?? '')),
                'place' => trim((string) ($data['place'] ?? '')),
                'entity' => trim((string) ($data['entity'] ?? '')),
                'payment_mode' => trim((string) ($data['payment_mode'] ?? '')),
                'fees' => (float) ($data['fees'] ?? 0),
                'visit_date' => !empty($data['visit_date']) ? $data['visit_date'] : now()->toDateString(),
                'diagnosis' => trim((string) ($data['diagnosis'] ?? '')),
                'total_amount' => 0,
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
            'Fees',
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
                $patient->fees,
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
            'fees' => ['nullable', 'numeric', 'min:0'],
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
}



