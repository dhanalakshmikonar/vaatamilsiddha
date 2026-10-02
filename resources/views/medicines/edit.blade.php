@extends('layout.app')

@section('content')

<div class="form-container">

    <div class="form-header">
        <h2><i class="fa-solid fa-pills" style="color:var(--primary);margin-right:8px;"></i> Edit Medicine</h2>
        <p>Update pharmaceutical product details, stock count, and automated selling price.</p>
    </div>

    @if ($errors->any())
    <div class="alert-error" style="background:#fee2e2;border:1px solid #fecaca;padding:14px 18px;border-radius:12px;margin-bottom:20px;color:#991b1b;">
        <strong style="display:block;margin-bottom:6px;"><i class="fa-solid fa-circle-exclamation"></i> Please correct the following errors:</strong>
        <ul style="margin-left: 20px;font-size:13px;">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="/medicines/{{ $medicine->id }}">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <div class="form-section-title">
                <i class="fa-solid fa-capsules"></i> Product Information
            </div>

            <div class="form-group">
                <label for="name">Medicine Name <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $medicine->name) }}" required maxlength="255" placeholder="e.g. Nilavembu Kudineer Choornam" class="@error('name') is-invalid @enderror">
                @error('name')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mode_of_product">Mode of Product / Dosage Form</label>
                <input type="text" name="mode_of_product" id="mode_of_product" value="{{ old('mode_of_product', $medicine->mode_of_product) }}" maxlength="255" placeholder="e.g. Choornam / Thailam / Tablet / Syrup" class="@error('mode_of_product') is-invalid @enderror">
                @error('mode_of_product')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pharmaceutical_name">Pharmaceutical Manufacturer</label>
                <input type="text" name="pharmaceutical_name" id="pharmaceutical_name" value="{{ old('pharmaceutical_name', $medicine->pharmaceutical_name) }}" maxlength="255" placeholder="e.g. SKM Siddha / Impcops" class="@error('pharmaceutical_name') is-invalid @enderror">
                @error('pharmaceutical_name')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date) }}" class="@error('expiry_date') is-invalid @enderror">
                @error('expiry_date')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-boxes-stacked"></i> Stock & Pricing Calculation
            </div>

            <div class="form-group">
                <label for="stock">Stock Quantity (Units) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="stock" id="stock" min="0" max="1000000" step="1" value="{{ old('stock', $medicine->stock) }}" required oninput="calculateMedicineValues()" placeholder="Available stock count" class="@error('stock') is-invalid @enderror">
                @error('stock')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cost_price">Cost Price (Rs per unit) <span style="color:#ef4444;">*</span></label>
                <input type="number" step="0.01" min="0.01" max="999999.99" name="cost_price" id="cost_price" value="{{ old('cost_price', $medicine->cost_price ?: $medicine->cost) }}" required oninput="calculateMedicineValues()" placeholder="Purchase cost" class="@error('cost_price') is-invalid @enderror">
                @error('cost_price')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price (Rs with margin)</label>
                <input type="number" step="0.01" id="selling_price" name="selling_price" value="{{ old('selling_price', $medicine->selling_price) }}" readonly style="background:#f8fafc;cursor:not-allowed;">
            </div>

            <div class="form-group">
                <label for="total_amount">Total Inventory Valuation (Rs)</label>
                <input type="number" step="0.01" id="total_amount" name="total_amount" value="{{ old('total_amount', $medicine->total_amount) }}" readonly style="background:#f8fafc;cursor:not-allowed;">
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-check"></i> Update Medicine
            </button>
            <a href="/medicines" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Cancel
            </a>
        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>
function calculateMedicineValues() {
    const costPrice = parseFloat(document.getElementById('cost_price')?.value || 0);
    const stock = parseInt(document.getElementById('stock')?.value || 0, 10);
    const sellingPrice = (costPrice * 1.2).toFixed(2);
    const totalAmount = (costPrice * stock).toFixed(2);

    const spInput = document.getElementById('selling_price');
    if (spInput) spInput.value = sellingPrice;

    const taInput = document.getElementById('total_amount');
    if (taInput) taInput.value = totalAmount;
}
</script>
@endpush
