@extends('layout.app')

@section('content')

<div class="card">

<div style="display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
<div>
<h2>Billing</h2>
<p style="color:#64748b;margin-top:6px;">Patient bills generated from medicines and quantities</p>
</div>
</div>

<table>
<tr>
<th>Patient Name</th>
<th>Visit Date</th>
<th>Medicines</th>
<th>Bill Amount</th>
<th>Action</th>
</tr>

@foreach($patients as $patient)
<tr>
<td>{{$patient->name}}</td>
<td>{{$patient->visit_date}}</td>
<td>
@if($patient->patientMedicines->count())
{{ $patient->patientMedicines->pluck('medicine.name')->filter()->implode(', ') }}
@else
No medicines
@endif
</td>
<td>Rs {{number_format($patient->total_amount, 2)}}</td>
<td>
<a href="/billing/{{$patient->id}}" class="btn">
<i class="fa-solid fa-file-invoice"></i> View Bill
</a>
</td>
</tr>
@endforeach

</table>

</div>

@endsection
