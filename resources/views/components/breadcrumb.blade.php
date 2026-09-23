@props([
    'items' => []
])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb small mb-3">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted"><i class="bi bi-house me-1"></i> Dashboard</a></li>
        @foreach($items as $label => $link)
            @if($loop->last)
                <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">{{ $label }}</li>
            @else
                <li class="breadcrumb-item"><a href="{{ $link }}" class="text-decoration-none text-muted">{{ $label }}</a></li>
            @endif
        @endforeach
    </ol>
</nav>
