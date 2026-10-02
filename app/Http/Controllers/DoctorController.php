<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::latest()->get();

        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('doctors.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateDoctor($request);

        Doctor::create([
            'name' => $data['name'],
            'aadhar' => $data['aadhar'],
            'license_no' => $data['license_no'],
            'specialization' => $data['specialization'],
            'qualification' => $data['qualification'] ?? null,
            'role' => $data['role'] ?? null,
            'phone' => $data['phone'],
            'experience' => $data['experience'],
            'clinic_address' => $data['clinic_address'] ?? null,
            'photo' => $this->storeUpload($request, 'photo'),
            'aadhar_photo' => $this->storeUpload($request, 'aadhar_photo'),
            'signature' => $this->storeUpload($request, 'signature'),
        ]);

        return redirect('/doctors');
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);

        return view('doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $data = $this->validateDoctor($request, true);

        $doctor->update([
            'name' => $data['name'],
            'aadhar' => $data['aadhar'],
            'license_no' => $data['license_no'],
            'specialization' => $data['specialization'],
            'qualification' => $data['qualification'] ?? null,
            'role' => $data['role'] ?? null,
            'phone' => $data['phone'],
            'experience' => $data['experience'],
            'clinic_address' => $data['clinic_address'] ?? null,
            'photo' => $this->storeUpload($request, 'photo', $doctor->photo),
            'aadhar_photo' => $this->storeUpload($request, 'aadhar_photo', $doctor->aadhar_photo),
            'signature' => $this->storeUpload($request, 'signature', $doctor->signature),
        ]);

        return redirect('/doctors');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();

        return redirect('/doctors');
    }

    private function validateDoctor(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'aadhar' => ['required', 'string', 'regex:/^\d{12}$/'],
            'license_no' => ['required', 'string', 'max:100', 'regex:/^[a-zA-Z0-9\s\-_/]+$/'],
            'specialization' => ['required', 'string', 'max:255', 'regex:/^[\pL0-9\s&,.\-()]+$/u'],
            'qualification' => ['nullable', 'string', 'max:255', 'regex:/^[\pL0-9\s,.\-()]+$/u'],
            'role' => ['nullable', 'string', 'max:255', 'regex:/^[\pL0-9\s,.\-()\/]+$/u'],
            'phone' => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'experience' => ['required', 'integer', 'min:0', 'max:100'],
            'clinic_address' => ['nullable', 'string', 'max:1000', 'regex:/^[\pL0-9\s,.\-#\/()\'":;]+$/u'],
            'photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'aadhar_photo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:10240'],
            'signature' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ], [
            'name.required' => 'The doctor name is required.',
            'name.regex' => 'The doctor name may only contain alphabets and spaces.',
            'aadhar.required' => 'The Aadhar number is required.',
            'aadhar.regex' => 'The Aadhar number must be exactly 12 digits.',
            'license_no.required' => 'The license number is required.',
            'license_no.regex' => 'The license number may only contain letters, numbers, spaces, hyphens, and slashes.',
            'specialization.required' => 'The specialization is required.',
            'specialization.regex' => 'The specialization contains invalid characters.',
            'qualification.regex' => 'The qualification contains invalid characters.',
            'role.regex' => 'The role contains invalid characters.',
            'phone.required' => 'The phone number is required.',
            'phone.regex' => 'The phone number must be exactly 10 digits starting with 6, 7, 8, or 9.',
            'experience.required' => 'The experience is required.',
            'experience.integer' => 'Experience must be a whole number.',
            'experience.min' => 'Experience cannot be negative.',
            'experience.max' => 'Experience cannot exceed 100 years.',
            'clinic_address.regex' => 'The clinic address contains invalid characters.',
            'clinic_address.max' => 'The clinic address must not exceed 1000 characters.',
            'photo.max' => 'The doctor photo must not exceed 10MB.',
            'photo.mimes' => 'The doctor photo must be a file of type: JPG, JPEG, PNG, or WEBP.',
            'aadhar_photo.max' => 'The Aadhar card document must not exceed 10MB.',
            'aadhar_photo.mimes' => 'The Aadhar card document must be a file of type: JPG, JPEG, PNG, WEBP, or PDF.',
            'signature.max' => 'The signature image must not exceed 10MB.',
            'signature.mimes' => 'The signature must be a file of type: JPG, JPEG, PNG, or WEBP.',
        ]);
    }

    private function storeUpload(Request $request, string $field, ?string $existingPath = null): ?string
    {
        if (!$request->hasFile($field) || !$request->file($field)->isValid()) {
            return $existingPath;
        }

        $file = $request->file($field);
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $safeBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = time() . '_' . $field . '_' . substr($safeBase, 0, 30) . '.' . $extension;
        $destination = public_path('uploads/doctors');

        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $filename);

        return 'uploads/doctors/' . $filename;
    }
}
