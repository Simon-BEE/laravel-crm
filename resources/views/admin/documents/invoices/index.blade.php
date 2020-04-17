@extends('layouts.app')

@section('title')
Liste des factures
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Liste des factures</li>
@endsection

@section('content')
        <div class="my-2">
            @include('includes.filter', ['statuses' => $statuses, 'price' => true, 'rows' => true])
        </div>
        <div class="row justify-content-between align-items-center mb-2">
            <h3 class="h2">Liste des factures</h3>
            <a href="{{ route('admin.invoices.create') }}" class="btn btn-info">Créer une nouvelle facture</a>
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
                    @foreach ($invoices as $invoice)
                        <tr>
                            <th scope="row">{{ $invoice->invoice_id }}</th>
                            @if ($invoice->customer)
                                <td class="w-25"><a href="{{ route('admin.customers.show', $invoice->customer) }}">{{ $invoice->customer->name }}</a></td>
                            @else
                                <td class="w-25">Client supprimé</td>
                            @endif
                            <td class="w-25">{{ Formats::formatPrice($invoice->amount) }}</td>
                            <td class="w-25">{!! $invoice->itsStatus !!}</td>
                            <td class="w-25">
                                <div class="">
                                    <a href="{{ asset('storage/invoices/' . $invoice->file ) }}" target="_blank" class="btn btn-info">Voir</a>
                                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#changeStatusModal" data-invoice="{{ $invoice->invoice_id }}" onclick="changeStatusModal(event)">Changer le statut</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="row justify-content-center mt-5">
                {{ $invoices->links() }}
            </div>
        </div>

<div class="modal fade" id="changeStatusModal" tabindex="-1" role="dialog" aria-labelledby="changeStatusModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Changement du statut de la facture n°<span id="thereInvoice"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.invoices.status.update') }}" method="post" class="formChangeInvoiceStatus">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="invoice" value="" id="hiddenModalInput">

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
        $('#changeStatusModal').modal('show');
        document.getElementById('hiddenModalInput').value = e.target.dataset.invoice
        document.getElementById('thereInvoice').innerHTML = e.target.dataset.invoice
        document.getElementById('confirmChange').onclick = () => {
            document.getElementsByClassName('formChangeInvoiceStatus')[0].submit();
        };
    }
</script>
@endsection
