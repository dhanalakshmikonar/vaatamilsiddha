@extends('layout.app')

@section('content')

<div class="profile-card">

<div style="display:flex;justify-content:space-between;align-items:flex-start;gap:14px;flex-wrap:wrap;margin-bottom:18px;">
<h2>Patient Profile</h2>
<div style="display:flex;gap:10px;flex-wrap:wrap;">
<a href="/patients/{{$patient->id}}/edit" class="btn">
<i class="fa-solid fa-pen"></i> Edit Patient
</a>
<form action="/patients/{{$patient->id}}" method="POST" onsubmit="return confirm('Delete this patient record?');">
@csrf
@method('DELETE')
<button type="submit" class="delete-btn">
<i class="fa-solid fa-trash"></i> Delete Patient
</button>
</form>
</div>
</div>

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
<strong>Place</strong>
<p>{{$patient->place}}</p>
</div>

<div>
<strong>Entity</strong>
<p>{{$patient->entity}}</p>
</div>

<div>
<strong>Payment Mode</strong>
<p>{{$patient->payment_mode}}</p>
</div>

<div>
<strong>Fees</strong>
<p>Rs {{number_format((float) $patient->fees, 2)}}</p>
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
