<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorCertificate;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DoctorCertificateController extends Controller
{
    public function index()
    {
        $certificates = DoctorCertificate::with(['patient', 'doctor'])
            ->latest('date')
            ->latest('id')
            ->get();

        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();

        return view('certificates.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $data = $this->validateCertificate($request);

        $certificate = DoctorCertificate::create($data);

        return redirect('/certificates/' . $certificate->id)
            ->with('success', 'Doctor certificate generated successfully.');
    }

    public function show($id)
    {
        $certificate = DoctorCertificate::with(['patient', 'doctor'])->findOrFail($id);

        return view('certificates.show', compact('certificate'));
    }

    public function edit($id)
    {
        $certificate = DoctorCertificate::findOrFail($id);
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();

        return view('certificates.edit', compact('certificate', 'patients', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $certificate = DoctorCertificate::findOrFail($id);
        $data = $this->validateCertificate($request);

        $certificate->update($data);

        return redirect('/certificates/' . $certificate->id)
            ->with('success', 'Doctor certificate updated successfully.');
    }

    public function destroy($id)
    {
        $certificate = DoctorCertificate::findOrFail($id);
        $certificate->delete();

        return redirect('/certificates')
            ->with('success', 'Doctor certificate deleted successfully.');
    }

    private function validateCertificate(Request $request): array
    {
        return $request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'diagnosis' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'leave_from' => ['required', 'date'],
            'leave_to' => ['required', 'date', 'after_or_equal:leave_from'],
            'certificate_type' => ['required', 'string', Rule::in(['Corporate', 'School'])],
            'doctor_description' => ['required', 'string'],
        ], [
            'leave_to.after_or_equal' => 'The Leave To date must be on or after the Leave From date.',
        ]);
    }
}
