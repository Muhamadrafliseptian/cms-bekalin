@props([
    'url' => '#',
    'label' => 'Delete',
])

<form method="POST" action="{{ $url }}" class="d-inline delete-form">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger btn-delete-alert">
        {{ $label }}
    </button>
</form>
