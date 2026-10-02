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
            'diagnosis' => ['required', 'string', 'max:500', 'regex:/^[\pL0-9\s,.\-#\/()\'":;%&+=!?\r\n\t]+$/u'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'leave_from' => ['required', 'date', 'date_format:Y-m-d'],
            'leave_to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:leave_from'],
            'certificate_type' => ['required', 'string', Rule::in(['Corporate', 'School'])],
            'doctor_description' => ['required', 'string', 'max:3000', 'regex:/^[\pL0-9\s,.\-#\/()\'":;%&+=!?\r\n\t]+$/u'],
        ], [
            'patient_id.required' => 'Please select an existing patient.',
            'patient_id.exists' => 'The selected patient does not exist.',
            'doctor_id.required' => 'Please select an attending doctor.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'diagnosis.required' => 'The diagnosis/medical condition is required.',
            'diagnosis.regex' => 'The diagnosis contains invalid characters.',
            'diagnosis.max' => 'The diagnosis must not exceed 500 characters.',
            'date.required' => 'The certificate issue date is required.',
            'date.date_format' => 'The certificate date format must be YYYY-MM-DD.',
            'leave_from.required' => 'The Leave From date is required.',
            'leave_from.date_format' => 'The Leave From date format must be YYYY-MM-DD.',
            'leave_to.required' => 'The Leave To date is required.',
            'leave_to.date_format' => 'The Leave To date format must be YYYY-MM-DD.',
            'leave_to.after_or_equal' => 'The Leave To date must be on or after the Leave From date.',
            'certificate_type.required' => 'Please select a certificate type.',
            'certificate_type.in' => 'The certificate type must be either Corporate or School.',
            'doctor_description.required' => 'The doctor description / medical advice is required.',
            'doctor_description.regex' => 'The doctor description contains invalid characters.',
            'doctor_description.max' => 'The doctor description must not exceed 3000 characters.',
        ]);
    }
}
