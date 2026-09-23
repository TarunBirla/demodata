@extends('layouts.app')

@section('title', 'Classes & Sections')

@section('content')

<x-breadcrumb :items="['Classes' => route('admin.classes.index')]" />

<x-page-header title="Academic Classes & Sections" subtitle="Configure grade levels, section capacities, and class teacher assignments.">
    @if(in_array(auth()->user()->role_name ?? '', ['super_admin', 'school_admin']))
    <x-slot:actions>
        <button class="btn btn-navy me-2" data-bs-toggle="modal" data-bs-target="#addClassModal"><i class="bi bi-plus-lg me-1"></i> Add New Class</button>
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSectionModal"><i class="bi bi-plus-lg me-1"></i> Add Section to Class</button>
    </x-slot:actions>
    @endif
</x-page-header>

<div class="row g-4">
    @foreach($classes as $c)
        <div class="col-md-6 col-lg-4">
            <x-card :title="$c->name" headerIcon="bi-building">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-soft-primary">Order: {{ $c->display_order }}</span>
                    @if(in_array(auth()->user()->role_name ?? '', ['super_admin', 'school_admin']))
                    <div>
                        <button class="btn btn-sm btn-light py-0 px-1 text-warning" data-bs-toggle="modal" data-bs-target="#editClassModal{{ $c->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.classes.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete class {{ $c->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light py-0 px-1 text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                    @endif
                </div>
                <h6 class="fw-bold text-dark small text-uppercase">Assigned Sections</h6>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @forelse($c->sections as $sec)
                        <div class="badge bg-light text-dark border p-2 d-flex align-items-center gap-2">
                            <span><i class="bi bi-door-open me-1 text-primary"></i> {{ $sec->name }} (Cap: {{ $sec->capacity }})</span>
                            @if(in_array(auth()->user()->role_name ?? '', ['super_admin', 'school_admin']))
                            <button class="btn btn-link p-0 text-warning" data-bs-toggle="modal" data-bs-target="#editSectionModal{{ $sec->id }}"><i class="bi bi-pencil-fill" style="font-size:0.75rem;"></i></button>
                            <form action="{{ route('admin.sections.destroy', $sec->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete section {{ $sec->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-danger"><i class="bi bi-x-circle-fill" style="font-size:0.75rem;"></i></button>
                            </form>
                            @endif
                        </div>

                        <!-- EDIT SECTION MODAL -->
                        <x-modal id="editSectionModal{{ $sec->id }}" title="Edit Section — {{ $c->name }} Section {{ $sec->name }}">
                            <form action="{{ route('admin.sections.update', $sec->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <x-input name="name" label="Section Name" value="{{ $sec->name }}" required />
                                <x-input name="capacity" label="Student Capacity" type="number" value="{{ $sec->capacity }}" required />
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-navy">Update Section</button>
                                </div>
                            </form>
                        </x-modal>
                    @empty
                        <span class="text-muted small">No sections created yet.</span>
                    @endforelse
                </div>

                <!-- EDIT CLASS MODAL -->
                <x-modal id="editClassModal{{ $c->id }}" title="Edit Class — {{ $c->name }}">
                    <form action="{{ route('admin.classes.update', $c->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-input name="name" label="Class Name" value="{{ $c->name }}" required />
                        <x-input name="display_order" label="Display Order" type="number" value="{{ $c->display_order }}" />
                        <x-select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" :value="$c->status" required />
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-navy">Save Class Changes</button>
                        </div>
                    </form>
                </x-modal>
            </x-card>
        </div>
    @endforeach
</div>

<!-- ADD CLASS MODAL -->
<x-modal id="addClassModal" title="Add New Class">
    <form action="{{ route('admin.classes.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Class Grade Name" placeholder="e.g. Grade 10" required />
        <x-input name="display_order" label="Display Priority Order" type="number" value="10" />
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Create Class</button>
        </div>
    </form>
</x-modal>

<!-- ADD SECTION MODAL -->
<x-modal id="addSectionModal" title="Add Section to Class">
    <form action="{{ route('admin.sections.store') }}" method="POST">
        @csrf
        <x-select name="class_id" label="Class Grade Choice" :options="$classes->pluck('name', 'id')->toArray()" required />
        <x-input name="name" label="Section Name" placeholder="e.g. A, B, Rose" required />
        <x-input name="capacity" label="Classroom Student Capacity" type="number" value="40" required />
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-check-lg me-1"></i> Add Section</button>
        </div>
    </form>
</x-modal>

@endsection
