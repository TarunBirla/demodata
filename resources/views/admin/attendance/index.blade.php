@extends('layouts.app')

@section('title', 'Mark Student Attendance')

@section('content')

<x-breadcrumb :items="['Attendance' => route('admin.attendance.index')]" />

<x-page-header title="Daily Attendance Marker" subtitle="Mark and review student presence, absences, leave applications, and late arrivals." />

<x-card>
    <form action="{{ route('admin.attendance.index') }}" method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <x-select name="class_id" label="Class" :options="$classes->pluck('name', 'id')->toArray()" :selected="$classId" />
        </div>
        <div class="col-md-3">
            <x-select name="section_id" label="Section" :options="$sections->pluck('name', 'id')->toArray()" :selected="$sectionId" />
        </div>
        <div class="col-md-3">
            <x-input name="date" label="Attendance Date" type="date" value="{{ $date }}" />
        </div>
        <div class="col-md-3 mb-3">
            <button type="submit" class="btn btn-navy w-100 py-2"><i class="bi bi-filter"></i> Load Register</button>
        </div>
    </form>

    @if($students->count() > 0)
        <form action="{{ route('admin.attendance.store') }}" method="POST">
            @csrf
            <input type="hidden" name="class_id" value="{{ $classId }}">
            <input type="hidden" name="section_id" value="{{ $sectionId }}">
            <input type="hidden" name="date" value="{{ $date }}">

            <x-table :headers="['Admission #', 'Student Name', 'Status Selection']">
                @foreach($students as $st)
                    @php $currStatus = $existingAttendance[$st->id] ?? 'present'; @endphp
                    <tr>
                        <td class="fw-semibold text-primary">{{ $st->admission_number }}</td>
                        <td class="fw-bold text-dark">{{ $st->full_name }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="attendance[{{ $st->id }}]" id="pres_{{ $st->id }}" value="present" {{ $currStatus === 'present' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success btn-sm" for="pres_{{ $st->id }}">Present</label>

                                <input type="radio" class="btn-check" name="attendance[{{ $st->id }}]" id="abs_{{ $st->id }}" value="absent" {{ $currStatus === 'absent' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger btn-sm" for="abs_{{ $st->id }}">Absent</label>

                                <input type="radio" class="btn-check" name="attendance[{{ $st->id }}]" id="lat_{{ $st->id }}" value="late" {{ $currStatus === 'late' ? 'checked' : '' }}>
                                <label class="btn btn-outline-warning btn-sm" for="lat_{{ $st->id }}">Late</label>

                                <input type="radio" class="btn-check" name="attendance[{{ $st->id }}]" id="lea_{{ $st->id }}" value="leave" {{ $currStatus === 'leave' ? 'checked' : '' }}>
                                <label class="btn btn-outline-info btn-sm" for="lea_{{ $st->id }}">Leave</label>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </x-table>

            <div class="text-end mt-4">
                <x-button type="submit" variant="navy" icon="bi-save">Submit & Lock Attendance Register</x-button>
            </div>
        </form>
    @else
        <x-empty-state title="Select Class & Section" description="Please select a class, section, and date to view or mark attendance." />
    @endif
</x-card>

@endsection
