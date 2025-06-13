@props([
    'src' => '',
    'label' => 'Current Image',
])

<div class="form-group row mb-4" id="{{ $attributes->get('id') }}">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ $label }}</label>
    <div class="col-sm-12 col-md-7">
        <div style="border: 1px solid #ddd; padding: 10px; border-radius: 8px; max-width: 300px;">
            <img src="{{ $src }}" alt="Preview" class="img-fluid"
                style="max-height: 180px; border-radius: 6px; object-fit: contain; width: 100%;" />
        </div>
    </div>
</div>

<x-modal.modal-form></x-modal.modal-form>
