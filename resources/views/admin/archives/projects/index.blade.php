@extends('layouts.app')

@section('title')
    Liste des projets archivés
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des projets archivés</li>
@endsection

@section('content')

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des projets archivés</h3>
    </div>
    <div class="row">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Client</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->name }}</td>
                        <td>
                            @if ($project->customer->isDelete)
                                {{ $project->customer->name }}
                            @else
                                <a href="{{ route('admin.customers.show', $project->customer) }}" class="text-secondary">{{ $project->customer->name }}</a>
                            @endif
                        </td>
                        <td class="">
                            @if ($project->customer->isDelete)
                                Aucune action disponible
                            @else
                                <div class="dropdown">
                                    <button class="btn btn-link text-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                                        <form action="{{ route('admin.archives.projects.restore', $project) }}" method="post" class="dropdown-item">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-link p-0 text-primary">
                                                <i class="fas fa-trash-restore-alt"></i>
                                                <span class="ml-3">Restaurer</span>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.archives.projects.destroy', $project) }}" method="post" class="dropdown-item" onsubmit="confirmAction(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link p-0 text-danger">
                                                <i class="fas fa-trash-alt"></i>
                                                <span class="ml-3">Supprimer définitivement</span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif
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

