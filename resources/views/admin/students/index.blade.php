@extends('layouts.app')

@section('title', 'Student Directory')

@section('content')

<x-breadcrumb :items="['Students' => route('admin.students.index')]" />

<x-page-header title="Student Management" subtitle="Manage student profiles, class section assignments, and academic records.">
    @if(in_array(auth()->user()->role_name, ['super_admin', 'school_admin']))
        <x-slot:actions>
            <x-button variant="navy" icon="bi-plus-lg" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add New Student</x-button>
        </x-slot:actions>
    @endif
</x-page-header>

<x-card>
    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <form action="{{ route('admin.students.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" name="search" class="form-control" placeholder="Search by name or admission number..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-navy"><i class="bi bi-search"></i> Search</button>
            </form>
        </div>
        <div class="col-md-3 ms-auto">
            <form action="{{ route('admin.students.index') }}" method="GET">
                <select name="class_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Filter by Class (All)</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id }}" {{ request('class_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    <x-table :headers="['Admission #', 'Student Name', 'Class & Section', 'Gender', 'Contact Phone', 'Status', 'Actions']">
        @forelse($students as $st)
            <tr>
                <td class="fw-semibold text-primary">{{ $st->admission_number }}</td>
                <td>
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-navy text-white fw-bold d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                            {{ strtoupper(substr($st->first_name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold text-dark">{{ $st->full_name }}</div>
                            <div class="small text-muted">{{ $st->email }}</div>
                        </div>
                    </div>
                </td>
                <td>{{ $st->schoolClass->name ?? 'N/A' }} - {{ $st->section->name ?? 'A' }}</td>
                <td><span class="text-capitalize">{{ $st->gender }}</span></td>
                <td>{{ $st->phone ?? '+91 98765 00000' }}</td>
                <td><x-badge variant="success">{{ strtoupper($st->status) }}</x-badge></td>
                <td>
                    <div class="d-flex align-items-center gap-1">
                        <a href="{{ route('admin.students.show', $st->id) }}" class="btn btn-sm btn-outline-primary" title="View Profile"><i class="bi bi-eye"></i></a>
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editStudentModal{{ $st->id }}" title="Edit Student"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.students.destroy', $st->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete student {{ $st->full_name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Student"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT STUDENT MODAL -->
                    <x-modal id="editStudentModal{{ $st->id }}" title="Edit Student — {{ $st->full_name }}">
                        <form action="{{ route('admin.students.update', $st->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input name="first_name" label="First Name" value="{{ $st->first_name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="last_name" label="Last Name" value="{{ $st->last_name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="gender" label="Gender" :options="['male' => 'Male', 'female' => 'Female']" :value="$st->gender" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="dob" label="Date of Birth" type="date" value="{{ $st->dob ? \Carbon\Carbon::parse($st->dob)->format('Y-m-d') : '' }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="class_id" label="Class" :options="$classes->pluck('name', 'id')->toArray()" :value="$st->class_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="section_id" label="Section" :options="$sections->pluck('name', 'id')->toArray()" :value="$st->section_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="phone" label="Contact Phone" value="{{ $st->phone }}" />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="status" label="Status" :options="['active' => 'Active', 'archived' => 'Archived', 'graduated' => 'Graduated']" :value="$st->status" required />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <x-button type="submit" variant="navy" icon="bi-check-lg">Update Student</x-button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state title="No Students Found" description="Try clearing search filters or add a new student." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-3">
        {{ $students->links() }}
    </div>
</x-card>

<!-- ADD STUDENT MODAL -->
<x-modal id="addStudentModal" title="Add New Student">
    <form action="{{ route('admin.students.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-input name="first_name" label="First Name" required placeholder="e.g. Aarav" />
            </div>
            <div class="col-md-6">
                <x-input name="last_name" label="Last Name" required placeholder="e.g. Gupta" />
            </div>
            <div class="col-md-6">
                <x-select name="gender" label="Gender" :options="['male' => 'Male', 'female' => 'Female']" required />
            </div>
            <div class="col-md-6">
                <x-input name="dob" label="Date of Birth" type="date" required value="2012-05-10" />
            </div>
            <div class="col-md-6">
                <x-select name="class_id" label="Class Choice" :options="$classes->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="section_id" label="Section Choice" :options="$sections->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-input name="phone" label="Contact Phone" placeholder="+91 98765 43210" />
            </div>
            <div class="col-md-6">
                <x-input name="email" label="Student Portal Email" type="email" placeholder="student@juniorgurukul.in" />
            </div>
            <div class="col-md-6">
                <x-input name="password" label="Portal Login Password" type="password" placeholder="Default: password123" />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <x-button type="submit" variant="navy" icon="bi-check-lg">Save Student Record</x-button>
        </div>
    </form>
</x-modal>

@endsection
