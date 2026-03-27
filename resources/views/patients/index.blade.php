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

<form method="POST" action="/patients/import/clear" onsubmit="return confirm('Delete all imported patient records?');">
@csrf
@method('DELETE')
<button type="submit" class="delete-btn">
<i class="fa-solid fa-trash"></i> Delete Uploaded Data
</button>
</form>

<a href="/patients/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Patient
</a>

<a href="/patients/export" class="ghost-btn">
<i class="fa-solid fa-file-export"></i> Export Excel
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

<div class="table-shell">
<table>

<tr>
<th>Name</th>
<th>Age</th>
<th>Phone</th>
<th>Visit Date</th>
<th>Action</th>
</tr>

@foreach($patients as $patient)

<tr>

<td>{{$patient->name}}</td>
<td>{{$patient->age}}</td>
<td>{{$patient->phone}}</td>
<td>{{$patient->visit_date}}</td>

<td>
<div class="table-actions">
<a href="/patients/{{$patient->id}}">
<button type="button" class="icon-action view" aria-label="View patient">
<i class="fa-solid fa-eye"></i>
</button>
</a>

<a href="/patients/{{$patient->id}}/edit">
<button type="button" class="icon-action edit" aria-label="Edit patient">
<i class="fa-solid fa-pen"></i>
</button>
</a>

<form action="/patients/{{$patient->id}}" method="POST" onsubmit="return confirm('Delete this patient record?');">
@csrf
@method('DELETE')
<button type="submit" class="icon-action delete" aria-label="Delete patient">
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

</div>

@endsection
