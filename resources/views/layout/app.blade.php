<!DOCTYPE html>

<html>
<head>
<title>Siddha Clinic ERP</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI', sans-serif;
}

body{
background:#f1f4f9;
}

/* Layout */

.container{
display:flex;
height:100vh;
}

/* Sidebar */

.sidebar{
width:240px;
background:#1e293b;
color:white;
padding:25px 20px;
}

.logo{
font-size:22px;
font-weight:bold;
margin-bottom:40px;
}

.sidebar ul{
list-style:none;
}

.sidebar ul li{
margin-bottom:10px;
}

.sidebar ul li a{
display:flex;
align-items:center;
gap:10px;
padding:12px;
text-decoration:none;
color:#cbd5e1;
border-radius:6px;
transition:0.2s;
}

.sidebar ul li a:hover{
background:#334155;
color:white;
}

/* Main */

.main{
flex:1;
display:flex;
flex-direction:column;
}

/* Header */

.header{
background:white;
padding:18px 25px;
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:1px solid #e2e8f0;
}

.header h3{
font-weight:600;
}

/* Content */

.content{
padding:30px;
}

/* Card */

.card{
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.05);
}

/* Table */

table{
width:100%;
border-collapse:collapse;
margin-top:20px;
}

table th{
text-align:left;
padding:14px;
background:#10b981;
color:white;
}

table td{
padding:14px;
border-bottom:1px solid #eee;
}

table tr:hover{
background:#f9fafb;
}

/* Button */

.btn{
background:#10b981;
color:white;
padding:10px 16px;
border-radius:6px;
text-decoration:none;
font-size:14px;
display:inline-flex;
align-items:center;
gap:6px;
}

.btn:hover{
background:#059669;
}

/* Action buttons */

.edit-btn{
background:#3b82f6;
color:white;
padding:8px 10px;
border-radius:6px;
border:none;
cursor:pointer;
}

.delete-btn{
background:#ef4444;
color:white;
padding:8px 10px;
border-radius:6px;
border:none;
cursor:pointer;
}

.edit-btn:hover{
background:#2563eb;
}

.delete-btn:hover{
background:#dc2626;
}

.form-card{
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 4px 15px rgba(0,0,0,0.05);
max-width:900px;
}

.form-title{
font-size:22px;
font-weight:600;
margin-bottom:25px;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

.form-group{
display:flex;
flex-direction:column;
}

.form-group label{
font-weight:500;
margin-bottom:6px;
color:#444;
}

.form-group input,
.form-group select{
padding:10px;
border:1px solid #ddd;
border-radius:6px;
font-size:14px;
}

.form-actions{
margin-top:25px;
}

.primary-btn{
background:#10b981;
border:none;
padding:12px 18px;
border-radius:6px;
color:white;
font-size:14px;
cursor:pointer;
}

.form-container{
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
max-width:900px;
}

.form-header h2{
margin-bottom:5px;
}

.form-header p{
color:#666;
font-size:14px;
margin-bottom:25px;
}

.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
}

.form-group{
display:flex;
flex-direction:column;
}

.form-group label{
font-weight:500;
margin-bottom:6px;
color:#444;
}

.form-group input,
.form-group select,
.form-group textarea{
padding:10px;
border:1px solid #ddd;
border-radius:6px;
font-size:14px;
}

.form-group.full{
grid-column:1 / span 2;
}

.form-actions{
margin-top:20px;
}

.btn-primary{
background:#10b981;
border:none;
padding:12px 18px;
color:white;
border-radius:6px;
cursor:pointer;
font-weight:500;
}

.btn-primary:hover{
background:#059669;
}

.primary-btn:hover{
background:#059669;
}

.profile-card{
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
max-width:800px;
}

.profile-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:20px;
margin-top:20px;
}

.profile-grid p{
margin-top:5px;
color:#555;
}

.profile-grid .full{
grid-column:1 / span 2;
}

.view-btn{
background:#3b82f6;
color:white;
border:none;
padding:7px 10px;
border-radius:6px;
cursor:pointer;
}

.page-title{
margin-bottom:20px;
}

.doctor-grid{
display:grid;
grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
gap:20px;
}

.doctor-card{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 5px 12px rgba(0,0,0,0.05);
transition:0.3s;
}

.doctor-card:hover{
transform:translateY(-4px);
}

.doctor-avatar{
font-size:40px;
color:#10b981;
margin-bottom:10px;
}

.special{
color:#666;
margin-bottom:10px;
}

.doctor-info{
font-size:14px;
color:#444;
line-height:1.6;
}
</style>

</head>

<body>

<div class="container">

<!-- Sidebar -->

<div class="sidebar">

<div class="logo">Siddha ERP</div>

<ul>

<li><a href="/"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>

<li><a href="/patients"><i class="fa-solid fa-user"></i> Patients</a></li>

<li><a href="/medicines"><i class="fa-solid fa-capsules"></i> Medicines</a></li>

<li><a href="/prescriptions"><i class="fa-solid fa-file-medical"></i> Prescriptions</a></li>

<li><a href="#"><i class="fa-solid fa-user-doctor"></i> Doctors</a></li>

</ul>

</div>

<!-- Main -->

<div class="main">

<div class="header">

<h3>Clinic Management System</h3>

<div>
<i class="fa-solid fa-user-circle"></i> Admin
</div>

</div>

<div class="content">

@yield('content')

</div>

</div>

</div>

</body>
</html>
