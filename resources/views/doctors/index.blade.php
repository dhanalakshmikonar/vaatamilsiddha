@extends('layout.app')

@section('content')

<style>
    .doctor-grid-modern {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 24px;
        margin-top: 12px;
    }

    .doctor-card-modern {
        background: #ffffff;
        border-radius: var(--radius-lg);
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .doctor-card-modern:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
        border-color: #cbd5e1;
    }

    .doctor-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #14b8a6, #0f766e);
    }

    .doctor-header-row {
        display: flex;
        gap: 16px;
        align-items: center;
        margin-bottom: 20px;
    }

    .doctor-photo-large {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        object-fit: cover;
        border: 2px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
    }

    .doctor-photo-fallback-large {
        width: 72px;
        height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0d9488, #042f2e);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
        box-shadow: 0 4px 12px rgba(13, 148, 136, 0.25);
    }

    .doctor-title-meta h3 {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .doctor-role-badge {
        font-size: 12px;
        color: var(--text-muted);
        font-weight: 600;
        margin-top: 2px;
    }

    .doctor-specialty-chip {
        display: inline-block;
        margin-top: 6px;
        background: #ccfbf1;
        color: #0f766e;
        padding: 3px 10px;
        border-radius: var(--radius-full);
        font-size: 11.5px;
        font-weight: 700;
        border: 1px solid #99f6e4;
    }

    .doctor-details-table {
        background: #f8fafc;
        border-radius: var(--radius-md);
        padding: 14px 16px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        font-size: 12px;
        margin-bottom: 18px;
        border: 1px solid var(--border-color);
    }

    .doctor-details-table strong {
        color: #64748b;
        display: block;
        font-size: 10.5px;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        margin-bottom: 2px;
    }

    .doctor-details-table p {
        color: #0f172a;
        font-weight: 700;
        font-size: 12.5px;
    }

    .doc-attachment-box {
        display: flex;
        gap: 8px;
        margin-bottom: 18px;
    }

    .doc-attachment-item {
        flex: 1;
        background: #ffffff;
        border: 1px dashed var(--border-color);
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 11.5px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
</style>

<div class="page-shell">

    <div class="toolbar-card">
        <div class="toolbar-title">
            <h2><i class="fa-solid fa-user-doctor" style="color:var(--primary);"></i> Siddha Doctors & Specialists</h2>
            <p>Manage licensed medical practitioners, qualifications, certifications, and clinic roles.</p>
        </div>

        <div class="toolbar-actions">
            <a href="/doctors/create" class="btn">
                <i class="fa-solid fa-user-plus"></i> Add Doctor
            </a>
        </div>
    </div>

    <div class="doctor-grid-modern">
        @forelse($doctors as $doctor)
        <div class="doctor-card-modern">
            <div>
                <div class="doctor-header-row">
                    @if($doctor->photo)
                        <img src="/{{ $doctor->photo }}" alt="{{ $doctor->name }}" class="doctor-photo-large">
                    @else
                        <div class="doctor-photo-fallback-large">
                            <i class="fa-solid fa-user-doctor"></i>
                        </div>
                    @endif

                    <div class="doctor-title-meta">
                        <h3>{{ $doctor->name }}</h3>
                        <div class="doctor-role-badge">{{ $doctor->role ?: 'Siddha Physician' }}</div>
                        <span class="doctor-specialty-chip">{{ $doctor->specialization }}</span>
                    </div>
                </div>

                <div class="doctor-details-table">
                    <div>
                        <strong>Qualification</strong>
                        <p>{{ $doctor->qualification ?: '-' }}</p>
                    </div>
                    <div>
                        <strong>Experience</strong>
                        <p>{{ $doctor->experience }} Years</p>
                    </div>
                    <div>
                        <strong>License No</strong>
                        <p>{{ $doctor->license_no }}</p>
                    </div>
                    <div>
                        <strong>Contact Phone</strong>
                        <p>{{ $doctor->phone }}</p>
                    </div>
                    <div style="grid-column: 1 / -1;">
                        <strong>Clinic Branch / Address</strong>
                        <p>{{ $doctor->clinic_address ?: 'Main Clinic' }}</p>
                    </div>
                </div>

                <div class="doc-attachment-box" style="flex-wrap:wrap;">
                    <div class="doc-attachment-item">
                        <span><i class="fa-regular fa-image" style="color:#0d9488;"></i> Profile Photo</span>
                        @if($doctor->photo)
                            <a href="/{{ $doctor->photo }}" target="_blank" style="font-weight:700;color:var(--primary);font-size:11px;">View</a>
                        @else
                            <span style="color:#94a3b8;font-size:11px;">None</span>
                        @endif
                    </div>

                    <div class="doc-attachment-item">
                        <span><i class="fa-regular fa-id-card" style="color:#d97706;"></i> Aadhar Document</span>
                        @if($doctor->aadhar_photo)
                            <a href="/{{ $doctor->aadhar_photo }}" target="_blank" style="font-weight:700;color:var(--accent);font-size:11px;">View</a>
                        @else
                            <span style="color:#94a3b8;font-size:11px;">None</span>
                        @endif
                    </div>

                    <div class="doc-attachment-item">
                        <span><i class="fa-solid fa-signature" style="color:#0f766e;"></i> Signature</span>
                        @if($doctor->signature)
                            <a href="/{{ $doctor->signature }}" target="_blank" style="font-weight:700;color:#0f766e;font-size:11px;">View</a>
                        @else
                            <span style="color:#94a3b8;font-size:11px;">None</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-actions" style="margin-top:0;padding-top:14px;">
                <a href="/doctors/{{ $doctor->id }}/edit" class="btn" style="padding:8px 14px;font-size:12px;">
                    <i class="fa-solid fa-pen"></i> Edit Doctor
                </a>

                <form action="/doctors/{{ $doctor->id }}" method="POST" onsubmit="return confirm('Delete this doctor record?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="delete-btn" style="padding:8px 14px;font-size:12px;">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; background:white; padding:48px 20px; border-radius:20px; text-align:center; border:1px solid var(--border-color);">
            <i class="fa-solid fa-user-doctor" style="font-size: 40px; margin-bottom: 14px; display: block; color: #94a3b8;"></i>
            <strong style="font-size:16px;color:#334155;">No doctor records available</strong><br>
            <p style="font-size:13px;margin:6px 0 16px 0;color:#94a3b8;">Add certified Siddha physicians to the clinic system.</p>
            <a href="/doctors/create" class="btn">
                <i class="fa-solid fa-plus"></i> Add New Doctor
            </a>
        </div>
        @endforelse
    </div>

</div>

@endsection
