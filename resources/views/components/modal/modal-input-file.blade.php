@props(['name', 'label', 'value' => old($name)])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="file" class="form-control" name="{{ $name }}" />
</div>
