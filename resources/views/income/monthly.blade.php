@extends('layout.app')
@section('content')
<div class="page-shell">
    <div class="toolbar-card">
        <div class="toolbar-title"><h2><i class="fa-solid fa-calendar-days" style="color:var(--primary);"></i> Monthly Income</h2><p>Review patient count and total income for a selected month.</p></div>
        <form method="GET" action="/income/monthly" class="toolbar-actions">
            <label for="income-month">Report month</label><input type="month" id="income-month" name="month" value="{{ $month }}" required aria-label="Choose report month">
            <button type="submit" class="btn"><i class="fa-solid fa-filter"></i> View</button>
        </form>
    </div>
    <div class="card" style="padding:22px;margin-bottom:18px;">
        <div style="color:var(--text-muted);font-size:13px;font-weight:700;">TOTAL INCOME · {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</div>
        <div style="font-size:30px;font-weight:800;color:var(--primary-dark);margin-top:6px;">Rs {{ number_format($totalIncome, 2) }}</div>
        <div style="color:var(--text-muted);font-size:13px;margin-top:4px;">{{ $patients->count() }} patient {{ $patients->count() === 1 ? 'visit' : 'visits' }}</div>
    </div>
    <div class="card"><div class="table-shell"><table>
        <thead><tr><th>Month</th><th>Total Patients</th><th>Monthly Income</th></tr></thead>
        <tbody><tr><td>{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</td><td>{{ $patients->count() }}</td><td>Rs {{ number_format($totalIncome, 2) }}</td></tr></tbody>
    </table></div></div>
    <div class="card" style="margin-top:18px;"><div style="padding:18px 18px 0;font-size:14px;font-weight:800;color:var(--text-main);">Patient visit details · {{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('F Y') }}</div><div class="table-shell"><table>
        <thead><tr><th>Visit Date</th><th>Patient</th><th>Payment Mode</th><th>Income</th><th>Invoice</th></tr></thead>
        <tbody>@forelse($patients as $patient)
            <tr><td>{{ \Carbon\Carbon::parse($patient->visit_date)->format('d M Y') }}</td><td>{{ $patient->name }}</td><td>{{ $patient->payment_mode ?: '—' }}</td><td>Rs {{ number_format((float) $patient->total_amount, 2) }}</td><td><a href="/billing/{{ $patient->id }}" class="ghost-btn">View invoice</a></td></tr>
        @empty
            <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-muted);">No patient visits recorded for this month.</td></tr>
        @endforelse</tbody>
    </table></div></div>
</div>
@endsection
