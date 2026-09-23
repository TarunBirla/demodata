@extends('layouts.app')

@section('title', 'Subjects Directory')

@section('content')

<x-breadcrumb :items="['Subjects' => route('admin.subjects.index')]" />

<x-page-header title="Subject Configuration" subtitle="Manage academic subject catalog, codes, theory/practical classification.">
    @if(in_array(auth()->user()->role_name, ['super_admin', 'school_admin']))
        <x-slot:actions>
            <button class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#addSubjectModal"><i class="bi bi-plus-lg me-1"></i> Add New Subject</button>
        </x-slot:actions>
    @endif
</x-page-header>

<x-card>
    <x-table :headers="['Subject Code', 'Subject Name', 'Type', 'Status', 'Actions']">
        @forelse($subjects as $sub)
            <tr>
                <td class="fw-semibold text-primary">{{ $sub->code }}</td>
                <td class="fw-bold text-dark">{{ $sub->name }}</td>
                <td><x-badge variant="info">{{ strtoupper($sub->type) }}</x-badge></td>
                <td><x-badge variant="success">{{ strtoupper($sub->status) }}</x-badge></td>
                <td>
                    @if(in_array(auth()->user()->role_name, ['super_admin', 'school_admin']))
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editSubjectModal{{ $sub->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('admin.subjects.destroy', $sub->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete subject {{ $sub->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    @else
                        <span class="text-muted small"><i class="bi bi-lock"></i> Read Only</span>
                    @endif

                    <!-- EDIT SUBJECT MODAL -->
                    <x-modal id="editSubjectModal{{ $sub->id }}" title="Edit Subject — {{ $sub->name }}">
                        <form action="{{ route('admin.subjects.update', $sub->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <x-input name="name" label="Subject Name" value="{{ $sub->name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="code" label="Subject Code" value="{{ $sub->code }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="type" label="Subject Type Choice" :options="['theory' => 'Theory', 'practical' => 'Practical', 'elective' => 'Elective']" :value="$sub->type" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" :value="$sub->status" required />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Subject Changes</button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted py-3">No subjects created yet.</td></tr>
        @endforelse
    </x-table>
</x-card>

<!-- ADD SUBJECT MODAL -->
<x-modal id="addSubjectModal" title="Add New Subject">
    <form action="{{ route('admin.subjects.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <x-input name="name" label="Subject Name" placeholder="e.g. Mathematics" required />
            </div>
            <div class="col-md-6">
                <x-input name="code" label="Subject Code" placeholder="e.g. MATH-101" required />
            </div>
            <div class="col-md-12">
                <x-select name="type" label="Subject Type Choice" :options="['theory' => 'Theory', 'practical' => 'Practical / Lab', 'elective' => 'Elective / Activity']" required />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Save Subject</button>
        </div>
    </form>
</x-modal>

@endsection
