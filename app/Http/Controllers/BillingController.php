<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Support\SimpleSpreadsheetExporter;
use App\Support\TherapyOptions;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillingController extends Controller
{
    public function index()
    {
        $patients = Patient::with('patientMedicines.medicine')
            ->latest()
            ->get();

        $billSummaries = [];

        foreach ($patients as $patient) {
            $billSummaries[$patient->id] = $this->buildBillSummary($patient);
        }

        return view('billing.index', compact('patients', 'billSummaries'));
    }

    public function create()
    {
        $medicines = Medicine::orderBy('name')->get();

        return view('billing.create', [
            'medicines' => $medicines,
            'therapyOptions' => TherapyOptions::all(),
        ]);
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => ['nullable', 'integer', 'exists:medicines,id'],
            'therapy' => ['nullable', 'string', Rule::in(TherapyOptions::keys())],
            'appointment' => ['nullable', 'numeric', 'min:0'],
        ]);

        $medicine = null;
        $medicineAmount = 0.0;

        if (!empty($validated['medicine_id'])) {
            $medicine = Medicine::find($validated['medicine_id']);
            $medicineAmount = (float) ($medicine->selling_price ?: $medicine->cost_price ?: $medicine->cost ?: 0);
        }

        $therapyKey = $validated['therapy'] ?? '';
        $therapyAmount = TherapyOptions::amount($therapyKey);
        $appointmentAmount = (float) ($validated['appointment'] ?? 0);
        $totalAmount = $medicineAmount + $therapyAmount + $appointmentAmount;

        return view('billing.preview', [
            'medicine' => $medicine,
            'medicineAmount' => $medicineAmount,
            'therapyKey' => $therapyKey,
            'therapyAmount' => $therapyAmount,
            'appointmentAmount' => $appointmentAmount,
            'totalAmount' => $totalAmount,
        ]);
    }

    public function show($id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);

        $billSummary = $this->buildBillSummary($patient);

        return view('billing.show', compact('patient', 'billSummary'));
    }

    public function export()
    {
        $patients = Patient::with('patientMedicines.medicine')
            ->latest()
            ->get();

        $rows = [[
            'Patient Name',
            'Visit Date',
            'Phone',
            'Diagnosis',
            'Bill Items',
            'Bill Amount',
        ]];

        foreach ($patients as $patient) {
            $billSummary = $this->buildBillSummary($patient);
            $items = collect($billSummary['items'])
                ->map(function ($item) {
                    return $item['label'] . ' (Rs ' . number_format((float) $item['total'], 2) . ')';
                })
                ->implode(' | ');

            $rows[] = [
                $patient->name,
                $patient->visit_date,
                $patient->phone,
                $patient->diagnosis,
                $items,
                $billSummary['grand_total'],
            ];
        }

        return SimpleSpreadsheetExporter::download(
            'billing_export_' . now()->format('Ymd_His') . '.xlsx',
            $rows,
            'Billing'
        );
    }

    private function buildBillSummary(Patient $patient): array
    {
        $items = [];

        foreach ($patient->patientMedicines as $item) {
            $medicineName = $item->medicine?->name ?: 'Unknown Medicine';
            $items[] = [
                'label' => $medicineName . ' x ' . $item->quantity,
                'quantity' => (int) $item->quantity,
                'unit_price' => (float) $item->unit_price,
                'total' => (float) $item->total_price,
                'type' => 'medicine',
            ];
        }

        $fees = (float) ($patient->fees ?? 0);
        $therapyLabel = TherapyOptions::label($patient->therapy);

        if ($fees > 0) {
            $items[] = [
                'label' => $therapyLabel !== '' ? $therapyLabel : 'Consultation / Fees',
                'quantity' => 1,
                'unit_price' => $fees,
                'total' => $fees,
                'type' => 'fees',
            ];
        }

        $appointmentAmount = (float) ($patient->appointment_amount ?? 0);

        if ($appointmentAmount > 0) {
            $items[] = [
                'label' => 'Appointment',
                'quantity' => 1,
                'unit_price' => $appointmentAmount,
                'total' => $appointmentAmount,
                'type' => 'appointment',
            ];
        }

        $grandTotal = collect($items)->sum('total');

        return [
            'items' => $items,
            'grand_total' => $grandTotal,
        ];
    }
}
