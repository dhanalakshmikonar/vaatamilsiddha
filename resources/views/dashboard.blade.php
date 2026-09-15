@extends('layout.app')

@section('content')

<style>
    .dashboard-welcome {
        background: linear-gradient(135deg, #064e3b 0%, #0f766e 60%, #0d9488 100%);
        border-radius: var(--radius-lg);
        padding: 28px 32px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 28px;
        box-shadow: 0 16px 36px rgba(6, 78, 59, 0.22);
        position: relative;
        overflow: hidden;
    }

    .dashboard-welcome::after {
        content: '\f469';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        right: 25px;
        bottom: -20px;
        font-size: 140px;
        color: rgba(255, 255, 255, 0.06);
        pointer-events: none;
    }

    .welcome-text h2 {
        font-family: 'Outfit', sans-serif;
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.02em;
    }

    .welcome-text p {
        font-size: 14px;
        color: #ccfbf1;
        margin-top: 6px;
        max-width: 580px;
        line-height: 1.5;
    }

    .welcome-cta {
        display: flex;
        gap: 12px;
        z-index: 2;
    }

    .btn-gold {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 11px 20px;
        border-radius: var(--radius-md);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 8px 20px rgba(217, 119, 6, 0.35);
        transition: var(--transition-fast);
        border: none;
    }

    .btn-gold:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(217, 119, 6, 0.45);
    }

    /* Stats Grid */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card-modern {
        background: #ffffff;
        border-radius: var(--radius-lg);
        padding: 22px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .stat-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: #cbd5e1;
    }

    .stat-info .stat-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.06em;
    }

    .stat-info .stat-value {
        font-family: 'Outfit', sans-serif;
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin: 4px 0 6px 0;
        line-height: 1;
    }

    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 11px;
        font-weight: 700;
        color: #10b981;
    }

    .stat-icon-wrap {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-icon-wrap.teal { background: #ccfbf1; color: #0f766e; }
    .stat-icon-wrap.blue { background: #dbeafe; color: #1d4ed8; }
    .stat-icon-wrap.emerald { background: #dcfce7; color: #15803d; }
    .stat-icon-wrap.amber { background: #fef3c7; color: #b45309; }
    .stat-icon-wrap.purple { background: #ede9fe; color: #6d28d9; }

    /* Quick Launch Row */
    .quick-launch-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 28px;
    }

    .quick-launch-item {
        background: #ffffff;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        text-decoration: none;
        color: var(--text-main);
        transition: var(--transition-fast);
        box-shadow: var(--shadow-xs);
    }

    .quick-launch-item:hover {
        border-color: var(--primary-light);
        box-shadow: var(--shadow-sm);
        transform: translateY(-2px);
    }

    .quick-launch-item i {
        font-size: 20px;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quick-launch-item.one i { background: #e0f2fe; color: #0284c7; }
    .quick-launch-item.two i { background: #fef3c7; color: #d97706; }
    .quick-launch-item.three i { background: #dcfce7; color: #16a34a; }
    .quick-launch-item.four i { background: #f3e8ff; color: #9333ea; }

    .quick-launch-item strong {
        display: block;
        font-size: 13.5px;
        font-weight: 700;
    }

    .quick-launch-item span {
        font-size: 11.5px;
        color: var(--text-muted);
    }

    /* 2 Column Content Layout */
    .dashboard-preview-grid {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 24px;
    }

    .preview-card {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        padding: 24px;
    }

    .preview-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid var(--border-color);
    }

    .preview-header h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .preview-header a {
        font-size: 12.5px;
        font-weight: 700;
        color: var(--primary);
        text-decoration: none;
    }

    .preview-header a:hover {
        text-decoration: underline;
    }

    @media (max-width: 992px) {
        .quick-launch-grid { grid-template-columns: repeat(2, 1fr); }
        .dashboard-preview-grid { grid-template-columns: 1fr; }
        .dashboard-welcome { flex-direction: column; align-items: flex-start; gap: 16px; }
    }
</style>

<!-- Welcome Banner -->
<div class="dashboard-welcome">
    <div style="display:flex;align-items:center;gap:20px;">
        <img src="/images/logo.png" alt="Vaatamilsiddha Logo" style="width:70px;height:70px;object-fit:contain;background:#ffffff;border-radius:16px;padding:5px;box-shadow:0 8px 20px rgba(0,0,0,0.2);flex-shrink:0;">
        <div class="welcome-text">
            <h2>Welcome to Vaatamilsiddha Clinic ERP</h2>
            <p>Comprehensive patient wellness records, herbal dispensaries, appointments, and billing operations in one unified workspace.</p>
        </div>
    </div>
    <div class="welcome-cta">
        <a href="/appointments/create" class="btn-gold">
            <i class="fa-solid fa-calendar-plus"></i> New Appointment
        </a>
        <a href="/patients/create" class="ghost-btn" style="color:#ffffff;background:rgba(255,255,255,0.15);border-color:rgba(255,255,255,0.25);">
            <i class="fa-solid fa-user-plus"></i> Add Patient
        </a>
    </div>
</div>


<!-- 5 Stat Metric Cards -->
<div class="stats-container">

    <div class="stat-card-modern">
        <div class="stat-info">
            <span class="stat-label">Total Patients</span>
            <div class="stat-value">{{ $patients }}</div>
            <div class="stat-trend"><i class="fa-solid fa-arrow-trend-up"></i> Active Profiles</div>
        </div>
        <div class="stat-icon-wrap blue">
            <i class="fa-solid fa-user-injured"></i>
        </div>
    </div>

    <div class="stat-card-modern">
        <div class="stat-info">
            <span class="stat-label">Appointments</span>
            <div class="stat-value">{{ $appointments ?? 0 }}</div>
            <div class="stat-trend"><i class="fa-solid fa-calendar-check"></i> Consultations</div>
        </div>
        <div class="stat-icon-wrap teal">
            <i class="fa-solid fa-calendar-days"></i>
        </div>
    </div>

    <div class="stat-card-modern">
        <div class="stat-info">
            <span class="stat-label">Medicines</span>
            <div class="stat-value">{{ $medicines }}</div>
            <div class="stat-trend"><i class="fa-solid fa-pills"></i> Herbal Products</div>
        </div>
        <div class="stat-icon-wrap emerald">
            <i class="fa-solid fa-capsules"></i>
        </div>
    </div>

    <div class="stat-card-modern">
        <div class="stat-info">
            <span class="stat-label">Stock Units</span>
            <div class="stat-value">{{ $availableStock }}</div>
            <div class="stat-trend"><i class="fa-solid fa-boxes-stacked"></i> Available Items</div>
        </div>
        <div class="stat-icon-wrap amber">
            <i class="fa-solid fa-cubes"></i>
        </div>
    </div>

    <div class="stat-card-modern">
        <div class="stat-info">
            <span class="stat-label">Doctors</span>
            <div class="stat-value">{{ $doctors ?? 0 }}</div>
            <div class="stat-trend"><i class="fa-solid fa-user-doctor"></i> Siddha Experts</div>
        </div>
        <div class="stat-icon-wrap purple">
            <i class="fa-solid fa-stethoscope"></i>
        </div>
    </div>

</div>

<!-- Quick Launch Hub -->
<div class="quick-launch-grid">
    <a href="/patients/create" class="quick-launch-item one">
        <i class="fa-solid fa-user-plus"></i>
        <div>
            <strong>Add Patient</strong>
            <span>Register new profile</span>
        </div>
    </a>
    <a href="/appointments/create" class="quick-launch-item two">
        <i class="fa-solid fa-calendar-plus"></i>
        <div>
            <strong>Book Appointment</strong>
            <span>Schedule consultation</span>
        </div>
    </a>
    <a href="/billing/create" class="quick-launch-item three">
        <i class="fa-solid fa-file-invoice-dollar"></i>
        <div>
            <strong>Create Bill</strong>
            <span>Prescription & therapy</span>
        </div>
    </a>
    <a href="/medicines/create" class="quick-launch-item four">
        <i class="fa-solid fa-pills"></i>
        <div>
            <strong>Add Medicine</strong>
            <span>Update dispensary</span>
        </div>
    </a>
</div>

<!-- 2-Column Split: Upcoming Appointments & Recent Patients -->
<div class="dashboard-preview-grid">

    <!-- Column 1: Upcoming Appointments -->
    <div class="preview-card">
        <div class="preview-header">
            <h3><i class="fa-regular fa-calendar-check" style="color:var(--primary);"></i> Upcoming Appointments</h3>
            <a href="/appointments">View All ({{ $appointments ?? 0 }}) →</a>
        </div>

        <div class="table-shell">
            <table>
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentAppointments ?? [] as $apt)
                    <tr>
                        <td>
                            <div class="patient-cell-wrap">
                                <div class="avatar-initial-chip">
                                    {{ strtoupper(substr($apt->patient->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $apt->patient->name ?? 'Unknown' }}</strong>
                                    <div style="font-size:11.5px;color:var(--text-muted);">{{ $apt->patient->phone ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $apt->doctor->name ?? '-' }}</td>
                        <td>
                            <div>{{ \Carbon\Carbon::parse($apt->appointment_date)->format('d M Y') }}</div>
                            <div style="font-size:11.5px;color:var(--text-muted);">{{ $apt->appointment_time }}</div>
                        </td>
                        <td>
                            <span class="status-badge {{ strtolower($apt->status ?? 'scheduled') }}">
                                {{ $apt->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:28px;color:#94a3b8;">
                            No appointments scheduled yet. <br>
                            <a href="/appointments/create" class="btn" style="margin-top:10px;">Schedule One</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Column 2: Recent Patients -->
    <div class="preview-card">
        <div class="preview-header">
            <h3><i class="fa-solid fa-users" style="color:var(--primary);"></i> Recent Patients</h3>
            <a href="/patients">View All ({{ $patients }}) →</a>
        </div>

        <div class="table-shell">
            <table>
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Place</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPatients ?? [] as $pat)
                    <tr>
                        <td>
                            <div class="patient-cell-wrap">
                                <div class="avatar-initial-chip" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);">
                                    {{ strtoupper(substr($pat->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $pat->name }}</strong>
                                    <div style="font-size:11.5px;color:var(--text-muted);">{{ $pat->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $pat->place ?: '-' }}</td>
                        <td>
                            <a href="/patients/{{ $pat->id }}">
                                <button type="button" class="icon-action view" title="View Patient Profile">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center;padding:28px;color:#94a3b8;">
                            No patient records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
