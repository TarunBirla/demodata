@extends('layouts.app')

@section('title', 'System Settings, Schools & Roles')

@section('content')

<x-breadcrumb :items="['Settings' => route('admin.settings.index')]" />

<x-page-header title="Super Admin System Management" subtitle="Manage Multi-School Campuses, School Admins, System Roles, Global Users, and School Profile Parameters.">
    <x-slot:actions>
        <button class="btn btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#addSchoolModal"><i class="bi bi-building-add me-1"></i> Add New School</button>
        <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="bi bi-person-plus me-1"></i> Create User Account</button>
        <button class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#addRoleModal"><i class="bi bi-shield-plus me-1"></i> Add User Role</button>
    </x-slot:actions>
</x-page-header>

<!-- SCHOOL CAMPUSES MANAGEMENT SECTION -->
<div class="row g-4 mb-4">
    <div class="col-12">
        <x-card title="Multi-Tenant School Campuses Registry" headerIcon="bi-buildings">
            <x-table :headers="['School Name', 'Code', 'Contact Phone', 'Email Address', 'Assigned Users', 'Total Students', 'Actions']">
                @foreach($schools as $s)
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="bi bi-building text-primary me-2"></i>{{ $s->name }}
                        </td>
                        <td><x-badge variant="navy">{{ $s->code }}</x-badge></td>
                        <td>{{ $s->phone ?? 'N/A' }}</td>
                        <td class="text-muted">{{ $s->email ?? 'N/A' }}</td>
                        <td><span class="badge bg-info text-dark">{{ $s->users_count }} Users</span></td>
                        <td><span class="badge bg-success">{{ $s->students_count }} Students</span></td>
                        <td>
                            <button class="btn btn-sm btn-light text-warning ms-1" data-bs-toggle="modal" data-bs-target="#editSchoolModal{{ $s->id }}"><i class="bi bi-pencil me-1"></i> Edit School</button>
                        </td>
                    </tr>

                    <!-- EDIT SCHOOL MODAL -->
                    <x-modal id="editSchoolModal{{ $s->id }}" title="Edit Campus — {{ $s->name }}">
                        <form action="{{ route('admin.settings.school.update', $s->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="name" label="School Campus Name" value="{{ $s->name }}" required />
                            <x-input name="phone" label="Contact Phone" value="{{ $s->phone }}" />
                            <x-input name="email" label="Official Email" type="email" value="{{ $s->email }}" />
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small">Campus Address</label>
                                <textarea name="address" class="form-control" rows="2">{{ $s->address }}</textarea>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy"><i class="bi bi-save me-1"></i> Save Changes</button>
                            </div>
                        </form>
                    </x-modal>
                @endforeach
            </x-table>
        </x-card>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <x-card title="Active School Profile Settings" headerIcon="bi-sliders">
            <form action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Select School Campus</label>
                    <select name="school_id" class="form-select mb-2" onchange="this.form.submit()">
                        @foreach($schools as $s)
                            <option value="{{ $s->id }}" {{ ($school->id ?? 1) == $s->id ? 'selected' : '' }}>{{ $s->name }} (Code: {{ $s->code }})</option>
                        @endforeach
                    </select>
                </div>
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
        <x-card title="System Roles & Access Slugs" headerIcon="bi-shield-lock">
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

<!-- USER LOGIN ACCOUNTS REGISTRY & MANAGEMENT -->
<x-card title="System User Login Accounts Registry (Full Super Admin Access)" headerIcon="bi-people-fill">
    <x-table :headers="['User Name', 'Login Email', 'Assigned Role', 'School Scope', 'Status', 'Actions']">
        @foreach($users as $u)
            <tr>
                <td class="fw-bold text-dark">{{ $u->name }}</td>
                <td class="text-primary fw-semibold">{{ $u->email }}</td>
                <td><x-badge variant="navy">{{ strtoupper(str_replace('_', ' ', $u->role_name)) }}</x-badge></td>
                <td><span class="small text-muted">{{ $u->school->name ?? 'Global (All Schools)' }}</span></td>
                <td><x-badge variant="{{ $u->status === 'active' ? 'success' : 'secondary' }}">{{ strtoupper($u->status) }}</x-badge></td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <button class="btn btn-sm btn-light text-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $u->id }}"><i class="bi bi-pencil me-1"></i> Edit</button>
                        @if($u->id !== auth()->id())
                            <form action="{{ route('admin.settings.user.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete user account {{ $u->email }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>

            <!-- EDIT USER ACCOUNT MODAL -->
            <x-modal id="editUserModal{{ $u->id }}" title="Edit User Account — {{ $u->name }}">
                <form action="{{ route('admin.settings.user.update', $u->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <x-input name="name" label="Full Name" value="{{ $u->name }}" required />
                    <x-input name="email" label="Login Email Address" type="email" value="{{ $u->email }}" required />
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Assigned System Role</label>
                        <select name="role_name" class="form-select" required>
                            @foreach($roles as $roleOption)
                                <option value="{{ $roleOption->slug }}" {{ $u->role_name === $roleOption->slug ? 'selected' : '' }}>{{ $roleOption->name }} ({{ $roleOption->slug }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">School Campus Scope</label>
                        <select name="school_id" class="form-select">
                            <option value="">Global (All Schools — Super Admin)</option>
                            @foreach($schools as $sch)
                                <option value="{{ $sch->id }}" {{ $u->school_id == $sch->id ? 'selected' : '' }}>{{ $sch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-input name="phone" label="Contact Phone" value="{{ $u->phone }}" />
                    <x-input name="password" label="New Password (leave blank to keep current password)" type="password" placeholder="Min 6 chars..." />
                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark small">Account Status</label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ $u->status === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $u->status === 'inactive' ? 'selected' : '' }}>Inactive / Suspended</option>
                        </select>
                    </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-navy"><i class="bi bi-save me-1"></i> Update User Account</button>
                    </div>
                </form>
            </x-modal>
        @endforeach
    </x-table>
</x-card>

<!-- CREATE USER ACCOUNT MODAL -->
<x-modal id="addUserModal" title="Create User Account (Any Role)">
    <form action="{{ route('admin.settings.user.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Full Name" placeholder="e.g. Ramesh Kumar" required />
        <x-input name="email" label="Login Email Address" type="email" placeholder="ramesh@juniorgurukulschool.in" required />
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Select System Role</label>
            <select name="role_name" class="form-select" required>
                @foreach($roles as $roleOption)
                    <option value="{{ $roleOption->slug }}">{{ $roleOption->name }} ({{ $roleOption->slug }})</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Select School Campus Scope</label>
            <select name="school_id" class="form-select">
                <option value="">Global (All Schools — Super Admin)</option>
                @foreach($schools as $sch)
                    <option value="{{ $sch->id }}">{{ $sch->name }}</option>
                @endforeach
            </select>
        </div>
        <x-input name="password" label="Login Password" type="password" placeholder="Minimum 6 characters" required />
        <x-input name="phone" label="Contact Phone" placeholder="+91 98765 00000" />
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <x-button type="submit" variant="navy" icon="bi-check-lg">Create User Account</x-button>
        </div>
    </form>
</x-modal>

<!-- ADD NEW SCHOOL MODAL -->
<x-modal id="addSchoolModal" title="Add New School Campus">
    <form action="{{ route('admin.settings.school.store') }}" method="POST">
        @csrf
        <x-input name="name" label="School Campus Name" placeholder="e.g. St. Xavier Gurukul Branch" required />
        <x-input name="code" label="Campus Code / Identifier" placeholder="e.g. STX-GURUKUL" required />
        <x-input name="phone" label="Contact Phone" placeholder="+91 98765 11111" />
        <x-input name="email" label="Official Email" type="email" placeholder="admin@stxavier.edu" />
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Campus Address</label>
            <textarea name="address" class="form-control" rows="2" placeholder="Full campus location address..."></textarea>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success"><i class="bi bi-building-add me-1"></i> Register School Campus</button>
        </div>
    </form>
</x-modal>

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
            <button type="submit" class="btn btn-navy"><i class="bi-check-lg me-1"></i> Create Role</button>
        </div>
    </form>
</x-modal>

@endsection
