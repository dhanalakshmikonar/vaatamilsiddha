@extends('layout.app')

@section('content')

<div class="page-shell">

<div class="toolbar-card">
<div class="toolbar-title">
<h2>Vaatamilsiddha Doctors</h2>
<p>Manage licensed practitioners with profile, qualification, role, and document details.</p>
</div>

<div class="toolbar-actions">
<a href="/doctors/create" class="btn">
<i class="fa-solid fa-plus"></i> Add Doctor
</a>
</div>
</div>

<div class="doctor-grid doctor-grid-elegant">

@foreach($doctors as $doctor)

<div class="doctor-card doctor-card-elegant">

<div class="doctor-top">
<div class="doctor-photo-wrap">
@if($doctor->photo)
<img src="/{{$doctor->photo}}" alt="{{$doctor->name}}" class="doctor-photo">
@else
<div class="doctor-photo doctor-photo-fallback">
<i class="fa-solid fa-user-doctor"></i>
</div>
@endif
</div>

<div class="doctor-title-block">
<h3>{{$doctor->name}}</h3>
<p class="doctor-role">{{$doctor->role ?: 'Doctor'}}</p>
<span class="doctor-chip">{{$doctor->specialization}}</span>
</div>
</div>

<div class="doctor-info-grid">
<div><strong>Qualification</strong><p>{{$doctor->qualification ?: '-'}}</p></div>
<div><strong>License No</strong><p>{{$doctor->license_no}}</p></div>
<div><strong>Aadhar No</strong><p>{{$doctor->aadhar}}</p></div>
<div><strong>Experience</strong><p>{{$doctor->experience}} years</p></div>
<div><strong>Phone</strong><p>{{$doctor->phone}}</p></div>
<div><strong>Address</strong><p>{{$doctor->clinic_address ?: '-'}}</p></div>
</div>

<div class="doctor-doc-row">
<div class="doctor-doc-box">
<span>Doctor Photo</span>
@if($doctor->photo)
<a href="/{{$doctor->photo}}" target="_blank" class="doc-link">View image</a>
@else
<span class="doc-muted">Not uploaded</span>
@endif
</div>
<div class="doctor-doc-box">
<span>Aadhar Card Photo</span>
@if($doctor->aadhar_photo)
<a href="/{{$doctor->aadhar_photo}}" target="_blank" class="doc-link">View image</a>
@else
<span class="doc-muted">Not uploaded</span>
@endif
</div>
</div>

<div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap;">
<a href="/doctors/{{$doctor->id}}/edit" class="btn">
<i class="fa-solid fa-pen"></i> Edit Doctor
</a>

<form action="/doctors/{{$doctor->id}}" method="POST" onsubmit="return confirm('Delete this doctor?');">
@csrf
@method('DELETE')
<button type="submit" class="delete-btn">
<i class="fa-solid fa-trash"></i> Delete
</button>
</form>
</div>

</div>

@endforeach

</div>

</div>

@endsection
