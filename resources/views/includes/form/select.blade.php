<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="custom-select @error('{{ $name }}') is-invalid @enderror" name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}>
        @foreach ($collection as $item)
            @if ($selected && $item->id == $property->id)
                <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
            @else
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endif
        @endforeach
    </select>
    @if ($helper)
        <small id="{{ $name }}Help" class="form-text text-muted">{!! $helper !!}</small>
    @endif
    @error($name)
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
