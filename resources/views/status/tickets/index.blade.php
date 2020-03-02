@extends('layouts.app')

@section('title')
    Liste des statuts de tickets
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des statuts de tickets</li>
@endsection

@section('content')

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des tickets</h3>
        <a href="{{ route('status.tickets.create') }}" class="btn btn-info">Ajouter un nouveau statut</a>
    </div>
    <div class="row">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($statuts as $statut)
                    <tr>
                        <th scope="row">{{ $statut->id }}</th>
                        <td>{{ $statut->name }}</td>
                        <td class="">
                            <div class="dropdown">
                                <button class="btn btn-link text-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <form action="{{ route('status.tickets.destroy', $statut) }}" method="post" class="dropdown-item" onsubmit="confirmAction(event)">
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
    @include('includes.delete-modal')
@endsection

