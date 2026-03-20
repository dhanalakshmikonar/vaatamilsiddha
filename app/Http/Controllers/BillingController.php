<?php

namespace App\Http\Controllers;

use App\Models\Patient;

class BillingController extends Controller
{
    public function index()
    {
        $patients = Patient::with('patientMedicines.medicine')
            ->latest()
            ->get();

        return view('billing.index', compact('patients'));
    }

    public function show($id)
    {
        $patient = Patient::with('patientMedicines.medicine')->findOrFail($id);

        return view('billing.show', compact('patient'));
    }
}
