@extends('layout.app')

@section('content')

<div class="form-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-calculator" style="color:var(--primary);margin-right:8px;"></i> Create Patient Invoice</h2>
        <p>Select medicines, add therapeutic procedures, enter consultation fees, and generate grand total.</p>
    </div>

    @if (isset($errors) && $errors->any())
    <div class="alert-error" style="background:#fee2e2;border:1px solid #fecaca;padding:14px 18px;border-radius:12px;margin-bottom:20px;color:#991b1b;">
        <strong style="display:block;margin-bottom:6px;"><i class="fa-solid fa-circle-exclamation"></i> {{ $errors->first() }}</strong>
    </div>
    @endif


    <form method="POST" action="/billing/preview" id="billingForm">
        @csrf

        <div class="form-grid">

            <div class="form-section-title">
                <i class="fa-solid fa-capsules"></i> Pharmacy & Prescriptions
            </div>

            <div class="form-group full">
                <label for="medicine_id">Medicines (Optional)</label>
                <select name="medicine_id" id="medicine_id" onchange="updateBillingTotal()">
                    <option value="">-- Select Prescribed Medicine --</option>
                    @foreach($medicines as $medicine)
                    <option
                        value="{{ $medicine->id }}"
                        data-amount="{{ (float) ($medicine->selling_price ?: $medicine->cost_price ?: $medicine->cost ?: 0) }}"
                        {{ old('medicine_id') == $medicine->id ? 'selected' : '' }}
                    >
                        {{ $medicine->name }} — Rs {{ number_format((float) ($medicine->selling_price ?: $medicine->cost_price ?: $medicine->cost ?: 0), 2) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-spa"></i> Siddha Therapy & Procedures
            </div>

            <div class="form-group full">
                <label for="therapy">Therapy Procedure (Optional)</label>
                <select name="therapy" id="therapy" onchange="updateBillingTotal()">
                    <option value="">-- Select Therapy Type --</option>
                    @foreach($therapyOptions as $key => $option)
                    <option
                        value="{{ $key }}"
                        data-amount="{{ $option['amount'] }}"
                        {{ old('therapy') === $key ? 'selected' : '' }}
                    >
                        {{ $option['label'] }} — Rs {{ number_format((float) $option['amount'], 2) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-section-title">
                <i class="fa-solid fa-user-doctor"></i> Doctor Consultation Fee
            </div>

            <div class="form-group full">
                <label for="appointment">Appointment / Consultation Fee (Rs)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="appointment"
                    id="appointment"
                    value="{{ old('appointment') }}"
                    placeholder="Enter consultation amount e.g. 300"
                    oninput="updateBillingTotal()"
                >
            </div>

            <div class="form-group full" style="margin-top:12px;background:#f8fafc;padding:20px;border-radius:14px;border:1px solid var(--border-color);">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div>
                        <span style="font-size:12px;font-weight:700;color:var(--text-muted);text-transform:uppercase;">Calculated Grand Total</span>
                        <h3 style="font-family:'Outfit',sans-serif;font-size:28px;color:#0f766e;margin-top:2px;" id="total_amount_display">Rs 0.00</h3>
                    </div>
                    <i class="fa-solid fa-receipt" style="font-size:36px;color:#14b8a6;opacity:0.6;"></i>
                </div>
                <input type="hidden" id="total_amount" value="Rs 0.00">
            </div>

        </div>

        <div class="form-actions">
            <button type="submit" class="btn">
                <i class="fa-solid fa-receipt"></i> Generate Invoice Preview
            </button>
            <button type="reset" class="ghost-btn" onclick="setTimeout(updateBillingTotal, 0)">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </button>
            <a href="/billing" class="ghost-btn">Back to Billing</a>
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

    document.getElementById('total_amount_display').textContent = 'Rs ' + total.toFixed(2);
    document.getElementById('total_amount').value = 'Rs ' + total.toFixed(2);
}

updateBillingTotal();
</script>
@endpush
