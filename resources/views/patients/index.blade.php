@extends('layout.app')

@section('content')

<div class="page-shell">

    <div class="toolbar-card">
        <div class="toolbar-title">
            <h2><i class="fa-solid fa-user-injured" style="color:var(--primary);"></i> Patient Directory</h2>
            <p>Manage patient health profiles, diagnostic visit logs, therapies, and quick billing.</p>
        </div>

        <div class="toolbar-actions">
            <div class="search-box-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="patientSearch" placeholder="Search by name, phone, age, place..." onkeyup="filterTable('patientSearch', 'patientsTable')">
            </div>

            <a href="/patients/create" class="btn">
                <i class="fa-solid fa-user-plus"></i> Add Patient
            </a>

            <a href="/patients/export" class="ghost-btn">
                <i class="fa-solid fa-file-excel" style="color:#16a34a;"></i> Export Excel
            </a>

            <form method="POST" action="/patients/import" enctype="multipart/form-data" class="upload-inline">
                @csrf
                <input type="file" name="file" accept=".csv,.xlsx" required>
                <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;">
                    <i class="fa-solid fa-file-arrow-up"></i> Import
                </button>
            </form>

            <form method="POST" action="/patients/import/clear" onsubmit="return confirm('Delete all imported patient records?');" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="delete-btn" style="padding:7px 12px;font-size:12px;" title="Clear Imported">
                    <i class="fa-solid fa-trash-can"></i> Clear
                </button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-shell">
            <table id="patientsTable">
                <thead>
                    <tr>
                        <th>Patient Name</th>
                        <th>Age / Gender</th>
                        <th>Phone Number</th>
                        <th>Place / City</th>
                        <th>Last Visit</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td>
                            <div class="patient-cell-wrap">
                                <div class="avatar-initial-chip" style="background:linear-gradient(135deg, #0d9488, #0f766e);">
                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                </div>
                                <div>
                                    <strong style="color:#0f172a;font-size:14px;">{{ $patient->name }}</strong>
                                    <div style="font-size:11.5px;color:var(--text-muted);">ID: #{{ $patient->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-pill gray">
                                {{ $patient->age ? $patient->age . ' yrs' : '-' }}
                                @if($patient->gender)
                                • {{ $patient->gender }}
                                @endif
                            </span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:6px;font-weight:600;color:#334155;">
                                <i class="fa-solid fa-phone" style="font-size:11px;color:#94a3b8;"></i>
                                {{ $patient->phone ?: '-' }}
                            </div>
                        </td>
                        <td>{{ $patient->place ?: '-' }}</td>
                        <td>
                            <span class="badge-pill teal">
                                <i class="fa-regular fa-calendar"></i>
                                {{ $patient->visit_date ? \Carbon\Carbon::parse($patient->visit_date)->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="/patients/{{ $patient->id }}">
                                    <button type="button" class="icon-action view" title="View Patient Profile">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>

                                <a href="/patients/{{ $patient->id }}/edit">
                                    <button type="button" class="icon-action edit" title="Edit Patient">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </a>

                                <form action="/patients/{{ $patient->id }}" method="POST" onsubmit="return confirm('Delete this patient record?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-action delete" title="Delete Patient">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            <i class="fa-solid fa-users-slash" style="font-size: 38px; margin-bottom: 14px; display: block; color: #94a3b8;"></i>
                            <strong style="font-size:16px;color:#334155;">No patient records found</strong><br>
                            <p style="font-size:13px;margin:6px 0 16px 0;color:#94a3b8;">Register a new patient or import from spreadsheet.</p>
                            <a href="/patients/create" class="btn">
                                <i class="fa-solid fa-user-plus"></i> Add First Patient
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
