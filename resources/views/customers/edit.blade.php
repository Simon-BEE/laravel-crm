@extends('layouts.app')

@section('title')
    Edition du client {{$customer->name}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('customers.index') }}" class="text-info">Liste des clients</a></li>
<li class="breadcrumb-item">Edition du client {{$customer->name}}</li>
@endsection

@section('content')

    <div class="row justify-content-end">
        @if (!$customer->know)
            <div class="col-6 col-md-2">
                <a class="btn btn-dark" href="{{ route('customers.send_password', $customer) }}">
                    <i class="fas fa-key"></i> <span class="ml-3">Envoyer son mot de passe</span>
                </a>
            </div>
        @endif
        <div class="col-6 col-md-2">
            <form action="{{ route('customers.destroy', $customer) }}" method="post" class="" onsubmit="confirmAction(event)">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i>
                    <span class="ml-3">Supprimer</span>
                </button>
            </form>
        </div>
    </div>

    <div class="row justify-content-center">
        <form action="{{ route('customers.update', $customer) }}" method="POST" class="col-md-6" role="form">
            @csrf
            @method('PATCH')

            @include('includes.input', [
                'name' => 'firstname',
                'type' => 'text',
                'label' => 'Prénom',
                'placeholder' => 'Le prénom',
                'property' => $customer,
                'helper' => null,
                'required' => true
            ])

            @include('includes.input', [
                'name' => 'lastname',
                'type' => 'text',
                'label' => 'Nom',
                'placeholder' => 'Le nom',
                'property' => $customer,
                'helper' => null,
                'required' => true
            ])

            @include('includes.input', [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Adresse email',
                'placeholder' => 'L\'adresse email',
                'property' => $customer,
                'helper' => 'Veillez à enregistrer une adresse valide, son mot de passe lui sera envoyé par ce biais.',
                'required' => true
            ])

            @include('includes.textarea', [
                'name' => 'address',
                'label' => 'Adresse complète',
                'placeholder' => 'L\'adresse complète',
                'property' => $customer,
                'helper' => null,
                'required' => false
            ])

            <div class="text-right">
                <button type="submit" class="btn btn-info">Modifier les données</button>
            </div>
        </form>
    </div>

@endsection

@include('includes.delete-modal')
