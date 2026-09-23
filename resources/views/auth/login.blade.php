@extends('layouts.auth')

@section('title', 'Portal Login')

@section('content')
<h5 class="fw-bold text-dark mb-1" style="font-family: 'Space Grotesk', sans-serif;">Sign In to Your Account</h5>
<p class="text-muted small mb-4">Enter your registered email and password to access the Junior Gurukul School portal.</p>

@if(session('error'))
    <x-alert type="danger">{{ session('error') }}</x-alert>
@endif
@if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif

<form action="{{ route('auth.login.submit') }}" method="POST" id="loginForm">
    @csrf
    <x-input name="email" id="emailInput" label="Email Address" type="email" placeholder="admin@juniorgurukulschool.in" value="{{ old('email', 'admin@juniorgurukulschool.in') }}" required />
    <x-input name="password" id="passwordInput" label="Password" type="password" placeholder="••••••••" value="password123" required />

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label small text-muted" for="remember">Remember Me</label>
        </div>
        <a href="{{ route('auth.forgot_password') }}" class="small text-decoration-none fw-semibold" style="color: #C5A059;">Forgot Password?</a>
    </div>

    <button type="submit" class="btn btn-navy w-100 py-2.5 fw-bold rounded-2" style="font-family: 'Space Grotesk', sans-serif;">
        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
    </button>
</form>

<div class="mt-4 pt-3 border-top">
    <div class="d-flex align-items-center justify-content-between mb-2">
        <span class="small text-muted fw-bold text-uppercase" style="font-size: 0.72rem; letter-spacing: 0.5px;">⚡ Quick Role Demo Logins</span>
        <span class="badge bg-soft-primary text-primary" style="font-size: 0.68rem;">Click to Auto-fill</span>
    </div>
    
    <div class="row g-2">
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('superadmin@system.com')">
                <div class="fw-bold text-truncate text-danger" style="font-size: 0.76rem;"><i class="bi bi-shield-lock-fill me-1"></i> Super Admin</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">superadmin@system.com</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('admin@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-primary" style="font-size: 0.76rem;"><i class="bi bi-building-fill me-1"></i> Admin (JGS)</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">admin@juniorgurukulschool.in</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('admin@greenvalley.edu')">
                <div class="fw-bold text-truncate text-info" style="font-size: 0.76rem;"><i class="bi bi-building-gear me-1"></i> Admin (GVIS)</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">admin@greenvalley.edu</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('vikram.m@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-success" style="font-size: 0.76rem;"><i class="bi bi-person-badge-fill me-1"></i> Teacher</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">vikram.m@juniorgurukulschool.in</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('accountant@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-warning" style="font-size: 0.76rem;"><i class="bi bi-cash-stack me-1"></i> Accountant</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">accountant@...</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('librarian@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-secondary" style="font-size: 0.76rem;"><i class="bi bi-book-half me-1"></i> Librarian</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">librarian@...</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('transport@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-dark" style="font-size: 0.76rem;"><i class="bi bi-bus-front-fill me-1"></i> Transport Mgr</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">transport@...</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('hr@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-danger" style="font-size: 0.76rem;"><i class="bi bi-people-fill me-1"></i> HR Manager</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">hr@...</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('aarav.patidar@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-primary" style="font-size: 0.76rem;"><i class="bi bi-backpack-fill me-1"></i> Student</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">aarav.patidar@...</div>
            </button>
        </div>
        <div class="col-6">
            <button type="button" class="btn btn-outline-secondary btn-sm w-100 text-start py-1 px-2 demo-btn" onclick="fillDemo('parent@juniorgurukulschool.in')">
                <div class="fw-bold text-truncate text-success" style="font-size: 0.76rem;"><i class="bi bi-heart-pulse-fill me-1"></i> Parent</div>
                <div class="text-muted text-truncate" style="font-size: 0.68rem;">parent@...</div>
            </button>
        </div>
    </div>
    <div class="text-center small text-muted mt-2" style="font-size: 0.75rem;">Password for all accounts: <code class="fw-bold text-dark">password123</code></div>
</div>

<script>
function fillDemo(email) {
    var emailInputs = document.querySelectorAll('input[name="email"]');
    var passwordInputs = document.querySelectorAll('input[name="password"]');
    emailInputs.forEach(function(inp) { inp.value = email; });
    passwordInputs.forEach(function(inp) { inp.value = 'password123'; });
}
</script>
@endsection