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
                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g. Dr. Uma Petchi" required>
            </div>

            <div class="form-group">
                <label for="role">Role / Designation</label>
                <input type="text" name="role" id="role" value="{{ old('role') }}" placeholder="e.g. Chief Siddha Physician / Consultant">
            </div>

            <div class="form-group">
                <label for="specialization">Specialization <span style="color:#ef4444;">*</span></label>
                <input type="text" name="specialization" id="specialization" value="{{ old('specialization') }}" placeholder="e.g. Siddha Medicine & Pulse Diagnosis" required>
            </div>

            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input type="text" name="qualification" id="qualification" value="{{ old('qualification') }}" placeholder="e.g. BSMS, MD (Siddha)">
            </div>

            <div class="form-group">
                <label for="license_no">License / Registration Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="license_no" id="license_no" value="{{ old('license_no') }}" placeholder="e.g. SIDDHA-2024-001" required>
            </div>

            <div class="form-group">
                <label for="aadhar">Aadhar Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="aadhar" id="aadhar" value="{{ old('aadhar') }}" placeholder="12-digit Aadhar number" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" placeholder="e.g. 9876543210" required>
            </div>

            <div class="form-group">
                <label for="experience">Experience (Years) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="experience" id="experience" min="0" value="{{ old('experience', 0) }}" required>
            </div>

            <div class="form-group full">
                <label for="clinic_address">Clinic Address / Branch</label>
                <textarea name="clinic_address" id="clinic_address" rows="3" placeholder="Enter clinic branch or residential address...">{{ old('clinic_address') }}</textarea>
            </div>

            <div class="form-group">
                <label for="photo">Doctor Profile Photo</label>
                <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png,.webp">
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Accepted: JPG, JPEG, PNG, WEBP (Max 10MB)</span>
            </div>

            <div class="form-group">
                <label for="aadhar_photo">Aadhar Card / Identity Document</label>
                <input type="file" name="aadhar_photo" id="aadhar_photo" accept=".jpg,.jpeg,.png,.webp,.pdf">
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Accepted: JPG, PNG, WEBP or PDF (Max 10MB)</span>
            </div>

            <div class="form-group full">
                <label for="signature">Doctor Signature Image</label>
                <input type="file" name="signature" id="signature" accept=".jpg,.jpeg,.png,.webp">
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
