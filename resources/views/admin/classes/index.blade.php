@extends('layouts.app')

@section('title', 'Classes & Sections')

@section('content')

<x-breadcrumb :items="['Classes' => route('admin.classes.index')]" />

<x-page-header title="Academic Classes & Sections" subtitle="Configure grade levels, section capacities, and class teacher assignments." />

<div class="row g-4">
    @foreach($classes as $c)
        <div class="col-md-6 col-lg-4">
            <x-card :title="$c->name" headerIcon="bi-building">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="badge bg-soft-primary">Order: {{ $c->display_order }}</span>
                    <span class="badge bg-soft-success">Active</span>
                </div>
                <h6 class="fw-bold text-dark small text-uppercase">Assigned Sections</h6>
                <div class="d-flex flex-wrap gap-2 mb-2">
                    @forelse($c->sections as $sec)
                        <span class="badge bg-light text-dark border p-2">
                            <i class="bi bi-door-open me-1"></i> {{ $sec->name }} (Cap: {{ $sec->capacity }})
                        </span>
                    @empty
                        <span class="text-muted small">No sections created yet.</span>
                    @endforelse
                </div>
            </x-card>
        </div>
    @endforeach
</div>

@endsection
