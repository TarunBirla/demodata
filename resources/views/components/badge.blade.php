@props([
    'variant' => 'primary'
])

<span {{ $attributes->merge(['class' => "badge bg-soft-{$variant} text-{$variant} rounded-pill px-3 py-1 fw-medium"]) }}>
    {{ $slot }}
</span>
