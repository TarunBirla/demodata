@props([
    'title',
    'subtitle' => null,
    'actions' => null
])

<div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-2">
    <div>
        <h4 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
            {{ $title }}
        </h4>
        @if($subtitle)
            <p class="text-muted small mb-0">{{ $subtitle }}</p>
        @endif
    </div>
    @if($actions)
        <div class="d-flex align-items-center gap-2">
            {{ $actions }}
        </div>
    @endif
</div>
