@extends('layouts.app')

@section('title', $roleContext['title'] ?? 'Dashboard')

@section('content')

@php
    $userRole = $roleContext['role'] ?? (auth()->user()->role_name ?? 'school_admin');
    $isAdmin = in_array($userRole, ['super_admin', 'school_admin']);
    $isTeacher = $userRole === 'teacher';
    $isStudent = $userRole === 'student';
    $isParent = $userRole === 'parent';
@endphp

<x-page-header :title="$roleContext['title'] ?? 'Executive Dashboard'" :subtitle="$roleContext['subtitle'] ?? 'Welcome to Junior Gurukul School Management Panel'">
    <x-slot:actions>
        @if($isAdmin)
            <a href="{{ route('admin.students.index') }}" class="btn btn-navy btn-sm"><i class="bi bi-person-plus me-1"></i> Add Student</a>
            <a href="{{ route('admin.fees.index') }}" class="btn btn-success btn-sm"><i class="bi bi-cash-stack me-1"></i> Collect Fee</a>
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-check2-square me-1"></i> Attendance</a>
        @elseif($isTeacher)
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-check2-square me-1"></i> Mark Attendance</a>
            <a href="{{ route('admin.homework.index') }}" class="btn btn-navy btn-sm"><i class="bi bi-file-earmark-plus me-1"></i> Assign Homework</a>
            <a href="{{ route('admin.timetable.index') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-calendar3 me-1"></i> View Timetable</a>
        @elseif($isStudent)
            <a href="{{ route('admin.timetable.index') }}" class="btn btn-navy btn-sm"><i class="bi bi-calendar3 me-1"></i> Class Timetable</a>
            <a href="{{ route('admin.homework.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-journal-text me-1"></i> My Homework</a>
            <a href="{{ route('admin.fees.index') }}" class="btn btn-success btn-sm"><i class="bi bi-receipt me-1"></i> Fee Receipts</a>
        @elseif($isParent)
            <a href="{{ route('admin.attendance.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-check2-square me-1"></i> Children Attendance</a>
            <a href="{{ route('admin.fees.index') }}" class="btn btn-success btn-sm"><i class="bi bi-cash-stack me-1"></i> Pay Fee Dues</a>
            <a href="{{ route('admin.notices.index') }}" class="btn btn-navy btn-sm"><i class="bi bi-megaphone me-1"></i> School Notices</a>
        @endif
    </x-slot:actions>
</x-page-header>

<!-- TOP 3 STATUS WIDGETS -->
<div class="row g-3 mb-4">
    <!-- School Timing Widget -->
    <div class="col-md-4">
        <x-card title="School Timing" headerIcon="bi-clock-history">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="badge bg-success px-3 py-1">OPEN</span>
                <span class="text-muted small">Academic Hours</span>
            </div>
            <div class="d-flex justify-content-between p-2 bg-light rounded mb-2 small">
                <span class="text-muted">Check-in:</span>
                <span class="fw-bold text-success">8:00 AM</span>
            </div>
            <div class="d-flex justify-content-between p-2 bg-light rounded small">
                <span class="text-muted">Check-out:</span>
                <span class="fw-bold text-danger">2:00 PM</span>
            </div>
        </x-card>
    </div>

    <!-- Today's Birthdays / Role Profile Summary Widget -->
    <div class="col-md-4">
        @if($isStudent)
            <x-card title="My Profile Details" headerIcon="bi-person-badge">
                <div class="d-flex align-items-center gap-3 py-1">
                    <div class="rounded-circle text-navy fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(145deg, #E4C185, #C5A059); color: #0B192C;">
                        {{ strtoupper(substr($roleContext['student']->first_name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-0">{{ $roleContext['student']->full_name ?? auth()->user()->name }}</h6>
                        <span class="small text-muted">Roll No: #{{ $roleContext['student']->roll_number ?? '1' }} | Admission: {{ $roleContext['student']->admission_number ?? 'GVIS-2026-0101' }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between p-2 bg-light rounded mt-2 small">
                    <span class="text-muted">Attendance Pct:</span>
                    <span class="fw-bold text-success">{{ $roleContext['myAttendancePct'] ?? '95.0' }}%</span>
                </div>
            </x-card>
        @elseif($isParent)
            <x-card title="Children Overview" headerIcon="bi-people">
                <div class="py-1">
                    <div class="h3 fw-bold text-navy mb-0">{{ $roleContext['childrenCount'] ?? 1 }}</div>
                    <div class="text-muted small">Linked Student(s)</div>
                </div>
                <div class="d-flex flex-column gap-1 mt-2">
                    @foreach($roleContext['children'] ?? [] as $child)
                        <div class="d-flex justify-content-between p-2 bg-light rounded small">
                            <span class="fw-semibold text-dark">{{ $child->full_name }}</span>
                            <span class="badge bg-soft-primary text-primary">{{ $child->schoolClass->name ?? 'Grade 6' }}</span>
                        </div>
                    @endforeach
                </div>
            </x-card>
        @else
            <x-card title="Today's Birthdays" headerIcon="bi-cake2">
                <div class="d-flex justify-content-around text-center py-2">
                    <div>
                        <div class="h3 fw-bold text-primary mb-0">2</div>
                        <div class="text-muted small">Students</div>
                    </div>
                    <div class="border-end"></div>
                    <div>
                        <div class="h3 fw-bold text-warning mb-0">1</div>
                        <div class="text-muted small">Employees</div>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-2 mt-2">
                    <span class="badge bg-soft-primary border text-dark">Aarav Gupta</span>
                    <span class="badge bg-soft-success border text-dark">Sunita Rao</span>
                </div>
            </x-card>
        @endif
    </div>

    <!-- Finance / Dues Summary Widget -->
    <div class="col-md-4">
        @if($isStudent || $isParent)
            <x-card title="My Fee Summary" headerIcon="bi-cash-coin">
                <div class="d-flex justify-content-between py-1 small">
                    <span class="text-muted">Academic Term Fee:</span>
                    <span class="fw-bold text-dark">₹ 15,000.00</span>
                </div>
                <div class="d-flex justify-content-between py-1 small">
                    <span class="text-muted">Paid Amount:</span>
                    <span class="fw-bold text-success">₹ 15,000.00</span>
                </div>
                <div class="d-flex justify-content-between py-1 small border-top pt-2">
                    <span class="text-muted">Pending Balance:</span>
                    <span class="fw-bold text-success">₹ 0.00 (PAID)</span>
                </div>
            </x-card>
        @else
            <x-card title="Finance Summary" headerIcon="bi-bank">
                <div class="d-flex justify-content-between py-1 small">
                    <span class="text-muted">Academic Balance:</span>
                    <span class="fw-bold text-success">₹ 9,30,000.00</span>
                </div>
                <div class="d-flex justify-content-between py-1 small">
                    <span class="text-muted">Today's Collections:</span>
                    <span class="fw-bold text-primary">₹ 45,000.00</span>
                </div>
                <div class="d-flex justify-content-between py-1 small border-top pt-2">
                    <span class="text-muted">Pending Dues:</span>
                    <span class="fw-bold text-danger">₹ {{ number_format($totalFeePending, 2) }}</span>
                </div>
            </x-card>
        @endif
    </div>
</div>

<!-- CASHFLOW ANALYSIS & FEE REPORT ROW (Admin only or summary view) -->
@if($isAdmin)
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <x-card title="Cashflow Analysis (Incomes vs Expenses)" headerIcon="bi-graph-up-arrow">
            <div style="height: 250px;">
                <canvas id="cashflowChart"></canvas>
            </div>
        </x-card>
    </div>
    <div class="col-lg-4">
        <x-card title="Fee Collection Status" headerIcon="bi-pie-chart">
            <div class="p-2 mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span class="small text-muted">Expected</span>
                    <span class="small fw-bold text-primary">₹ {{ number_format($totalFeeExpected, 2) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                </div>
            </div>
            <div class="p-2 mb-3">
                <div class="d-flex justify-content-between mb-1">
                    <span class="small text-muted">Collected</span>
                    <span class="small fw-bold text-success">₹ {{ number_format($totalFeeCollected, 2) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-success" style="width: 75%"></div>
                </div>
            </div>
            <div class="p-2">
                <div class="d-flex justify-content-between mb-1">
                    <span class="small text-muted">Pending</span>
                    <span class="small fw-bold text-danger">₹ {{ number_format($totalFeePending, 2) }}</span>
                </div>
                <div class="progress" style="height: 8px;">
                    <div class="progress-bar bg-danger" style="width: 25%"></div>
                </div>
            </div>
        </x-card>
    </div>
</div>
@endif

<!-- STUDENT STATISTICS & TODAY'S ATTENDANCE OVERVIEW ROW -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <x-card title="Student Statistics & Today's Attendance Overview" headerIcon="bi-people-fill">
            <div class="row text-center g-3 mb-3">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <i class="bi bi-mortarboard fs-3 text-primary mb-1"></i>
                        <div class="h3 fw-bold mb-0 text-dark">{{ $totalStudents }}</div>
                        <div class="text-muted small">Total Registered</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <i class="bi bi-person-check fs-3 text-success mb-1"></i>
                        <div class="h3 fw-bold mb-0 text-dark">{{ $totalStudents }}</div>
                        <div class="text-muted small">Currently Enrolled</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-3">
                        <i class="bi bi-house-door fs-3 text-warning mb-1"></i>
                        <div class="h3 fw-bold mb-0 text-dark">{{ ceil($totalStudents * 0.8) }}</div>
                        <div class="text-muted small">Families Linked</div>
                    </div>
                </div>
            </div>

            <!-- Attendance breakdown pills -->
            <div class="row text-center g-2 pt-2 border-top">
                <div class="col-3">
                    <div class="py-2 bg-soft-success rounded">
                        <span class="fw-bold fs-5 text-success">{{ $presentToday > 0 ? $presentToday : 18 }}</span>
                        <div class="small text-muted">PRESENT</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="py-2 bg-soft-danger rounded">
                        <span class="fw-bold fs-5 text-danger">{{ $absentToday > 0 ? $absentToday : 2 }}</span>
                        <div class="small text-muted">ABSENT</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="py-2 bg-soft-warning rounded">
                        <span class="fw-bold fs-5 text-warning">{{ $leaveToday > 0 ? $leaveToday : 1 }}</span>
                        <div class="small text-muted">LEAVE</div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="py-2 bg-soft-info rounded">
                        <span class="fw-bold fs-5 text-info">{{ $lateToday > 0 ? $lateToday : 1 }}</span>
                        <div class="small text-muted">LATE</div>
                    </div>
                </div>
            </div>
        </x-card>
    </div>
</div>

<!-- RECENT ACTIVITY & UPCOMING EVENTS ROW -->
<div class="row g-3">
    <div class="col-lg-7">
        <x-card title="Recent Activity & Transactions" headerIcon="bi-activity">
            <x-table :headers="['Receipt #', 'Student', 'Amount', 'Date', 'Mode']">
                @forelse($recentPayments as $payment)
                    <tr>
                        <td class="fw-semibold text-primary">{{ $payment->receipt_number }}</td>
                        <td>{{ $payment->student->full_name ?? 'Student' }}</td>
                        <td class="fw-bold text-success">₹ {{ number_format($payment->amount, 2) }}</td>
                        <td class="small text-muted">{{ $payment->payment_date ? $payment->payment_date->format('M d, Y') : 'Sep 15, 2026' }}</td>
                        <td><x-badge variant="info">{{ strtoupper($payment->payment_mode ?? 'CASH') }}</x-badge></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">No payments recorded yet.</td></tr>
                @endforelse
            </x-table>
        </x-card>
    </div>

    <div class="col-lg-5">
        <x-card title="Upcoming Holidays & Events" headerIcon="bi-calendar-event">
            <div class="d-flex flex-column gap-3">
                @forelse($upcomingEvents as $ev)
                    <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-3">
                        <div class="bg-navy text-white rounded text-center px-3 py-2">
                            <div class="fw-bold fs-5 leading-none">{{ $ev->event_date ? $ev->event_date->format('d') : '10' }}</div>
                            <div class="small text-uppercase" style="font-size: 0.65rem;">{{ $ev->event_date ? $ev->event_date->format('M') : 'OCT' }}</div>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">{{ $ev->title }}</h6>
                            <span class="small text-muted"><i class="bi bi-geo-alt"></i> {{ $ev->location ?? 'Main Campus' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-3">
                        <div class="bg-navy text-white rounded text-center px-3 py-2">
                            <div class="fw-bold fs-5 leading-none">10</div>
                            <div class="small text-uppercase" style="font-size: 0.65rem;">OCT</div>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Annual Sports Meet 2026</h6>
                            <span class="small text-muted"><i class="bi bi-geo-alt"></i> Main Sports Ground</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-3 p-2 bg-light rounded-3">
                        <div class="bg-navy text-white rounded text-center px-3 py-2">
                            <div class="fw-bold fs-5 leading-none">28</div>
                            <div class="small text-uppercase" style="font-size: 0.65rem;">SEP</div>
                        </div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0">Term 1 Parent Teacher Meeting</h6>
                            <span class="small text-muted"><i class="bi bi-building"></i> Main Auditorium</span>
                        </div>
                    </div>
                @endforelse
            </div>
        </x-card>
    </div>
</div>

@endsection

@push('scripts')
@if($isAdmin)
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const chartEl = document.getElementById('cashflowChart');
        if (chartEl) {
            const ctx = chartEl.getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Sep 2025', 'Oct 2025', 'Nov 2025', 'Dec 2025', 'Jan 2026', 'Feb 2026'],
                    datasets: [
                        {
                            label: 'Incomes (₹)',
                            data: [220000, 200000, 165000, 210000, 205000, 185000],
                            borderColor: '#047857',
                            backgroundColor: 'rgba(4, 120, 87, 0.1)',
                            fill: true,
                            tension: 0.4
                        },
                        {
                            label: 'Expenses (₹)',
                            data: [100000, 90000, 85000, 92000, 80000, 95000],
                            borderColor: '#B91C1C',
                            backgroundColor: 'rgba(185, 28, 28, 0.1)',
                            fill: true,
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top' }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        }
    });
</script>
@endif
@endpush
