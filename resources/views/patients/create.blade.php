@extends('layout.app')

@section('content')

<div class="form-container">

    <div class="form-header">
        <h2>Add Patient</h2>
        <p>Register a new patient in the clinic system</p>
    </div>

<form method="POST" action="/patients">

@csrf

<div class="form-grid">

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="name" placeholder="Enter patient name" required>
</div>

<div class="form-group">
<label>Age</label>
<input type="number" name="age" placeholder="Enter age" required>
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender">
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>

<div class="form-group">
<label>Phone Number</label>
<input type="text" name="phone" placeholder="Enter phone number">
</div>

<div class="form-group">
<label>Visit Date</label>
<input type="date" name="visit_date">
</div>

<div class="form-group full">
<label>Diagnosis</label>
<textarea name="diagnosis" rows="3" placeholder="Patient diagnosis"></textarea>
</div>

</div>

<div class="form-actions">
<button type="submit" class="btn-primary">
Save Patient
</button>
</div>

</form>

</div>

@endsection