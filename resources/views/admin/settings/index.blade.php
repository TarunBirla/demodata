@extends('layouts.app')

@section('title', 'System Settings & Roles')

@section('content')

<x-breadcrumb :items="['Settings' => route('admin.settings.index')]" />

<x-page-header title="School Profile & System Settings" subtitle="Configure multi-school parameters, currency, receipt prefixes, and granular user roles & permissions." />

<div class="row g-4">
    <div class="col-lg-6">
        <x-card title="School General Profile" headerIcon="bi-sliders">
            <form action="#" method="POST" onsubmit="event.preventDefault(); alert('School Settings Updated Successfully!');">
                <x-input name="school_name" label="School Name" value="{{ $school->name ?? 'Junior Gurukul School' }}" />
                <x-input name="school_phone" label="Contact Phone" value="{{ $school->phone ?? '096176 14788' }}" />
                <x-input name="school_email" label="Official Email" value="{{ $school->email ?? 'info@juniorgurukulschool.in' }}" />
                <x-input name="currency_symbol" label="Currency Symbol" value="₹" />
                <x-input name="receipt_prefix" label="Fee Receipt Prefix" value="REC-2026-" />
                <button type="submit" class="btn btn-navy"><i class="bi bi-save me-1"></i> Save Profile Settings</button>
            </form>
        </x-card>
    </div>

    <div class="col-lg-6">
        <x-card title="Roles & Granular Permissions" headerIcon="bi-shield-lock">
            <div class="list-group list-group-flush">
                @foreach($roles as $role)
                    <div class="list-group-item px-0 py-2 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fw-bold text-dark">{{ $role->name }}</div>
                            <div class="small text-muted">{{ $role->description }}</div>
                        </div>
                        <x-badge variant="navy">{{ $role->slug }}</x-badge>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
</div>

@endsection
