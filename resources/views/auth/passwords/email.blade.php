@extends('layouts.init')

@section('form')
<div class="container p-4 shadow rounded col-md-6">
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="form-label">{{ __('Adresse email') }}</label>

            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group mb-0">
            <button type="submit" class="btn btn-info">
                {{ __('Changer de mot passe') }}
            </button>
        </div>
        <div>
            <a class="btn btn-link text-info" href="{{ route('login') }}">
                {{ __('Retour') }}
            </a>
        </div>
    </form>
</div>
@endsection
