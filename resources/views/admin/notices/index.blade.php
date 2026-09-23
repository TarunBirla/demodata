@extends('layouts.app')

@section('title', 'Notices & Events')

@section('content')

<x-breadcrumb :items="['Notices & Events' => route('admin.notices.index')]" />

<x-page-header title="Noticeboard & Calendar Events" subtitle="Publish school circulars, announcements, and upcoming campus calendar events.">
    <x-slot:actions>
        <button class="btn btn-navy me-2" data-bs-toggle="modal" data-bs-target="#addNoticeModal"><i class="bi bi-megaphone me-1"></i> Publish Notice</button>
        <button class="btn btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#addEventModal"><i class="bi bi-calendar-plus me-1"></i> Schedule Event</button>
    </x-slot:actions>
</x-page-header>

<div class="row g-4">
    <div class="col-lg-6">
        <x-card title="Active Notices & Circulars" headerIcon="bi-megaphone">
            @forelse($notices as $n)
                <div class="p-3 bg-light rounded-3 mb-3 border-start border-4 border-primary position-relative">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h6 class="fw-bold text-dark mb-0">{{ $n->title }}</h6>
                        <div>
                            <span class="badge bg-navy me-1">{{ strtoupper($n->audience) }}</span>
                            <button class="btn btn-sm btn-light py-0 px-1 text-warning" data-bs-toggle="modal" data-bs-target="#editNoticeModal{{ $n->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('admin.notices.destroy', $n->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete notice {{ $n->title }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light py-0 px-1 text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="small text-muted mb-2">{{ $n->description }}</p>
                    <div class="small text-muted"><i class="bi bi-calendar"></i> Published: {{ \Carbon\Carbon::parse($n->publish_date)->format('M d, Y') }}</div>

                    <!-- EDIT NOTICE MODAL -->
                    <x-modal id="editNoticeModal{{ $n->id }}" title="Edit Notice — {{ $n->title }}">
                        <form action="{{ route('admin.notices.update', $n->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="title" label="Notice Title" value="{{ $n->title }}" required />
                            <x-select name="audience" label="Audience Choice" :options="['everyone' => 'Everyone (Public & School)', 'students' => 'Students Only', 'teachers' => 'Teachers & Staff Only', 'parents' => 'Parents Only']" :value="$n->audience" required />
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small">Notice Content / Description</label>
                                <textarea name="description" class="form-control" rows="3" required>{{ $n->description }}</textarea>
                            </div>
                            <x-input name="publish_date" label="Publish Date" type="date" value="{{ \Carbon\Carbon::parse($n->publish_date)->format('Y-m-d') }}" required />
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Notice</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            @empty
                <x-empty-state title="No Active Notices" description="Publish notices for parents, students, or staff." />
            @endforelse
        </x-card>
    </div>

    <div class="col-lg-6">
        <x-card title="Upcoming School Events" headerIcon="bi-calendar-event">
            @forelse($events as $e)
                <div class="p-3 bg-light rounded-3 mb-3 border-start border-4 border-warning position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div class="fw-bold text-dark fs-6">{{ $e->title }}</div>
                        <div>
                            <button class="btn btn-sm btn-light py-0 px-1 text-warning" data-bs-toggle="modal" data-bs-target="#editEventModal{{ $e->id }}"><i class="bi bi-pencil"></i></button>
                            <form action="{{ route('admin.events.destroy', $e->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete event {{ $e->title }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-light py-0 px-1 text-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    <p class="small text-muted mb-1">{{ $e->description }}</p>
                    <div class="small text-muted"><i class="bi bi-geo-alt me-1"></i> {{ $e->location ?? 'Main Campus' }} — {{ \Carbon\Carbon::parse($e->event_date)->format('M d, Y') }}</div>

                    <!-- EDIT EVENT MODAL -->
                    <x-modal id="editEventModal{{ $e->id }}" title="Edit Event — {{ $e->title }}">
                        <form action="{{ route('admin.events.update', $e->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="title" label="Event Title" value="{{ $e->title }}" required />
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small">Event Description</label>
                                <textarea name="description" class="form-control" rows="2">{{ $e->description }}</textarea>
                            </div>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <x-input name="event_date" label="Event Date" type="date" value="{{ \Carbon\Carbon::parse($e->event_date)->format('Y-m-d') }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="location" label="Location / Venue" value="{{ $e->location }}" />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">Save Event</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            @empty
                <x-empty-state title="No Events Scheduled" description="Schedule sports days, exhibitions, or cultural events." />
            @endforelse
        </x-card>
    </div>
</div>

<!-- ADD NOTICE MODAL -->
<x-modal id="addNoticeModal" title="Publish New Notice / Circular">
    <form action="{{ route('admin.notices.store') }}" method="POST">
        @csrf
        <x-input name="title" label="Notice Title" placeholder="e.g. Science Exhibition Registration" required />
        <x-select name="audience" label="Audience Choice" :options="['everyone' => 'Everyone (Public & School)', 'students' => 'Students Only', 'teachers' => 'Teachers & Staff Only', 'parents' => 'Parents Only']" required />
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Notice Content / Details</label>
            <textarea name="description" class="form-control" rows="3" placeholder="Write notice content here..." required></textarea>
        </div>
        <x-input name="publish_date" label="Publish Date" type="date" value="{{ date('Y-m-d') }}" required />
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Publish Notice</button>
        </div>
    </form>
</x-modal>

<!-- ADD EVENT MODAL -->
<x-modal id="addEventModal" title="Schedule School Event">
    <form action="{{ route('admin.events.store') }}" method="POST">
        @csrf
        <x-input name="title" label="Event Name" placeholder="e.g. Annual Sports Day 2026" required />
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Event Description</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Brief details about the event..."></textarea>
        </div>
        <div class="row g-2">
            <div class="col-md-6">
                <x-input name="event_date" label="Event Date" type="date" value="{{ date('Y-m-d', strtotime('+7 days')) }}" required />
            </div>
            <div class="col-md-6">
                <x-input name="location" label="Venue / Location" placeholder="Main School Ground" />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-warning"><i class="bi bi-check-lg me-1"></i> Save Event</button>
        </div>
    </form>
</x-modal>

@endsection
