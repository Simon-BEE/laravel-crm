@extends('layouts.app')

@section('title')
    Liste des projets
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des projets</li>
@endsection

@section('content')

    <div class="my-2">
        @include('includes.filter', ['statuses' => $statuses, 'customers' => $customers, 'rows' => true])
    </div>

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des projets</h3>
        <a href="{{ route('admin.projects.create') }}" class="btn btn-info">Ajouter un nouveau projet</a>
    </div>

    <div class="row">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Client</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->name }}</td>
                        <td><a href="{{ route('admin.customers.show', $project->customer) }}" class="text-secondary">{{ $project->customer->name }}</a></td>
                        <td>{!! $project->actualStatus !!}</td>
                        <td class="">
                            <div class="dropdown">
                                <button class="btn btn-link text-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('admin.projects.show', $project) }}">
                                        <i class="far fa-eye"></i> <span class="ml-3">Voir</span>
                                    </a>
                                    <a class="dropdown-item" href="{{ route('admin.projects.edit', $project) }}">
                                        <i class="fas fa-paint-brush"></i> <span class="ml-3">Editer</span>
                                    </a>
                                    <form action="{{ route('admin.projects.destroy', $project) }}" method="post" class="dropdown-item" onsubmit="confirmAction(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                            <span class="ml-3">Supprimer</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center my-3">
        {{ $projects->links() }}
    </div>
    @include('includes.modal.delete-modal')
@endsection

