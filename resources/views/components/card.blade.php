@props([
    'title' => null,
    'headerIcon' => null,
    'headerClass' => 'bg-navy text-white',
    'bodyClass' => 'p-3',
    'actions' => null
])

<div {{ $attributes->merge(['class' => 'card border-0 shadow-sm rounded-3 mb-4 overflow-hidden']) }}>
    @if($title)
        <div class="card-header {{ $headerClass }} py-2 px-3 d-flex align-items-center justify-content-between border-0">
            <h6 class="mb-0 fw-semibold d-flex align-items-center">
                @if($headerIcon)
                    <i class="bi {{ $headerIcon }} me-2"></i>
                @endif
                {{ $title }}
            </h6>
            @if($actions)
                <div>{{ $actions }}</div>
            @endif
        </div>
    @endif
    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
