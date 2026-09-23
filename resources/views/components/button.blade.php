@props([
    'variant' => 'primary',
    'size' => '',
    'icon' => null,
    'type' => 'button'
])

@php
$sizeClass = $size ? "btn-{$size}" : '';
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => "btn btn-{$variant} {$sizeClass} fw-medium shadow-sm d-inline-flex align-items-center gap-1 rounded-2"]) }}>
    @if($icon)
        <i class="bi {{ $icon }}"></i>
    @endif
    <span>{{ $slot }}</span>
</button>
