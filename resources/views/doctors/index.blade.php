@extends('layout.app')

@section('content')

<div class="page-title">
<h2>Siddha Doctors</h2>
<p>Registered practitioners in clinic</p>
</div>

<div class="doctor-grid">

@foreach($doctors as $doctor)

<div class="doctor-card">

<div class="doctor-avatar">
<i class="fa-solid fa-user-doctor"></i>
</div>

<h3>{{$doctor->name}}</h3>

<p class="special">{{$doctor->specialization}}</p>

<div class="doctor-info">

<p><strong>Aadhar:</strong> {{$doctor->aadhar}}</p>

<p><strong>License:</strong> {{$doctor->license_no}}</p>

<p><strong>Phone:</strong> {{$doctor->phone}}</p>

<p><strong>Experience:</strong> {{$doctor->experience}} years</p>

<p><strong>Address:</strong> {{$doctor->clinic_address}}</p>

</div>

</div>

@endforeach

</div>

@endsection