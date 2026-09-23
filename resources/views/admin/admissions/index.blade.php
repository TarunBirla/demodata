@extends('layouts.app')

@section('title', 'Online Admissions & Enquiries')

@section('content')

<x-breadcrumb :items="['Online Admissions' => route('admin.admissions.index')]" />

<x-page-header title="Online Admission Applications" subtitle="Review admission enquiries, verify candidate documents, and convert approved applicants to students." />

<div class="row g-4">
    <div class="col-lg-7">
        <x-card title="Admission Applications" headerIcon="bi-person-plus">
            <x-table :headers="['App #', 'Student Name', 'Parent Name', 'Phone', 'Status']">
                @forelse($admissions as $adm)
                    <tr>
                        <td class="fw-semibold text-primary">{{ $adm->application_no }}</td>
                        <td class="fw-bold text-dark">{{ $adm->student_name }}</td>
                        <td>{{ $adm->parent_name }}</td>
                        <td>{{ $adm->parent_phone }}</td>
                        <td><x-badge variant="warning">{{ strtoupper($adm->status) }}</x-badge></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-3">No admission applications submitted yet.</td></tr>
                @endforelse
            </x-table>
        </x-card>
    </div>

    <div class="col-lg-5">
        <x-card title="Public Contact Enquiries" headerIcon="bi-inbox">
            @forelse($enquiries as $enq)
                <div class="p-3 bg-light rounded-3 mb-2 border-start border-4 border-info">
                    <div class="fw-bold text-dark">{{ $enq->name }}</div>
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
