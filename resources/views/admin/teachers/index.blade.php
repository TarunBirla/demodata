@extends('layouts.app')

@section('title', 'Teachers & Faculty')

@section('content')

<x-breadcrumb :items="['Teachers' => route('admin.teachers.index')]" />

<x-page-header title="Teachers & Faculty Directory" subtitle="Manage teaching staff profiles, qualifications, and class section assignments.">
    <x-slot:actions>
        <x-button variant="navy" icon="bi-plus-lg" data-bs-toggle="modal" data-bs-target="#addTeacherModal">Add New Teacher</x-button>
    </x-slot:actions>
</x-page-header>

<x-card>
    <x-table :headers="['Employee ID', 'Faculty Name', 'Qualification', 'Designation', 'Phone', 'Status', 'Actions']">
        @forelse($teachers as $t)
            <tr>
                <td class="fw-semibold text-primary">{{ $t->employee_id }}</td>
                <td>
                    <div class="fw-bold text-dark">{{ $t->full_name }}</div>
                    <div class="small text-muted">{{ $t->email }}</div>
                </td>
                <td>{{ $t->qualification }}</td>
                <td>{{ $t->designation }}</td>
                <td>{{ $t->phone }}</td>
                <td><x-badge variant="success">{{ strtoupper($t->status) }}</x-badge></td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editTeacherModal{{ $t->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.teachers.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete teacher {{ $t->full_name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT TEACHER MODAL -->
                    <x-modal id="editTeacherModal{{ $t->id }}" title="Edit Teacher — {{ $t->full_name }}">
                        <form action="{{ route('admin.teachers.update', $t->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input name="first_name" label="First Name" value="{{ $t->first_name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="last_name" label="Last Name" value="{{ $t->last_name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="email" label="Official Email" type="email" value="{{ $t->email }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="phone" label="Contact Phone" value="{{ $t->phone }}" />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="qualification" label="Qualification" :options="['M.Sc. B.Ed' => 'M.Sc. B.Ed', 'M.A. B.Ed' => 'M.A. B.Ed', 'B.Tech / B.E.' => 'B.Tech / B.E.', 'Ph.D. Education' => 'Ph.D. Education', 'B.Sc. B.Ed' => 'B.Sc. B.Ed']" :value="$t->qualification" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="designation" label="Designation" :options="['Senior Teacher' => 'Senior Teacher', 'Head of Department' => 'Head of Department', 'Assistant Teacher' => 'Assistant Teacher', 'Lab Instructor' => 'Lab Instructor']" :value="$t->designation" required />
                                </div>
                                <div class="col-md-12">
                                    <x-select name="status" label="Status" :options="['active' => 'Active', 'on_leave' => 'On Leave', 'resigned' => 'Resigned']" :value="$t->status" required />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <x-button type="submit" variant="navy" icon="bi-check-lg">Update Teacher Profile</x-button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-3">No teachers found.</td></tr>
        @endforelse
    </x-table>
</x-card>

<!-- ADD TEACHER MODAL -->
<x-modal id="addTeacherModal" title="Add New Teacher">
    <form action="{{ route('admin.teachers.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-input name="first_name" label="First Name" placeholder="e.g. Ramesh" required />
            </div>
            <div class="col-md-6">
                <x-input name="last_name" label="Last Name" placeholder="e.g. Sharma" required />
            </div>
            <div class="col-md-6">
                <x-input name="email" label="Official Email" type="email" placeholder="ramesh@juniorgurukul.in" required />
            </div>
            <div class="col-md-6">
                <x-input name="phone" label="Contact Phone" placeholder="+91 98765 11111" />
            </div>
            <div class="col-md-6">
                <x-select name="qualification" label="Qualification Choice" :options="['M.Sc. B.Ed' => 'M.Sc. B.Ed', 'M.A. B.Ed' => 'M.A. B.Ed', 'B.Tech / B.E.' => 'B.Tech / B.E.', 'Ph.D. Education' => 'Ph.D. Education', 'B.Sc. B.Ed' => 'B.Sc. B.Ed']" required />
            </div>
            <div class="col-md-6">
                <x-select name="designation" label="Designation Choice" :options="['Senior Teacher' => 'Senior Teacher', 'Head of Department' => 'Head of Department', 'Assistant Teacher' => 'Assistant Teacher', 'Lab Instructor' => 'Lab Instructor']" required />
            </div>
            <div class="col-md-12">
                <x-input name="password" label="Portal Login Password" type="password" placeholder="Default: password123" />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <x-button type="submit" variant="navy" icon="bi-check-lg">Save Teacher Profile</x-button>
        </div>
    </form>
</x-modal>

@endsection
