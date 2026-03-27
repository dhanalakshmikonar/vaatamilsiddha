@extends('layout.app')

@section('content')

<div class="page-shell">

<div class="toolbar-card">
<div class="toolbar-title">
<h2>Billing</h2>
<p>Patient bills generated from medicines and quantities.</p>
</div>

<div class="toolbar-actions">
<a href="/billing/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Billing
</a>
<a href="/billing/export" class="ghost-btn">
<i class="fa-solid fa-file-export"></i> Export Excel
</a>
</div>
</div>

<div class="card">

<div class="table-shell">
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
<span class="pill">No medicines</span>
@endif
</td>
<td>Rs {{number_format($billSummaries[$patient->id]['grand_total'] ?? 0, 2)}}</td>
<td>
<a href="/billing/{{$patient->id}}" class="btn">
<i class="fa-solid fa-file-invoice"></i> View Bill
</a>
</td>
</tr>
@endforeach

</table>
</div>

</div>
</div>

@endsection
