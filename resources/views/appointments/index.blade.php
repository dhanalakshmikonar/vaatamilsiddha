@extends('layout.app')

@section('content')

<div class="page-shell">

    <div class="toolbar-card">
        <div class="toolbar-title">
            <h2><i class="fa-solid fa-calendar-check" style="color:var(--primary);"></i> Clinic Appointments</h2>
            <p>Track, schedule, and manage doctor consultations and visit statuses.</p>
        </div>

        <div class="toolbar-actions">
            <div class="search-box-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="appointmentSearch" placeholder="Search patient, doctor, status..." onkeyup="filterTable('appointmentSearch', 'appointmentsTable')">
            </div>

            <a href="/appointments/create" class="btn">
                <i class="fa-solid fa-plus"></i> Book Appointment
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-shell">
            <table id="appointmentsTable">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Phone</th>
                        <th>Doctor</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($appointments as $appointment)
                    <tr>
                        <td>
                            <div class="patient-cell-wrap">
                                <div class="avatar-initial-chip">
                                    {{ strtoupper(substr($appointment->patient->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <strong>{{ $appointment->patient->name ?? 'N/A' }}</strong>
                                    <div style="font-size:11px;color:var(--text-muted);">ID: #{{ $appointment->patient_id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span style="font-weight:600;color:#334155;">{{ $appointment->patient->phone ?? '-' }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <i class="fa-solid fa-user-doctor" style="color:#0d9488;font-size:13px;"></i>
                                <span style="font-weight:600;">{{ $appointment->doctor->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="badge-pill gray">
                                <i class="fa-regular fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d M Y') }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-pill gray">
                                <i class="fa-regular fa-clock"></i>
                                {{ $appointment->appointment_time }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusClass = strtolower($appointment->status ?? 'scheduled');
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                <i class="fa-regular fa-circle-dot"></i> {{ $appointment->status }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="/appointments/{{ $appointment->id }}/edit">
                                    <button type="button" class="icon-action edit" title="Edit Appointment">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </a>

                                <form action="/appointments/{{ $appointment->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this appointment?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-action delete" title="Delete Appointment">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            <i class="fa-regular fa-calendar-xmark" style="font-size: 38px; margin-bottom: 14px; display: block; color: #94a3b8;"></i>
                            <strong style="font-size:16px;color:#334155;">No appointments scheduled yet</strong><br>
                            <p style="font-size:13px;margin:6px 0 16px 0;color:#94a3b8;">Book consultation slots for registered patients.</p>
                            <a href="/appointments/create" class="btn">
                                <i class="fa-solid fa-plus"></i> Book First Appointment
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
