@extends('layout.app')

@section('content')

<div class="form-container">

    <div class="form-header">
        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
            <div>
                <h2><i class="fa-solid fa-capsules" style="color:var(--primary);margin-right:8px;"></i>Add Medicine</h2>
                <p>Register pharmaceutical stock, specify pricing, and track dispensary quantities.</p>
            </div>
            <a href="/medicines" class="ghost-btn">
                <i class="fa-solid fa-arrow-left"></i> Back to Medicines
            </a>
        </div>
    </div>

    @if ($errors->any())
    <div style="background:#fee2e2;color:#991b1b;padding:14px 18px;border-radius:12px;margin-bottom:24px;border:1px solid #fecaca;font-size:13.5px;">
        <div style="font-weight:700;margin-bottom:6px;"><i class="fa-solid fa-circle-exclamation"></i> Please resolve the following errors:</div>
        <ul style="margin-left:20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="/medicines">
        @csrf

        <div class="form-grid">

            <div class="form-group">
                <label for="name">Medicine Name <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required maxlength="255" placeholder="e.g. Nilavembu Kudineer" class="@error('name') is-invalid @enderror">
                @error('name')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="mode_of_product">Mode of Product</label>
                <input type="text" name="mode_of_product" id="mode_of_product" value="{{ old('mode_of_product') }}" maxlength="255" placeholder="e.g. Choornam / Tablet / Thailam" class="@error('mode_of_product') is-invalid @enderror">
                @error('mode_of_product')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pharmaceutical_name">Pharmaceutical Name</label>
                <input type="text" name="pharmaceutical_name" id="pharmaceutical_name" value="{{ old('pharmaceutical_name') }}" maxlength="255" placeholder="e.g. SKM Siddha / Impcops" class="@error('pharmaceutical_name') is-invalid @enderror">
                @error('pharmaceutical_name')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}" class="@error('expiry_date') is-invalid @enderror">
                @error('expiry_date')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="stock">Stock Quantity <span style="color:#ef4444;">*</span></label>
                <input type="number" name="stock" id="stock" min="0" max="1000000" step="1" value="{{ old('stock', 0) }}" required oninput="calculateMedicineValues()" class="@error('stock') is-invalid @enderror">
                @error('stock')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="cost_price">Cost Price (Rs) <span style="color:#ef4444;">*</span></label>
                <input type="number" step="0.01" min="0.01" max="999999.99" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" required oninput="calculateMedicineValues()" placeholder="0.00" class="@error('cost_price') is-invalid @enderror">
                @error('cost_price')
                    <span class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price (Rs - Auto 20%)</label>
                <input type="number" step="0.01" name="selling_price_preview" id="selling_price" readonly style="background:#f8fafc;cursor:not-allowed;">
            </div>

            <div class="form-group">
                <label for="total_amount">Total Amount (Rs)</label>
                <input type="number" step="0.01" name="total_amount_preview" id="total_amount" readonly style="background:#f8fafc;cursor:not-allowed;">
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-check"></i> Save Medicine
            </button>
            <a href="/medicines" class="ghost-btn">Cancel</a>
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
calculateMedicineValues();
</script>
@endpush
