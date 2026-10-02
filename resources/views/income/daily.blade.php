@extends('layout.app')
@section('content')
<div class="page-shell">
    <div class="toolbar-card">
        <div class="toolbar-title"><h2><i class="fa-solid fa-calendar-day" style="color:var(--primary);"></i> Daily Income</h2><p>Income recorded from patient visits on the selected date.</p></div>
        <form method="GET" action="/income/daily" class="toolbar-actions">
            <label for="income-date">Select date</label><input type="date" id="income-date" name="date" value="{{ $date }}" required>
            <button type="submit" class="btn"><i class="fa-solid fa-filter"></i> View</button>
        </form>
    </div>
    <div class="card" style="padding:22px;margin-bottom:18px;">
        <div style="color:var(--text-muted);font-size:13px;font-weight:700;">TOTAL INCOME · {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</div>
        <div style="font-size:30px;font-weight:800;color:var(--primary-dark);margin-top:6px;">Rs {{ number_format($totalIncome, 2) }}</div>
        <div style="color:var(--text-muted);font-size:13px;margin-top:4px;">{{ $patients->count() }} patient {{ $patients->count() === 1 ? 'visit' : 'visits' }}</div>
    </div>
    <div class="card"><div class="table-shell"><table>
        <thead><tr><th>Patient</th><th>Phone</th><th>Payment Mode</th><th>Income</th><th>Invoice</th></tr></thead>
        <tbody>
            @forelse($patients as $patient)
                <tr><td>{{ $patient->name }}</td><td>{{ $patient->phone ?: '—' }}</td><td>{{ $patient->payment_mode ?: '—' }}</td><td>Rs {{ number_format((float) $patient->total_amount, 2) }}</td><td><a href="/billing/{{ $patient->id }}" class="ghost-btn">View invoice</a></td></tr>
            @empty
                <tr><td colspan="5" style="text-align:center;padding:30px;color:var(--text-muted);">No patient income recorded for this date.</td></tr>
            @endforelse
        </tbody>
    </table></div></div>
</div>
@endsection
