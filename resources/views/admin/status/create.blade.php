@extends('layouts.app')

@section('title')
    Ajout d'un nouveau statut
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.status.index') }}" class="text-info">Liste des statuts</a></li>
    <li class="breadcrumb-item">Ajout d'un nouveau statut</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire de création d'un statut</h1>

<div class="container">
    <form action="{{ route('admin.status.store') }}" method="post">
        @csrf

        @include('includes.form.input', [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Nom',
            'placeholder' => 'Le nom du statut',
            'property' => null,
            'helper' => null,
            'required' => true
        ])

        <div class="row align-items-center">
            <div class="col-1">
                <span id="colorExample" class="badge badge-primary" style="height:25px;width:25px;">&emsp;</span>
            </div>
            <div class="col-11">
                @include('includes.form.select', [
                    'name' => 'color_id',
                    'label' => 'Choisissez une couleur',
                    'collection' => $colors,
                    'helper' => null,
                    'required' => true,
                    'selected' => null,
                    'property' => null,
                ])
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-info">Créer</button>
        </div>

    </form>
</div>

@endsection

@section('javascript')
    <script>
        const spanColor = document.getElementById('colorExample');
        const selectInput = document.getElementById('color_id');
        selectInput.addEventListener('change', changeColor);

        function changeColor(event) {
            let colorValue = this.options[this.selectedIndex].text;
            spanColor.className = '';
            spanColor.classList.add('badge', 'badge-' + colorValue);
        }
    </script>
@endsection
