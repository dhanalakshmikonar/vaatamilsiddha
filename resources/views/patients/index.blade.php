@extends('layout.app')

@section('content')

<div class="card">

<div style="display:flex;justify-content:space-between;align-items:center">

<h2>Patients</h2>

<a href="/patients/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Patient
</a>

</div>

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

<td style="display:flex;gap:10px">

<a href="/patients/{{$patient->id}}">
<button class="view-btn">
<i class="fa-solid fa-eye"></i>
</button>
</a>

<a href="/patients/{{$patient->id}}/edit">
<button class="edit-btn">
<i class="fa-solid fa-pen"></i>
</button>
</a>

<form action="/patients/{{$patient->id}}" method="POST">

@csrf
@method('DELETE')

<button class="delete-btn">
<i class="fa-solid fa-trash"></i>
</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

@endsection