@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
<h5 class="fw-bold text-dark mb-1">Reset Password</h5>
<p class="text-muted small mb-4">Enter your registered email address and we'll send you a password reset link.</p>

@if(session('error'))
    <x-alert type="danger">{{ session('error') }}</x-alert>
@endif
@if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif

<form action="{{ route('auth.forgot_password.submit') }}" method="POST">
    @csrf
    <x-input name="email" label="Registered Email" type="email" placeholder="e.g. admin@greenvalley.edu" value="{{ old('email') }}" required />

    <button type="submit" class="btn btn-navy w-100 py-2.5 fw-bold rounded-2 mb-3">
        <i class="bi bi-envelope-paper me-1"></i> Send Password Reset Link
    </button>
</form>

<div class="text-center border-top pt-3">
    <a href="{{ route('auth.login') }}" class="small text-decoration-none fw-semibold">
        <i class="bi bi-arrow-left me-1"></i> Back to Login
    </a>
</div>
@endsection
