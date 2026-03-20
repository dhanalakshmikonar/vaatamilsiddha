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
<input type="text" name="name" placeholder="Enter patient name" required>
</div>

<div class="form-group">
<label>Age</label>
<input type="number" name="age" placeholder="Enter age" required>
</div>

<div class="form-group">
<label>Gender</label>
<select name="gender" required>
<option value="">Select Gender</option>
<option>Male</option>
<option>Female</option>
<option>Other</option>
</select>
</div>

<div class="form-group">
<label>Phone Number</label>
<input type="text" name="phone" placeholder="Enter phone number">
</div>

<div class="form-group">
<label>Visit Date</label>
<input type="date" name="visit_date" value="{{date('Y-m-d')}}" required>
</div>

<div class="form-group full">
<label>Diagnosis</label>
<textarea name="diagnosis" rows="3" placeholder="Patient diagnosis"></textarea>
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
            <button type="button" class="delete-btn" onclick="removeMedicineRow(this)">Remove</button>
        </div>
    `;
    container.appendChild(row);
}

function removeMedicineRow(button) {
    button.closest('.medicine-row').remove();
}

addMedicineRow();
</script>
@endpush
