@extends('layouts.app')

@section('title')
    Liste des clients
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste des clients</li>
@endsection

@section('content')

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste des clients</h3>
        <a href="{{ route('customers.create') }}" class="btn btn-info">Ajouter un nouveau client</a>
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
                            <a href="{{ route('customers.edit', $user) }}" class="mr-2"><i class="fas fa-paint-brush"></i></a>
                            <form action="{{ route('customers.destroy', $user) }}" method="post" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        {{ $users->links() }}
    </div>
@endsection
