@extends('layout.app')

@section('content')

<div class="form-container">

    @if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:14px 18px;border-radius:12px;margin-bottom:24px;border:1px solid #fecaca;font-size:13.5px;">
        <div style="font-weight:700;margin-bottom:4px;"><i class="fa-solid fa-circle-exclamation"></i> Please fix the following errors:</div>
        <ul style="margin-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="form-header">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <div>
                <h2><i class="fa-solid fa-pen-to-square" style="color:var(--primary);margin-right:8px;"></i>Edit Doctor Certificate</h2>
                <p>Update medical details, leave period, or doctor recommendations.</p>
            </div>
            <a href="/certificates" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Certificates
            </a>
        </div>
    </div>

    <form method="POST" action="/certificates/{{ $certificate->id }}" id="certificateForm">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <!-- Patient Selection -->
            <div class="form-group full">
                <label for="patient_id">Select Patient <span style="color:#ef4444;">*</span></label>
                <select name="patient_id" id="patient_id" required>
                    <option value="">-- Choose Existing Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" 
                            {{ (old('patient_id', $certificate->patient_id) == $patient->id) ? 'selected' : '' }}>
                            {{ $patient->name }} (Phone: {{ $patient->phone ?: 'N/A' }} • Place: {{ $patient->place ?: 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Diagnosis -->
            <div class="form-group full">
                <label for="diagnosis">Diagnosis / Medical Condition <span style="color:#ef4444;">*</span></label>
                <input type="text" name="diagnosis" id="diagnosis" value="{{ old('diagnosis', $certificate->diagnosis) }}" required>
            </div>

            <!-- Issue Date -->
            <div class="form-group">
                <label for="date">Certificate Issue Date <span style="color:#ef4444;">*</span></label>
                <input type="date" name="date" id="date" value="{{ old('date', $certificate->date ? $certificate->date->format('Y-m-d') : '') }}" required>
            </div>

            <!-- Certificate Type -->
            <div class="form-group">
                <label for="certificate_type">Certificate Type <span style="color:#ef4444;">*</span></label>
                <select name="certificate_type" id="certificate_type" required>
                    <option value="Corporate" {{ old('certificate_type', $certificate->certificate_type) === 'Corporate' ? 'selected' : '' }}>Corporate (Workplace / Office)</option>
                    <option value="School" {{ old('certificate_type', $certificate->certificate_type) === 'School' ? 'selected' : '' }}>School (School / College / Student)</option>
                </select>
            </div>

            <!-- Leave From -->
            <div class="form-group">
                <label for="leave_from">Leave Recommended From <span style="color:#ef4444;">*</span></label>
                <input type="date" name="leave_from" id="leave_from" value="{{ old('leave_from', $certificate->leave_from ? $certificate->leave_from->format('Y-m-d') : '') }}" required onchange="updateLeaveToMin()">
            </div>

            <!-- Leave To -->
            <div class="form-group">
                <label for="leave_to">Leave Recommended To <span style="color:#ef4444;">*</span></label>
                <input type="date" name="leave_to" id="leave_to" value="{{ old('leave_to', $certificate->leave_to ? $certificate->leave_to->format('Y-m-d') : '') }}" required>
            </div>

            <!-- Attending Doctor -->
            <div class="form-group full">
                <label for="doctor_id">Attending Doctor <span style="color:#ef4444;">*</span></label>
                <select name="doctor_id" id="doctor_id" required>
                    <option value="">-- Choose Existing Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ (old('doctor_id', $certificate->doctor_id) == $doctor->id) ? 'selected' : '' }}>
                            Dr. {{ $doctor->name }} ({{ $doctor->qualification ?: $doctor->specialization }} • Reg: {{ $doctor->license_no }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Doctor Description -->
            <div class="form-group full">
                <label for="doctor_description">Doctor's Description / Medical Advice & Recommendation <span style="color:#ef4444;">*</span></label>
                <textarea name="doctor_description" id="doctor_description" rows="5" required>{{ old('doctor_description', $certificate->doctor_description) }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-floppy-disk"></i> Update Certificate
            </button>
            <a href="/certificates/{{ $certificate->id }}" class="ghost-btn">
                <i class="fa-solid fa-eye"></i> View Certificate
            </a>
            <a href="/certificates" class="ghost-btn">Cancel</a>
        </div>

    </form>

</div>

@push('scripts')
<script>
    function updateLeaveToMin() {
        const leaveFrom = document.getElementById('leave_from').value;
        const leaveTo = document.getElementById('leave_to');
        if (leaveFrom) {
            leaveTo.min = leaveFrom;
            if (leaveTo.value && leaveTo.value < leaveFrom) {
                leaveTo.value = leaveFrom;
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        updateLeaveToMin();
    });
</script>
@endpush

@endsection
