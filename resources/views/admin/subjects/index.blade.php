@extends('layouts.app')

@section('title', 'Subjects Directory')

@section('content')

<x-breadcrumb :items="['Subjects' => route('admin.subjects.index')]" />

<x-page-header title="Subject Configuration" subtitle="Manage academic subject catalog, codes, theory/practical classification." />

<x-card>
    <x-table :headers="['Subject Code', 'Subject Name', 'Type', 'Status']">
        @forelse($subjects as $sub)
            <tr>
                <td class="fw-semibold text-primary">{{ $sub->code }}</td>
                <td class="fw-bold text-dark">{{ $sub->name }}</td>
                <td><x-badge variant="info">{{ strtoupper($sub->type) }}</x-badge></td>
                <td><x-badge variant="success">{{ strtoupper($sub->status) }}</x-badge></td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted py-3">No subjects created yet.</td></tr>
        @endforelse
    </x-table>
</x-card>

@endsection
