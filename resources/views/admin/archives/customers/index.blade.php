@extends('layouts.app')

@section('title')
    Liste des clients archivés
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des clients archivés</li>
@endsection

@section('content')

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des clients archivés</h3>
    </div>
    <div class="row">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Adresse email</th>
                    <th scope="col">Adresse</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td class="">
                            <div class="dropdown">
                                <button class="btn btn-link text-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

                                    <form action="{{ route('admin.archives.customers.restore', $user) }}" method="post" class="dropdown-item">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0 text-primary">
                                            <i class="fas fa-trash-restore-alt"></i>
                                            <span class="ml-3">Restaurer</span>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.archives.customers.destroy', $user) }}" method="post" class="dropdown-item" onsubmit="confirmAction(event)">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0 text-danger">
                                            <i class="fas fa-trash-alt"></i>
                                            <span class="ml-3">Supprimer définitivement</span>
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
        {{ $users->links() }}
    </div>
    @include('includes.modal.delete-modal')
@endsection

