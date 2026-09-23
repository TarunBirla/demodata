@extends('layouts.app')

@section('title', 'Online Admissions & Enquiries')

@section('content')

<x-breadcrumb :items="['Online Admissions' => route('admin.admissions.index')]" />

<x-page-header title="Online Admission Applications" subtitle="Review admission enquiries, verify candidate documents, and convert approved applicants to students." />

<div class="row g-4">
    <div class="col-lg-7">
        <x-card title="Admission Applications" headerIcon="bi-person-plus">
    <x-table :headers="['App #', 'Student Name', 'Parent Name', 'Phone', 'Status', 'Actions']">
        @forelse($admissions as $adm)
            <tr>
                <td class="fw-semibold text-primary">{{ $adm->application_no }}</td>
                <td class="fw-bold text-dark">{{ $adm->student_name }}</td>
                <td>{{ $adm->parent_name }}</td>
                <td>{{ $adm->parent_phone }}</td>
                <td>
                    <span class="badge {{ $adm->status === 'approved' ? 'bg-success' : ($adm->status === 'rejected' ? 'bg-danger' : 'bg-warning') }}">
                        {{ strtoupper($adm->status) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#editAdmissionModal{{ $adm->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.admissions.destroy', $adm->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete admission application {{ $adm->application_no }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT ADMISSION MODAL -->
                    <x-modal id="editAdmissionModal{{ $adm->id }}" title="Manage Application — {{ $adm->application_no }}">
                        <form action="{{ route('admin.admissions.update', $adm->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <x-input name="student_name" label="Student Full Name" value="{{ $adm->student_name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="parent_name" label="Parent Name" value="{{ $adm->parent_name }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="parent_phone" label="Parent Phone" value="{{ $adm->parent_phone }}" required />
                                </div>
                                <div class="col-md-6">
                                    <x-input name="grade_applying" label="Grade Seeking" value="{{ $adm->grade_applying }}" required />
                                </div>
                                <div class="col-md-12">
                                    <x-select name="status" label="Application Status Choice" :options="['pending' => 'Pending Review', 'approved' => 'Approved (Admitted)', 'rejected' => 'Rejected']" :value="$adm->status" required />
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Application Status</button>
                            </div>
                        </form>
                    </x-modal>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-3">No admission applications submitted yet.</td></tr>
        @endforelse
    </x-table>
</x-card>

<div class="col-lg-5">
    <x-card title="Public Contact Enquiries" headerIcon="bi-inbox">
        @forelse($enquiries as $enq)
            <div class="p-3 bg-light rounded-3 mb-2 border-start border-4 border-info position-relative">
                <div class="d-flex justify-content-between align-items-start mb-1">
                    <div class="fw-bold text-dark">{{ $enq->name }}</div>
                    <form action="{{ route('admin.enquiries.destroy', $enq->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete enquiry from {{ $enq->name }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-link text-danger p-0 ms-2"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
                <div class="small text-muted">{{ $enq->phone }} | {{ $enq->email }}</div>
                <p class="small text-dark mt-1 mb-0">{{ $enq->message }}</p>
            </div>
        @empty
            <x-empty-state title="No Contact Enquiries" description="Submissions from the public website contact form will appear here." />
        @endforelse
    </x-card>
</div>
</div>

@endsection
