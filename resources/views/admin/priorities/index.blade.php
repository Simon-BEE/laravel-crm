@extends('layouts.app')

@section('title')
    Liste des priorités
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des priorités</li>
@endsection

@section('content')

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des priorités</h3>
        <button type="button" class="btn btn-info" id="btnNewElement" onclick="showModalElement(event)">Ajouter une nouvelle priorité</button>
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
                @foreach ($priorities as $priority)
                    <tr>
                        <th scope="row">{{ $priority->id }}</th>
                        <td>{{ $priority->name }}</td>
                        <td class="">
                            <div class="dropdown">
                                <button class="btn btn-link text-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <button class="dropdown-item btn-link" onclick="showModalElement(event, '{{$priority->name}}', {{$priority->id}})">
                                        <i class="fas fa-paint-brush"></i>
                                        <span class="ml-3">Editer</span>
                                    </button>
                                    <form action="{{ route('admin.priorities.destroy', $priority) }}" method="post" class="dropdown-item" onsubmit="confirmAction(event)">
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
    @include('includes.modal.new-modal', [
        'name' => 'Priorité',
        'route' => 'admin.priorities.store',
    ])
    @include('includes.modal.delete-modal')
@endsection

