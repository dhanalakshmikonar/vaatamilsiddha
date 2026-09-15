@extends('layout.app')

@section('content')

<div class="page-shell">

    <div class="toolbar-card">
        <div class="toolbar-title">
            <h2><i class="fa-solid fa-file-invoice-dollar" style="color:var(--primary);"></i> Invoicing & Patient Billing</h2>
            <p>Generate consultation bills, medicine charges, therapies, and print tax receipts.</p>
        </div>

        <div class="toolbar-actions">
            <div class="search-box-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="billingSearch" placeholder="Search patient name, medicine..." onkeyup="filterTable('billingSearch', 'billingTable')">
            </div>

            <a href="/billing/create" class="btn">
                <i class="fa-solid fa-plus"></i> Add Billing
            </a>
            <a href="/billing/export" class="ghost-btn">
                <i class="fa-solid fa-file-excel" style="color:#16a34a;"></i> Export Excel
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-shell">
            <table id="billingTable">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Visit Date</th>
                        <th>Prescribed Medicines</th>
                        <th>Total Bill Amount</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>
                            <div class="patient-cell-wrap">
                                <div class="avatar-initial-chip" style="background:linear-gradient(135deg, #d97706, #b45309);">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong style="color:#0f172a;font-size:14px;">{{ $patient->name }}</strong>
                                    <div style="font-size:11.5px;color:var(--text-muted);">{{ $patient->phone ?: 'No phone' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-pill teal">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $patient->visit_date ? \Carbon\Carbon::parse($patient->visit_date)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            @if($patient->patientMedicines && $patient->patientMedicines->count())
                                <div style="display:flex;flex-wrap:wrap;gap:4px;">
                                    @foreach($patient->patientMedicines as $pm)
                                        @if($pm->medicine)
                                            <span class="badge-pill gray" style="font-size:11px;">
                                                <i class="fa-solid fa-capsules" style="color:#0d9488;"></i> {{ $pm->medicine->name }}
                                            </span>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <span class="badge-pill gray">No medicines</span>
                            @endif
                        </td>
                        <td>
                            <strong style="font-family:'Outfit',sans-serif;font-size:15px;color:#0f172a;">
                                Rs {{ number_format($billSummaries[$patient->id]['grand_total'] ?? 0, 2) }}
                            </strong>
                        </td>
                        <td style="text-align:right;">
                            <a href="/billing/{{ $patient->id }}" class="btn" style="padding:7px 14px;font-size:12px;">
                                <i class="fa-solid fa-file-invoice"></i> View Invoice
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            <i class="fa-solid fa-receipt" style="font-size: 38px; margin-bottom: 14px; display: block; color: #94a3b8;"></i>
                            <strong style="font-size:16px;color:#334155;">No billing records found</strong><br>
                            <p style="font-size:13px;margin:6px 0 16px 0;color:#94a3b8;">Generate bills from patient consultations or medicines.</p>
                            <a href="/billing/create" class="btn">
                                <i class="fa-solid fa-plus"></i> Create First Bill
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
