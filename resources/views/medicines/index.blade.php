@extends('layout.app')

@section('content')

<style>
.medicines-action-col{
width:148px;
}

.medicines-col-mode{
width:120px;
white-space:nowrap;
}

.medicines-col-pharma{
width:210px;
}

.medicines-col-expiry{
width:120px;
white-space:nowrap;
}

.mode-two-words{
line-height:1.35;
}

.medicines-action-wrap{
display:flex;
align-items:center;
gap:6px;
flex-wrap:nowrap;
}

.medicines-action-wrap form{
margin:0;
}
</style>

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

<form method="POST" action="/medicines/import/clear" onsubmit="return confirm('Delete all imported medicine records from the inventory?');">
@csrf
@method('DELETE')
<button type="submit" class="delete-btn">
<i class="fa-solid fa-trash"></i> Delete Uploaded Data
</button>
</form>

<a href="/medicines/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Medicine
</a>

<a href="/medicines/export" class="ghost-btn">
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
<th class="medicines-col-mode">Mode</th>
<th class="medicines-col-pharma">Pharmaceutical</th>
<th class="medicines-col-expiry">Expiry</th>
<th>Available Stock</th>
<th>Cost Price</th>
<th>Selling Price</th>
<th>Total Amount</th>
<th class="medicines-action-col">Action</th>
</tr>

@foreach($medicines as $medicine)

<tr>

<td>{{$medicine->name}}</td>
<td class="medicines-col-mode">
@php
$modeWords = preg_split('/\s+/', trim((string) $medicine->mode_of_product));
$modeChunks = $modeWords ? array_chunk(array_filter($modeWords), 2) : [];
@endphp
<div class="mode-two-words">
@if(count($modeChunks))
{!! implode('<br>', array_map(fn($chunk) => e(implode(' ', $chunk)), $modeChunks)) !!}
@else
-
@endif
</div>
</td>
<td class="medicines-col-pharma">{{$medicine->pharmaceutical_name}}</td>
<td class="medicines-col-expiry">{{$medicine->expiry_date}}</td>
<td>{{$medicine->stock}}</td>
<td>Rs {{$medicine->cost_price ?: $medicine->cost}}</td>
<td>Rs {{$medicine->selling_price}}</td>
<td>Rs {{$medicine->total_amount}}</td>

<td class="medicines-action-col">
<div class="medicines-action-wrap">
<a href="/medicines/{{$medicine->id}}" class="icon-action view" aria-label="View medicine">
<i class="fa-solid fa-eye"></i>
</a>

<a href="/medicines/{{$medicine->id}}/edit" class="icon-action edit" aria-label="Edit medicine">
<i class="fa-solid fa-pen"></i>
</a>

<form action="/medicines/{{$medicine->id}}" method="POST" onsubmit="return confirm('Delete this medicine?');">
@csrf
@method('DELETE')
<button type="submit" class="icon-action delete" aria-label="Delete medicine">
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
