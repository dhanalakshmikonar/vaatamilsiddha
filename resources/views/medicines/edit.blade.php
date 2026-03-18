@extends('layout.app')

@section('content')

<div class="form-container">

<div class="form-header">
<h2>Edit Medicine</h2>
<p>Update medicine inventory details</p>
</div>

<form method="POST" action="/medicines/{{$medicine->id}}">

@csrf
@method('PUT')

<div class="form-grid">

<div class="form-group">
<label>Medicine Name</label>
<input type="text" name="name" value="{{$medicine->name}}">
</div>

<div class="form-group">
<label>Cost</label>
<input type="number" name="cost" value="{{$medicine->cost}}">
</div>

<div class="form-group">
<label>Stock Quantity</label>
<input type="number" name="stock" value="{{$medicine->stock}}">
</div>

</div>

<div class="form-actions">
<button class="btn-primary">
Update Medicine
</button>
</div>

</form>

</div>

@endsection