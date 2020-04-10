
<div class="form-group">
    @if ($label)
        <label for="{{ $array_name }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" class="form-control @error($array_name) is-invalid @enderror" id="{{ $array_name }}" name ="{{ $name }}" value="{{ old($array_name) ?? $property->$simple_name ?? '' }}" placeholder="{{ $placeholder }}" {{ $required ? 'required' : '' }} />
    @if ($helper)
        <small id="{{ $array_name }}Help" class="form-text text-muted">{{ $helper }}</small>
    @endif
    @error($array_name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
