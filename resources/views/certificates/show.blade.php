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

    .cert-body-card {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        margin-bottom: 32px;
        overflow: hidden;
    }

    .cert-body-header {
        background: #f1f5f9;
        padding: 12px 20px;
        border-bottom: 1px solid var(--border-color);
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #334155;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cert-detail-table {
        width: 100%;
        border-collapse: collapse;
    }

    .cert-detail-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #edf2f7;
        font-size: 13.5px;
        color: #1e293b;
        vertical-align: top;
    }

    .cert-detail-table tr:last-child td {
        border-bottom: none;
    }

    .cert-label {
        width: 200px;
        font-weight: 700;
        color: #475569;
        background: #fafbfc;
        border-right: 1px solid #edf2f7;
    }

    .cert-value {
        line-height: 1.6;
        color: #0f172a;
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
        width: 220px;
    }

    .signature-line {
        border-top: 1px solid #94a3b8;
        margin-top: 8px;
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
        .cert-body-card,
        .cert-body-header,
        .cert-detail-table td {
            background: #ffffff !important;
            border-color: #cbd5e1 !important;
        }
    }
</style>

<div class="invoice-wrapper">

    <!-- Screen Toolbar -->
    <div class="invoice-toolbar">
        <a href="/certificates" class="ghost-btn">
            <i class="fa-solid fa-arrow-left"></i> Back to Certificates
        </a>

        <div style="display:flex;gap:10px;">
            <a href="/certificates/{{ $certificate->id }}/edit" class="ghost-btn">
                <i class="fa-solid fa-pen-to-square"></i> Edit Certificate
            </a>
            <button type="button" class="btn" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Print Certificate
            </button>
        </div>
    </div>

    <!-- Printable Certificate Sheet (Exact Billing Invoice Structure) -->
    <div class="invoice-sheet" id="certificateSheet">

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
                <h3>Doctor Certificate</h3>
                <p><strong>Certificate #:</strong> CERT-{{ str_pad($certificate->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Date:</strong> {{ $certificate->date ? \Carbon\Carbon::parse($certificate->date)->format('d M Y') : date('d M Y') }}</p>
            </div>
        </div>

        <!-- Patient Details Grid -->
        <div class="patient-meta-grid">
            <div class="meta-box">
                <span>Patient Name</span>
                <strong>{{ $certificate->patient->name ?? '-' }}</strong>
            </div>
            <div class="meta-box">
                <span>Phone Number</span>
                <strong>{{ $certificate->patient->phone ?? '-' }}</strong>
            </div>
            <div class="meta-box">
                <span>Age / Gender</span>
                <strong>
                    {{ ($certificate->patient && $certificate->patient->age) ? $certificate->patient->age . ' yrs' : '-' }}
                    {{ ($certificate->patient && $certificate->patient->gender) ? '• ' . $certificate->patient->gender : '' }}
                </strong>
            </div>
            <div class="meta-box">
                <span>Place / City</span>
                <strong>{{ $certificate->patient->place ?? '-' }}</strong>
            </div>
            <div class="meta-box">
                <span>Certificate Type</span>
                <strong style="color:#0f766e;">{{ $certificate->certificate_type }} Recommendation</strong>
            </div>
            <div class="meta-box">
                <span>Attending Doctor</span>
                <strong>Dr. {{ $certificate->doctor->name ?? 'Consulting Physician' }}</strong>
            </div>
        </div>

        <!-- Certificate Body: Replaces Medicine/Item Details Section -->
        <div class="cert-body-card">
            <div class="cert-body-header">
                <span><i class="fa-solid fa-file-waveform" style="color:#0f766e;margin-right:6px;"></i> Medical Certification & Leave Recommendation</span>
                <span style="font-weight:700;color:#0f766e;">Official Record</span>
            </div>

            <table class="cert-detail-table">
                <tbody>
                    <tr>
                        <td class="cert-label">Patient Name</td>
                        <td class="cert-value">
                            <strong style="font-size:15px;color:#064e3b;">{{ $certificate->patient->name ?? '-' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="cert-label">Diagnosis</td>
                        <td class="cert-value">
                            <strong style="color:#0f172a;font-size:14.5px;">{{ $certificate->diagnosis }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="cert-label">Date of Issue</td>
                        <td class="cert-value">
                            {{ $certificate->date ? \Carbon\Carbon::parse($certificate->date)->format('d F Y') : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="cert-label">Leave From</td>
                        <td class="cert-value">
                            <strong>{{ $certificate->leave_from ? \Carbon\Carbon::parse($certificate->leave_from)->format('d F Y') : '-' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="cert-label">Leave To</td>
                        <td class="cert-value">
                            <strong>{{ $certificate->leave_to ? \Carbon\Carbon::parse($certificate->leave_to)->format('d F Y') : '-' }}</strong>
                            @if($certificate->leave_from && $certificate->leave_to)
                                @php
                                    $from = \Carbon\Carbon::parse($certificate->leave_from);
                                    $to = \Carbon\Carbon::parse($certificate->leave_to);
                                    $days = $from->diffInDays($to) + 1;
                                @endphp
                                <span class="badge-pill teal" style="margin-left:8px;font-size:11.5px;">
                                    Total: {{ $days }} {{ \Illuminate\Support\Str::plural('Day', $days) }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="cert-label">Doctor's Description</td>
                        <td class="cert-value" style="white-space: pre-line; line-height: 1.7; color: #334155;">{{ $certificate->doctor_description }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-note">
                <strong>Vaatamilsiddha Holistic Medical Care</strong><br>
                This medical certificate is issued upon clinical consultation and assessment. For authenticity verification, please contact our clinic front desk.
            </div>

            <!-- Signature Section: Shows Authorised Signature + Uploaded Doctor Signature Image -->
            @php
                $certDoc = $certificate->doctor ?? \App\Models\Doctor::whereNotNull('signature')->where('signature', '!=', '')->latest()->first();
                $certSigImg = null;

                if ($certDoc && !empty($certDoc->signature)) {
                    $cleanPath = ltrim($certDoc->signature, '/\\');
                    $certSigImg = '/' . $cleanPath;
                }

                if (!$certSigImg || !file_exists(public_path(ltrim($certSigImg, '/\\')))) {
                    $fallbackDoc = \App\Models\Doctor::whereNotNull('signature')->where('signature', '!=', '')->latest()->first();
                    if ($fallbackDoc && !empty($fallbackDoc->signature)) {
                        $certSigImg = '/' . ltrim($fallbackDoc->signature, '/\\');
                    }
                }

                if (!$certSigImg || !file_exists(public_path(ltrim($certSigImg, '/\\')))) {
                    if (file_exists(public_path('images/doctor_signature.jpg'))) {
                        $certSigImg = '/images/doctor_signature.jpg';
                    } elseif (file_exists(public_path('uploads/doctors/doctor_signature.jpg'))) {
                        $certSigImg = '/uploads/doctors/doctor_signature.jpg';
                    }
                }
            @endphp
            <div class="signature-area">
                @if($certSigImg)
                    <img src="{{ $certSigImg }}" alt="Authorised Signature" style="max-height: 52px; max-width: 170px; object-fit: contain; margin-bottom: 4px; display: block; margin-left: auto; margin-right: auto; mix-blend-mode: multiply;">
                @else
                    <div style="height: 48px;"></div>
                @endif
                <div class="signature-line">
                    Authorised Signature
                </div>
                @if($certDoc)
                    <div style="font-size: 11px; color: #64748b; margin-top: 2px;">
                        Dr. {{ $certDoc->name }}
                        @if($certDoc->qualification)
                            ({{ $certDoc->qualification }})
                        @endif
                    </div>
                @endif
            </div>
        </div>

    </div>

</div>

@endsection
