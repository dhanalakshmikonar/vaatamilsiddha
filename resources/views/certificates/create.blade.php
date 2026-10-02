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
                <h2><i class="fa-solid fa-stamp" style="color:var(--primary);margin-right:8px;"></i>Create Doctor Certificate</h2>
                <p>Generate medical leave recommendations for Corporate or School purposes.</p>
            </div>
            <a href="/certificates" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Certificates
            </a>
        </div>
    </div>

    <form method="POST" action="/certificates" id="certificateForm">
        @csrf

        <div class="form-grid">

            <!-- Patient Selection -->
            <div class="form-group full">
                <label for="patient_id">Select Patient <span style="color:#ef4444;">*</span></label>
                <select name="patient_id" id="patient_id" required onchange="handlePatientChange(this)" class="@error('patient_id') is-invalid @enderror">
                    <option value="">-- Choose Existing Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" 
                            data-diagnosis="{{ $patient->diagnosis }}"
                            data-phone="{{ $patient->phone }}"
                            data-place="{{ $patient->place }}"
                            data-age="{{ $patient->age }}"
                            data-gender="{{ $patient->gender }}"
                            {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} (Phone: {{ $patient->phone ?: 'N/A' }} • Place: {{ $patient->place ?: 'N/A' }})
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Diagnosis -->
            <div class="form-group full">
                <label for="diagnosis">Diagnosis / Medical Condition <span style="color:#ef4444;">*</span></label>
                <input type="text" name="diagnosis" id="diagnosis" value="{{ old('diagnosis') }}" maxlength="500" placeholder="e.g. Acute Lumbago / Viral Fever / Cervical Spondylosis" required class="@error('diagnosis') is-invalid @enderror">
                @error('diagnosis')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Issue Date -->
            <div class="form-group">
                <label for="date">Certificate Issue Date <span style="color:#ef4444;">*</span></label>
                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required class="@error('date') is-invalid @enderror">
                @error('date')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Certificate Type -->
            <div class="form-group">
                <label for="certificate_type">Certificate Type <span style="color:#ef4444;">*</span></label>
                <select name="certificate_type" id="certificate_type" required class="@error('certificate_type') is-invalid @enderror">
                    <option value="Corporate" {{ old('certificate_type') === 'Corporate' ? 'selected' : '' }}>Corporate (Workplace / Office)</option>
                    <option value="School" {{ old('certificate_type') === 'School' ? 'selected' : '' }}>School (School / College / Student)</option>
                </select>
                @error('certificate_type')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Leave From -->
            <div class="form-group">
                <label for="leave_from">Leave Recommended From <span style="color:#ef4444;">*</span></label>
                <input type="date" name="leave_from" id="leave_from" value="{{ old('leave_from', date('Y-m-d')) }}" required onchange="updateLeaveToMin()" class="@error('leave_from') is-invalid @enderror">
                @error('leave_from')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Leave To -->
            <div class="form-group">
                <label for="leave_to">Leave Recommended To <span style="color:#ef4444;">*</span></label>
                <input type="date" name="leave_to" id="leave_to" value="{{ old('leave_to', date('Y-m-d')) }}" required class="@error('leave_to') is-invalid @enderror">
                @error('leave_to')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Attending Doctor -->
            <div class="form-group full">
                <label for="doctor_id">Attending Doctor <span style="color:#ef4444;">*</span></label>
                <select name="doctor_id" id="doctor_id" required class="@error('doctor_id') is-invalid @enderror">
                    <option value="">-- Choose Existing Doctor --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            Dr. {{ $doctor->name }} ({{ $doctor->qualification ?: $doctor->specialization }} • Reg: {{ $doctor->license_no }})
                        </option>
                    @endforeach
                </select>
                @error('doctor_id')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <!-- Doctor Description -->
            <div class="form-group full">
                <label for="doctor_description">Doctor's Description / Medical Advice & Recommendation <span style="color:#ef4444;">*</span></label>
                <textarea name="doctor_description" id="doctor_description" rows="5" maxlength="3000" placeholder="Enter clinical assessment, physical rest recommendation, and fitness status..." required class="@error('doctor_description') is-invalid @enderror">{{ old('doctor_description', "This is to certify that the patient mentioned above has been examined at our clinic and is diagnosed with the condition stated above. The patient has been advised complete rest and medical care for the duration specified above and is expected to resume normal duties thereafter.") }}</textarea>
                @error('doctor_description')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-stamp"></i> Generate Certificate (Next)
            </button>
            <a href="/certificates" class="ghost-btn">Cancel</a>
        </div>

    </form>

</div>

@push('scripts')
<script>
    function handlePatientChange(select) {
        const selectedOpt = select.options[select.selectedIndex];
        if (!selectedOpt || !selectedOpt.value) return;

        const diagnosis = selectedOpt.getAttribute('data-diagnosis');
        const diagnosisInput = document.getElementById('diagnosis');

        if (diagnosis && (!diagnosisInput.value || diagnosisInput.value === 'General Consultation')) {
            diagnosisInput.value = diagnosis;
        }
    }

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
