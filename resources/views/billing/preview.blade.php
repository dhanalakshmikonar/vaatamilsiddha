@extends('layout.app')

@section('content')

<div class="bill-card">
<div class="bill-header">
<div>
<div class="bill-brand">Vaatamilsiddha</div>
<h2>Generated Billing</h2>
<p style="color:#64748b;margin-top:6px;">Medicine and therapy billing summary</p>
</div>
<a href="/billing/create" class="btn">
<i class="fa-solid fa-arrow-left"></i> Back to Add Billing
</a>
</div>

<div class="bill-meta">
<div>
<strong>Medicine / Therapy Name</strong>
<p>
{{ $medicine?->name ?: 'No medicine selected' }}
@if($therapyKey)
 | {{ ucwords(str_replace('_', ' ', $therapyKey)) }}
@endif
</p>
</div>
<div>
<strong>Appointment Amount</strong>
<p>Rs {{ number_format($appointmentAmount, 2) }}</p>
</div>
<div>
<strong>Medicine Amount</strong>
<p>Rs {{ number_format($medicineAmount, 2) }}</p>
</div>
<div>
<strong>Therapy Amount</strong>
<p>Rs {{ number_format($therapyAmount, 2) }}</p>
</div>
</div>

<div class="bill-total">
Total Amount: Rs {{ number_format($totalAmount, 2) }}
</div>

<div class="form-actions" style="display:flex;gap:12px;flex-wrap:wrap;margin-top:20px;">
<a href="/billing/create" class="btn">Add Another Bill</a>
<a href="/billing" class="ghost-btn">Go to Billing</a>
</div>
</div>

@endsection
