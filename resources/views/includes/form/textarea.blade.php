<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $id ?? $name }}" class="form-control @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }}>{{ old($name) ?? $property->$name ?? '' }}</textarea>
    @if ($helper)
        <small id="{{ $name }}Help" class="form-text text-muted">{{ $helper }}</small>
    @endif
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
