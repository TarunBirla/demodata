@extends('layouts.app')

@section('title', 'Library Management')

@section('content')
<x-page-header title="Library Management" subtitle="Manage school catalog, books, and book issues">
    @if(in_array(auth()->user()->role_name, ['super_admin', 'school_admin', 'librarian']))
    <button type="button" class="btn btn-navy rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#addBookModal">
        <i class="bi bi-plus-lg me-1"></i> Add New Book
    </button>
    @endif
</x-page-header>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <x-stat-card title="Total Books" value="{{ $books->count() }}" icon="bi-book" bgClass="bg-soft-primary" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Available Copies" value="{{ $books->sum('available_quantity') }}" icon="bi-check-circle" bgClass="bg-soft-success" />
    </div>
    <div class="col-md-4">
        <x-stat-card title="Currently Issued" value="{{ $issues->where('status', 'issued')->count() }}" icon="bi-journal-arrow-up" bgClass="bg-soft-warning" />
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-navy"><i class="bi bi-book-half me-2"></i> Book Catalog</h5>
    </div>
    <div class="card-body p-0">
        @if($books->isEmpty())
            <x-empty-state title="No Books Found" message="No library books registered in the system yet." />
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>ISBN</th>
                            <th>Shelf</th>
                            <th>Available / Total</th>
                            <th class="pe-4 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($books as $b)
                        <tr>
                            <td class="ps-4 fw-semibold text-dark">{{ $b->title }}</td>
                            <td>{{ $b->author }}</td>
                            <td><span class="badge bg-soft-info text-info">{{ $b->category }}</span></td>
                            <td><code>{{ $b->isbn ?: 'N/A' }}</code></td>
                            <td>{{ $b->shelf_location ?: 'General' }}</td>
                            <td>
                                <span class="fw-bold text-success">{{ $b->available_quantity }}</span> / {{ $b->quantity }}
                            </td>
                            <td class="pe-4 text-end">
                                @if($b->available_quantity > 0 && in_array(auth()->user()->role_name, ['super_admin', 'school_admin', 'librarian']))
                                <button class="btn btn-sm btn-outline-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#issueModal{{ $b->id }}">
                                    <i class="bi bi-box-arrow-right me-1"></i> Issue
                                </button>
                                @else
                                <span class="badge bg-light text-muted">Unavailable</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Modal Add Book -->
<div class="modal fade" id="addBookModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.library.books.store') }}" method="POST">
            @csrf
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 bg-navy text-white">
                    <h5 class="modal-title fw-bold">Add Book to Library</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Book Title *</label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Author Name *</label>
                        <input type="text" name="author" class="form-control" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Category *</label>
                            <input type="text" name="category" class="form-control" value="General" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Total Copies *</label>
                            <input type="number" name="quantity" class="form-control" value="1" min="1" required>
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">ISBN</label>
                            <input type="text" name="isbn" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Shelf Location</label>
                            <input type="text" name="shelf_location" class="form-control" placeholder="e.g. Rack A3">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-navy rounded-pill px-4">Save Book</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
