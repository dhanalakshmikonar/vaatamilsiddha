@extends('layout.app')

@section('content')

<div class="page-shell">

    <div class="toolbar-card">
        <div class="toolbar-title">
            <h2><i class="fa-solid fa-capsules" style="color:var(--primary);"></i> Medicines Dispensary</h2>
            <p>Upload stock inventories, manage pharmaceutical products, and track selling prices.</p>
        </div>

        <div class="toolbar-actions">
            <div class="search-box-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="medicineSearch" placeholder="Search medicine, pharma, mode..." onkeyup="filterTable('medicineSearch', 'medicinesTable')">
            </div>

            <a href="/medicines/create" class="btn">
                <i class="fa-solid fa-plus"></i> Add Medicine
            </a>

            <a href="/medicines/export" class="ghost-btn">
                <i class="fa-solid fa-file-excel" style="color:#16a34a;"></i> Export Excel
            </a>

            <form method="POST" action="/medicines/import" enctype="multipart/form-data" class="upload-inline">
                @csrf
                <input type="file" name="file" accept=".csv,.xlsx" required>
                <button type="submit" class="btn" style="padding:6px 12px;font-size:12px;">
                    <i class="fa-solid fa-file-arrow-up"></i> Import
                </button>
            </form>

            <form method="POST" action="/medicines/import/clear" onsubmit="return confirm('Delete all imported medicine records from the inventory?');" style="display:inline;">
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
            <table id="medicinesTable">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Product Form</th>
                        <th>Pharmaceutical</th>
                        <th>Expiry Date</th>
                        <th>Stock Level</th>
                        <th>Cost Price</th>
                        <th>Selling Price</th>
                        <th>Total Value</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($medicines as $medicine)
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="avatar-initial-chip" style="background:linear-gradient(135deg, #10b981, #059669);">
                                    <i class="fa-solid fa-pills" style="font-size:12px;"></i>
                                </div>
                                <div>
                                    <strong style="color:#0f172a;font-size:14px;">{{ $medicine->name }}</strong>
                                    <div style="font-size:11px;color:var(--text-muted);">SKU #{{ $medicine->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-pill gray">
                                {{ $medicine->mode_of_product ?: '-' }}
                            </span>
                        </td>
                        <td>{{ $medicine->pharmaceutical_name ?: '-' }}</td>
                        <td>
                            @if($medicine->expiry_date)
                            <span class="badge-pill gray">
                                <i class="fa-regular fa-calendar-xmark"></i> {{ $medicine->expiry_date }}
                            </span>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($medicine->stock <= 0)
                            <span class="status-badge cancelled">Out of Stock</span>
                            @elseif($medicine->stock <= 10)
                            <span class="status-badge confirmed">{{ $medicine->stock }} units (Low)</span>
                            @else
                            <span class="status-badge completed">{{ $medicine->stock }} units</span>
                            @endif
                        </td>
                        <td>Rs {{ number_format((float) ($medicine->cost_price ?: $medicine->cost ?: 0), 2) }}</td>
                        <td><strong>Rs {{ number_format((float) ($medicine->selling_price ?: 0), 2) }}</strong></td>
                        <td>Rs {{ number_format((float) ($medicine->total_amount ?: (($medicine->stock ?: 0) * ($medicine->selling_price ?: 0))), 2) }}</td>

                        <td style="text-align:right;">
                            <div class="table-actions" style="justify-content:flex-end;">
                                <a href="/medicines/{{ $medicine->id }}">
                                    <button type="button" class="icon-action view" title="View Medicine">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </a>

                                <a href="/medicines/{{ $medicine->id }}/edit">
                                    <button type="button" class="icon-action edit" title="Edit Medicine">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </a>

                                <form action="/medicines/{{ $medicine->id }}" method="POST" onsubmit="return confirm('Delete this medicine?');" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="icon-action delete" title="Delete Medicine">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 48px 20px; color: #64748b;">
                            <i class="fa-solid fa-box-open" style="font-size: 38px; margin-bottom: 14px; display: block; color: #94a3b8;"></i>
                            <strong style="font-size:16px;color:#334155;">No medicine records found in inventory</strong><br>
                            <p style="font-size:13px;margin:6px 0 16px 0;color:#94a3b8;">Add new herbal products or upload inventory via spreadsheet.</p>
                            <a href="/medicines/create" class="btn">
                                <i class="fa-solid fa-plus"></i> Add First Medicine
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
