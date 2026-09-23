@extends('layouts.app')

@section('title', 'Notices & Events')

@section('content')

<x-breadcrumb :items="['Notices & Events' => route('admin.notices.index')]" />

<x-page-header title="Noticeboard & Calendar Events" subtitle="Publish school circulars, announcements, and upcoming campus calendar events." />

<div class="row g-4">
    <div class="col-lg-6">
        <x-card title="Active Notices & Circulars" headerIcon="bi-megaphone">
            @forelse($notices as $n)
                <div class="p-3 bg-light rounded-3 mb-3 border-start border-4 border-primary">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold text-dark mb-0">{{ $n->title }}</h6>
                        <span class="badge bg-navy">{{ strtoupper($n->audience) }}</span>
                    </div>
                    <p class="small text-muted mb-2">{{ $n->description }}</p>
                    <div class="small text-muted"><i class="bi bi-calendar"></i> Published: {{ $n->publish_date->format('M d, Y') }}</div>
                </div>
            @empty
                <x-empty-state title="No Active Notices" description="Publish notices for parents, students, or staff." />
            @endforelse
        </x-card>
    </div>

    <div class="col-lg-6">
        <x-card title="Upcoming School Events" headerIcon="bi-calendar-event">
            @forelse($events as $e)
                <div class="p-3 bg-light rounded-3 mb-3 border-start border-4 border-warning">
                    <div class="fw-bold text-dark">{{ $e->title }}</div>
                    <p class="small text-muted mb-1">{{ $e->description }}</p>
                    <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $e->location ?? 'Main Campus' }} — {{ $e->event_date->format('M d, Y') }}</div>
                </div>
            @empty
                <x-empty-state title="No Events Scheduled" description="Schedule sports days, exhibitions, or cultural events." />
            @endforelse
        </x-card>
    </div>
</div>

@endsection
