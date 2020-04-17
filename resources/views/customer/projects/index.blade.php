@extends('layouts.app')

@section('title')
    Liste de vos projets
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Liste de vos projets</li>
@endsection

@section('content')

    <div class="my-2">
        @include('includes.filter', ['statuses' => $statuses, 'rows' => true])
    </div>

    <div class="row justify-content-between align-items-center mb-2">
        <h3 class="h2">Liste de vos projets</h3>
    </div>

    <div class="row">
        <table class="table table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nom</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        <td>{{ $project->name }}</td>
                        <td>{!! $project->actualStatus !!}</td>
                        <td class="">
                            <a class="btn btn-info" href="{{ route('customer.projects.show', $project) }}">
                                <i class="far fa-eye"></i> <span class="ml-3">Voir</span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row justify-content-center my-3">
        {{ $projects->links() }}
    </div>
@endsection

