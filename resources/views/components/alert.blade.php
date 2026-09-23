@props([
    'type' => 'info',
    'dismissible' => true
])

<div {{ $attributes->merge(['class' => "alert alert-{$type} " . ($dismissible ? 'alert-dismissible fade show' : '') . " rounded-3 shadow-sm border-0"]) }} role="alert">
    <div class="d-flex align-items-center">
        @if($type === 'success') <i class="bi bi-check-circle-fill me-2 fs-5"></i> @endif
        @if($type === 'danger') <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i> @endif
        @if($type === 'warning') <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i> @endif
        @if($type === 'info') <i class="bi bi-info-circle-fill me-2 fs-5"></i> @endif
        <div>{{ $slot }}</div>
    </div>
    @if($dismissible)
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
