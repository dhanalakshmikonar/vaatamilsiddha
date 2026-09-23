@extends('layout.app')

@section('content')

<style>
    .history-toggle {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 18px;
        background: #f1f5f9;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        cursor: pointer;
        transition: var(--transition-fast);
    }

    .history-toggle:hover {
        background: #e2e8f0;
    }

    .history-toggle i {
        transition: transform 0.25s ease;
    }

    .history-panel {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 18px;
        margin-top: 10px;
    }

    .history-checkbox-row {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 16px;
        cursor: pointer;
    }

    .history-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 12px;
    }

    .history-item {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 10px 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .history-select {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        border: 1px solid #cbd5e1;
        background: #f1f5f9;
        color: #334155;
        font-weight: 800;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-fast);
        flex-shrink: 0;
    }

    .history-select[data-val="Y"], .history-select.val-y {
        background: #dcfce7;
        color: #15803d;
        border-color: #86efac;
    }

    .history-select[data-val="N"], .history-select.val-n {
        background: #fee2e2;
        color: #b91c1c;
        border-color: #fca5a5;
    }

    .history-item span {
        font-size: 12px;
        font-weight: 600;
        color: #334155;
        line-height: 1.2;
    }

    /* Medicine Section & Rows */
    .medicine-section {
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--border-color);
    }

    .medicine-section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .medicine-section-header h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .medicine-section-header p {
        font-size: 13px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .medicine-row {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        margin-bottom: 14px;
        display: grid;
        grid-template-columns: 2fr 1fr auto;
        align-items: flex-end;
        gap: 16px;
        transition: var(--transition-fast);
    }

    .medicine-row:hover {
        border-color: #cbd5e1;
        background: #f1f5f9;
    }

    .remove-medicine-btn {
        height: 42px;
        padding: 0 16px;
        border-radius: var(--radius-md);
        background: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: var(--transition-fast);
    }

    .remove-medicine-btn:hover {
        background: #fecdd3;
        color: #991b1b;
        transform: translateY(-1px);
    }

    .total-box-card {
        background: linear-gradient(135deg, #f0fdfa, #e6fffa);
        border: 1px solid #99f6e4;
        border-radius: var(--radius-md);
        padding: 16px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    @media (max-width: 768px) {
        .medicine-row {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-container">

    <div class="form-header">
        <h2><i class="fa-solid fa-user-pen" style="color:var(--primary);margin-right:8px;"></i> Edit Patient Record</h2>
        <p>Update patient personal details, clinical history, diagnostic notes, and prescribed medicines.</p>
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

    <form method="POST" action="/patients/{{ $patient->id }}" id="patientEditForm">
        @csrf
        @method('PUT')

        <div class="form-grid">

            <!-- Section 1: Personal Details -->
            <div class="form-section-title">
                <i class="fa-solid fa-address-card"></i> Personal Information
            </div>

            <div class="form-group">
                <label for="name">Patient Full Name <span style="color:#ef4444;">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $patient->name) }}" required placeholder="e.g. Samuel Rajan">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone', $patient->phone) }}" placeholder="10-digit mobile number">
            </div>

            <div class="form-group">
                <label for="age">Age (Years) <span style="color:#ef4444;">*</span></label>
                <input type="number" name="age" id="age" value="{{ old('age', $patient->age) }}" required placeholder="e.g. 38" min="0" max="150">
            </div>

            <div class="form-group">
                <label for="gender">Gender <span style="color:#ef4444;">*</span></label>
                <select name="gender" id="gender" required>
                    <option value="Male" {{ old('gender', $patient->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $patient->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ old('gender', $patient->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="place">Place / City</label>
                <input type="text" name="place" id="place" value="{{ old('place', $patient->place) }}" placeholder="e.g. Tirunelveli / Chennai">
            </div>

            <div class="form-group">
                <label for="entity">Entity / Clinic Tag</label>
                <input type="text" name="entity" id="entity" value="{{ old('entity', $patient->entity) }}" placeholder="e.g. Main Clinic">
            </div>

            <div class="form-group">
                <label for="payment_mode">Payment Mode</label>
                <input type="text" name="payment_mode" id="payment_mode" value="{{ old('payment_mode', $patient->payment_mode) }}" placeholder="Cash / UPI / GPay / Card">
            </div>

            <div class="form-group">
                <label for="visit_date">Visit Date <span style="color:#ef4444;">*</span></label>
                <input type="date" name="visit_date" id="visit_date" value="{{ old('visit_date', $patient->visit_date) }}" required>
            </div>

            <!-- Section 2: Clinical History & Diagnosis -->
            <div class="form-section-title">
                <i class="fa-solid fa-notes-medical"></i> Clinical Examination & History
            </div>

            <div class="form-group full">
                <button type="button" class="history-toggle" onclick="toggleHistorySection()">
                    <span><i class="fa-solid fa-book-medical" style="color:var(--primary);margin-right:8px;"></i> Patient Medical History (Click to expand / collapse)</span>
                    <i class="fa-solid fa-chevron-down" id="history-toggle-icon"></i>
                </button>

                <div class="history-panel" id="history-panel" style="display:none;">
                    <label class="history-checkbox-row">
                        <input type="checkbox" name="no_patient_history" id="no_patient_history" value="1" {{ old('no_patient_history', $patient->no_patient_history) ? 'checked' : '' }} onchange="toggleNoPatientHistory(this.checked)">
                        <span>No prior medical history</span>
                    </label>

                    <div class="history-grid">
                        @php
                            $historyValues = old('patient_history', $patient->patient_history ?? []);
                        @endphp
                        @foreach($historyFields as $key => $label)
                        @php
                            $val = strtoupper($historyValues[$key] ?? '-');
                            $valClass = $val === 'Y' ? 'val-y' : ($val === 'N' ? 'val-n' : '');
                        @endphp
                        <div class="history-item">
                            <div class="history-select-wrap">
                                <input type="hidden" name="patient_history[{{ $key }}]" value="{{ $historyValues[$key] ?? '-' }}" class="history-input">
                                <button type="button" class="history-select {{ $valClass }}" onclick="cycleHistoryValue(this)">{{ $val }}</button>
                            </div>
                            <span>{{ $label }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="form-group full">
                <label for="diagnosis">Diagnosis / Chief Complaints</label>
                <textarea name="diagnosis" id="diagnosis" rows="3" placeholder="Enter pulse observation (Naadi), vatha/pitha/kaba condition, or symptoms...">{{ old('diagnosis', $patient->diagnosis) }}</textarea>
            </div>

            <!-- Section 3: Therapy & Consultation -->
            <div class="form-section-title">
                <i class="fa-solid fa-spa"></i> Therapy & Consultation Fees
            </div>

            <div class="form-group">
                <label for="therapy">Therapy (Optional)</label>
                <select name="therapy" id="therapy" onchange="updatePatientTotal()">
                    <option value="">-- Select Therapy --</option>
                    @foreach($therapyOptions as $key => $option)
                    <option
                        value="{{ $key }}"
                        data-amount="{{ $option['amount'] }}"
                        {{ old('therapy', $patient->therapy) === $key ? 'selected' : '' }}
                    >
                        {{ $option['label'] }} — Rs {{ number_format((float) $option['amount'], 2) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="appointment_amount">Consultation / Appointment Fee (Rs)</label>
                <input
                    type="number"
                    step="0.01"
                    min="0"
                    name="appointment_amount"
                    id="appointment_amount"
                    value="{{ old('appointment_amount', $patient->appointment_amount) }}"
                    placeholder="e.g. 200"
                    oninput="updatePatientTotal()"
                >
            </div>

            <div class="form-group full">
                <div class="total-box-card">
                    <div>
                        <span style="font-size:11.5px;font-weight:700;color:#0f766e;text-transform:uppercase;letter-spacing:0.04em;">Calculated Visit Total</span>
                        <h3 style="font-family:'Outfit',sans-serif;font-size:24px;color:#064e3b;margin-top:2px;" id="total_amount_display">Rs 0.00</h3>
                    </div>
                    <i class="fa-solid fa-wallet" style="font-size:30px;color:#14b8a6;opacity:0.7;"></i>
                </div>
                <input type="hidden" id="total_amount_preview" value="Rs 0.00">
            </div>

        </div>

        <!-- Section 4: Prescribed Medicines -->
        <div class="medicine-section">
            <div class="medicine-section-header">
                <div>
                    <h3><i class="fa-solid fa-capsules" style="color:var(--primary);"></i> Prescribed Medicines</h3>
                    <p>Add herbal medicines and dosage quantities for this patient visit.</p>
                </div>
                <button type="button" class="btn" onclick="addMedicineRow()" style="padding:8px 16px;font-size:12.5px;">
                    <i class="fa-solid fa-plus"></i> Add Medicine
                </button>
            </div>

            <div id="medicine-rows"></div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions" style="margin-top:32px;">
            <button type="submit" class="btn" style="padding:12px 24px;font-size:14px;">
                <i class="fa-solid fa-check"></i> Update Patient Record
            </button>
            <a href="/patients" class="ghost-btn" style="padding:11px 20px;">
                <i class="fa-solid fa-arrow-left"></i> Cancel
            </a>
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
    let html = '<option value="">-- Choose Medicine --</option>';
    medicines.forEach(medicine => {
        const selected = String(selectedId) === String(medicine.id) ? 'selected' : '';
        const price = parseFloat(medicine.selling_price || medicine.cost || 0).toFixed(2);
        html += `<option value="${medicine.id}" data-amount="${medicine.selling_price || medicine.cost || 0}" ${selected}>${medicine.name} (Stock: ${medicine.stock} | Rs ${price})</option>`;
    });
    return html;
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
        <div class="form-group" style="margin:0;">
            <label style="font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;display:block;">Select Medicine</label>
            <select name="medicine_id[]" onchange="updatePatientTotal()">
                ${medicineOptions(selectedId)}
            </select>
        </div>
        <div class="form-group" style="margin:0;">
            <label style="font-size:12px;font-weight:700;color:#334155;margin-bottom:4px;display:block;">Quantity</label>
            <input type="number" name="quantity[]" min="1" value="${quantity}" oninput="updatePatientTotal()" placeholder="Qty">
        </div>
        <div style="display:flex;align-items:flex-end;">
            <button type="button" class="remove-medicine-btn" onclick="removeMedicineRow(this)" title="Remove this medicine">
                <i class="fa-solid fa-trash-can"></i> Remove
            </button>
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

    const therapySelect = document.getElementById('therapy');
    const therapyAmount = getSelectedAmount(therapySelect);
    const appointmentAmount = parseFloat(document.getElementById('appointment_amount')?.value || '0');
    const total = medicineTotal + therapyAmount + appointmentAmount;

    const formatted = 'Rs ' + total.toFixed(2);
    const displayElem = document.getElementById('total_amount_display');
    if (displayElem) displayElem.textContent = formatted;
    const previewInput = document.getElementById('total_amount_preview');
    if (previewInput) previewInput.value = formatted;
}

function toggleHistorySection(forceOpen = null) {
    const panel = document.getElementById('history-panel');
    const icon = document.getElementById('history-toggle-icon');
    if (!panel || !icon) return;

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
            button.className = 'history-select';
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
    button.className = 'history-select ' + (next === 'Y' ? 'val-y' : (next === 'N' ? 'val-n' : ''));
}

document.addEventListener('DOMContentLoaded', function() {
    if (existingItems && existingItems.length) {
        existingItems.forEach(item => addMedicineRow(item.medicine_id, item.quantity));
    } else {
        addMedicineRow();
    }
    updatePatientTotal();
});
</script>
@endpush
