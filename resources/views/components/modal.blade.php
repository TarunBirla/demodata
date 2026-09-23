@props([
    'id',
    'title',
    'size' => 'modal-lg'
])

<div class="modal fade" id="{{ $id }}" tabindex="-1" aria-labelledby="{{ $id }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $size }} modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-3">
            <div class="modal-header bg-navy text-white py-3 px-4 border-0">
                <h5 class="modal-title fw-bold" id="{{ $id }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
