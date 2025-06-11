@props([
    'name',
    'label',
    'value' => old($name),
])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" class="form-control summernote">{{ $value }}</textarea>
</div>
