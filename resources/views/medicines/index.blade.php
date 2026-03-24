@extends('layout.app')

@section('content')

<div class="page-shell">

<div class="toolbar-card">
<div class="toolbar-title">
<h2>Medicines Inventory</h2>
<p>Upload stock sheets, manage medicine prices, and keep inventory tidy and accessible.</p>
</div>

<div class="toolbar-actions">
<form method="POST" action="/medicines/import" enctype="multipart/form-data" class="upload-inline">
@csrf
<input type="file" name="file" accept=".csv,.xlsx" required>
<button type="submit" class="btn">
<i class="fa-solid fa-file-arrow-up"></i> Upload Excel
</button>
</form>

<a href="/medicines/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Medicine
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

<div class="meta-note">Medicine file headers: <strong>name, cost, stock</strong></div>

<table>

<tr>
<th>Name</th>
<th>Mode</th>
<th>Pharmaceutical</th>
<th>Expiry</th>
<th>Available Stock</th>
<th>Cost Price</th>
<th>Selling Price</th>
<th>Total Amount</th>
<th>Action</th>
</tr>

@foreach($medicines as $medicine)

<tr>

<td>{{$medicine->name}}</td>
<td>{{$medicine->mode_of_product}}</td>
<td>{{$medicine->pharmaceutical_name}}</td>
<td>{{$medicine->expiry_date}}</td>
<td>{{$medicine->stock}}</td>
<td>Rs {{$medicine->cost_price ?: $medicine->cost}}</td>
<td>Rs {{$medicine->selling_price}}</td>
<td>Rs {{$medicine->total_amount}}</td>

<td>
<div class="table-actions">
<a href="/medicines/{{$medicine->id}}/edit">
<button class="icon-action edit">
<i class="fa-solid fa-pen"></i>
</button>
</a>

<form action="/medicines/{{$medicine->id}}" method="POST">
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
