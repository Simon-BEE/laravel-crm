@extends('layouts.app')

@section('title')
    Ajout d'un nouveau statut de projet
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-info">Liste des projets</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.status.projects.index') }}" class="text-info">Liste des statuts de projets</a></li>
    <li class="breadcrumb-item">Ajout d'un nouveau statut de projet</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire de création d'un statut</h1>

<div class="container">
    <form action="{{ route('admin.status.projects.store') }}" method="post">
        @csrf

        @include('includes.input', [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Nom',
            'placeholder' => 'Le nom du statut',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        <div class="text-right">
            <button type="submit" class="btn btn-info">Créer</button>
        </div>

    </form>
</div>

@endsection
