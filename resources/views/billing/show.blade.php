@extends('layout.app')

@section('content')

<style>
    .invoice-wrapper {
        max-width: 820px;
        margin: 0 auto;
    }

    .invoice-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 12px;
        flex-wrap: wrap;
    }

    .invoice-sheet {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        padding: 40px;
        position: relative;
    }

    .invoice-header-grid {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 24px;
        border-bottom: 2px solid #0f766e;
        margin-bottom: 28px;
    }

    .clinic-info-brand h2 {
        font-family: 'Cormorant Garamond', Georgia, serif;
        font-size: 32px;
        font-weight: 700;
        color: #064e3b;
        letter-spacing: 0.02em;
        line-height: 1.1;
    }

    .clinic-info-brand p {
        font-size: 13px;
        color: #64748b;
        margin-top: 4px;
        line-height: 1.4;
    }

    .invoice-badge-block {
        text-align: right;
    }

    .invoice-badge-block h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #0f766e;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .invoice-badge-block p {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-top: 4px;
    }

    .patient-meta-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        background: #f8fafc;
        padding: 18px 22px;
        border-radius: var(--radius-md);
        border: 1px solid var(--border-color);
        margin-bottom: 28px;
    }

    .meta-box span {
        display: block;
        font-size: 11px;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 3px;
    }

    .meta-box strong {
        font-size: 14px;
        color: #0f172a;
    }

    .invoice-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 28px;
    }

    .invoice-table th {
        background: #f1f5f9;
        color: #334155;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-color);
        text-align: left;
    }

    .invoice-table th.text-right,
    .invoice-table td.text-right {
        text-align: right;
    }

    .invoice-table td {
        padding: 14px 16px;
        border-bottom: 1px solid #edf2f7;
        font-size: 13.5px;
        color: #1e293b;
    }

    .invoice-total-section {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 32px;
    }

    .total-calculation-box {
        width: 280px;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        color: #475569;
        margin-bottom: 8px;
    }

    .total-row.grand {
        border-top: 2px solid #0f766e;
        padding-top: 10px;
        margin-top: 10px;
        margin-bottom: 0;
        font-size: 17px;
        font-weight: 800;
        color: #064e3b;
        font-family: 'Outfit', sans-serif;
    }

    .invoice-footer {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        padding-top: 24px;
        border-top: 1px dashed var(--border-color);
        margin-top: 20px;
    }

    .footer-note {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
        max-width: 440px;
    }

    .signature-area {
        text-align: center;
        width: 180px;
    }

    .signature-line {
        border-top: 1px solid #94a3b8;
        margin-top: 40px;
        padding-top: 6px;
        font-size: 12px;
        font-weight: 700;
        color: #475569;
    }

    /* Print Specific Media Styles */
    @media print {
        body {
            background: #ffffff !important;
            color: #000000 !important;
            height: auto !important;
            overflow: visible !important;
        }

        .sidebar,
        .app-header,
        .invoice-toolbar,
        .toast-notification-wrap {
            display: none !important;
        }

        .app-container {
            display: block !important;
            height: auto !important;
            overflow: visible !important;
        }

        .main-viewport,
        .content-scroll {
            display: block !important;
            padding: 0 !important;
            margin: 0 !important;
            overflow: visible !important;
            height: auto !important;
        }

        .invoice-wrapper {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .invoice-sheet {
            border: none !important;
            box-shadow: none !important;
            padding: 20px 0 !important;
            border-radius: 0 !important;
        }

        .patient-meta-grid,
        .total-calculation-box,
        .meta-box.full-width div,
        .invoice-table th {
            background: #ffffff !important;
            border-color: #cbd5e1 !important;
        }

        .invoice-table td {
            border-bottom: 1px solid #cbd5e1 !important;
        }
    }
</style>

<div class="invoice-wrapper">

    <!-- Screen Toolbar -->
    <div class="invoice-toolbar">
        <a href="/billing" class="ghost-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Billing
        </a>

        <div style="display:flex;gap:10px;">
            <button type="button" class="btn" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Print Invoice
            </button>
        </div>
    </div>

    <!-- Printable Invoice Sheet -->
    <div class="invoice-sheet" id="invoiceSheet">

        <!-- Header -->
        <div class="invoice-header-grid">
            <div class="clinic-info-brand" style="display:flex;align-items:center;gap:18px;">
                <img src="/images/logo.png" alt="Vaatamilsiddha Logo" style="width:72px;height:72px;object-fit:contain;border-radius:12px;background:#ffffff;border:1px solid #e2e8f0;padding:4px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <div>
                    <h2>Vaatamilsiddha</h2>
                    <p>
                        Traditional Siddha Clinic & Holistic Health Care<br>
                        Main Branch • Phone: +91 98765 43210<br>
                        Website: vaatamilsiddha.com
                    </p>
                </div>
            </div>


            <div class="invoice-badge-block">
                <h3>Invoice</h3>
                <p><strong>Invoice #:</strong> INV-{{ str_pad($patient->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Date:</strong> {{ $patient->visit_date ? \Carbon\Carbon::parse($patient->visit_date)->format('d M Y') : date('d M Y') }}</p>
            </div>
        </div>

        <!-- Patient Details -->
        <div class="patient-meta-grid">
            <div class="meta-box">
                <span>Patient Name</span>
                <strong>{{ $patient->name }}</strong>
            </div>
            <div class="meta-box">
                <span>Phone Number</span>
                <strong>{{ $patient->phone ?: '-' }}</strong>
            </div>
            <div class="meta-box">
                <span>Age / Gender</span>
                <strong>{{ $patient->age ? $patient->age . ' yrs' : '-' }} {{ $patient->gender ? '• ' . $patient->gender : '' }}</strong>
            </div>
            <div class="meta-box">
                <span>Place / City</span>
                <strong>{{ $patient->place ?: '-' }}</strong>
            </div>
            <div class="meta-box">
                <span>Payment Mode</span>
                <strong>{{ $patient->payment_mode ?: 'Cash / Direct' }}</strong>
            </div>
            <div class="meta-box">
                <span>Visit Date</span>
                <strong>{{ $patient->visit_date ? \Carbon\Carbon::parse($patient->visit_date)->format('d M Y') : date('d M Y') }}</strong>
            </div>

            <!-- Full Width Diagnosis Section -->
            @if($patient->diagnosis)
            <div class="meta-box full-width" style="grid-column: 1 / -1; border-top: 1px dashed #cbd5e1; padding-top: 12px; margin-top: 2px;">
                <span style="display:flex;align-items:center;gap:6px;margin-bottom:6px;">
                    <i class="fa-solid fa-notes-medical" style="color:#0f766e;"></i> Diagnosis / Clinical Assessment
                </span>
                <div style="font-size: 13.5px; font-weight: 600; color: #1e293b; line-height: 1.65; white-space: pre-line; word-break: break-word; background: #ffffff; padding: 10px 14px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    {{ $patient->diagnosis }}
                </div>
            </div>
            @endif
        </div>

        <!-- Itemized Table -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Item & Description</th>
                    <th style="width: 90px;" class="text-right">Qty</th>
                    <th style="width: 120px;" class="text-right">Unit Price</th>
                    <th style="width: 130px;" class="text-right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @php $rowIdx = 1; @endphp
                @forelse($billSummary['items'] as $item)
                <tr>
                    <td>{{ $rowIdx++ }}</td>
                    <td>
                        <strong>{{ $item['label'] }}</strong>
                        @if($item['type'] === 'medicine')
                            <div style="font-size:11.5px;color:#64748b;">Herbal Medicine Dispensary</div>
                        @elseif($item['type'] === 'fees')
                            <div style="font-size:11.5px;color:#64748b;">Clinical Therapy / Consultation Fee</div>
                        @elseif($item['type'] === 'appointment')
                            <div style="font-size:11.5px;color:#64748b;">Physician Consultation Booking</div>
                        @endif
                    </td>
                    <td class="text-right">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rs {{ number_format((float) $item['unit_price'], 2) }}</td>
                    <td class="text-right"><strong>Rs {{ number_format((float) $item['total'], 2) }}</strong></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 24px; color: #94a3b8;">
                        No bill items recorded for this visit.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Total Calculation -->
        <div class="invoice-total-section">
            <div class="total-calculation-box">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>Rs {{ number_format((float) $billSummary['grand_total'], 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Tax / GST:</span>
                    <span>Rs 0.00</span>
                </div>
                <div class="total-row grand">
                    <span>Grand Total:</span>
                    <span>Rs {{ number_format((float) $billSummary['grand_total'], 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-note">
                <strong>Thank you for choosing Vaatamilsiddha!</strong><br>
                For questions regarding this bill or your prescription dosage, please contact our front desk.
            </div>

            @php
                $doctorSignatory = \App\Models\Doctor::whereNotNull('signature')->where('signature', '!=', '')->first() ?? \App\Models\Doctor::first();
                $signatureImg = ($doctorSignatory && !empty($doctorSignatory->signature) && file_exists(public_path($doctorSignatory->signature)))
                    ? '/' . $doctorSignatory->signature
                    : '/images/doctor_signature.jpg';
            @endphp
            <div class="signature-area">
                <img src="{{ $signatureImg }}" alt="Authorised Signature" style="max-height: 52px; max-width: 170px; object-fit: contain; margin-bottom: 4px; display: block; margin-left: auto; margin-right: auto; mix-blend-mode: multiply;">
                <div class="signature-line">
                    Authorised Signature
                </div>
                @if($doctorSignatory)
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                        Dr. {{ $doctorSignatory->name }}
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection
