@props([
    'type' => session('type', 'success') ?? section('type', 'error') ?? null,
    'message' => session('success') ?? session('error') ?? null,
])

@if ($message)
    <script>
        iziToast.{{ $type }}({
            title: '{{ ucfirst($type) }}',
            message: '{{ $message }}',
            position: 'topRight'
        });
    </script>
@endif
