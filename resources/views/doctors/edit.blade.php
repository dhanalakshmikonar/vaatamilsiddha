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
                <h2><i class="fa-solid fa-pen-to-square" style="color:var(--primary);margin-right:8px;"></i>Edit Doctor</h2>
                <p>Update doctor profile, qualifications, documents, and signature.</p>
            </div>
            <a href="/doctors" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Doctors
            </a>
        </div>
    </div>

    <form method="POST" action="/doctors/{{ $doctor->id }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Doctor Name <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $doctor->name) }}" required>
            </div>

            <div class="form-group">
                <label for="role">Role / Designation</label>
                <input type="text" name="role" id="role" value="{{ old('role', $doctor->role) }}">
            </div>

            <div class="form-group">
                <label for="specialization">Specialization <span style="color:#ef4444;">*</span></label>
                <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $doctor->specialization) }}" required>
            </div>

            <div class="form-group">
                <label for="qualification">Qualification</label>
                <input type="text" name="qualification" id="qualification" value="{{ old('qualification', $doctor->qualification) }}">
            </div>

            <div class="form-group">
                <label for="license_no">License Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="license_no" id="license_no" value="{{ old('license_no', $doctor->license_no) }}" required>
            </div>

            <div class="form-group">
                <label for="aadhar">Aadhar Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="aadhar" id="aadhar" value="{{ old('aadhar', $doctor->aadhar) }}" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number <span style="color:#ef4444;">*</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $doctor->phone) }}" required>
            </div>

            <div class="form-group">
                <label for="experience">Experience (Years) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="experience" id="experience" min="0" value="{{ old('experience', $doctor->experience) }}" required>
            </div>

            <div class="form-group full">
                <label for="clinic_address">Clinic Address</label>
                <textarea name="clinic_address" id="clinic_address" rows="3">{{ old('clinic_address', $doctor->clinic_address) }}</textarea>
            </div>

            <div class="form-group">
                <label for="photo">Doctor Profile Photo</label>
                <input type="file" name="photo" id="photo" accept=".jpg,.jpeg,.png,.webp">
                @if($doctor->photo)
                    <div style="margin-top:6px;display:flex;align-items:center;gap:10px;">
                        <img src="/{{ $doctor->photo }}" alt="Photo" style="width:36px;height:36px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                        <a href="/{{ $doctor->photo }}" target="_blank" class="ghost-btn" style="padding:4px 10px;font-size:11px;">View Current Photo</a>
                    </div>
                @endif
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Accepted: JPG, JPEG, PNG, WEBP (Max 10MB)</span>
            </div>

            <div class="form-group">
                <label for="aadhar_photo">Aadhar Card / Identity Document</label>
                <input type="file" name="aadhar_photo" id="aadhar_photo" accept=".jpg,.jpeg,.png,.webp,.pdf">
                @if($doctor->aadhar_photo)
                    <div style="margin-top:6px;display:flex;align-items:center;gap:10px;">
                        <a href="/{{ $doctor->aadhar_photo }}" target="_blank" class="ghost-btn" style="padding:4px 10px;font-size:11px;">
                            <i class="fa-solid fa-file"></i> View Current Document
                        </a>
                    </div>
                @endif
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Accepted: JPG, PNG, WEBP or PDF (Max 10MB)</span>
            </div>

            <div class="form-group full">
                <label for="signature">Doctor Signature Image</label>
                <input type="file" name="signature" id="signature" accept=".jpg,.jpeg,.png,.webp">
                @if($doctor->signature)
                    <div style="margin-top:6px;display:flex;align-items:center;gap:10px;">
                        <img src="/{{ $doctor->signature }}" alt="Signature" style="max-height:36px;max-width:120px;object-fit:contain;background:#fff;border:1px solid #e2e8f0;padding:2px;border-radius:4px;">
                        <a href="/{{ $doctor->signature }}" target="_blank" class="ghost-btn" style="padding:4px 10px;font-size:11px;">View Current Signature</a>
                    </div>
                @endif
                <span style="font-size:11.5px;color:#64748b;margin-top:2px;">Upload transparent/clean signature image (used on Certificates & Bills - Max 10MB)</span>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-floppy-disk"></i> Update Doctor
            </button>
            <a href="/doctors" class="ghost-btn">Cancel</a>
        </div>

    </form>

</div>

@endsection
