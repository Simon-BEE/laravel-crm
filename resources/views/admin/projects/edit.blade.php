@extends('layouts.app')

@section('title')
    Edition du projet {{$project->name}}
@endsection

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-info">Liste des projets</a></li>
<li class="breadcrumb-item">Edition du projet {{$project->name}}</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire d'édition d'un projet</h1>

    <div class="row justify-content-end">
        <div class="col-6 col-md-2">
            <form action="{{ route('admin.projects.destroy', $project) }}" method="post" class="mb-3" onsubmit="confirmAction(event)">
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
        <form action="{{ route('admin.projects.update', $project) }}" method="POST" class="col-md-6 mb-3" role="form">
            @csrf
            @method('PATCH')

            @include('includes.form.input', [
                'name' => 'name',
                'type' => 'text',
                'label' => 'Nom',
                'placeholder' => 'Le nom du projet',
                'property' => $project,
                'helper' => null,
                'required' => true
            ])

            @include('includes.form.select', [
                'name' => 'customer_id',
                'label' => 'Définir le client associé',
                'collection' => $customers,
                'helper' => "Si aucun client ne correspond, veuillez en <strong>créer un nouveau</strong> avant de procéder à la suite.",
                'required' => true,
                'selected' => true,
                'property' => $project->customer,
            ])

            @include('includes.form.input', [
                'name' => 'news',
                'type' => 'text',
                'label' => 'Point important',
                'placeholder' => 'Indiquez une information importante',
                'property' => $project,
                'helper' => 'Ce champ est facultatif.',
                'required' => false
            ])

            @include('includes.form.select', [
                'name' => 'status_id',
                'label' => 'Choisir un statut',
                'collection' => $status,
                'helper' => 'Par défaut le status <strong>En développement</strong> est affecté.',
                'required' => false,
                'selected' => true,
                'property' => $project->status,
            ])

            @include('includes.form.textarea', [
                'name' => 'body',
                'label' => 'Informations sur le projet',
                'placeholder' => 'Les informations sur le projet',
                'property' => $project,
                'helper' => null,
                'required' => true,
                'id' => 'body'
            ])

            <div class="text-right">
                <button type="submit" class="btn btn-info">Modifier les données</button>
            </div>
        </form>
    </div>

@endsection

@include('includes.modal.delete-modal')
@section('javascript')
    @include('includes.wysiwyg', ['id' => 'body', 'property' => $project])
@endsection
