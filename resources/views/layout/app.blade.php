<!DOCTYPE html>

<html>
<head>
<title>Siddha Clinic ERP</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI', sans-serif;
}

html,
body{
width:100%;
height:100%;
overflow:hidden;
}

body{
background:#f1f4f9;
height:100vh;
overflow:hidden;
}

.container{
display:flex;
height:100vh;
}

.sidebar{
width:240px;
background:#1e293b;
color:white;
padding:25px 20px;
position:sticky;
top:0;
height:100vh;
flex-shrink:0;
overflow:hidden;
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

.main{
flex:1;
display:flex;
flex-direction:column;
height:100vh;
overflow:hidden;
}

.header{
background:white;
padding:18px 25px;
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:1px solid #e2e8f0;
position:sticky;
top:0;
z-index:10;
}

.header h3{
font-weight:600;
}

.header-right{
display:flex;
align-items:center;
gap:14px;
}

.header-user{
padding:10px 14px;
border-radius:999px;
background:#f8fafc;
color:#0f172a;
font-size:14px;
font-weight:600;
}

.logout-btn{
border:none;
background:#0f172a;
color:white;
padding:10px 14px;
border-radius:10px;
cursor:pointer;
font-weight:600;
}

.logout-btn:hover{
background:#1e293b;
}

.content{
padding:30px;
flex:1;
overflow-y:auto;
overflow-x:hidden;
scrollbar-width:none;
}

.content::-webkit-scrollbar{
display:none;
}

.card{
background:white;
padding:25px;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.05);
width:100%;
}

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
.form-group select,
.form-group textarea{
padding:10px;
border:1px solid #ddd;
border-radius:6px;
font-size:14px;
}

.form-actions{
margin-top:20px;
}

.primary-btn,
.btn-primary{
background:#10b981;
border:none;
padding:12px 18px;
color:white;
border-radius:6px;
cursor:pointer;
font-weight:500;
}

.btn-primary:hover,
.primary-btn:hover{
background:#059669;
}

.form-container{
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
width:100%;
max-width:1000px;
}

.form-header h2{
margin-bottom:5px;
}

.form-header p{
color:#666;
font-size:14px;
margin-bottom:25px;
}

.form-group.full{
grid-column:1 / span 2;
}

.profile-card{
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
width:100%;
max-width:1000px;
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

.doctor-grid-elegant{
grid-template-columns:repeat(auto-fill,minmax(340px,1fr));
}

.doctor-card-elegant{
padding:24px;
border-radius:18px;
background:linear-gradient(180deg,#ffffff 0%,#f8fafc 100%);
border:1px solid #e2e8f0;
box-shadow:0 18px 35px rgba(15,23,42,0.08);
}

.doctor-top{
display:flex;
gap:16px;
align-items:center;
margin-bottom:18px;
}

.doctor-photo-wrap{
flex-shrink:0;
}

.doctor-photo{
width:82px;
height:82px;
border-radius:22px;
object-fit:cover;
display:flex;
align-items:center;
justify-content:center;
background:#e2e8f0;
color:#0f766e;
font-size:28px;
}

.doctor-photo-fallback{
background:linear-gradient(135deg,#d1fae5,#ccfbf1);
}

.doctor-title-block h3{
font-size:22px;
margin-bottom:4px;
}

.doctor-role{
color:#475569;
margin-bottom:10px;
}

.doctor-chip{
display:inline-flex;
padding:7px 12px;
border-radius:999px;
background:#ecfeff;
color:#0f766e;
font-size:12px;
font-weight:700;
letter-spacing:0.04em;
text-transform:uppercase;
}

.doctor-info-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:14px 18px;
margin-top:18px;
}

.doctor-info-grid p{
margin-top:5px;
color:#334155;
line-height:1.5;
}

.doctor-doc-row{
display:grid;
grid-template-columns:1fr 1fr;
gap:14px;
margin-top:18px;
}

.doctor-doc-box{
padding:14px;
border-radius:12px;
background:#f8fafc;
border:1px solid #e2e8f0;
display:flex;
flex-direction:column;
gap:8px;
}

.doc-link{
color:#0f766e;
text-decoration:none;
font-weight:600;
}

.doc-link:hover{
text-decoration:underline;
}

.doc-muted{
color:#94a3b8;
}

.medicine-section{
margin-top:30px;
padding-top:20px;
border-top:1px solid #e5e7eb;
}

.section-title{
display:flex;
justify-content:space-between;
align-items:center;
gap:16px;
margin-bottom:15px;
}

.secondary-btn{
background:#0f172a;
color:white;
border:none;
padding:10px 14px;
border-radius:6px;
cursor:pointer;
}

.secondary-btn:hover{
background:#1e293b;
}

.medicine-row{
display:grid;
grid-template-columns:2fr 1fr auto;
gap:12px;
margin-bottom:12px;
align-items:end;
}

.readonly-field{
background:#f8fafc;
}

.summary-box{
margin-top:20px;
padding:14px 16px;
background:#f8fafc;
border-radius:8px;
font-weight:600;
}

.detail-table{
width:100%;
margin-top:18px;
}

.detail-table th{
background:#0f766e;
}

.bill-card{
background:white;
padding:30px;
border-radius:12px;
box-shadow:0 4px 12px rgba(0,0,0,0.05);
width:100%;
max-width:1100px;
}

.bill-header{
display:flex;
justify-content:space-between;
align-items:flex-start;
gap:20px;
margin-bottom:24px;
}

.bill-brand{
font-size:14px;
letter-spacing:0.18em;
text-transform:uppercase;
color:#0f766e;
font-weight:700;
margin-bottom:8px;
}

.bill-meta{
display:grid;
grid-template-columns:repeat(2,minmax(0,1fr));
gap:18px;
padding:20px;
background:#f8fafc;
border-radius:10px;
margin-bottom:22px;
}

.bill-meta p{
margin-top:6px;
color:#334155;
}

.bill-total{
margin-top:20px;
padding:18px 20px;
border-radius:10px;
background:#0f172a;
color:white;
font-size:18px;
font-weight:700;
text-align:right;
}

@media (max-width: 768px){
.container{
flex-direction:column;
height:auto;
}

.sidebar{
width:100%;
height:auto;
position:relative;
}

.content{
padding:18px;
overflow:visible;
}

.form-grid,
.profile-grid,
.medicine-row,
.bill-meta{
grid-template-columns:1fr;
}

.form-group.full,
.profile-grid .full{
grid-column:auto;
}

.section-title{
flex-direction:column;
align-items:flex-start;
}
}

</style>

</head>

<body>

<div class="container">

<div class="sidebar">

<div class="logo">Siddha ERP</div>

<ul>

<li><a href="/"><i class="fa-solid fa-chart-line"></i> Dashboard</a></li>
<li><a href="/patients"><i class="fa-solid fa-user"></i> Patients</a></li>
<li><a href="/medicines"><i class="fa-solid fa-capsules"></i> Medicines</a></li>
<li><a href="/billing"><i class="fa-solid fa-file-invoice"></i> Billing</a></li>
<li><a href="/doctors"><i class="fa-solid fa-user-doctor"></i> Doctors</a></li>

</ul>

</div>

<div class="main">

<div class="header">
<h3>Clinic Management System</h3>
<div class="header-right">
<div class="header-user">
<i class="fa-solid fa-user-circle"></i> {{ auth()->user()->name ?? 'Admin' }}
</div>
<form method="POST" action="/logout">
@csrf
<button type="submit" class="logout-btn">Logout</button>
</form>
</div>
</div>

<div class="content">
@yield('content')
</div>

</div>

</div>

@stack('scripts')

</body>
</html>
