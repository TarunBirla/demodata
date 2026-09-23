@extends('layouts.app')

@section('title', 'System Settings & Roles')

@section('content')

<x-breadcrumb :items="['Settings' => route('admin.settings.index')]" />

<x-page-header title="School Profile & System Settings" subtitle="Configure multi-school parameters, currency, receipt prefixes, and granular user roles & permissions.">
    <x-slot:actions>
        <button class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="bi bi-shield-plus me-1"></i> Add User Role</button>
    </x-slot:actions>
</x-page-header>

<div class="row g-4">
    <div class="col-lg-6">
        <x-card title="School General Profile" headerIcon="bi-sliders">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <x-input name="school_name" label="School Name" value="{{ $school->name ?? 'Junior Gurukul School' }}" required />
                <x-input name="school_phone" label="Contact Phone" value="{{ $school->phone ?? '096176 14788' }}" required />
                <x-input name="school_email" label="Official Email" value="{{ $school->email ?? 'info@juniorgurukulschool.in' }}" required />
                <x-input name="currency_symbol" label="Currency Symbol" value="₹" required />
                <x-input name="receipt_prefix" label="Fee Receipt Prefix" value="REC-2026-" required />
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
                        <div class="d-flex align-items-center gap-2">
                            <x-badge variant="navy">{{ $role->slug }}</x-badge>
                            <button class="btn btn-sm btn-light text-warning" data-bs-toggle="modal" data-bs-target="#editRoleModal{{ $role->id }}"><i class="bi bi-pencil"></i></button>
                            @if(!in_array($role->slug, ['super_admin', 'school_admin']))
                                <form action="{{ route('admin.settings.role.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete role {{ $role->name }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                                </form>
                            @endif
                        </div>

                        <!-- EDIT ROLE MODAL -->
                        <x-modal id="editRoleModal{{ $role->id }}" title="Edit Role — {{ $role->name }}">
                            <form action="{{ route('admin.settings.role.update', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <x-input name="name" label="Role Title" value="{{ $role->name }}" required />
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark small">Role Description</label>
                                    <textarea name="description" class="form-control" rows="2">{{ $role->description }}</textarea>
                                </div>
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-navy">Save Role</button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                @endforeach
            </div>
        </x-card>
    </div>
</div>

<!-- ADD ROLE MODAL -->
<x-modal id="addRoleModal" title="Create New User Role">
    <form action="{{ route('admin.settings.role.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Role Name" placeholder="e.g. Vice Principal" required />
        <x-input name="slug" label="Role Identifier Code (Slug)" placeholder="e.g. vice_principal" required />
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Role Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Brief permissions description..."></textarea>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Create Role</button>
        </div>
    </form>
</x-modal>

@endsection
