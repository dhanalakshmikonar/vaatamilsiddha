@extends('layout.app')

@section('content')

<style>

.dashboard-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
gap:20px;
margin-top:25px;
}

.stat-card{
padding:20px 25px;
border-radius:12px;
color:white;
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:0.2s;
}

.stat-card:hover{
transform:translateY(-4px);
}

.stat-title{
font-size:16px;
}

.stat-number{
font-size:32px;
font-weight:bold;
}

.stat-icon{
font-size:34px;
opacity:0.8;
}

/* Colors */

.blue{ background:linear-gradient(135deg,#3b82f6,#1d4ed8); }
.green{ background:linear-gradient(135deg,#10b981,#059669); }
.orange{ background:linear-gradient(135deg,#f59e0b,#d97706); }
.purple{ background:linear-gradient(135deg,#8b5cf6,#6d28d9); }

</style>


<h2>Dashboard</h2>
<p style="color:#666;margin-top:4px">
Clinic statistics overview
</p>


<div class="dashboard-grid">


<div class="stat-card blue">

<div>
<div class="stat-title">Patients</div>
</div>

<div style="display:flex;align-items:center;gap:15px">

<div class="stat-number">{{$patients}}</div>

<i class="fa-solid fa-user stat-icon"></i>

</div>

</div>



<div class="stat-card green">

<div>
<div class="stat-title">Medicines</div>
</div>

<div style="display:flex;align-items:center;gap:15px">

<div class="stat-number">{{$medicines}}</div>

<i class="fa-solid fa-capsules stat-icon"></i>

</div>

</div>



<div class="stat-card orange">

<div>
<div class="stat-title">Prescriptions</div>
</div>

<div style="display:flex;align-items:center;gap:15px">

<div class="stat-number">{{$prescriptions}}</div>

<i class="fa-solid fa-file-medical stat-icon"></i>

</div>

</div>



<div class="stat-card purple">

<div>
<div class="stat-title">Doctors</div>
</div>

<div style="display:flex;align-items:center;gap:15px">

<div class="stat-number">0</div>

<i class="fa-solid fa-user-doctor stat-icon"></i>

</div>

</div>


</div>

@endsection