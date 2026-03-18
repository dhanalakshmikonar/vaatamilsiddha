@extends('layout.app')

@section('content')

<div class="form-container">

<div class="form-header">
<h2>Edit Patient</h2>
<p>Update patient information</p>
</div>

<form method="POST" action="/patients/{{$patient->id}}">

@csrf
@method('PUT')

<div class="form-grid">

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="name" value="{{$patient->name}}">
</div>

<div class="form-group">
<label>Age</label>
<input type="number" name="age" value="{{$patient->age}}">
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender">

<option {{$patient->gender=='Male'?'selected':''}}>Male</option>
<option {{$patient->gender=='Female'?'selected':''}}>Female</option>
<option {{$patient->gender=='Other'?'selected':''}}>Other</option>

</select>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" value="{{$patient->phone}}">
</div>

<div class="form-group">
<label>Visit Date</label>
<input type="date" name="visit_date" value="{{$patient->visit_date}}">
</div>

<div class="form-group full">
<label>Diagnosis</label>
<textarea name="diagnosis">{{$patient->diagnosis}}</textarea>
</div>

</div>

<div class="form-actions">
<button class="btn-primary">Update Patient</button>
</div>

</form>

</div>

@endsection