<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Patient;
use App\Support\SimpleSpreadsheetExporter;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BillingController extends Controller
{
    private const THERAPY_AMOUNTS = [
        'consultation' => 200,
        'quarter_massage' => 800,
        'half_back_massage' => 500,
        'full_body_massage' => 1000,
        'navarakili_massage' => 1000,
        'leg_massage' => 750,
    ];

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
            'therapyOptions' => self::THERAPY_AMOUNTS,
        ]);
    }

    public function preview(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => ['nullable', 'integer', 'exists:medicines,id'],
            'therapy' => ['nullable', 'string', Rule::in(array_keys(self::THERAPY_AMOUNTS))],
            'appointment' => ['nullable', 'numeric', 'min:0'],
        ]);

        $medicine = null;
        $medicineAmount = 0.0;

        if (!empty($validated['medicine_id'])) {
            $medicine = Medicine::find($validated['medicine_id']);
            $medicineAmount = (float) ($medicine->selling_price ?: $medicine->cost_price ?: $medicine->cost ?: 0);
        }

        $therapyKey = $validated['therapy'] ?? '';
        $therapyAmount = (float) (self::THERAPY_AMOUNTS[$therapyKey] ?? 0);
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

        if ($fees > 0) {
            $items[] = [
                'label' => 'Consultation / Fees',
                'quantity' => 1,
                'unit_price' => $fees,
                'total' => $fees,
                'type' => 'fees',
            ];
        }

        $grandTotal = collect($items)->sum('total');

        return [
            'items' => $items,
            'grand_total' => $grandTotal,
        ];
    }
}

