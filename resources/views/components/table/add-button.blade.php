@props([
    'label' => 'Tambah Data',
    'target' => '#createModal',
])

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="{{ $target }}">
    {{ $label }}
</button>
