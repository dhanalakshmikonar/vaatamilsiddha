<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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

        return view('patients.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePatient($request);

        DB::transaction(function () use ($data) {
            [$items, $totalAmount] = $this->prepareMedicineItems($data);

            $patient = Patient::create([
                'name' => $data['name'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'phone' => $data['phone'] ?? null,
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

        return view('patients.edit', compact('patient', 'medicines'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);
        $data = $this->validatePatient($request);

        DB::transaction(function () use ($patient, $data) {
            foreach ($patient->patientMedicines as $existingItem) {
                $existingItem->medicine->increment('stock', $existingItem->quantity);
            }

            [$items, $totalAmount] = $this->prepareMedicineItems($data);

            $patient->update([
                'name' => $data['name'],
                'age' => $data['age'],
                'gender' => $data['gender'],
                'phone' => $data['phone'] ?? null,
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
                $item->medicine->increment('stock', $item->quantity);
            }

            $patient->delete();
        });

        return redirect('/patients');
    }

    public function show($id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);

        return view('patients.view', compact('patient'));
    }

    private function validatePatient(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'age' => ['required', 'integer', 'min:0'],
            'gender' => ['required', 'string', 'max:50'],
            'phone' => ['nullable', 'string', 'max:20'],
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

            $unitPrice = (float) $medicine->cost;
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
}
