@extends('layout.app')

@section('content')

<div class="form-container">

    @if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:14px 18px;border-radius:12px;margin-bottom:24px;border:1px solid #fecaca;font-size:13.5px;">
        <div style="font-weight:700;margin-bottom:6px;"><i class="fa-solid fa-circle-exclamation"></i> Please resolve the following errors:</div>
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
                <h2><i class="fa-solid fa-user-doctor" style="color:var(--primary);margin-right:8px;"></i>Add Doctor</h2>
                <p>Create a licensed doctor profile with document and signature uploads.</p>
            </div>
            <a href="/doctors" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Doctors
            </a>
        </div>
    </div>

    <form method="POST" action="/doctors" enctype="multipart/form-data">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Doctor Name <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. Dr Uma Petchi" required pattern="^[A-Za-z\s]+$" title="Alphabets and spaces only" maxlength="255" class="@error('name') is-invalid @enderror">
                @error('name')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Role / Designation</label>
                <input type="text" name="role" id="role" value="{{ old('role') }}" maxlength="255" placeholder="e.g. Chief Siddha Physician / Consultant" class="@error('role') is-invalid @enderror">
                @error('role')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="specialization">Specialization <span style="color:#ef4444;">*</span></label>
                <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" placeholder="e.g. Siddha Medicine & Pulse Diagnosis" required maxlength="255" class="@error('specialization') is-invalid @enderror">
                @error('specialization')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input type="text" name="qualification" id="qualification" value="{{ old('qualification') }}" maxlength="255" placeholder="e.g. BSMS, MD (Siddha)" class="@error('qualification') is-invalid @enderror">
                @error('qualification')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="license_no">License / Registration Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="license_no" id="license_no" value="{{ old('license_no') }}" placeholder="e.g. SIDDHA-2024-001" required maxlength="100" class="@error('license_no') is-invalid @enderror">
                @error('license_no')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="aadhar">Aadhar Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="aadhar" id="aadhar" value="{{ old('aadhar') }}" placeholder="12-digit Aadhar number" pattern="^\d{12}$" maxlength="12" minlength="12" title="Exactly 12 digits" required class="@error('aadhar') is-invalid @enderror">
                @error('aadhar')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210" pattern="^[6-9][0-9]{9}$" maxlength="10" minlength="10" title="10-digit mobile number starting with 6, 7, 8, or 9" required class="@error('phone') is-invalid @enderror">
                @error('phone')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="experience">Experience (Years) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="experience" id="experience" min="0" max="100" step="1" value="{{ old('experience', 0) }}" required class="@error('experience') is-invalid @enderror">
                @error('experience')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full">
                <label for="clinic_address">Clinic Address / Branch</label>
                <textarea name="clinic_address" id="clinic_address" rows="3" maxlength="1000" placeholder="Enter clinic branch or residential address..." class="@error('clinic_address') is-invalid @enderror">{{ old('clinic_address') }}</textarea>
                @error('clinic_address')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="photo">Doctor Profile Photo</label>
                <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png,.webp" class="@error('photo') is-invalid @enderror">
                @error('photo')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Accepted: JPG, JPEG, PNG, WEBP (Max 10MB)</span>
            </div>

            <div class="form-group">
                <label for="aadhar_photo">Aadhar Card / Identity Document</label>
                <input type="file" name="aadhar_photo" id="aadhar_photo" accept=".jpg,.jpeg,.png,.webp,.pdf" class="@error('aadhar_photo') is-invalid @enderror">
                @error('aadhar_photo')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Accepted: JPG, PNG, WEBP or PDF (Max 10MB)</span>
            </div>

            <div class="form-group full">
                <label for="signature">Doctor Signature Image</label>
                <input type="file" name="signature" id="signature" accept=".jpg,.jpeg,.png,.webp" class="@error('signature') is-invalid @enderror">
                @error('signature')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Upload transparent/clean signature image (used on Certificates & Billing Invoices - Max 10MB)</span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-floppy-disk"></i> Save Doctor
            </button>
            <a href="/doctors" class="ghost-btn">Cancel</a>
        </div>

    </form>

</div>

@endsection
