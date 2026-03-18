@extends('layout.app')

@section('content')

<div class="form-card">

<div class="form-title">
Add Medicine
</div>

<form method="POST" action="/medicines">

@csrf

<div class="form-grid">

<div class="form-group">
<label>Medicine Name</label>
<input type="text" name="name" required>
</div>

<div class="form-group">
<label>Cost</label>
<input type="number" name="cost" required>
</div>

<div class="form-group">
<label>Stock Quantity</label>
<input type="number" name="stock" required>
</div>

</div>

<div class="form-actions">
<button class="primary-btn">
Save Medicine
</button>
</div>

</form>

</div>

@endsection