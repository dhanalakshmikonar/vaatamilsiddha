<!DOCTYPE html>

<html>
<head>
<title>Siddha Clinic ERP</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@600;700&display=swap" rel="stylesheet">
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
background:
radial-gradient(circle at top left, rgba(16,185,129,0.08), transparent 22%),
radial-gradient(circle at bottom right, rgba(14,116,144,0.08), transparent 22%),
linear-gradient(180deg,#edf3f9 0%,#f6f9fd 100%);
height:100vh;
overflow:hidden;
color:#0f172a;
}

.container{
display:flex;
height:100vh;
}

.sidebar{
width:250px;
background:linear-gradient(180deg,#0f172a 0%,#16243b 100%);
color:white;
padding:26px 20px;
position:sticky;
top:0;
height:100vh;
flex-shrink:0;
overflow:hidden;
border-right:1px solid rgba(255,255,255,0.05);
}

.logo{
font-size:22px;
font-weight:800;
margin-bottom:34px;
letter-spacing:0.04em;
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
gap:12px;
padding:13px 14px;
text-decoration:none;
color:#cbd5e1;
border-radius:14px;
transition:0.2s ease;
font-weight:700;
}

.sidebar ul li a:hover{
background:rgba(255,255,255,0.08);
color:white;
transform:translateX(2px);
}

.main{
flex:1;
display:flex;
flex-direction:column;
height:100vh;
overflow:hidden;
}

.header{
background:rgba(255,255,255,0.78);
backdrop-filter:blur(14px);
padding:18px 28px;
display:flex;
justify-content:space-between;
align-items:center;
border-bottom:1px solid rgba(226,232,240,0.85);
position:sticky;
top:0;
z-index:10;
}

.header h3{
font-weight:800;
letter-spacing:-0.02em;
}

.brand-title{
font-family:'Cormorant Garamond', serif;
font-size:34px;
font-weight:700;
letter-spacing:0.04em;
color:#0f3d3e;
line-height:1;
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
border:1px solid #e2e8f0;
color:#0f172a;
font-size:14px;
font-weight:700;
display:inline-flex;
align-items:center;
gap:10px;
}

.header-user-name{
font-family:'Cormorant Garamond', serif;
font-size:19px;
font-weight:600;
letter-spacing:0.02em;
color:#0f3d3e;
line-height:1;
}

.logout-btn{
border:none;
background:linear-gradient(135deg,#0f172a,#1e293b);
color:white;
padding:10px 14px;
border-radius:12px;
cursor:pointer;
font-weight:700;
box-shadow:0 10px 24px rgba(15,23,42,0.18);
}

.logout-btn:hover{
filter:brightness(1.05);
}

.content{
padding:24px;
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
padding:22px;
border-radius:22px;
box-shadow:0 14px 28px rgba(15,23,42,0.06);
border:1px solid rgba(226,232,240,0.85);
width:100%;
}

table{
width:100%;
border-collapse:collapse;
margin-top:0;
}

table th{
text-align:left;
padding:14px 14px;
background:#eef7f8;
color:#0f4b56;
font-size:12px;
letter-spacing:0.07em;
text-transform:uppercase;
border-bottom:1px solid #d9edf0;
position:sticky;
top:0;
z-index:1;
}

table td{
padding:13px 14px;
border-bottom:1px solid #edf2f7;
font-size:14px;
vertical-align:top;
}

table tbody tr:nth-child(even){
background:#fcfdff;
}

table tbody tr:hover{
background:#f3f9ff;
}

.btn{
background:linear-gradient(135deg,#14b8a6,#0f766e);
color:white;
padding:10px 14px;
border-radius:14px;
text-decoration:none;
font-size:13px;
display:inline-flex;
align-items:center;
gap:8px;
font-weight:700;
border:none;
box-shadow:0 14px 28px rgba(15,118,110,0.18);
transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
}

.btn:hover{
transform:translateY(-1px);
box-shadow:0 18px 34px rgba(15,118,110,0.24);
filter:brightness(1.02);
}

.upload-inline{
display:flex;
gap:8px;
align-items:center;
flex-wrap:wrap;
padding:8px 10px;
background:#f8fbff;
border:1px solid #e2e8f0;
border-radius:16px;
}

.upload-inline input[type="file"]{
background:white;
border:1px solid #d1d5db;
border-radius:12px;
padding:8px 10px;
font-size:12px;
color:#475569;
min-width:210px;
cursor:pointer;
box-shadow:inset 0 1px 0 rgba(255,255,255,0.8);
transition:border-color .18s ease, box-shadow .18s ease, background .18s ease;
}

.upload-inline input[type="file"]:hover{
border-color:#99f6e4;
background:#ffffff;
box-shadow:0 0 0 4px rgba(20,184,166,0.08);
}

.upload-inline input[type="file"]::file-selector-button{
margin-right:12px;
border:none;
background:linear-gradient(135deg,#0f172a,#1e293b);
color:white;
padding:8px 12px;
border-radius:10px;
font-weight:700;
cursor:pointer;
transition:filter .18s ease;
}

.upload-inline input[type="file"]::file-selector-button:hover{
filter:brightness(1.06);
}

.alert-success,
.alert-error{
padding:16px 18px;
border-radius:16px;
margin-bottom:18px;
font-weight:700;
border:1px solid transparent;
box-shadow:0 10px 24px rgba(15,23,42,0.04);
}

.alert-success{
background:linear-gradient(180deg,#ecfdf5 0%,#dcfce7 100%);
color:#166534;
border-color:#bbf7d0;
}

.alert-error{
background:linear-gradient(180deg,#fff1f2 0%,#fee2e2 100%);
color:#991b1b;
border-color:#fecaca;
}

.edit-btn{
background:linear-gradient(135deg,#3b82f6,#1d4ed8);
color:white;
padding:10px 12px;
border-radius:12px;
border:none;
cursor:pointer;
box-shadow:0 10px 22px rgba(37,99,235,0.2);
}

.delete-btn{
background:linear-gradient(135deg,#ef4444,#dc2626);
color:white;
padding:10px 14px;
border-radius:12px;
border:none;
cursor:pointer;
box-shadow:0 10px 22px rgba(220,38,38,0.18);
}

.edit-btn:hover,
.delete-btn:hover{
filter:brightness(1.03);
transform:translateY(-1px);
}

.form-card{
background:white;
padding:30px;
border-radius:20px;
box-shadow:0 18px 42px rgba(15,23,42,0.08);
border:1px solid rgba(226,232,240,0.85);
max-width:900px;
}

.form-title{
font-size:22px;
font-weight:700;
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
font-weight:600;
margin-bottom:7px;
color:#334155;
}

.form-group input,
.form-group select,
.form-group textarea{
padding:12px 13px;
border:1px solid #dbe2ea;
border-radius:14px;
font-size:14px;
background:#fbfdff;
}

.form-actions{
margin-top:20px;
}

.primary-btn,
.btn-primary{
background:linear-gradient(135deg,#14b8a6,#0f766e);
border:none;
padding:13px 18px;
color:white;
border-radius:14px;
cursor:pointer;
font-weight:700;
box-shadow:0 14px 28px rgba(15,118,110,0.18);
}

.btn-primary:hover,
.primary-btn:hover{
filter:brightness(1.03);
}

.form-container{
background:#fff;
padding:30px;
border-radius:22px;
box-shadow:0 18px 42px rgba(15,23,42,0.08);
border:1px solid rgba(226,232,240,0.85);
width:100%;
max-width:1000px;
}

.form-header h2{
margin-bottom:6px;
font-size:30px;
letter-spacing:-0.03em;
}

.form-header p{
color:#64748b;
font-size:14px;
margin-bottom:25px;
}

.form-group.full{
grid-column:1 / span 2;
}

.profile-card{
background:white;
padding:30px;
border-radius:22px;
box-shadow:0 18px 42px rgba(15,23,42,0.08);
border:1px solid rgba(226,232,240,0.85);
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
transition:transform .18s ease, box-shadow .18s ease;
}

.doctor-card-elegant:hover{
transform:translateY(-3px);
box-shadow:0 22px 40px rgba(15,23,42,0.12);
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
font-weight:700;
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
padding:11px 15px;
border-radius:14px;
cursor:pointer;
font-weight:700;
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

.detail-table{
width:100%;
margin-top:18px;
}

.detail-table th{
background:#f0fdfa;
color:#0f766e;
}

.bill-card{
background:white;
padding:30px;
border-radius:22px;
box-shadow:0 18px 42px rgba(15,23,42,0.08);
border:1px solid rgba(226,232,240,0.85);
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
border-radius:16px;
margin-bottom:22px;
}

.bill-meta p{
margin-top:6px;
color:#334155;
}

.bill-total{
margin-top:20px;
padding:18px 20px;
border-radius:16px;
background:#0f172a;
color:white;
font-size:18px;
font-weight:700;
text-align:right;
}

.page-shell{
display:grid;
gap:14px;
}

.toolbar-card{
display:flex;
justify-content:space-between;
align-items:center;
gap:18px;
flex-wrap:wrap;
padding:20px 22px;
background:white;
border:1px solid rgba(226,232,240,0.85);
border-radius:22px;
box-shadow:0 14px 28px rgba(15,23,42,0.06);
}

.toolbar-title h2{
font-size:26px;
letter-spacing:-0.03em;
margin-bottom:6px;
}

.toolbar-title p{
color:#64748b;
font-size:14px;
line-height:1.6;
max-width:620px;
}

.toolbar-actions{
display:flex;
gap:12px;
align-items:center;
flex-wrap:wrap;
justify-content:flex-end;
}

.ghost-btn{
display:inline-flex;
align-items:center;
gap:8px;
padding:10px 14px;
border-radius:14px;
border:1px solid #dbeafe;
background:#eff6ff;
color:#1d4ed8;
font-weight:700;
text-decoration:none;
}

.ghost-btn:hover{
background:#dbeafe;
}

.meta-note{
padding:14px 16px;
border-radius:16px;
background:#f8fafc;
border:1px dashed #cbd5e1;
color:#475569;
font-size:14px;
line-height:1.6;
}

.table-actions{
display:flex;
gap:8px;
align-items:center;
flex-wrap:wrap;
}

.stats-grid{
display:grid;
grid-template-columns:repeat(4,minmax(0,1fr));
gap:14px;
}

.stat-card{
background:linear-gradient(180deg,#ffffff 0%,#f8fbff 100%);
border:1px solid #e2e8f0;
border-radius:18px;
padding:16px 18px;
box-shadow:0 10px 24px rgba(15,23,42,0.05);
}

.stat-label{
font-size:12px;
font-weight:700;
letter-spacing:0.08em;
text-transform:uppercase;
color:#64748b;
}

.stat-value{
margin-top:8px;
font-size:26px;
font-weight:800;
letter-spacing:-0.03em;
color:#0f172a;
}

.stat-sub{
margin-top:6px;
font-size:13px;
color:#64748b;
}

.table-shell{
margin-top:6px;
border:1px solid #e2e8f0;
border-radius:18px;
overflow:hidden;
background:#fff;
box-shadow:inset 0 0 0 1px rgba(255,255,255,0.5);
}

.table-shell table{
margin-top:0;
min-width:900px;
}

.pill{
display:inline-flex;
align-items:center;
padding:6px 10px;
border-radius:999px;
font-size:12px;
font-weight:700;
background:#f1f5f9;
color:#334155;
}

.icon-action{
display:inline-flex;
align-items:center;
justify-content:center;
min-width:36px;
height:36px;
padding:0 10px;
border:1px solid #dbe3ee;
border-radius:10px;
cursor:pointer;
background:#ffffff;
color:#334155;
box-shadow:0 4px 10px rgba(15,23,42,0.06);
transition:all .15s ease;
}

.icon-action.view{
color:#2563eb;
border-color:#bfdbfe;
}

.icon-action.edit{
color:#0f766e;
border-color:#99f6e4;
}

.icon-action.delete{
color:#be123c;
border-color:#fecdd3;
}

.icon-action:hover{
transform:translateY(-1px);
box-shadow:0 8px 16px rgba(15,23,42,0.08);
}

.icon-action.view:hover{
background:#eff6ff;
}

.icon-action.edit:hover{
background:#ecfeff;
}

.icon-action.delete:hover{
background:#fff1f2;
}

.icon-action i{
font-size:13px;
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
.bill-meta,
.doctor-info-grid,
.doctor-doc-row{
grid-template-columns:1fr;
}

.form-group.full,
.profile-grid .full{
grid-column:auto;
}

.section-title,
.toolbar-card{
flex-direction:column;
align-items:flex-start;
}

.stats-grid{
grid-template-columns:1fr 1fr;
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
<h3 class="brand-title">Vaatamilsiddha</h3>
<div class="header-right">
<div class="header-user">
<i class="fa-solid fa-user-circle"></i>
<span class="header-user-name">Dhanalakshmi Nainar Konar</span>
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
