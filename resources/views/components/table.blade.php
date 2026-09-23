@props([
    'headers' => []
])

<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table table-hover align-middle mb-0']) }}>
        @if(count($headers) > 0)
            <thead class="table-light text-uppercase small text-muted">
                <tr>
                    @foreach($headers as $header)
                        <th class="py-3 px-3 fw-semibold">{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody class="border-top-0">
            {{ $slot }}
        </tbody>
    </table>
</div>
