<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | Vaatamilsiddha ERP</title>
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
radial-gradient(circle at top left, rgba(20,184,166,0.18), transparent 28%),
radial-gradient(circle at bottom right, rgba(14,165,233,0.14), transparent 24%),
linear-gradient(135deg,#081120 0%,#0d2136 48%,#0f4c4d 100%);
color:#e2e8f0;
overflow:hidden;
}
.auth-shell{
width:min(1160px,100%);
height:min(720px,calc(100dvh - 32px));
display:grid;
grid-template-columns:1fr 0.92fr;
background:rgba(255,255,255,0.08);
border:1px solid rgba(255,255,255,0.1);
border-radius:28px;
overflow:hidden;
box-shadow:0 28px 70px rgba(2,8,23,0.42);
backdrop-filter:blur(16px);
}
.auth-panel{
padding:36px 40px;
overflow:hidden;
}
.auth-hero{
display:flex;
flex-direction:column;
justify-content:space-between;
background:
linear-gradient(180deg, rgba(20,184,166,0.14), rgba(15,23,42,0.1)),
linear-gradient(145deg,#0c5b50,#0c1b2e);
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
margin-top:22px;
font-size:clamp(36px,4vw,56px);
line-height:0.98;
letter-spacing:-0.04em;
max-width:460px;
}
.auth-copy p{
margin-top:16px;
font-size:16px;
line-height:1.65;
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
color:#7dd3fc;
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
color:#98abc0;
}
.auth-card{
background:linear-gradient(180deg,#ffffff 0%,#f8fafc 100%);
color:#0f172a;
display:flex;
align-items:center;
}
.auth-card-inner{
width:100%;
max-width:420px;
margin:0 auto;
}
.auth-card h2{
font-size:42px;
line-height:1;
letter-spacing:-0.04em;
margin-bottom:12px;
}
.auth-card p{
font-size:15px;
line-height:1.6;
color:#64748b;
margin-bottom:24px;
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
.input-group{
display:grid;
gap:8px;
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
min-height:58px;
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
.auth-actions{
display:flex;
justify-content:space-between;
align-items:center;
gap:12px;
margin-top:4px;
}
.remember{
display:flex;
align-items:center;
gap:8px;
font-size:14px;
color:#475569;
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
}
.auth-link{
margin-top:22px;
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
height:min(860px,calc(100dvh - 24px));
}
.auth-panel{
padding:24px;
}
.auth-copy h1{
font-size:34px;
}
.feature-list{
grid-template-columns:1fr;
}
}
</style>
</head>
<body>
<div class="auth-shell">
<div class="auth-panel auth-hero">
<div class="auth-copy">
<div class="auth-badge"><i class="fa-solid fa-leaf"></i> Vaatamilsiddha ERP</div>
<h1>Welcome back to Vaatamil Siddha  continuing your journey to natural healing.</h1>
<p>Access patients, medicines, billing, and doctor records from one organized Siddha ERP workspace.</p>
<div class="feature-list">
<div class="feature-item"><i class="fa-solid fa-user-group"></i><div><strong>Connected workflow</strong><span>Patients, medicines, and billing stay linked clearly.</span></div></div>
<div class="feature-item"><i class="fa-solid fa-shield-halved"></i><div><strong>Secure access</strong><span>Authorized staff can sign in through one professional screen.</span></div></div>
</div>
</div>
<div class="auth-foot">Built for smooth daily operations at Vaatamilsiddha.</div>
</div>

<div class="auth-panel auth-card">
<div class="auth-card-inner">
<h2>Login</h2>
<p>Enter your account details to continue.</p>

@if ($errors->any())
<div class="error-box">{{$errors->first()}}</div>
@endif

<form method="POST" action="/login" class="auth-form">
@csrf
<div class="input-group">
<label>Email Address</label>
<div class="input-wrap">
<i class="fa-solid fa-envelope"></i>
<input type="email" name="email" value="{{old('email')}}" placeholder="admin@vaatamilsiddha.com" required>
</div>
</div>

<div class="input-group">
<label>Password</label>
<div class="input-wrap">
<i class="fa-solid fa-lock"></i>
<input type="password" name="password" placeholder="Enter password" required>
</div>
</div>

<div class="auth-actions">
<label class="remember">
<input type="checkbox" name="remember">
<span>Remember me</span>
</label>
<button type="submit" class="auth-btn">Login</button>
</div>
</form>

<div class="auth-link">
Need an account? <a href="/register">Create one here</a>
</div>
</div>
</div>
</div>
</body>
</html>
