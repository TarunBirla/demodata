@extends('layouts.app')

@section('title', 'HR & Staff Management')

@section('content')
<x-page-header title="HR & Staff Management" subtitle="Manage non-teaching staff, employee records, and HR directory">
    @if(in_array(auth()->user()->role_name, ['super_admin', 'school_admin', 'hr_manager']))
    <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addStaffModal">
        <i class="bi bi-plus-lg me-1"></i> Add Staff Member
    </button>
    @endif
</x-page-header>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <x-stat-card title="Total Staff Members" value="{{ $staffList->count() }}" icon="bi-person-badge" bgClass="bg-soft-primary" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Active Employees" value="{{ $staffList->where('status', 'active')->count() }}" icon="bi-check-circle" bgClass="bg-soft-success" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Total Monthly Payroll" value="₹{{ number_format($staffList->sum('basic_salary'), 2) }}" icon="bi-cash-coin" bgClass="bg-soft-warning" />
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white py-3 border-0">
        <h5 class="fw-bold mb-0 text-navy"><i class="bi bi-person-workspace me-2"></i> Employee Directory</h5>
    </div>
    <div class="card-body p-0">
        @if($staffList->isEmpty())
            <x-empty-state title="No Staff Members" message="No staff profiles registered yet." />
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">EMP ID</th>
                            <th>Name</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>Phone / Email</th>
                            <th>Basic Salary</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staffList as $s)
                        <tr>
                            <td class="ps-4"><code>{{ $s->employee_id }}</code></td>
                            <td class="fw-bold text-dark">{{ $s->name }}</td>
                            <td><span class="badge bg-soft-primary text-primary">{{ $s->department }}</span></td>
                            <td>{{ $s->designation }}</td>
                            <td class="small">
                                <div>{{ $s->phone ?: 'N/A' }}</div>
                                <div class="text-muted">{{ $s->email }}</div>
                            </td>
                            <td><strong class="text-success">₹{{ number_format($s->basic_salary, 2) }}</strong></td>
                            <td><span class="badge bg-soft-success text-success">{{ ucfirst($s->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Staff Modal -->
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.staff.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-navy text-white">
                    <h5 class="modal-title fw-bold">Register Staff Member</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Department *</label>
                            <input type="text" name="department" class="form-control" placeholder="e.g. Accounts / HR / IT" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Designation *</label>
                            <input type="text" name="designation" class="form-control" placeholder="e.g. Officer / Executive" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Basic Salary (₹) *</label>
                            <input type="number" step="0.01" name="basic_salary" class="form-control" value="35000.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4">Save Staff Member</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
