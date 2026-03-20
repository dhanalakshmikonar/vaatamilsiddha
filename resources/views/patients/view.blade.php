@extends('layout.app')

@section('content')

<div class="profile-card">

<h2>Patient Profile</h2>

<div class="profile-grid">

<div>
<strong>Name</strong>
<p>{{$patient->name}}</p>
</div>

<div>
<strong>Age</strong>
<p>{{$patient->age}}</p>
</div>

<div>
<strong>Gender</strong>
<p>{{$patient->gender}}</p>
</div>

<div>
<strong>Phone</strong>
<p>{{$patient->phone}}</p>
</div>

<div>
<strong>Visit Date</strong>
<p>{{$patient->visit_date}}</p>
</div>

<div class="full">
<strong>Diagnosis</strong>
<p>{{$patient->diagnosis}}</p>
</div>

</div>

<h3 style="margin-top:25px">Medicines</h3>

<table class="detail-table">
<tr>
<th>Medicine</th>
<th>Qty</th>
</tr>

@forelse($patient->patientMedicines as $item)
<tr>
<td>{{$item->medicine->name}}</td>
<td>{{$item->quantity}}</td>
</tr>
@empty
<tr>
<td colspan="2">No medicines added for this patient.</td>
</tr>
@endforelse
</table>

</div>

@endsection
