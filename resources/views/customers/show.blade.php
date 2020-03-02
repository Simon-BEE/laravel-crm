@extends('layouts.app')

@section('title')
    Client : {{$customer->name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}" class="text-info">Liste des clients</a></li>
    <li class="breadcrumb-item">Client : {{$customer->name}}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    {{$customer->name}}
                </div>
                <div class="card-body row">
                    <div class="col-md-6">
                        <div class="bg-dark text-white mb-5 rounded">
                            <h5 class="card-title p-2">Informations</h5>
                        </div>
                        <div class="card-text">
                            <p class="text-muted"><i class="fas fa-user-tie"></i> {{ $customer->name }}</p>
                            <p><a href="mailto:{{ $customer->email }}" class="text-info"><i class="far fa-envelope"></i> {{ $customer->email }}</a></p>
                            <hr>
                            <p class="text-secondary"><i class="fas fa-map-marker-alt"></i> {{ $customer->address }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-info text-white mb-5 rounded">
                            <h5 class="card-title p-2">Projets</h5>
                        </div>
                        <div class="list-group">
                            @if (!$customer->projects->isEmpty())
                                @foreach ($customer->projects as $project)
                                    <a href="{{ route('projects.show', $project) }}" class="list-group-item list-group-item-action">
                                        {{ $project->name }}
                                    </a>
                                @endforeach
                            @else
                                <p class="list-group-item">Aucun projet lié à ce client.</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted">
                    @if (!$customer->know)
                        <a class="mr-2" href="{{ route('customers.send_password', $customer) }}">
                            <i class="fas fa-key"></i>
                        </a>
                    @endif

                    <a class="mr-2" href="{{ route('customers.edit', $customer) }}">
                        <i class="fas fa-paint-brush"></i>
                    </a>
                    <form action="{{ route('customers.destroy', $customer) }}" method="post" class="d-inline-block" onsubmit="confirmAction(event)">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-link p-0 text-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@include('includes.delete-modal')
