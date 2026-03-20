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
            'name' => ['required', 'string', 'max:255'],
            'aadhar' => ['required', 'string', 'max:255'],
            'license_no' => ['required', 'string', 'max:255'],
            'specialization' => ['required', 'string', 'max:255'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'experience' => ['required', 'integer', 'min:0'],
            'clinic_address' => ['nullable', 'string'],
            'photo' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'aadhar_photo' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }

    private function storeUpload(Request $request, string $field, ?string $existingPath = null): ?string
    {
        if (!$request->hasFile($field)) {
            return $existingPath;
        }

        $file = $request->file($field);
        $filename = time() . '_' . $field . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
        $destination = public_path('uploads/doctors');

        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        $file->move($destination, $filename);

        return 'uploads/doctors/' . $filename;
    }
}
