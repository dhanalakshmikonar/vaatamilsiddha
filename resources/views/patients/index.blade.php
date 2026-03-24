@extends('layout.app')

@section('content')

<div class="page-shell">

<div class="toolbar-card">
<div class="toolbar-title">
<h2>Patients</h2>
<p>Manage patient records, import visit data, and move quickly to billing details.</p>
</div>

<div class="toolbar-actions">
<form method="POST" action="/patients/import" enctype="multipart/form-data" class="upload-inline">
@csrf
<input type="file" name="file" accept=".csv,.xlsx" required>
<button type="submit" class="btn">
<i class="fa-solid fa-file-arrow-up"></i> Upload Excel
</button>
</form>

<a href="/patients/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Patient
</a>
</div>
</div>

<div class="card">

@if (session('success'))
<div class="alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
<div class="alert-error">{{ session('error') }}</div>
@endif

<div class="meta-note">Patient file headers: <strong>name, age, gender, phone, visit_date, diagnosis</strong></div>

<table>

<tr>
<th>Name</th>
<th>Age</th>
<th>Phone</th>
<th>Visit Date</th>
<th>Billing</th>
<th>Action</th>
</tr>

@foreach($patients as $patient)

<tr>

<td>{{$patient->name}}</td>
<td>{{$patient->age}}</td>
<td>{{$patient->phone}}</td>
<td>{{$patient->visit_date}}</td>
<td>
<a href="/billing/{{$patient->id}}" class="ghost-btn">
<i class="fa-solid fa-file-invoice"></i> Bill
</a>
</td>

<td>
<div class="table-actions">
<a href="/patients/{{$patient->id}}">
<button class="icon-action view">
<i class="fa-solid fa-eye"></i>
</button>
</a>

<a href="/patients/{{$patient->id}}/edit">
<button class="icon-action edit">
<i class="fa-solid fa-pen"></i>
</button>
</a>

<form action="/patients/{{$patient->id}}" method="POST">
@csrf
@method('DELETE')
<button class="icon-action delete">
<i class="fa-solid fa-trash"></i>
</button>
</form>
</div>
</td>

</tr>

@endforeach

</table>

</div>

</div>

@endsection
