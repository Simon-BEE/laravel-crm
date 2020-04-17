@extends('layouts.app')

@section('title')
    Client : {{$customer->name}}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.customers.index') }}" class="text-info">Liste des clients</a></li>
    <li class="breadcrumb-item">Client : {{$customer->name}}</li>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header">
                    <strong>{{$customer->name}}</strong>
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
                            <p class="text-secondary"><i class="fas fa-map-marker-alt"></i> {{ $customer->completeAddress }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-info text-white mb-5 rounded">
                            <h5 class="card-title p-2">Projets</h5>
                        </div>
                        <div class="list-group">
                            @if (!$customer->projects->isEmpty())
                                @foreach ($customer->projects as $project)
                                    <a href="{{ route('admin.projects.show', $project) }}" class="list-group-item list-group-item-action">
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
                    @if (!$customer->changed)
                        <a class="mr-2 text-warning" href="{{ route('admin.customers.send_password', $customer) }}" title="Envoyer @if(!$customer->knew) le @else un nouveau @endif le mot de passe">
                            <i class="fas fa-key"></i>
                        </a>
                    @endif

                    <a class="mr-2" href="{{ route('admin.customers.edit', $customer) }}">
                        <i class="fas fa-paint-brush"></i>
                    </a>
                    <a class="mr-2 text-secondary" href="{{ route('admin.customers.export.customer', $customer) }}" target="_blank">
                        <i class="fas fa-file-export"></i>
                    </a>
                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="post" class="d-inline-block" onsubmit="confirmAction(event)">
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

    <div class="row justify-content-center">
        <div class="col-md-6 my-4">
            <div class="mb-2">
                <h3 class="h3">Devis</h3>
                @if ($customer->customerEstimates->isEmpty())
                    <p class="text-center">Ce client n'a aucun devis.</p>
                @else
                    <div class="list-group">
                        @foreach ($customer->customerEstimates as $estimate)
                            <a href="{{ asset('storage/estimates/' . $estimate->file ) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-around align-items-center">
                                <strong>Facture n°{{ $estimate->estimate_id }}</strong>
                                <p class="m-0">{!! $estimate->itsStatus !!}</p>
                                <p class="m-0">Montant: <span class="text-info">{{ Formats::formatPrice($estimate->amount) }}</span></p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="my-5">
                <h3 class="h3">Factures</h3>
                @if ($customer->customerInvoices->isEmpty())
                    <p class="text-center">Ce client n'a aucune facture.</p>
                @else
                    <div class="list-group">
                        @foreach ($customer->customerInvoices as $invoice)
                            <a href="{{ asset('storage/invoices/' . $invoice->file ) }}" target="_blank" class="list-group-item list-group-item-action d-flex justify-content-around align-items-center">
                                <strong>Facture n°{{ $invoice->invoice_id }}</strong>
                                <p class="m-0">{!! $invoice->itsStatus !!}</p>
                                <p class="m-0">Montant: <span class="text-info">{{ Formats::formatPrice($invoice->amount) }}</span></p>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@include('includes.modal.delete-modal')
