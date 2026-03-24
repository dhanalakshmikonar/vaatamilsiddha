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
<label>Mode of Product</label>
<input type="text" name="mode_of_product">
</div>

<div class="form-group">
<label>Pharmaceutical Name</label>
<input type="text" name="pharmaceutical_name">
</div>

<div class="form-group">
<label>Expiry Date</label>
<input type="date" name="expiry_date">
</div>

<div class="form-group">
<label>Stock Quantity</label>
<input type="number" name="stock" id="stock" min="0" required oninput="calculateMedicineValues()">
</div>

<div class="form-group">
<label>Cost Price</label>
<input type="number" step="0.01" min="0" name="cost_price" id="cost_price" required oninput="calculateMedicineValues()">
</div>

<div class="form-group">
<label>Selling Price</label>
<input type="number" step="0.01" name="selling_price_preview" id="selling_price" readonly>
</div>

<div class="form-group">
<label>Total Amount</label>
<input type="number" step="0.01" name="total_amount_preview" id="total_amount" readonly>
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
