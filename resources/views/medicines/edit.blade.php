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
<label>Mode of Product</label>
<input type="text" name="mode_of_product" value="{{$medicine->mode_of_product}}">
</div>

<div class="form-group">
<label>Pharmaceutical Name</label>
<input type="text" name="pharmaceutical_name" value="{{$medicine->pharmaceutical_name}}">
</div>

<div class="form-group">
<label>Expiry Date</label>
<input type="date" name="expiry_date" value="{{$medicine->expiry_date}}">
</div>

<div class="form-group">
<label>Stock Quantity</label>
<input type="number" name="stock" id="stock" min="0" value="{{$medicine->stock}}" oninput="calculateMedicineValues()">
</div>

<div class="form-group">
<label>Cost Price</label>
<input type="number" step="0.01" min="0" name="cost_price" id="cost_price" value="{{$medicine->cost_price ?: $medicine->cost}}" oninput="calculateMedicineValues()">
</div>

<div class="form-group">
<label>Selling Price</label>
<input type="number" step="0.01" id="selling_price" value="{{$medicine->selling_price}}" readonly>
</div>

<div class="form-group">
<label>Total Amount</label>
<input type="number" step="0.01" id="total_amount" value="{{$medicine->total_amount}}" readonly>
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

@push('scripts')
<script>
function calculateMedicineValues() {
    const costPrice = parseFloat(document.getElementById('cost_price').value || 0);
    const stock = parseInt(document.getElementById('stock').value || 0, 10);
    document.getElementById('selling_price').value = (costPrice * 1.2).toFixed(2);
    document.getElementById('total_amount').value = (costPrice * stock).toFixed(2);
}
</script>
@endpush
