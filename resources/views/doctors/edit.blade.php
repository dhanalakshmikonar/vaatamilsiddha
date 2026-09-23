@extends('layout.app')

@section('content')

<div class="form-container">

@if ($errors->any())
<div style="background:#fee2e2;color:#991b1b;padding:12px 14px;border-radius:8px;margin-bottom:20px;">
{{$errors->first()}}
</div>
@endif

<div class="form-header">
<h2>Edit Doctor</h2>
<p>Update doctor profile, license and document details</p>
</div>

<form method="POST" action="/doctors/{{$doctor->id}}" enctype="multipart/form-data">
@csrf
@method('PUT')

<div class="form-grid">
<div class="form-group">
<label>Doctor Name</label>
<input type="text" name="name" value="{{$doctor->name}}" required>
</div>

<div class="form-group">
<label>Role</label>
<input type="text" name="role" value="{{$doctor->role}}">
</div>

<div class="form-group">
<label>Specialization</label>
<input type="text" name="specialization" value="{{$doctor->specialization}}" required>
</div>

<div class="form-group">
<label>Qualification</label>
<input type="text" name="qualification" value="{{$doctor->qualification}}">
</div>

<div class="form-group">
<label>License Number</label>
<input type="text" name="license_no" value="{{$doctor->license_no}}" required>
</div>

<div class="form-group">
<label>Aadhar Number</label>
<input type="text" name="aadhar" value="{{$doctor->aadhar}}" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" value="{{$doctor->phone}}" required>
</div>

<div class="form-group">
<label>Experience (Years)</label>
<input type="number" name="experience" min="0" value="{{$doctor->experience}}" required>
</div>

<div class="form-group full">
<label>Clinic Address</label>
<textarea name="clinic_address" rows="3">{{$doctor->clinic_address}}</textarea>
</div>

<div class="form-group">
<label>Doctor Photo</label>
<input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp">
@if($doctor->photo)
<a href="/{{$doctor->photo}}" target="_blank" class="doc-link" style="margin-top:8px;">View current photo</a>
@endif
</div>

<div class="form-group">
<label>Aadhar Card Photo</label>
<input type="file" name="aadhar_photo" accept=".jpg,.jpeg,.png,.webp">
@if($doctor->aadhar_photo)
<a href="/{{$doctor->aadhar_photo}}" target="_blank" class="doc-link" style="margin-top:8px;">View current Aadhar photo</a>
@endif
</div>

<div class="form-group">
<label>Doctor Signature Image</label>
<input type="file" name="signature" accept=".jpg,.jpeg,.png,.webp">
@if($doctor->signature)
<div style="margin-top:8px;display:flex;align-items:center;gap:10px;">
    <img src="/{{$doctor->signature}}" alt="Current Signature" style="max-height:40px;max-width:120px;object-fit:contain;border:1px solid #e2e8f0;padding:2px;border-radius:4px;background:#fff;">
    <a href="/{{$doctor->signature}}" target="_blank" class="doc-link" style="font-size:12px;">View signature</a>
</div>
@endif
<span style="font-size:11.5px;color:#64748b;margin-top:2px;">Upload transparent/clean signature image (used on Certificates & Bills)</span>
</div>
</div>

<div class="form-actions">
<button type="submit" class="btn-primary">Update Doctor</button>
</div>

</form>

</div>

@endsection
