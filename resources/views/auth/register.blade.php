<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register | Vaatamilsiddha ERP</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}
html,body{width:100%;height:100%;overflow:hidden;}
body{
height:100dvh;
display:flex;
align-items:center;
justify-content:center;
padding:16px;
background:
radial-gradient(circle at top right, rgba(250,204,21,0.16), transparent 25%),
radial-gradient(circle at bottom left, rgba(20,184,166,0.16), transparent 24%),
linear-gradient(135deg,#081120 0%,#16314a 48%,#14532d 100%);
color:#e2e8f0;
overflow:hidden;
}
.auth-shell{
width:min(1160px,100%);
height:min(740px,calc(100dvh - 32px));
display:grid;
grid-template-columns:0.96fr 1.04fr;
background:rgba(255,255,255,0.08);
border:1px solid rgba(255,255,255,0.1);
border-radius:28px;
overflow:hidden;
box-shadow:0 28px 70px rgba(2,8,23,0.42);
backdrop-filter:blur(16px);
}
.auth-panel{
padding:34px 38px;
overflow:hidden;
}
.auth-hero{
display:flex;
flex-direction:column;
justify-content:space-between;
background:
linear-gradient(180deg, rgba(250,204,21,0.1), rgba(20,83,45,0.08)),
linear-gradient(145deg,#10203a,#14532d);
}
.auth-badge{
display:inline-flex;
align-items:center;
gap:10px;
padding:10px 15px;
border-radius:999px;
background:rgba(255,255,255,0.08);
border:1px solid rgba(255,255,255,0.08);
font-size:12px;
letter-spacing:0.08em;
text-transform:uppercase;
font-weight:800;
width:max-content;
}
.auth-copy h1{
margin-top:20px;
font-size:clamp(34px,3.8vw,52px);
line-height:1;
letter-spacing:-0.04em;
max-width:450px;
}
.auth-copy p{
margin-top:14px;
font-size:16px;
line-height:1.62;
max-width:470px;
color:#d4e3ef;
}
.feature-list{
display:grid;
gap:12px;
margin-top:24px;
}
.feature-item{
display:flex;
gap:12px;
padding:14px 16px;
border-radius:16px;
background:rgba(255,255,255,0.05);
border:1px solid rgba(255,255,255,0.04);
}
.feature-item i{
color:#fcd34d;
margin-top:4px;
}
.feature-item strong{
display:block;
font-size:16px;
margin-bottom:3px;
}
.feature-item span{
color:#c7d6e5;
font-size:14px;
line-height:1.5;
}
.auth-foot{
font-size:13px;
color:#a5b6c8;
}
.auth-card{
background:linear-gradient(180deg,#ffffff 0%,#f8fafc 100%);
color:#0f172a;
display:flex;
align-items:center;
}
.auth-card-inner{
width:100%;
max-width:470px;
margin:0 auto;
}
.auth-card h2{
font-size:40px;
line-height:1;
letter-spacing:-0.04em;
margin-bottom:12px;
}
.auth-card p{
font-size:15px;
line-height:1.6;
color:#64748b;
margin-bottom:22px;
}
.error-box{
padding:13px 15px;
border-radius:14px;
background:#fef2f2;
border:1px solid #fecaca;
color:#b91c1c;
margin-bottom:16px;
font-size:14px;
}
.auth-form{
display:grid;
gap:16px;
}
.form-grid{
display:grid;
grid-template-columns:1fr 1fr;
gap:16px;
}
.input-group{
display:grid;
gap:8px;
}
.input-group.full{
grid-column:1 / -1;
}
.input-group label{
font-size:14px;
font-weight:700;
color:#334155;
}
.input-wrap{
display:flex;
align-items:center;
gap:12px;
min-height:56px;
padding:0 16px;
border-radius:16px;
border:1px solid #d6dfeb;
background:#f8fbff;
}
.input-wrap i{
color:#0f766e;
width:18px;
text-align:center;
}
.input-wrap input{
width:100%;
border:none;
outline:none;
background:transparent;
font-size:15px;
color:#0f172a;
}
.auth-btn{
border:none;
padding:15px 22px;
border-radius:16px;
background:linear-gradient(135deg,#14b8a6,#0f766e);
color:white;
font-size:15px;
font-weight:800;
cursor:pointer;
box-shadow:0 16px 30px rgba(15,118,110,0.24);
margin-top:2px;
}
.auth-link{
margin-top:18px;
font-size:15px;
color:#475569;
}
.auth-link a{
color:#0f766e;
font-weight:800;
text-decoration:none;
}
@media (max-width: 980px){
.auth-shell{
grid-template-columns:1fr;
height:min(880px,calc(100dvh - 24px));
}
.auth-panel{
padding:24px;
}
.form-grid{
grid-template-columns:1fr;
}
.auth-copy h1{
font-size:34px;
}
}
</style>
</head>
<body>
<div class="auth-shell">
<div class="auth-panel auth-hero">
<div class="auth-copy">
<div class="auth-badge"><i class="fa-solid fa-seedling"></i> Vaatamilsiddha ERP</div>
<h1>Begin your path to holistic wellness with Vaatamil Siddha.</h1>
<p>Create a secure clinic account through a compact and professional onboarding layout.</p>
<div class="feature-list">
<div class="feature-item"><i class="fa-solid fa-user-plus"></i><div><strong>Quick setup</strong><span>Create admin or staff access in a few clean steps.</span></div></div>
<div class="feature-item"><i class="fa-solid fa-briefcase-medical"></i><div><strong>ERP ready</strong><span>Go straight to patients, doctors, medicines, and billing after signup.</span></div></div>
</div>
</div>
<div class="auth-foot">Designed for a crisp full-screen fit without extra scroll.</div>
</div>

<div class="auth-panel auth-card">
<div class="auth-card-inner">
<h2>Register</h2>
<p>Create a new ERP user account.</p>

@if ($errors->any())
<div class="error-box">{{$errors->first()}}</div>
@endif

<form method="POST" action="/register" class="auth-form">
@csrf
<div class="form-grid">
<div class="input-group full">
<label>Full Name</label>
<div class="input-wrap">
<i class="fa-solid fa-user"></i>
<input type="text" name="name" value="{{old('name')}}" placeholder="Enter full name" required>
</div>
</div>

<div class="input-group full">
<label>Email Address</label>
<div class="input-wrap">
<i class="fa-solid fa-envelope"></i>
<input type="email" name="email" value="{{old('email')}}" placeholder="staff@vaatamilsiddha.com" required>
</div>
</div>

<div class="input-group">
<label>Password</label>
<div class="input-wrap">
<i class="fa-solid fa-lock"></i>
<input type="password" name="password" placeholder="Minimum 6 characters" required>
</div>
</div>

<div class="input-group">
<label>Confirm Password</label>
<div class="input-wrap">
<i class="fa-solid fa-shield-halved"></i>
<input type="password" name="password_confirmation" placeholder="Repeat password" required>
</div>
</div>
</div>

<button type="submit" class="auth-btn">Create Account</button>
</form>

<div class="auth-link">
Already have an account? <a href="/login">Login here</a>
</div>
</div>
</div>
</div>
</body>
</html>
