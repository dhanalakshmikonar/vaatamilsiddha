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
<input type="text" name="name" value="{{$patient->name}}" required>
</div>

<div class="form-group">
<label>Age</label>
<input type="number" name="age" value="{{$patient->age}}" required>
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender" required>
<option value="Male" {{$patient->gender=='Male'?'selected':''}}>Male</option>
<option value="Female" {{$patient->gender=='Female'?'selected':''}}>Female</option>
<option value="Other" {{$patient->gender=='Other'?'selected':''}}>Other</option>
</select>
</div>

<div class="form-group">
<label>Phone</label>
<input type="text" name="phone" value="{{$patient->phone}}">
</div>

<div class="form-group">
<label>Visit Date</label>
<input type="date" name="visit_date" value="{{$patient->visit_date}}" required>
</div>

<div class="form-group full">
<label>Diagnosis</label>
<textarea name="diagnosis">{{$patient->diagnosis}}</textarea>
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

<div class="summary-box">
Total Amount: Rs <span id="grand-total">{{number_format($patient->total_amount, 2)}}</span>
</div>
</div>

<div class="form-actions">
<button class="btn-primary">Update Patient</button>
</div>

</form>

</div>

@endsection

@push('scripts')
<script>
const medicines = {!! json_encode($medicinesData) !!};
const existingItems = {!! json_encode($existingMedicineItems) !!};

function medicineOptions(selectedId = '') {
    const defaultOption = '<option value="">Select Medicine</option>';
    return defaultOption + medicines.map((medicine) => {
        const selected = String(selectedId) === String(medicine.id) ? 'selected' : '';
        return `<option value="${medicine.id}" data-cost="${medicine.cost}" ${selected}>${medicine.name} (Stock: ${medicine.stock})</option>`;
    }).join('');
}

function addMedicineRow(selectedId = '', quantity = 1) {
    const container = document.getElementById('medicine-rows');
    const row = document.createElement('div');
    row.className = 'medicine-row';
    row.innerHTML = `
        <div class="form-group">
            <label>Medicine</label>
            <select name="medicine_id[]" onchange="updateMedicineRow(this)">
                ${medicineOptions(selectedId)}
            </select>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity[]" min="1" value="${quantity}" oninput="updateMedicineRow(this)">
        </div>
        <div class="form-group">
            <label>Unit Price</label>
            <input type="text" class="readonly-field unit-price" readonly>
        </div>
        <div class="form-group">
            <label>Total</label>
            <input type="text" class="readonly-field line-total" readonly>
        </div>
        <div class="form-group">
            <button type="button" class="delete-btn" onclick="removeMedicineRow(this)">Remove</button>
        </div>
    `;
    container.appendChild(row);
    updateMedicineRow(row.querySelector('select'));
}

function updateMedicineRow(element) {
    const row = element.closest('.medicine-row');
    const select = row.querySelector('select');
    const quantityInput = row.querySelector('input[name="quantity[]"]');
    const unitPriceInput = row.querySelector('.unit-price');
    const lineTotalInput = row.querySelector('.line-total');
    const selectedOption = select.options[select.selectedIndex];
    const unitPrice = parseFloat(selectedOption?.dataset?.cost || 0);
    const quantity = parseInt(quantityInput.value || 0, 10);

    unitPriceInput.value = unitPrice.toFixed(2);
    lineTotalInput.value = (unitPrice * quantity).toFixed(2);

    updateGrandTotal();
}

function removeMedicineRow(button) {
    button.closest('.medicine-row').remove();
    updateGrandTotal();
}

function updateGrandTotal() {
    let total = 0;

    document.querySelectorAll('.line-total').forEach((input) => {
        total += parseFloat(input.value || 0);
    });

    document.getElementById('grand-total').textContent = total.toFixed(2);
}

if (existingItems.length) {
    existingItems.forEach((item) => addMedicineRow(item.medicine_id, item.quantity));
} else {
    addMedicineRow();
}
</script>
@endpush
