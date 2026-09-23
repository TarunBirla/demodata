@extends('layouts.app')

@section('title', 'Teachers & Faculty')

@section('content')

<x-breadcrumb :items="['Teachers' => route('admin.teachers.index')]" />

<x-page-header title="Teachers & Faculty Directory" subtitle="Manage teaching staff profiles, qualifications, and class section assignments." />

<x-card>
    <x-table :headers="['Employee ID', 'Faculty Name', 'Qualification', 'Designation', 'Phone', 'Status']">
        @forelse($teachers as $t)
            <tr>
                <td class="fw-semibold text-primary">{{ $t->employee_id }}</td>
                <td>
                    <div class="fw-bold text-dark">{{ $t->full_name }}</div>
                    <div class="small text-muted">{{ $t->email }}</div>
                </td>
                <td>{{ $t->qualification }}</td>
                <td>{{ $t->designation }}</td>
                <td>{{ $t->phone }}</td>
                <td><x-badge variant="success">{{ strtoupper($t->status) }}</x-badge></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-3">No teachers found.</td></tr>
        @endforelse
    </x-table>
</x-card>

@endsection
