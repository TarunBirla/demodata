@extends('layouts.app')

@section('title', 'Class & Teacher Timetables')

@section('content')

<x-breadcrumb :items="['Timetable' => route('admin.timetable.index')]" />

<x-page-header title="Master Timetable Scheduler" subtitle="Weekly class period schedules, teacher allocation, and room collision prevention.">
    <x-slot:actions>
        <button class="btn btn-navy" data-bs-toggle="modal" data-bs-target="#addTimetableModal"><i class="bi bi-plus-lg me-1"></i> Add Timetable Slot</button>
    </x-slot:actions>
</x-page-header>

<x-card title="Scheduled Timetable Periods" headerIcon="bi-calendar-week" class="mb-4">
    <x-table :headers="['Class & Section', 'Day', 'Period #', 'Subject', 'Teacher', 'Timing & Room', 'Actions']">
        @forelse($timetables as $slot)
            <tr>
                <td class="fw-bold text-dark">{{ $slot->schoolClass->name ?? 'Class' }} - {{ $slot->section->name ?? 'A' }}</td>
                <td><span class="badge bg-navy">{{ $slot->day }}</span></td>
                <td class="fw-semibold text-primary">Period {{ $slot->period_number }}</td>
                <td class="fw-bold text-primary">{{ $slot->subject->name ?? 'Subject' }}</td>
                <td>{{ $slot->teacher->name ?? 'Teacher' }}</td>
                <td>
                    <div class="small text-dark fw-semibold">{{ \Carbon\Carbon::parse($slot->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($slot->end_time)->format('h:i A') }}</div>
                    <div class="small text-muted">{{ $slot->room_number ?? 'Room 101' }}</div>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editSlotModal{{ $slot->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.timetable.destroy', $slot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this timetable period slot?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT TIMETABLE SLOT MODAL -->
                    <x-modal id="editSlotModal{{ $slot->id }}" title="Edit Timetable Slot — Period {{ $slot->period_number }}">
                        <form action="{{ route('admin.timetable.update', $slot->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <x-select name="class_id" label="Class Choice" :options="$classes->pluck('name', 'id')->toArray()" :value="$slot->class_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="section_id" label="Section Choice" :options="$sections->pluck('name', 'id')->toArray()" :value="$slot->section_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="day" label="Day of Week" :options="['Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday']" :value="$slot->day" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="period_number" label="Period Number" type="number" min="1" max="10" value="{{ $slot->period_number }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="subject_id" label="Subject Choice" :options="$subjects->pluck('name', 'id')->toArray()" :value="$slot->subject_id" required />
                                </div>
                                <div class="col-md-6">
                                    <x-select name="teacher_id" label="Teacher Assignment" :options="$teachers->pluck('full_name', 'id')->toArray()" :value="$slot->teacher_id" required />
                                </div>
                                <div class="col-md-4">
                                    <x-input name="start_time" label="Start Time" type="time" value="{{ $slot->start_time }}" required />
                                </div>
                                <div class="col-md-4">
                                    <x-input name="end_time" label="End Time" type="time" value="{{ $slot->end_time }}" required />
                                </div>
                                <div class="col-md-4">
                                    <x-input name="room_number" label="Room / Lab" value="{{ $slot->room_number }}" />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Slot Changes</button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center text-muted py-3">No timetable period slots added yet. Click 'Add Timetable Slot' above.</td></tr>
        @endforelse
    </x-table>
</x-card>

<!-- ADD TIMETABLE SLOT MODAL -->
<x-modal id="addTimetableModal" title="Add Timetable Slot">
    <form action="{{ route('admin.timetable.store') }}" method="POST">
        @csrf
        <div class="row g-2">
            <div class="col-md-6">
                <x-select name="class_id" label="Class Choice" :options="$classes->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="section_id" label="Section Choice" :options="$sections->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="day" label="Day of Week Choice" :options="['Monday'=>'Monday','Tuesday'=>'Tuesday','Wednesday'=>'Wednesday','Thursday'=>'Thursday','Friday'=>'Friday','Saturday'=>'Saturday']" required />
            </div>
            <div class="col-md-6">
                <x-input name="period_number" label="Period Number (1 - 8)" type="number" min="1" max="10" value="1" required />
            </div>
            <div class="col-md-6">
                <x-select name="subject_id" label="Subject Choice" :options="$subjects->pluck('name', 'id')->toArray()" required />
            </div>
            <div class="col-md-6">
                <x-select name="teacher_id" label="Teacher Assignment Choice" :options="$teachers->pluck('full_name', 'id')->toArray()" required />
            </div>
            <div class="col-md-4">
                <x-input name="start_time" label="Start Time" type="time" value="08:30" required />
            </div>
            <div class="col-md-4">
                <x-input name="end_time" label="End Time" type="time" value="09:15" required />
            </div>
            <div class="col-md-4">
                <x-input name="room_number" label="Room / Lab No." placeholder="e.g. Room 101" />
            </div>
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Save Timetable Slot</button>
        </div>
    </form>
</x-modal>

@endsection
