@extends('layouts.app')

@section('title')
    Ajout d'un nouveau client
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Liste des clients</a></li>
    <li class="breadcrumb-item">Ajout d'un nouveau client</li>
@endsection

@section('content')

<div class="container">
    <form action="{{ route('customers.store') }}" method="post">
        @csrf

        @include('includes.input', [
            'name' => 'firstname',
            'type' => 'text',
            'label' => 'Prénom',
            'placeholder' => 'Le prénom',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        @include('includes.input', [
            'name' => 'lastname',
            'type' => 'text',
            'label' => 'Nom',
            'placeholder' => 'Le nom',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        @include('includes.input', [
            'name' => 'email',
            'type' => 'email',
            'label' => 'Adresse email',
            'placeholder' => 'L\'adresse email',
            'property' => null,
            'helper' => 'Veillez à enregistrer une adresse valide, son mot de passe lui sera envoyé par ce biais.',
            'required' => true
        ])

        @include('includes.textarea', [
            'name' => 'address',
            'label' => 'Adresse complète',
            'placeholder' => 'L\'adresse complète',
            'property' => null,
            'helper' => null,
            'required' => false
        ])

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="know" name="know" value=1>
            <label class="form-check-label ml-2" for="know">Lui envoyer un mot de passe ?</label>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-info">Créer</button>
        </div>

    </form>
</div>

@endsection
