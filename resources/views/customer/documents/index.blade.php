@extends('layouts.app')

@section('title')
Liste de vos documents
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Liste de vos documents</li>
@endsection

@section('content')
        <div class="my-2">
            @include('includes.filter', ['statuses' => $statuses, 'price' => true, 'type' => true])
        </div>
        <div class="row justify-content-between align-items-center mb-2">
            <h3 class="h2">Liste de vos documents</h3>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Type</th>
                        <th scope="col">Montant total</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($documents as $document)
                        <tr>
                            <th scope="row">{{ $document->documentId }}</th>
                            <td class="w-25 text-muted">{{ Helpers::className($document) == 'Estimate' ? 'Devis' : 'Facture' }}</td>
                            <td class="w-25">{{ Formats::formatPrice($document->amount) }}</td>
                            <td class="w-25">{!! $document->itsStatus !!}</td>
                            <td class="w-25">
                                <div class="">
                                    <a href="{{ route('customer.documents.show.' . strtolower(Helpers::className($document)), $document) }}" target="_blank" class="btn btn-info">
                                        <i class="far fa-eye"></i> <span class="ml-3">Voir</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center mt-5">
                {{-- {{ $documents->links() }} --}}
            </div>
        </div>



@endsection
