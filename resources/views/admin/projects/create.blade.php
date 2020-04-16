@extends('layouts.app')

@section('title')
    Ajout d'un nouveau projet
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-info">Liste des projets</a></li>
    <li class="breadcrumb-item">Ajout d'un nouveau projet</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire de création d'un projet</h1>

<div class="container">
    <form action="{{ route('admin.projects.store') }}" method="post" class="mb-3">
        @csrf

        @include('includes.form.input', [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Nom',
            'placeholder' => 'Le nom du projet',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        @include('includes.form.select', [
            'name' => 'customer_id',
            'label' => 'Définir le client associé',
            'collection' => $customers,
            'helper' => "Si aucun client ne correspond, veuillez en <strong>créer un nouveau</strong> avant de procéder à la suite.",
            'required' => true,
            'selected' => null,
            'property' => null,
        ])

        @include('includes.form.input', [
            'name' => 'news',
            'type' => 'text',
            'label' => 'Point important',
            'placeholder' => 'Indiquez une information importante',
            'property' => null,
            'helper' => 'Ce champ est facultatif.',
            'required' => false
        ])

        @include('includes.form.select', [
            'name' => 'status_id',
            'label' => 'Choisir un statut',
            'collection' => $status,
            'helper' => 'Par défaut le status <strong>En développement</strong> est affecté.',
            'required' => false,
            'selected' => null,
            'property' => null,
        ])

        @include('includes.form.textarea', [
            'name' => 'body',
            'label' => 'Informations sur le projet',
            'placeholder' => 'Les informations sur le projet',
            'property' => null,
            'helper' => null,
            'required' => true,
            'id' => 'body'
        ])

        <div class="text-right">
            <button type="submit" class="btn btn-info">Créer</button>
        </div>

    </form>
</div>

@endsection

@section('javascript')
    @include('includes.wysiwyg', ['id' => 'body', 'property' => null])
@endsection
