@extends('layout.app')

@section('content')

<div class="bill-card">

<div class="bill-header">
<div>
<div class="bill-brand">Vaatamilsiddha</div>
<h2>Patient Bill</h2>
<p style="color:#64748b;margin-top:6px;">Generated from patient medicines and quantities</p>
</div>
<a href="/billing" class="btn">
<i class="fa-solid fa-arrow-left"></i> Back
</a>
</div>

<div class="bill-meta">
<div>
<strong>Patient Name</strong>
<p>{{$patient->name}}</p>
</div>
<div>
<strong>Phone</strong>
<p>{{$patient->phone ?: '-'}}</p>
</div>
<div>
<strong>Visit Date</strong>
<p>{{$patient->visit_date}}</p>
</div>
<div>
<strong>Diagnosis</strong>
<p>{{$patient->diagnosis ?: '-'}}</p>
</div>
<div>
<strong>Payment Mode</strong>
<p>{{$patient->payment_mode ?: '-'}}</p>
</div>
</div>

<table class="detail-table">
<tr>
<th>Item</th>
<th>Quantity</th>
<th>Price</th>
<th>Total</th>
</tr>

@forelse($billSummary['items'] as $item)
<tr>
<td>{{$item['label']}}</td>
<td>{{$item['quantity']}}</td>
<td>Rs {{number_format($item['unit_price'], 2)}}</td>
<td>Rs {{number_format($item['total'], 2)}}</td>
</tr>
@empty
<tr>
<td colspan="4">No bill items added for this patient.</td>
</tr>
@endforelse
</table>

<div class="bill-total">
Grand Total: Rs {{number_format($billSummary['grand_total'], 2)}}
</div>

</div>

@endsection
