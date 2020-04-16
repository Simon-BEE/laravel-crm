@extends('layouts.app')

@section('title')
    Projet : {{$project->name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}" class="text-info">Liste des projets</a></li>
    <li class="breadcrumb-item">Projet : {{$project->name}}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="container p-3">
            <div class="title text-center">
                <span class="float-right">{!! $project->actualStatus !!}</span>
                <h2 class="display-2">{{ $project->name }}</h2>
            </div>
            <hr>
            @if ($project->news)
                <div class="alert alert-info">
                    <h4 class="alert-heading">Information importante</h4>
                    <p>{{ $project->news }}</p>
                </div>
                <hr>
            @endif
            <div class="row">
                <div class="col-md-2">
                    <p class="card-text"><a href="{{ route('admin.customers.show', $project->customer) }}" class="text-info">{{$project->customer->name}}</a></p>
                    <p class="card-text">{{$project->created_at->diffForHumans()}}</p>
                </div>
                <div class="col-md-10">
                    <div class="float-right">
                        <a class="btn btn-info mr-2" href="{{ route('admin.projects.edit', $project) }}">
                            <i class="fas fa-paint-brush"></i> <span class="ml-3">Editer</span>
                        </a>
                        <form action="{{ route('admin.projects.destroy', $project) }}" method="post" class="d-inline-block" onsubmit="confirmAction(event)">
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


@include('includes.modal.delete-modal')
