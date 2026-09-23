@extends('layouts.app')

@section('title', 'Homework Management')

@section('content')

<x-breadcrumb :items="['Homework' => route('admin.homework.index')]" />

<x-page-header title="Homework & Assignments" subtitle="Track subject homework, file attachments, and submission due dates." />

<x-card>
    <x-table :headers="['Title', 'Class & Section', 'Subject', 'Assigned Date', 'Due Date', 'Assigned Teacher']">
        @forelse($homeworkList as $hw)
            <tr>
                <td class="fw-bold text-dark">{{ $hw->title }}</td>
                <td>{{ $hw->schoolClass->name ?? 'Grade 8' }} - {{ $hw->section->name ?? 'A' }}</td>
                <td><x-badge variant="info">{{ $hw->subject->name ?? 'Subject' }}</x-badge></td>
                <td class="small text-muted">{{ $hw->assigned_date->format('M d, Y') }}</td>
                <td class="small text-danger fw-bold">{{ $hw->due_date->format('M d, Y') }}</td>
                <td>{{ $hw->teacher->name ?? 'Teacher' }}</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-3">No homework assigned yet.</td></tr>
        @endforelse
    </x-table>
</x-card>

@endsection
