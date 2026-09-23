@extends('layouts.app')

@section('title', 'Examinations & Marks')

@section('content')

<x-breadcrumb :items="['Exams' => route('admin.exams.index')]" />

<x-page-header title="Examination & Marks Management" subtitle="Manage exam schedules, subject max marks, bulk mark entries, and publish report cards.">
    <x-slot:actions>
        <button class="btn btn-navy me-2" data-bs-toggle="modal" data-bs-target="#addExamModal"><i class="bi bi-plus-lg me-1"></i> Create New Exam</button>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#enterMarksModal"><i class="bi bi-pencil-square me-1"></i> Enter Marks</button>
    </x-slot:actions>
</x-page-header>

<div class="row g-4">
    @forelse($exams as $ex)
        <div class="col-md-6">
            <x-card :title="$ex->name" headerIcon="bi-journal-check">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="small text-muted"><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($ex->start_date)->format('M d') }} - {{ \Carbon\Carbon::parse($ex->end_date)->format('M d, Y') }}</span>
                    <div>
                        @if($ex->is_published)
                            <x-badge variant="success">RESULTS PUBLISHED</x-badge>
                        @else
                            <x-badge variant="warning">DRAFT / UNPUBLISHED</x-badge>
                        @endif
                        <button class="btn btn-sm btn-light text-warning ms-1" data-bs-toggle="modal" data-bs-target="#editExamModal{{ $ex->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.exams.destroy', $ex->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete exam {{ $ex->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>

                <h6 class="fw-bold text-dark small text-uppercase mb-2">Exam Subjects</h6>
                <div class="list-group list-group-flush mb-3">
                    @forelse($ex->examSubjects as $es)
                        <div class="list-group-item px-0 py-2 d-flex align-items-center justify-content-between small">
                            <span class="fw-semibold text-dark">{{ $es->subject->name ?? 'Subject' }} ({{ $es->schoolClass->name ?? 'Class' }})</span>
                            <span class="text-muted">Max: {{ $es->max_marks }} | Pass: {{ $es->pass_marks }}</span>
                        </div>
                    @empty
                        <div class="text-muted small py-2">No subjects assigned to this exam schedule yet.</div>
                    @endforelse
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-navy" data-bs-toggle="modal" data-bs-target="#enterMarksModal"><i class="bi bi-pencil-square"></i> Enter Marks</button>
                    <button class="btn btn-sm btn-outline-secondary" onclick="alert('Report Cards Generated!')"><i class="bi bi-file-earmark-pdf"></i> Generate Report Cards</button>
                </div>

                <!-- EDIT EXAM MODAL -->
                <x-modal id="editExamModal{{ $ex->id }}" title="Edit Exam — {{ $ex->name }}">
                    <form action="{{ route('admin.exams.update', $ex->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <x-input name="name" label="Exam Title" value="{{ $ex->name }}" required />
                        <div class="row g-2">
                            <div class="col-md-6">
                                <x-input name="start_date" label="Start Date" type="date" value="{{ \Carbon\Carbon::parse($ex->start_date)->format('Y-m-d') }}" required />
                            </div>
                            <div class="col-md-6">
                                <x-input name="end_date" label="End Date" type="date" value="{{ \Carbon\Carbon::parse($ex->end_date)->format('Y-m-d') }}" required />
                            </div>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="pub_{{ $ex->id }}" {{ $ex->is_published ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold text-dark" for="pub_{{ $ex->id }}">
                                Publish Exam Results to Students & Parents
                            </label>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-navy">Save Exam Schedule</button>
                        </div>
                    </form>
                </x-modal>
            </x-card>
        </div>
    @empty
        <div class="col-12">
            <x-empty-state title="No Exams Created" description="Create an exam schedule to enter marks and generate student report cards." />
        </div>
    @endforelse
</div>

<!-- ADD EXAM MODAL -->
<x-modal id="addExamModal" title="Create New Examination Schedule">
    <form action="{{ route('admin.exams.store') }}" method="POST">
        @csrf
        <x-input name="name" label="Exam Title" placeholder="e.g. Mid-Term Examination 2026" required />
        <div class="row g-2">
            <div class="col-md-6">
                <x-input name="start_date" label="Start Date" type="date" value="{{ date('Y-m-d') }}" required />
            </div>
            <div class="col-md-6">
                <x-input name="end_date" label="End Date" type="date" value="{{ date('Y-m-d', strtotime('+10 days')) }}" required />
            </div>
        </div>
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" name="is_published" value="1" id="pub_new">
            <label class="form-check-label fw-bold text-dark" for="pub_new">
                Publish Exam Results Immediately
            </label>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Save Exam</button>
        </div>
    </form>
</x-modal>

<!-- ENTER MARKS MODAL -->
<x-modal id="enterMarksModal" title="Enter Student Exam Marks">
    <form action="{{ route('admin.exams.marks.store') }}" method="POST">
        @csrf
        <div class="row g-2">
            <div class="col-md-6">
                <x-select name="exam_id" label="Exam Schedule Choice" :options="$exams->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="class_id" label="Class Grade Choice" :options="$classes->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="subject_id" label="Subject Choice" :options="$subjects->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="student_id" label="Student Choice" :options="$students->pluck('full_name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-input name="marks_obtained" label="Marks Obtained" type="number" step="0.5" placeholder="85" required />
            </div>
            <div class="col-md-6">
                <x-input name="max_marks" label="Maximum Marks" type="number" step="0.5" value="100" required />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-1"></i> Save Student Marks</button>
        </div>
    </form>
</x-modal>

@endsection
