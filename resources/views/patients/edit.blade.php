@extends('layout.app')

@section('content')

<div class="form-container">

@if ($errors->any())
<div style="background:#fee2e2;color:#991b1b;padding:12px 14px;border-radius:8px;margin-bottom:20px;">
{{$errors->first()}}
</div>
@endif

<div class="form-header">
<h2>Edit Patient</h2>
<p>Update patient information and medicines</p>
</div>

<form method="POST" action="/patients/{{$patient->id}}">

@csrf
@method('PUT')

<div class="form-grid">

<div class="form-group">
<label>Patient Name</label>
<input type="text" name="name" value="{{ old('name', $patient->name) }}" required>
</div>

<div class="form-group">
<label>Age</label>
<input type="number" name="age" value="{{ old('age', $patient->age) }}" required>
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender" required>
<option value="Male" {{ old('gender', $patient->gender)=='Male'?'selected':'' }}>Male</option>
<option value="Female" {{ old('gender', $patient->gender)=='Female'?'selected':'' }}>Female</option>
<option value="Other" {{ old('gender', $patient->gender)=='Other'?'selected':'' }}>Other</option>
</select>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" value="{{ old('phone', $patient->phone) }}">
</div>

<div class="form-group">
<label>Place</label>
<input type="text" name="place" value="{{ old('place', $patient->place) }}">
</div>

<div class="form-group">
<label>Entity</label>
<input type="text" name="entity" value="{{ old('entity', $patient->entity) }}">
</div>

<div class="form-group">
<label>Payment Mode</label>
<input type="text" name="payment_mode" value="{{ old('payment_mode', $patient->payment_mode) }}">
</div>

<div class="form-group">
<label>Visit Date</label>
<input type="date" name="visit_date" value="{{ old('visit_date', $patient->visit_date) }}" required>
</div>

<div class="form-group full">
<button type="button" class="history-toggle" onclick="toggleHistorySection()">
<span>Patient History</span>
<i class="fa-solid fa-chevron-down" id="history-toggle-icon"></i>
</button>
<div class="history-panel" id="history-panel" style="display:none;">
<label class="history-checkbox-row">
<input type="checkbox" name="no_patient_history" id="no_patient_history" value="1" {{ old('no_patient_history', $patient->no_patient_history) ? 'checked' : '' }} onchange="toggleNoPatientHistory(this.checked)">
<span>No patient history</span>
</label>
<div class="history-grid">
@php
$historyValues = old('patient_history', $patient->patient_history ?? []);
@endphp
@foreach($historyFields as $key => $label)
<div class="history-item">
<div class="history-select-wrap">
<input type="hidden" name="patient_history[{{ $key }}]" value="{{ $historyValues[$key] ?? '-' }}" class="history-input">
<button type="button" class="history-select" onclick="cycleHistoryValue(this)">{{ strtoupper($historyValues[$key] ?? '-') }}</button>
</div>
<span>{{ $label }}</span>
</div>
@endforeach
</div>
</div>
</div>

<div class="form-group full">
<label>Diagnosis</label>
<textarea name="diagnosis">{{ old('diagnosis', $patient->diagnosis) }}</textarea>
</div>

<div class="form-group">
<label>Therapy (Optional)</label>
<select name="therapy" id="therapy" onchange="updatePatientTotal()">
<option value="">Select Therapy</option>
@foreach($therapyOptions as $key => $option)
<option value="{{ $key }}" data-amount="{{ $option['amount'] }}" {{ old('therapy', $patient->therapy) === $key ? 'selected' : '' }}>{{ $option['label'] }} - Rs {{ number_format((float) $option['amount'], 2) }}</option>
@endforeach
</select>
</div>

<div class="form-group">
<label>Appointment Amount</label>
<input type="number" step="0.01" min="0" name="appointment_amount" id="appointment_amount" value="{{ old('appointment_amount', $patient->appointment_amount) }}" oninput="updatePatientTotal()">
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
<p style="color:#666;font-size:14px">Edit medicines for this patient visit</p>
</div>
<button type="button" class="secondary-btn" onclick="addMedicineRow()">Add Medicine</button>
</div>

<div id="medicine-rows"></div>
</div>

<div class="form-actions">
<button class="btn-primary">Update Patient</button>
</div>

</form>

</div>

@endsection

@push('scripts')
@php
$scriptExistingItems = old('medicine_id')
    ? collect(old('medicine_id'))->map(function ($item, $index) {
        return [
            'medicine_id' => $item,
            'quantity' => old('quantity')[$index] ?? 1,
        ];
    })->values()
    : collect($existingMedicineItems);
@endphp
<script>
const medicines = {!! json_encode($medicinesData) !!};
const existingItems = {!! json_encode($scriptExistingItems) !!};

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

if (existingItems.length) {
    existingItems.forEach((item) => addMedicineRow(item.medicine_id, item.quantity));
} else {
    addMedicineRow();
}

toggleHistorySection(true);
toggleNoPatientHistory(document.getElementById('no_patient_history').checked);
updatePatientTotal();
</script>
@endpush
