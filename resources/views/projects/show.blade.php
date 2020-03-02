@extends('layouts.app')

@section('title')
    Projet : {{$project->name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}" class="text-info">Liste des projets</a></li>
    <li class="breadcrumb-item">Projet : {{$project->name}}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="container shadow p-3 rounded bg-dark text-secondary">
            <div class="title text-center">
                <h2 class="display-2">{{ $project->name }}</h2>
            </div>
            <hr>
            @if ($project->name)
                <div class="alert alert-info">
                    <h4 class="alert-heading">Information importante</h4>
                    <p>{{ $project->news }}</p>
                </div>
                <hr>
            @endif
            <div class="row">
                <div class="col-md-2">
                    <p class="card-text"><a href="{{ route('customers.show', $project->user )}}" class="text-info">{{$project->user->name}}</a></p>
                    <p class="card-text">{{$project->created_at->diffForHumans()}}</p>
                </div>
                <div class="col-md-10">
                    <div class="float-right">
                        <a class="btn btn-info mr-2" href="{{ route('projects.edit', $project) }}">
                            <i class="fas fa-paint-brush"></i> <span class="ml-3">Editer</span>
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="post" class="d-inline-block" onsubmit="confirmAction(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                                <span class="ml-3">Supprimer</span>
                            </button>
                        </form>
                    </div>
                    {!! $project->body !!}
                </div>
            </div>
        </div>
    </div>

@endsection


@include('includes.delete-modal')