@extends('layouts.app')

@section('title')
    Modifier son mot de passe
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Modifier son mot de passe</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire de modification du mot de passe</h1>

<div class="container">
    <form action="" method="post" class="mb-3">
        @csrf
        @method('PATCH')

        @if (auth()->user()->changed)
            @include('includes.form.input', [
                'name' => 'password',
                'type' => 'password',
                'label' => 'Ancien mot de passe',
                'placeholder' => 'Votre ancien mot de passe',
                'property' => null,
                'helper' => null,
                'required' => true
            ])
        @endif

        @include('includes.form.input', [
            'name' => 'new_password',
            'type' => 'password',
            'label' => 'Nouveau mot de passe',
            'placeholder' => 'Votre nouveau mot de passe',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        @include('includes.form.input', [
            'name' => 'new_password_confirmation',
            'type' => 'password',
            'label' => 'Confirmer le nouveau mot de passe',
            'placeholder' => 'Confirmer votre nouveau mot de passe',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        <div class="text-right">
            <button type="submit" class="btn btn-info">Modifier</button>
        </div>

    </form>
</div>

@endsection

