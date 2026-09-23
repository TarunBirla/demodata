@props([
    'title',
    'value',
    'icon' => 'bi-graph-up',
    'bg' => 'bg-primary',
    'subtitle' => null,
    'trend' => null
])

<div class="card border-0 shadow-sm rounded-3 mb-3 overflow-hidden">
    <div class="card-body p-3">
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0 me-3">
                <div class="rounded-circle {{ $bg }} text-white d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 1.3rem;">
                    <i class="bi {{ $icon }}"></i>
                </div>
            </div>
            <div class="flex-grow-1">
                <div class="text-uppercase text-muted fw-semibold" style="font-size: 0.75rem; letter-spacing: 0.5px;">{{ $title }}</div>
                <div class="h4 mb-0 fw-bold text-dark">{{ $value }}</div>
                @if($subtitle)
                    <div class="text-muted small mt-1">{{ $subtitle }}</div>
                @endif
            </div>
            @if($trend)
                <div class="ms-auto text-end">
                    <span class="badge bg-soft-success text-success fw-medium">{{ $trend }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
