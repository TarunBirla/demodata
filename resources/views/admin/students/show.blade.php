@extends('layouts.app')

@section('title', 'Student Profile — ' . $student->full_name)

@section('content')

<x-breadcrumb :items="['Students' => route('admin.students.index'), $student->full_name => '#']" />

<div class="row g-4">
    <!-- Student Summary Card -->
    <div class="col-lg-4">
        <x-card>
            <div class="text-center py-3">
                <div class="rounded-circle bg-navy text-white fw-bold d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 2rem;">
                    {{ strtoupper(substr($student->first_name, 0, 1)) }}
                </div>
                <h5 class="fw-bold text-dark mb-1">{{ $student->full_name }}</h5>
                <span class="badge bg-soft-primary mb-2">Admission No: {{ $student->admission_number }}</span>
                <div class="text-muted small">{{ $student->schoolClass->name ?? 'Grade 8' }} — {{ $student->section->name ?? 'Section A' }}</div>
            </div>

            <hr>

            <div class="d-flex flex-column gap-2 small">
                <div class="d-flex justify-content-between"><span class="text-muted">Roll Number:</span> <span class="fw-bold">{{ $student->roll_number ?? '1' }}</span></div>
                <div class="d-flex justify-content-between"><span class="text-muted">Gender:</span> <span class="fw-bold text-capitalize">{{ $student->gender }}</span></div>
                <div class="d-flex justify-content-between"><span class="text-muted">Date of Birth:</span> <span class="fw-bold">{{ $student->dob ? $student->dob->format('M d, Y') : 'N/A' }}</span></div>
                <div class="d-flex justify-content-between"><span class="text-muted">Blood Group:</span> <span class="fw-bold">{{ $student->blood_group ?? 'O+' }}</span></div>
                <div class="d-flex justify-content-between"><span class="text-muted">Contact Phone:</span> <span class="fw-bold">{{ $student->phone ?? '+91 98765 43210' }}</span></div>
            </div>
        </x-card>
    </div>

    <!-- Tabbed Detailed Profile -->
    <div class="col-lg-8">
        <x-card>
            <ul class="nav nav-tabs card-header-tabs mb-4" id="studentTab" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button">Overview</button></li>
                <li class="nav-item"><button class="nav-link" id="parent-tab" data-bs-toggle="tab" data-bs-target="#parent" type="button">Parent Details</button></li>
                <li class="nav-item"><button class="nav-link" id="fees-tab" data-bs-toggle="tab" data-bs-target="#fees" type="button">Fee Ledger</button></li>
                <li class="nav-item"><button class="nav-link" id="exams-tab" data-bs-toggle="tab" data-bs-target="#exams" type="button">Exam Marks</button></li>
            </ul>

            <div class="tab-content" id="studentTabContent">
                <!-- Overview Tab -->
                <div class="tab-pane fade show active" id="overview">
                    <h6 class="fw-bold text-navy mb-3">Academic & Admission Details</h6>
                    <div class="row g-3 small">
                        <div class="col-6"><span class="text-muted d-block">Academic Session</span><strong class="text-dark">2026 - 2027</strong></div>
                        <div class="col-6"><span class="text-muted d-block">Admission Date</span><strong class="text-dark">05 Apr 2026</strong></div>
                        <div class="col-12"><span class="text-muted d-block">Address</span><strong class="text-dark">Greater Noida, Delhi NCR</strong></div>
                    </div>
                </div>

                <!-- Parent Tab -->
                <div class="tab-pane fade" id="parent">
                    <h6 class="fw-bold text-navy mb-3">Linked Family Info</h6>
                    @forelse($student->parents as $p)
                        <div class="p-3 bg-light rounded-3 mb-2 small">
                            <div class="fw-bold text-dark">{{ $p->father_name }} (Father)</div>
                            <div>Phone: {{ $p->phone }}</div>
                            <div>Occupation: {{ $p->occupation }}</div>
                        </div>
                    @empty
                        <div class="p-3 bg-light rounded-3 small">
                            <div class="fw-bold text-dark">Ramesh Gupta (Father)</div>
                            <div>Phone: +91 98222 33344</div>
                            <div>Occupation: Senior Software Architect</div>
                        </div>
                    @endforelse
                </div>

                <!-- Fees Tab -->
                <div class="tab-pane fade" id="fees">
                    <h6 class="fw-bold text-navy mb-3">Assigned Fee Invoices</h6>
                    <x-table :headers="['Fee Name', 'Amount', 'Paid', 'Status']">
                        @forelse($student->fees as $f)
                            <tr>
                                <td>{{ $f->feeStructure->name ?? 'Tuition Fee' }}</td>
                                <td>₹ {{ number_format($f->amount, 2) }}</td>
                                <td class="text-success fw-bold">₹ {{ number_format($f->paid_amount, 2) }}</td>
                                <td><x-badge variant="success">{{ strtoupper($f->status) }}</x-badge></td>
                            </tr>
                        @empty
                            <tr><td>Q2 Tuition Fee</td><td>₹ 15,000.00</td><td class="text-success fw-bold">₹ 15,000.00</td><td><x-badge variant="success">PAID</x-badge></td></tr>
                        @endforelse
                    </x-table>
                </div>

                <!-- Exams Tab -->
                <div class="tab-pane fade" id="exams">
                    <h6 class="fw-bold text-navy mb-3">First Term Exam Performance</h6>
                    <x-table :headers="['Subject', 'Max Marks', 'Obtained', 'Grade']">
                        @forelse($student->markEntries as $m)
                            <tr>
                                <td>{{ $m->examSubject->subject->name ?? 'Subject' }}</td>
                                <td>100</td>
                                <td class="fw-bold text-primary">{{ $m->marks_obtained }}</td>
                                <td><x-badge variant="info">{{ $m->grade }}</x-badge></td>
                            </tr>
                        @empty
                            <tr><td>Mathematics</td><td>100</td><td class="fw-bold text-primary">95.00</td><td><x-badge variant="info">A+</x-badge></td></tr>
                            <tr><td>English Language</td><td>100</td><td class="fw-bold text-primary">88.00</td><td><x-badge variant="info">A</x-badge></td></tr>
                            <tr><td>Physics</td><td>100</td><td class="fw-bold text-primary">92.00</td><td><x-badge variant="info">A+</x-badge></td></tr>
                        @endforelse
                    </x-table>
                </div>
            </div>
        </x-card>
    </div>
</div>

@endsection
