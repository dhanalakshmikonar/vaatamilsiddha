@extends('layout.app')

@section('content')

<div class="page-shell">

    <div class="toolbar-card">
        <div class="toolbar-title">
            <h2><i class="fa-solid fa-stamp" style="color:var(--primary);"></i> Doctor Certification</h2>
            <p>Generate, manage, and print official medical fitness and leave recommendation certificates.</p>
        </div>

        <div class="toolbar-actions">
            <div class="search-box-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="certSearch" placeholder="Search patient, diagnosis, doctor..." onkeyup="filterTable('certSearch', 'certTable')">
            </div>

            <a href="/certificates/create" class="btn">
                <i class="fa-solid fa-plus"></i> Create Certificate
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-shell">
            <table id="certTable">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Diagnosis</th>
                        <th>Date</th>
                        <th>Leave From</th>
                        <th>Leave To</th>
                        <th>Doctor</th>
                        <th>Type</th>
                        <th style="text-align:right;">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($certificates as $cert)
                    <tr>
                        <td>
                            <div class="patient-cell-wrap">
                                <div class="avatar-initial-chip" style="background:linear-gradient(135deg, #0d9488, #0f766e);">
                                    {{ strtoupper(substr($cert->patient->name ?? 'P', 0, 1)) }}
                                </div>
                                <div>
                                    <strong style="color:#0f172a;font-size:14px;">{{ $cert->patient->name ?? 'Unknown Patient' }}</strong>
                                    <div style="font-size:11.5px;color:var(--text-muted);">{{ $cert->patient->phone ?? 'No phone' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <strong style="color:#1e293b;">{{ $cert->diagnosis }}</strong>
                        </td>
                        <td>
                            <span class="badge-pill teal">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $cert->date ? \Carbon\Carbon::parse($cert->date)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-pill gray">
                                <i class="fa-regular fa-calendar-minus"></i>
                                {{ $cert->leave_from ? \Carbon\Carbon::parse($cert->leave_from)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-pill gray">
                                <i class="fa-regular fa-calendar-check"></i>
                                {{ $cert->leave_to ? \Carbon\Carbon::parse($cert->leave_to)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:700;color:#0f766e;">
                                Dr. {{ $cert->doctor->name ?? 'N/A' }}
                            </div>
                            <div style="font-size:11px;color:#64748b;">
                                {{ $cert->doctor->specialization ?? '' }}
                            </div>
                        </td>
                        <td>
                            @if($cert->certificate_type === 'Corporate')
                                <span class="status-badge scheduled" style="font-size:11.5px;">
                                    <i class="fa-solid fa-building"></i> Corporate
                                </span>
                            @else
                                <span class="status-badge confirmed" style="font-size:11.5px;">
                                    <i class="fa-solid fa-graduation-cap"></i> School
                                </span>
                            @endif
                        </td>
                        <td style="text-align:right;">
                            <div class="table-actions" style="justify-content: flex-end;">
                                <a href="/certificates/{{ $cert->id }}" class="icon-action view" title="View Certificate">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="/certificates/{{ $cert->id }}/edit" class="icon-action edit" title="Edit Certificate">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <a href="/certificates/{{ $cert->id }}" class="icon-action" style="color:#0f766e;border-color:#99f6e4;" title="Print Certificate">
                                    <i class="fa-solid fa-print"></i>
                                </a>
                                <form action="/certificates/{{ $cert->id }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this certificate?');" style="display:inline-block;margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-action delete" title="Delete Certificate">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            <i class="fa-solid fa-stamp" style="font-size: 38px; margin-bottom: 14px; display: block; color: #94a3b8;"></i>
                            <strong style="font-size:16px;color:#334155;">No doctor certificates found</strong><br>
                            <p style="font-size:13px;margin:6px 0 16px 0;color:#94a3b8;">Issue medical leave certificates for corporate employees or students.</p>
                            <a href="/certificates/create" class="btn">
                                <i class="fa-solid fa-plus"></i> Create First Certificate
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
