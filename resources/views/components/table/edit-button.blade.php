@props([
    'id' => '',
    'action' => '#',
    'label' => 'Edit',
    'data' => [],
    'target' => ''
])

@php
    $dataAttributes = collect($data)->map(function ($value, $key) {
        return "data-$key=\"" . e($value) . "\"";
    })->implode(' ');
@endphp

<button type="button"
    data-id="{{ $id }}"
    data-action="{{ $action }}"
    {!! $dataAttributes !!}
    data-toggle="modal"
    data-target="{{ $target }}"
    {{ $attributes->merge(['class' => 'btn btn-sm btn-warning btn-edit']) }}>
    {{ $label }}
</button>
