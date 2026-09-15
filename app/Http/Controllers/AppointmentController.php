<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $data = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:Scheduled,Confirmed,Completed,Cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Appointment::create($data);

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

        $data = $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'appointment_date' => ['required', 'date'],
            'appointment_time' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:Scheduled,Confirmed,Completed,Cancelled'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $appointment->update($data);

        return redirect('/appointments')->with('success', 'Appointment updated successfully.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return redirect('/appointments')->with('success', 'Appointment deleted successfully.');
    }
}
