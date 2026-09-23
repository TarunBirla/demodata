@extends('layouts.app')

@section('title', 'Class & Teacher Timetables')

@section('content')

<x-breadcrumb :items="['Timetable' => route('admin.timetable.index')]" />

<x-page-header title="Master Timetable Scheduler" subtitle="Weekly class period schedules, teacher allocation, and room collision prevention." />

<x-card title="Weekly Schedule Overview (Monday - Saturday)" headerIcon="bi-calendar-week">
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center mb-0">
            <thead class="bg-navy text-white small">
                <tr>
                    <th>Day / Period</th>
                    <th>Period 1<br><small>08:30 - 09:15</small></th>
                    <th>Period 2<br><small>09:15 - 10:00</small></th>
                    <th>Period 3<br><small>10:15 - 11:00</small></th>
                    <th>Period 4<br><small>11:00 - 11:45</small></th>
                </tr>
            </thead>
            <tbody>
                @foreach(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
                    <tr>
                        <td class="fw-bold bg-light text-dark">{{ $day }}</td>
                        <td>
                            <div class="fw-bold text-primary">Mathematics</div>
                            <div class="small text-muted">Vikram Malhotra (Room 101)</div>
                        </td>
                        <td>
                            <div class="fw-bold text-success">English Literature</div>
                            <div class="small text-muted">Priya Sen (Room 101)</div>
                        </td>
                        <td>
                            <div class="fw-bold text-warning">Physics</div>
                            <div class="small text-muted">Anil Verma (Physics Lab)</div>
                        </td>
                        <td>
                            <div class="fw-bold text-info">Computer Science</div>
                            <div class="small text-muted">Sunita Rao (CS Lab)</div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-card>

@endsection
