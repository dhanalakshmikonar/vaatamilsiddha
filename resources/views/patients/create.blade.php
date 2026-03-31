@extends('layout.app')

@section('content')

<div class="form-container">

@if ($errors->any())
<div style="background:#fee2e2;color:#991b1b;padding:12px 14px;border-radius:8px;margin-bottom:20px;">
{{$errors->first()}}
</div>
@endif

<div class="form-header">
<h2>Add Patient</h2>
<p>Register a new patient in the clinic system</p>
</div>

<form method="POST" action="/patients">

@csrf

<div class="form-grid">

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="name" placeholder="Enter patient name" value="{{ old('name') }}" required>
</div>

<div class="form-group">
<label>Age</label>
<input type="number" name="age" placeholder="Enter age" value="{{ old('age') }}" required>
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender" required>
<option value="">Select Gender</option>
<option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
<option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
<option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
</select>
</div>

<div class="form-group">
<label>Phone Number</label>
<input type="text" name="phone" placeholder="Enter phone number" value="{{ old('phone') }}">
</div>

<div class="form-group">
<label>Place</label>
<input type="text" name="place" placeholder="Enter place" value="{{ old('place') }}">
</div>

<div class="form-group">
<label>Entity</label>
<input type="text" name="entity" placeholder="Enter entity" value="{{ old('entity') }}">
</div>

<div class="form-group">
<label>Payment Mode</label>
<input type="text" name="payment_mode" placeholder="Cash / Card / UPI" value="{{ old('payment_mode') }}">
</div>

<div class="form-group">
<label>Visit Date</label>
<input type="date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" required>
</div>

<div class="form-group full">
<button type="button" class="history-toggle" onclick="toggleHistorySection()">
<span>Patient History</span>
<i class="fa-solid fa-chevron-down" id="history-toggle-icon"></i>
</button>
<div class="history-panel" id="history-panel" style="display:none;">
<label class="history-checkbox-row">
<input type="checkbox" name="no_patient_history" id="no_patient_history" value="1" {{ old('no_patient_history') ? 'checked' : '' }} onchange="toggleNoPatientHistory(this.checked)">
<span>No patient history</span>
</label>
<div class="history-grid">
@foreach($historyFields as $key => $label)
<div class="history-item">
<div class="history-select-wrap">
<input type="hidden" name="patient_history[{{ $key }}]" value="{{ old('patient_history.' . $key, '-') }}" class="history-input">
<button type="button" class="history-select" onclick="cycleHistoryValue(this)">@php($value = old('patient_history.' . $key, '-')){{ strtoupper($value) }}</button>
</div>
<span>{{ $label }}</span>
</div>
@endforeach
</div>
</div>
</div>

<div class="form-group full">
<label>Diagnosis</label>
<textarea name="diagnosis" rows="3" placeholder="Patient diagnosis">{{ old('diagnosis') }}</textarea>
</div>

<div class="form-group">
<label>Therapy (Optional)</label>
<select name="therapy" id="therapy" onchange="updatePatientTotal()">
<option value="">Select Therapy</option>
@foreach($therapyOptions as $key => $option)
<option value="{{ $key }}" data-amount="{{ $option['amount'] }}" {{ old('therapy') === $key ? 'selected' : '' }}>{{ $option['label'] }} - Rs {{ number_format((float) $option['amount'], 2) }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Appointment Amount</label>
<input type="number" step="0.01" min="0" name="appointment_amount" id="appointment_amount" value="{{ old('appointment_amount') }}" placeholder="Enter appointment amount" oninput="updatePatientTotal()">
</div>

<div class="form-group full">
<label>Total Amount</label>
<input type="text" id="total_amount_preview" value="Rs 0.00" readonly>
</div>

</div>

<div class="medicine-section">
<div class="section-title">
<div>
<h3>Medicines</h3>
<p style="color:#666;font-size:14px">Add medicines under this patient visit</p>
</div>
<button type="button" class="secondary-btn" onclick="addMedicineRow()">Add Medicine</button>
</div>

<div id="medicine-rows"></div>
</div>

<div class="form-actions">
<button type="submit" class="btn-primary">
Save Patient
</button>
</div>

</form>

</div>

@endsection

@push('scripts')
<script>
const medicines = {!! json_encode($medicinesData) !!};
const oldMedicineIds = {!! json_encode(old('medicine_id', [])) !!};
const oldQuantities = {!! json_encode(old('quantity', [])) !!};

function medicineOptions(selectedId = '') {
    const defaultOption = '<option value="">Select Medicine</option>';
    return defaultOption + medicines.map((medicine) => {
        const selected = String(selectedId) === String(medicine.id) ? 'selected' : '';
        const price = parseFloat(medicine.selling_price || medicine.cost || 0).toFixed(2);
        return `<option value="${medicine.id}" data-amount="${medicine.selling_price || medicine.cost || 0}" ${selected}>${medicine.name} (Stock: ${medicine.stock}, Rs ${price})</option>`;
    }).join('');
}

function getSelectedAmount(select) {
    if (!select || select.selectedIndex < 0) return 0;
    const option = select.options[select.selectedIndex];
    return parseFloat(option.getAttribute('data-amount') || '0');
}

function addMedicineRow(selectedId = '', quantity = 1) {
    const container = document.getElementById('medicine-rows');
    const row = document.createElement('div');
    row.className = 'medicine-row';
    row.innerHTML = `
        <div class="form-group">
            <label>Medicine</label>
            <select name="medicine_id[]" onchange="updatePatientTotal()">
                ${medicineOptions(selectedId)}
            </select>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity[]" min="1" value="${quantity}" oninput="updatePatientTotal()">
        </div>
        <div class="form-group">
            <button type="button" class="delete-btn" onclick="removeMedicineRow(this)">Remove</button>
        </div>
    `;
    container.appendChild(row);
    updatePatientTotal();
}

function removeMedicineRow(button) {
    button.closest('.medicine-row').remove();
    updatePatientTotal();
}

function updatePatientTotal() {
    let medicineTotal = 0;

    document.querySelectorAll('#medicine-rows .medicine-row').forEach((row) => {
        const select = row.querySelector('select[name="medicine_id[]"]');
        const quantity = parseFloat(row.querySelector('input[name="quantity[]"]')?.value || '0');
        medicineTotal += getSelectedAmount(select) * quantity;
    });

    const therapyAmount = getSelectedAmount(document.getElementById('therapy'));
    const appointmentAmount = parseFloat(document.getElementById('appointment_amount').value || '0');
    const total = medicineTotal + therapyAmount + appointmentAmount;

    document.getElementById('total_amount_preview').value = 'Rs ' + total.toFixed(2);
}

function toggleHistorySection(forceOpen = null) {
    const panel = document.getElementById('history-panel');
    const icon = document.getElementById('history-toggle-icon');
    const shouldOpen = forceOpen === null ? panel.style.display === 'none' : forceOpen;

    panel.style.display = shouldOpen ? 'block' : 'none';
    icon.style.transform = shouldOpen ? 'rotate(180deg)' : 'rotate(0deg)';
}

function toggleNoPatientHistory(checked) {
    document.querySelectorAll('.history-select-wrap').forEach((wrap) => {
        const input = wrap.querySelector('.history-input');
        const button = wrap.querySelector('.history-select');

        if (checked) {
            input.value = '-';
            button.textContent = '-';
        }

        button.disabled = checked;
    });
}

function cycleHistoryValue(button) {
    const input = button.parentElement.querySelector('.history-input');
    const values = ['-', 'Y', 'N'];
    const current = (input.value || '-').toUpperCase();
    const index = values.indexOf(current);
    const next = values[(index + 1) % values.length];

    input.value = next.toLowerCase();
    button.textContent = next;
}

if (oldMedicineIds.length) {
    oldMedicineIds.forEach((medicineId, index) => addMedicineRow(medicineId, oldQuantities[index] || 1));
} else {
    addMedicineRow();
}

toggleHistorySection(false);
toggleNoPatientHistory(document.getElementById('no_patient_history').checked);
updatePatientTotal();
</script>
@endpush
