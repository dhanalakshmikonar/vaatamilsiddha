@extends('layout.app')

@section('content')

<div class="form-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-calendar-plus" style="color:var(--primary);margin-right:8px;"></i> Book New Appointment</h2>
        <p>Select a registered patient, choose the consulting doctor, set schedule, and record notes.</p>
    </div>

    @if (isset($errors) && $errors->any())
    <div class="alert-error" style="background:#fee2e2;border:1px solid #fecaca;padding:14px 18px;border-radius:12px;margin-bottom:20px;color:#991b1b;">

        <strong style="display:block;margin-bottom:6px;"><i class="fa-solid fa-circle-exclamation"></i> Please correct the following errors:</strong>
        <ul style="margin-left: 20px;font-size:13px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="/appointments" id="appointmentForm">
        @csrf

        <div class="form-grid">

            <div class="form-section-title">
                <i class="fa-solid fa-user-check"></i> Patient Details
            </div>

            <div class="form-group">
                <label for="patient_id">Select Patient <span style="color:#ef4444;">*</span></label>
                <select name="patient_id" id="patient_id" required onchange="updatePatientPhone()">
                    <option value="">-- Choose Registered Patient --</option>
                    @foreach($patients as $patient)
                    <option
                        value="{{ $patient->id }}"
                        data-phone="{{ $patient->phone }}"
                        {{ old('patient_id') == $patient->id ? 'selected' : '' }}
                    >
                        {{ $patient->name }} (Phone: {{ $patient->phone ?: 'N/A' }} | ID: #{{ $patient->id }})
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="patient_phone">Patient Phone Number</label>
                <div style="position:relative;">
                    <input
                        type="text"
                        id="patient_phone"
                        readonly
                        placeholder="Phone automatically populated"
                        style="background:#f8fafc; cursor:not-allowed; padding-left:36px;"
                    >
                    <i class="fa-solid fa-phone" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:13px;"></i>
                </div>
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-stethoscope"></i> Consultation & Doctor
            </div>

            <div class="form-group">
                <label for="doctor_id">Consulting Doctor <span style="color:#ef4444;">*</span></label>
                <select name="doctor_id" id="doctor_id" required>
                    <option value="">-- Choose Doctor --</option>
                    @foreach($doctors as $doctor)
                    <option
                        value="{{ $doctor->id }}"
                        {{ (old('doctor_id', $defaultDoctor?->id) == $doctor->id) ? 'selected' : '' }}
                    >
                        {{ $doctor->name }} {{ $doctor->specialization ? '— ' . $doctor->specialization : '' }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Appointment Status <span style="color:#ef4444;">*</span></label>
                <select name="status" id="status" required>
                    @foreach(['Scheduled', 'Confirmed', 'Completed', 'Cancelled'] as $statusOption)
                    <option value="{{ $statusOption }}" {{ old('status', 'Scheduled') === $statusOption ? 'selected' : '' }}>
                        {{ $statusOption }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-section-title">
                <i class="fa-regular fa-calendar-days"></i> Schedule Slot
            </div>

            <div class="form-group">
                <label for="appointment_date">Consultation Date <span style="color:#ef4444;">*</span></label>
                <input
                    type="date"
                    name="appointment_date"
                    id="appointment_date"
                    value="{{ old('appointment_date', date('Y-m-d')) }}"
                    required
                >
            </div>

            <div class="form-group">
                <label for="appointment_time">Consultation Time <span style="color:#ef4444;">*</span></label>
                <input
                    type="time"
                    name="appointment_time"
                    id="appointment_time"
                    value="{{ old('appointment_time', date('H:i')) }}"
                    required
                >
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-pen-to-square"></i> Clinical & Visit Notes
            </div>

            <div class="form-group full">
                <label for="notes">Optional Notes / Reason for Visit</label>
                <textarea
                    name="notes"
                    id="notes"
                    rows="3"
                    placeholder="Enter any initial symptoms, patient complaints, pulse observation notes, or instructions..."
                >{{ old('notes') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-calendar-check"></i> Save Appointment
            </button>
            <a href="/appointments" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Appointments
            </a>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
function updatePatientPhone() {
    const patientSelect = document.getElementById('patient_id');
    const phoneInput = document.getElementById('patient_phone');
    if (!patientSelect || !phoneInput) return;

    const selectedOption = patientSelect.options[patientSelect.selectedIndex];
    const phone = selectedOption ? selectedOption.getAttribute('data-phone') : '';
    phoneInput.value = phone || '';
}

document.addEventListener('DOMContentLoaded', function() {
    updatePatientPhone();
});
</script>
@endpush
