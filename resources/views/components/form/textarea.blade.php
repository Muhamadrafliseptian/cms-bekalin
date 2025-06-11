<div class="form-group row mb-2">
    <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">{{ $label }}</label>
    <div class="col-sm-12 col-md-7">
        <textarea class="summernote" name="{{ $name }}">{{ $slot }}</textarea>
    </div>
</div>
