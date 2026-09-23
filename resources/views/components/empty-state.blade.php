@props([
    'title' => 'No Data Found',
    'description' => 'There are no records matching your current filter criteria.',
    'icon' => 'bi-inbox',
    'actionText' => null,
    'actionUrl' => '#'
])

<div class="text-center py-5">
    <div class="rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center mb-3" style="width: 72px; height: 72px; font-size: 2.2rem;">
        <i class="bi {{ $icon }}"></i>
    </div>
    <h5 class="fw-bold text-dark mb-1">{{ $title }}</h5>
    <p class="text-muted max-w-sm mx-auto mb-3" style="max-width: 420px;">{{ $description }}</p>
    @if($actionText)
        <a href="{{ $actionUrl }}" class="btn btn-navy text-white fw-medium px-4">
            <i class="bi bi-plus-lg me-1"></i> {{ $actionText }}
        </a>
    @endif
</div>
