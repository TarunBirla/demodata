@extends('layouts.app')

@section('title', 'Examinations & Marks')

@section('content')

<x-breadcrumb :items="['Exams' => route('admin.exams.index')]" />

<x-page-header title="Examination & Marks Management" subtitle="Manage exam schedules, subject max marks, bulk mark entries, and publish report cards." />

<div class="row g-4">
    @forelse($exams as $ex)
        <div class="col-md-6">
            <x-card :title="$ex->name" headerIcon="bi-journal-check">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="small text-muted"><i class="bi bi-calendar"></i> {{ $ex->start_date->format('M d') }} - {{ $ex->end_date->format('M d, Y') }}</span>
                    @if($ex->is_published)
                        <x-badge variant="success">RESULTS PUBLISHED</x-badge>
                    @else
                        <x-badge variant="warning">DRAFT / UNPUBLISHED</x-badge>
                    @endif
                </div>

                <h6 class="fw-bold text-dark small text-uppercase mb-2">Exam Subjects</h6>
                <div class="list-group list-group-flush mb-3">
                    @foreach($ex->examSubjects as $es)
                        <div class="list-group-item px-0 py-2 d-flex align-items-center justify-content-between small">
                            <span class="fw-semibold text-dark">{{ $es->subject->name ?? 'Subject' }}</span>
                            <span class="text-muted">Max: {{ $es->max_marks }} | Pass: {{ $es->pass_marks }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-navy"><i class="bi bi-pencil-square"></i> Enter Marks</button>
                    <button class="btn btn-sm btn-outline-secondary"><i class="bi bi-file-earmark-pdf"></i> Generate Report Cards</button>
                </div>
            </x-card>
        </div>
    @empty
        <div class="col-12">
            <x-empty-state title="No Exams Created" description="Create an exam schedule to enter marks and generate student report cards." />
        </div>
    @endforelse
</div>

@endsection
