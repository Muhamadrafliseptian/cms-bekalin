@props([
    'message' => session('success') ?? session('error'),
    'type' => session('success') ? 'success' : (session('error') ? 'error' : 'info'),
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
