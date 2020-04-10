
<div class="form-group">
    @if ($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" class="form-control @error($name) is-invalid @enderror" id="{{ $name }}" name ="{{ $name }}" value="{{ old($name) ?? $property->$name ?? '' }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} />
    @if ($helper)
        <small id="{{ $name }}Help" class="form-text text-muted">{{ $helper }}</small>
    @endif
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
