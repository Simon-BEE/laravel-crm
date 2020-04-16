@extends('layouts.app')

@section('title')
    Projet : {{$project->name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('customer.projects.index') }}" class="text-info">Liste de vos projets</a></li>
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
            <div class="row">
                <div class="col-md-2">
                    <p class="card-text text-info">{{$project->customer->name}}</p>
                    <p class="card-text">{{$project->created_at->diffForHumans()}}</p>
                </div>
                <div class="col-md-10">
                    {!! $project->body !!}
                </div>
            </div>
        </div>
    </div>

@endsection


@include('includes.modal.delete-modal')
