@extends('layouts.app')

@section('title')
    Liste des statuts
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des statuts</li>
@endsection

@section('content')

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des statuts</h3>
        <a href="{{ route('admin.status.create') }}" class="btn btn-info">Ajouter un nouveau statut</a>
    </div>
    <div class="row">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Couleur</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statuses as $status)
                    <tr>
                        <th scope="row">{{ $status->id }}</th>
                        <td><span class="badge badge-{{$status->color->name}}">&emsp;</span></td>
                        <td>{{ $status->name }}</td>
                        <td class="">
                            <div class="dropdown">
                                <button class="btn btn-link text-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="{{ route('admin.status.edit', $status) }}">
                                        <i class="fas fa-paint-brush"></i>
                                        <span class="ml-3">Editer</span>
                                    </a>
                                    <form action="{{ route('admin.status.destroy', $status) }}" method="post" class="dropdown-item" onsubmit="confirmAction(event)">
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
    @include('includes.modal.delete-modal')
@endsection

