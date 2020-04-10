@extends('layouts.app')

@section('title')
    Ajout d'un nouveau client
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}" class="text-info">Liste des clients</a></li>
    <li class="breadcrumb-item">Ajout d'un nouveau client</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire d'ajout d'un client</h1>

<div class="container">
    <form action="{{ route('admin.customers.store') }}" method="post" class="mb-3">
        @csrf

        @include('includes.form.input-array', [
            'name' => 'user[firstname]',
            'simple_name' => 'firstname',
            'array_name' => 'user.firstname',
            'type' => 'text',
            'label' => 'Prénom',
            'placeholder' => 'Le prénom',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        @include('includes.form.input-array', [
            'name' => 'user[lastname]',
            'simple_name' => 'lastname',
            'array_name' => 'user.lastname',
            'type' => 'text',
            'label' => 'Nom',
            'placeholder' => 'Le nom',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        @include('includes.form.input-array', [
            'name' => 'user[email]',
            'simple_name' => 'email',
            'array_name' => 'user.email',
            'type' => 'email',
            'label' => 'Adresse email',
            'placeholder' => 'L\'adresse email',
            'property' => null,
            'helper' => 'Veillez à enregistrer une adresse valide, son mot de passe lui sera envoyé par ce biais.',
            'required' => true
        ])

        <h3 class="h3">Adresse du client</h3>

        @include('includes.form.input-array', [
            'name' => 'address[address_1]',
            'simple_name' => 'address_1',
            'array_name' => 'address.address_1',
            'type' => 'text',
            'label' => 'Adresse',
            'placeholder' => 'Adresse du client',
            'property' => 'null',
            'helper' => null,
            'required' => true
        ])
        @include('includes.form.input-array', [
            'name' => 'address[address_2]',
            'simple_name' => 'address_2',
            'array_name' => 'address.address_2',
            'type' => 'text',
            'label' => 'Complément d\'adresse',
            'placeholder' => 'Informations complémentaires sur l\'adresse du client',
            'property' => 'null',
            'helper' => 'Ce champs est facultatif',
            'required' => null
        ])
        <div class="row">
            <div class="col-md-4">
                @include('includes.form.input-array', [
                    'name' => 'address[zipcode]',
                    'simple_name' => 'zipcode',
                    'array_name' => 'address.zipcode',
                    'type' => 'text',
                    'label' => 'Code postal',
                    'placeholder' => 'Code postal du client',
                    'property' => 'null',
                    'helper' => null,
                    'required' => true
                ])
            </div>
            <div class="col-md-4">
                @include('includes.form.input-array', [
                    'name' => 'address[city]',
                    'simple_name' => 'city',
                    'array_name' => 'address.city',
                    'type' => 'text',
                    'label' => 'Ville',
                    'placeholder' => 'Ville du client',
                    'property' => 'null',
                    'helper' => null,
                    'required' => true
                ])
            </div>
            <div class="col-md-4">
                @include('includes.form.input-array', [
                    'name' => 'address[country]',
                    'simple_name' => 'country',
                    'array_name' => 'address.country',
                    'type' => 'text',
                    'label' => 'Pays',
                    'placeholder' => 'Pays du client',
                    'property' => 'null',
                    'helper' => null,
                    'required' => true
                ])
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('includes.form.input-array', [
                    'name' => 'address[phone_1]',
                    'simple_name' => 'phone_1',
                    'array_name' => 'address.phone_1',
                    'type' => 'text',
                    'label' => 'Numéro de téléphone portable',
                    'placeholder' => 'Numéro de téléphone portable du client',
                    'property' => 'null',
                    'helper' => null,
                    'required' => true
                ])
            </div>
            <div class="col-md-6">
                @include('includes.form.input-array', [
                    'name' => 'address[phone_2]',
                    'simple_name' => 'phone_2',
                    'array_name' => 'address.phone_2',
                    'type' => 'text',
                    'label' => 'Numéro de téléphone fixe',
                    'placeholder' => 'Numéro de téléphone fixe du client',
                    'property' => 'null',
                    'helper' => 'Ce champs est facultatif',
                    'required' => null
                ])
            </div>
        </div>

        <hr>

        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="knew" name="user[knew]" value=1>
            <label class="form-check-label ml-2" for="knew">Lui envoyer un mot de passe ?</label>
        </div>

        <hr>

        <div class="text-right">
            <button type="submit" class="btn btn-info">Créer</button>
        </div>

    </form>
</div>

@endsection
