@extends('layouts.app')

@section('title', 'Homework Management')

@section('content')

<x-breadcrumb :items="['Homework' => route('admin.homework.index')]" />

<x-page-header title="Homework & Assignments" subtitle="Track subject homework, file attachments, and submission due dates.">
    <x-slot:actions>
        <button class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#addHomeworkModal"><i class="bi bi-plus-lg me-1"></i> Assign New Homework</button>
    </x-slot:actions>
</x-page-header>

<x-card>
    <x-table :headers="['Title', 'Class & Section', 'Subject', 'Assigned Date', 'Due Date', 'Assigned Teacher', 'Actions']">
        @forelse($homeworkList as $hw)
            <tr>
                <td class="fw-bold text-dark">{{ $hw->title }}</td>
                <td>{{ $hw->schoolClass->name ?? 'Grade 8' }} - {{ $hw->section->name ?? 'A' }}</td>
                <td><x-badge variant="info">{{ $hw->subject->name ?? 'Subject' }}</x-badge></td>
                <td class="small text-muted">{{ \Carbon\Carbon::parse($hw->assigned_date)->format('M d, Y') }}</td>
                <td class="small text-danger fw-bold">{{ \Carbon\Carbon::parse($hw->due_date)->format('M d, Y') }}</td>
                <td>{{ $hw->teacher->name ?? 'Teacher' }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editHomeworkModal{{ $hw->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.homework.destroy', $hw->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete homework assignment {{ $hw->title }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT HOMEWORK MODAL -->
                    <x-modal id="editHomeworkModal{{ $hw->id }}" title="Edit Homework — {{ $hw->title }}">
                        <form action="{{ route('admin.homework.update', $hw->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="title" label="Homework Title" value="{{ $hw->title }}" required />
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <x-select name="class_id" label="Class Choice" :options="$classes->pluck('name', 'id')->toArray()" :value="$hw->class_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="section_id" label="Section Choice" :options="$sections->pluck('name', 'id')->toArray()" :value="$hw->section_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="subject_id" label="Subject Choice" :options="$subjects->pluck('name', 'id')->toArray()" :value="$hw->subject_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="teacher_id" label="Assigned Teacher Choice" :options="$teachers->pluck('full_name', 'id')->toArray()" :value="$hw->teacher_id" />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="assigned_date" label="Assigned Date" type="date" value="{{ \Carbon\Carbon::parse($hw->assigned_date)->format('Y-m-d') }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="due_date" label="Submission Due Date" type="date" value="{{ \Carbon\Carbon::parse($hw->due_date)->format('Y-m-d') }}" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small">Assignment Instructions</label>
                                <textarea name="description" class="form-control" rows="3" required>{{ $hw->description }}</textarea>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Assignment Changes</button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-3">No homework assigned yet. Click 'Assign New Homework' above.</td></tr>
        @endforelse
    </x-table>
</x-card>

<!-- ADD HOMEWORK MODAL -->
<x-modal id="addHomeworkModal" title="Assign New Subject Homework">
    <form action="{{ route('admin.homework.store') }}" method="POST">
        @csrf
        <x-input name="title" label="Homework Title" placeholder="e.g. Chapter 4 Trigonometry Exercises" required />
        <div class="row g-2">
            <div class="col-md-6">
                <x-select name="class_id" label="Class Grade Choice" :options="$classes->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="section_id" label="Section Choice" :options="$sections->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="subject_id" label="Subject Choice" :options="$subjects->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="teacher_id" label="Teacher Choice" :options="$teachers->pluck('full_name', 'id')->toArray()" />
            </div>
            <div class="col-md-6">
                <x-input name="assigned_date" label="Assigned Date" type="date" value="{{ date('Y-m-d') }}" required />
            </div>
            <div class="col-md-6">
                <x-input name="due_date" label="Submission Due Date" type="date" value="{{ date('Y-m-d', strtotime('+3 days')) }}" required />
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Homework Instructions & Questions</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Write question numbers or instructions here..." required></textarea>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Save & Assign Homework</button>
        </div>
    </form>
</x-modal>

@endsection
