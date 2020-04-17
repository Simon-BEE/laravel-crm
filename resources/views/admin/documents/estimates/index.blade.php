@extends('layouts.app')

@section('title')
Liste des devis
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Liste des devis</li>
@endsection

@section('content')
        <div class="my-2">
            @include('includes.filter', ['statuses' => $statuses, 'price' => true, 'rows' => true])
        </div>
        <div class="row justify-content-between align-items-center mb-2">
            <h3 class="h2">Liste des devis</h3>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-info">Créer un nouveau devis</a>
        </div>
        <div class="row">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Client</th>
                        <th scope="col">Montant total</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($estimates as $estimate)
                        <tr>
                            <th scope="row">{{ $estimate->estimate_id }}</th>
                            @if ($estimate->customer)
                                <td class="w-25"><a href="{{ route('admin.customers.show', $estimate->customer) }}">{{ $estimate->customer->name }}</a></td>
                            @else
                                <td class="w-25">Client supprimé</td>
                            @endif
                            <td class="w-25">{{ Formats::formatPrice($estimate->amount) }}</td>
                            <td class="w-25">{!! $estimate->itsStatus !!}</td>
                            <td class="w-25">
                                <div class="">
                                    <a href="{{ asset('storage/estimates/' . $estimate->file ) }}" target="_blank" class="btn btn-info">Voir</a>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#changeStatusModal" data-estimate="{{ $estimate->estimate_id }}" onclick="changeStatusModal(event)">Changer le statut</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center mt-5">
                {{ $estimates->links() }}
            </div>
        </div>

<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Changement du statut du devis n°<span id="thereInvoice"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.estimates.status.update') }}" method="post" class="formChangeEstimateStatus">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="estimate" value="" id="hiddenModalEstimate">

                    @include('includes.form.select', [
                        'name' => 'status_id',
                        'label' => 'Choisir un nouveau statut',
                        'collection' => $statuses,
                        'helper' => null,
                        'required' => true,
                        'selected' => null,
                        'property' => null,
                    ])
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="confirmChange">Changer le statut</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    function changeStatusModal(e) {
        e.preventDefault();
        console.log(e.target.dataset)
        $('#changeStatusModal').modal('show');
        document.getElementById('hiddenModalEstimate').value = e.target.dataset.estimate
        document.getElementById('thereInvoice').innerHTML = e.target.dataset.estimate
        document.getElementById('confirmChange').onclick = () => {
            document.getElementsByClassName('formChangeEstimateStatus')[0].submit();
        };
    }
</script>
@endsection
