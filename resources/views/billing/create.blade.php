@extends('layout.app')

@section('content')

<div class="form-container">
<div class="form-header">
<h2>Add Billing</h2>
<p>Select medicine and therapy, add appointment details, and generate total amount.</p>
</div>

@if ($errors->any())
<div class="alert-error">{{ $errors->first() }}</div>
@endif

<form method="POST" action="/billing/preview" id="billingForm">
@csrf

<div class="form-grid">
<div class="form-group">
<label>Medicines (Optional)</label>
<select name="medicine_id" id="medicine_id" onchange="updateBillingTotal()">
<option value="">Select Medicine</option>
@foreach($medicines as $medicine)
<option
value="{{ $medicine->id }}"
data-amount="{{ (float) ($medicine->selling_price ?: $medicine->cost_price ?: $medicine->cost ?: 0) }}"
{{ old('medicine_id') == $medicine->id ? 'selected' : '' }}>
{{ $medicine->name }} - Rs {{ number_format((float) ($medicine->selling_price ?: $medicine->cost_price ?: $medicine->cost ?: 0), 2) }}
</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Therapy (Optional)</label>
<select name="therapy" id="therapy" onchange="updateBillingTotal()">
<option value="">Select Therapy</option>
<option value="consultation" data-amount="200" {{ old('therapy') === 'consultation' ? 'selected' : '' }}>Consultation - Rs 200</option>
<option value="quarter_massage" data-amount="800" {{ old('therapy') === 'quarter_massage' ? 'selected' : '' }}>1/4 Massage - Rs 800</option>
<option value="half_back_massage" data-amount="500" {{ old('therapy') === 'half_back_massage' ? 'selected' : '' }}>Half Back Massage - Rs 500</option>
<option value="full_body_massage" data-amount="1000" {{ old('therapy') === 'full_body_massage' ? 'selected' : '' }}>Full Body Massage - Rs 1000</option>
<option value="navarakili_massage" data-amount="1000" {{ old('therapy') === 'navarakili_massage' ? 'selected' : '' }}>Navarakili Massage - Rs 1000</option>
<option value="leg_massage" data-amount="750" {{ old('therapy') === 'leg_massage' ? 'selected' : '' }}>Leg Massage - Rs 750</option>
</select>
</div>

<div class="form-group full">
<label>Appointment Amount</label>
<input type="number" step="0.01" min="0" name="appointment" id="appointment" value="{{ old('appointment') }}" placeholder="Enter appointment amount" oninput="updateBillingTotal()">
</div>

<div class="form-group full">
<label>Total Amount</label>
<input type="text" id="total_amount" value="Rs 0.00" readonly>
</div>
</div>

<div class="form-actions" style="display:flex;gap:12px;flex-wrap:wrap;">
<button type="submit" class="btn">Generate Bill</button>
<button type="reset" class="delete-btn" onclick="setTimeout(updateBillingTotal, 0)">Clear</button>
<a href="/billing" class="ghost-btn">Back</a>
</div>
</form>
</div>

@endsection

@push('scripts')
<script>
function getSelectedAmount(selectId) {
    const select = document.getElementById(selectId);
    if (!select || select.selectedIndex < 0) return 0;
    const option = select.options[select.selectedIndex];
    return parseFloat(option.getAttribute('data-amount') || '0');
}

function updateBillingTotal() {
    const medicineAmount = getSelectedAmount('medicine_id');
    const therapyAmount = getSelectedAmount('therapy');
    const appointmentAmount = parseFloat(document.getElementById('appointment').value || '0');
    const total = medicineAmount + therapyAmount + appointmentAmount;

    document.getElementById('total_amount').value = 'Rs ' + total.toFixed(2);
}

updateBillingTotal();
</script>
@endpush
