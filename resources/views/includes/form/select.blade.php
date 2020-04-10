<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select class="custom-select @error('{{ $name }}') is-invalid @enderror" name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}>
        @foreach ($collection as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
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
