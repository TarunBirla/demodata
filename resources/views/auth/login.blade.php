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

<form action="{{ route('auth.login.submit') }}" method="POST">
    @csrf
    <x-input name="email" label="Email Address" type="email" placeholder="admin@juniorgurukulschool.in" value="{{ old('email', 'admin@juniorgurukulschool.in') }}" required />
    <x-input name="password" label="Password" type="password" placeholder="••••••••" value="password123" required />

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

<div class="mt-4 pt-3 border-top text-center">
    <div class="small text-muted mb-2 fw-semibold">Quick Role Logins</div>
    <div class="d-flex flex-wrap justify-content-center gap-1">
        <span class="badge bg-light text-dark border">Admin: admin@juniorgurukulschool.in</span>
        <span class="badge bg-light text-dark border">Teacher: vikram.m@juniorgurukulschool.in</span>
        <span class="badge bg-light text-dark border">Parent: parent@juniorgurukulschool.in</span>
        <span class="badge bg-light text-dark border">Student: aarav.patidar@juniorgurukulschool.in</span>
    </div>
    <div class="small text-muted mt-1">Password for all accounts: <code>password123</code></div>
</div>
@endsection