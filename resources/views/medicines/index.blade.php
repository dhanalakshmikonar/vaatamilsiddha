@extends('layout.app')

@section('content')

<div class="card">

<div style="display:flex;justify-content:space-between;align-items:center">

<h2>Medicines Inventory</h2>

<a href="/medicines/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Medicine
</a>

</div>

<table>

<tr>
<th>Name</th>
<th>Cost</th>
<th>Available Stock</th>
<th>Action</th>
</tr>

@foreach($medicines as $medicine)

<tr>

<td>{{$medicine->name}}</td>

<td>₹{{$medicine->cost}}</td>

<td>{{$medicine->stock}}</td>

<td style="display:flex;gap:10px">

<a href="/medicines/{{$medicine->id}}/edit">

<button class="edit-btn">

<i class="fa-solid fa-pen"></i>

</button>

</a>


<form action="/medicines/{{$medicine->id}}" method="POST">

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