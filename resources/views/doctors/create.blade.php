@extends('layout.app')

@section('content')

<div class="form-container">

@if ($errors->any())
<div style="background:#fee2e2;color:#991b1b;padding:12px 14px;border-radius:8px;margin-bottom:20px;">
{{$errors->first()}}
</div>
@endif

<div class="form-header">
<h2>Add Doctor</h2>
<p>Create an elegant doctor profile with document uploads</p>
</div>

<form method="POST" action="/doctors" enctype="multipart/form-data">
@csrf

<div class="form-grid">
<div class="form-group">
<label>Doctor Name</label>
<input type="text" name="name" required>
</div>

<div class="form-group">
<label>Role</label>
<input type="text" name="role" placeholder="Chief Doctor / Visiting Consultant">
</div>

<div class="form-group">
<label>Specialization</label>
<input type="text" name="specialization" required>
</div>

<div class="form-group">
<label>Qualification</label>
<input type="text" name="qualification" placeholder="BSMS / MD Siddha">
</div>

<div class="form-group">
<label>License Number</label>
<input type="text" name="license_no" required>
</div>

<div class="form-group">
<label>Aadhar Number</label>
<input type="text" name="aadhar" required>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" required>
</div>

<div class="form-group">
<label>Experience (Years)</label>
<input type="number" name="experience" min="0" required>
</div>

<div class="form-group full">
<label>Clinic Address</label>
<textarea name="clinic_address" rows="3"></textarea>
</div>

<div class="form-group">
<label>Doctor Photo</label>
<input type="file" name="photo" accept=".jpg,.jpeg,.png,.webp" required>
</div>

<div class="form-group">
<label>Aadhar Card Photo</label>
<input type="file" name="aadhar_photo" accept=".jpg,.jpeg,.png,.webp" required>
</div>
</div>

<div class="form-actions">
<button type="submit" class="btn-primary">Save Doctor</button>
</div>

</form>

</div>

@endsection
