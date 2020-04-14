@extends('layouts.app')

@section('title')
Généreration d'une facture
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a class="text-info" href="{{ route('admin.invoices.index') }}">Liste des factures</a></li>
    <li class="breadcrumb-item active">Généreration d'une facture</li>
@endsection

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h3>
                Création de facture
            </h3>
            <hr>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.invoices.store') }}" method="post">
                @csrf
                <!-- Informations invoice -->
                <div class="row">
                    <div class="col-12">
                        <h4>Informations</h4>
                    </div>
                    <div class="col-5">
                        @include('includes.form.input', [
                            'name' => 'issue_date',
                            'type' => 'date',
                            'label' => 'Date d\'émission',
                            'placeholder' => 'Invoice\'s issue date',
                            'property' => 'null',
                            'helper' => null,
                            'required' => true,
                        ])
                        @include('includes.form.input', [
                            'name' => 'due_date',
                            'type' => 'date',
                            'label' => 'Date limite de paiement',
                            'placeholder' => 'Invoice\'s due date',
                            'property' => 'null',
                            'helper' => null,
                            'required' => true,
                        ])
                        <div class="d-flex justify-content-between">
                            <h5>Émetteur</h5>
                            <small><a class="text-info" href="{{ route('admin.account.edit') }}">Changer ces informations</a></small>
                        </div>
                        <hr>

                        <p>{{ auth()->user()->name }} </p>
                        <p>{{ auth()->user()->completeAddress }} </p>
                    </div>
                    <div class="col-5 offset-2">
                        <!-- -->
                        <div class="d-flex justify-content-between mb-n1">
                            <h5>Destinataire</h5>
                            <small><a class="text-info" href="{{ route('admin.customers.create') }}">Ajouter un nouveau client</a></small>
                        </div>
                        <hr>

                        @include('includes.form.select', [
                            'name' => 'customer_id',
                            'label' => 'Choisissez un client',
                            'collection' => $customers,
                            'helper' => 'Si votre client n\'apparait pas c\'est qu\'il n\'a pas de projet(s) affilié(s).',
                            'required' => true,
                            'selected' => null,
                            'property' => null,
                        ])
                        @include('includes.form.select', [
                            'name' => 'project_id',
                            'label' => 'Choisissez un projet',
                            'collection' => $projects,
                            'helper' => null,
                            'required' => true,
                            'selected' => null,
                            'property' => null,
                        ])
                    </div>
                </div>
                <hr>
                <!-- Items invoice -->
                <div class="row">
                    <div class="col-12">
                        <h4>Éléments</h4>
                    </div>
                    <div class="col-10" id="items-list">
                        <div id="item_1" class="d-flex justify-content-between align-items-start">
                                <div class="form-group w-75 d-flex align-items-end">
                                    <div class="upside flex-grow-1">
                                        <label for="item_1">Élément numéro 1</label>
                                        <input type="text" name="items[]" id="item_1" placeholder="Élément de facture" class="form-control @error('items[]') is-invalid @enderror" required>
                                    </div>
                                </div>
                                <div class="form-group mx-1">
                                    <label for="qty_item_1">Quantité élément 1</label>
                                    <input type="text" name="qty_items[]" id="qty_item_1" placeholder="Quantité de l'élément" class="form-control @error('qty_items[]') is-invalid @enderror">
                                    <small class="text-muted">Par défaut est de 1.</small>
                                </div>
                                <div class="form-group">
                                    <label for="price_item_1">Prix de l'élément</label>
                                    <input type="text" name="price_items[]" id="price_item_1" placeholder="Prix de l'élément" class="form-control @error('price_items[]') is-invalid @enderror" required>
                                    <small class="text-muted">Prix doit être en euro (€).</small>
                                </div>
                        </div>
                    </div>
                    <div class="col-2 text-right">
                        <button type="button" class="btn btn-warning" id="addNewItemButton">Ajouter un nouvel élément</button>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-12">
                        <h4>Notes additionnelles</h4>
                    </div>

                    <div class="col-12">
                        @include('includes.form.textarea', [
                        'name' => 'additionnal',
                        'label' => 'Notes additionnelles',
                        'placeholder' => 'Notes additionnelles de la facture',
                        'property' => 'null',
                        'helper' => 'Séparer les lignes par une virgule.',
                        'required' => true,
                    ])
                    </div>
                </div>

                <!-- end -->
                <div class="row">
                    <div class="offset-lg-11 col-lg-1">
                        <button type="submit" class="btn btn-info">Enregistrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var counter = 1;
        const baseInput = document.getElementById('item_1');
        const divItems = document.getElementById('items-list');
        const customerSelect = document.getElementById('customer_id');
        const projectsSelect = document.getElementById('project_id');

        customerSelect.addEventListener('change', selectProjectByCustomer);
        document.getElementById('addNewItemButton').addEventListener('click', addNewItemField);

        function selectProjectByCustomer(event) {
            axios.post("{{ route('admin.invoices.customer.projects') }}", {
                customerId: customerSelect.value,
            })
            .then(function (response) {
                projectsSelect.options.length = 0;

                for (let [key, project] of Object.entries(response.data)) {
                    const optionElement = document.createElement('option');
                    optionElement.value = project.id;
                    optionElement.text = project.name;

                    projectsSelect.appendChild(optionElement);
                }
            })
            .catch(function (error) {
                console.log(error);
                alert('Une erreur est survenu !');
            });
        }

        function addNewItemField(event) {
            const newInput = baseInput.cloneNode(true);

            counter++;

            newInput.id = 'item_' + counter;

            const labelItem = newInput.getElementsByTagName('label')[0];
            const inputItem = newInput.getElementsByTagName('input')[0];
            const labelQty = newInput.getElementsByTagName('label')[1];
            const inputQty = newInput.getElementsByTagName('input')[1];
            const labelPrice = newInput.getElementsByTagName('label')[2];
            const inputPrice = newInput.getElementsByTagName('input')[2];

            labelItem.htmlFor = 'item_' + counter;
            inputItem.id = 'item_' + counter;
            labelItem.innerHTML = 'Items line ' + counter;

            labelQty.htmlFor = 'qty_item_' + counter;
            inputQty.id = 'qty_item_' + counter;
            labelQty.innerHTML = 'qty item ' + counter;

            labelPrice.htmlFor = 'price_item_' + counter;
            inputPrice.id = 'price_item_' + counter;
            labelPrice.innerHTML = 'Price item ' + counter;

            const deleteDiv = document.createElement('div');
            deleteDiv.classList.add('rounded', 'p-1', 'bg-danger', 'mr-2');
            deleteDiv.innerHTML = `<a href="#" class="text-white lead float-right" onclick="deleteThisInput(event, ${counter})">&times;</a>`;

            labelItem.parentNode.parentNode.insertBefore(deleteDiv, labelItem.parentNode.parentNode.firstChild);
            divItems.appendChild(newInput);
        }

        function deleteThisInput(event, id) {
            event.preventDefault();
            document.getElementById('item_' + id).remove();
        }
    </script>
@endsection
