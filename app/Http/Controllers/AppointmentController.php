<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'asc')
            ->get();

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();

        // Identify default doctor (Uma Petchi)
        $defaultDoctor = $doctors->first(function ($doctor) {
            return stripos($doctor->name, 'Uma Petchi') !== false;
        }) ?? $doctors->first();

        return view('appointments.create', compact('patients', 'doctors', 'defaultDoctor'));
    }

    private function validateAppointment(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'doctor_id' => ['required', 'integer', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date', 'date_format:Y-m-d', $isUpdate ? 'nullable' : 'after_or_equal:today'],
            'appointment_time' => ['required', 'string', 'regex:/^(?:[01]\d|2[0-3]):[0-5]\d(?::[0-5]\d)?$/'],
            'notes' => ['nullable', 'string', 'max:1000', 'regex:/^[\pL0-9\s,.\-#\/()\'":;%&+=!?\r\n\t]+$/u'],
        ], [
            'patient_id.required' => 'Please select a registered patient.',
            'patient_id.exists' => 'The selected patient does not exist.',
            'doctor_id.required' => 'Please select a consulting doctor.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'appointment_date.required' => 'The consultation date is required.',
            'appointment_date.date_format' => 'The consultation date format must be YYYY-MM-DD.',
            'appointment_date.after_or_equal' => 'Appointments cannot be scheduled for a past date. Please select today or a future date.',
            'appointment_time.required' => 'The consultation time is required.',
            'appointment_time.regex' => 'The consultation time must be in HH:MM format.',
            'notes.regex' => 'The notes contain invalid characters.',
            'notes.max' => 'Notes cannot exceed 1000 characters.',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateAppointment($request, false);

        Appointment::create($data + ['status' => 'Scheduled']);

        return redirect('/appointments')->with('success', 'Appointment scheduled successfully.');
    }

    public function edit($id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->findOrFail($id);
        $patients = Patient::orderBy('name')->get();
        $doctors = Doctor::orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $data = $this->validateAppointment($request, true);

        $appointment->update($data);

        return redirect('/appointments')->with('success', 'Appointment updated successfully.');
    }

    public function markAttendance(Request $request, $id)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['Visited', 'Not Visited'])],
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update(['status' => $data['status']]);

        return redirect('/appointments')->with('success', 'Appointment attendance updated.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect('/appointments')->with('success', 'Appointment deleted successfully.');
    }
}
