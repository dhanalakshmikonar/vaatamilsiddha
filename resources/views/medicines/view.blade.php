@extends('layout.app')

@section('content')

<div class="profile-card">

<div class="form-header">
<h2>Medicine Details</h2>
<p>Review the medicine inventory information clearly in one place.</p>
</div>

<div class="profile-grid">
<div>
<strong>Medicine Name</strong>
<p>{{ $medicine->name ?: '-' }}</p>
</div>

<div>
<strong>Mode of Product</strong>
<p>{{ $medicine->mode_of_product ?: '-' }}</p>
</div>

<div>
<strong>Pharmaceutical Name</strong>
<p>{{ $medicine->pharmaceutical_name ?: '-' }}</p>
</div>

<div>
<strong>Expiry Date</strong>
<p>{{ $medicine->expiry_date ?: '-' }}</p>
</div>

<div>
<strong>Stock</strong>
<p>{{ $medicine->stock }}</p>
</div>

<div>
<strong>Cost Price</strong>
<p>Rs {{ number_format((float) ($medicine->cost_price ?: $medicine->cost), 2) }}</p>
</div>

<div>
<strong>Selling Price</strong>
<p>Rs {{ number_format((float) $medicine->selling_price, 2) }}</p>
</div>

<div>
<strong>Total Amount</strong>
<p>Rs {{ number_format((float) $medicine->total_amount, 2) }}</p>
</div>
</div>

<div class="form-actions">
<a href="/medicines/{{ $medicine->id }}/edit" class="btn">Edit Medicine</a>
<a href="/medicines" class="ghost-btn">Back to Medicines</a>
</div>

</div>

@endsection
