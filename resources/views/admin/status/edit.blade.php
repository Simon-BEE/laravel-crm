@extends('layouts.app')

@section('title')
    Édition de statut
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.status.index') }}" class="text-info">Liste des statuts</a></li>
    <li class="breadcrumb-item">Édition de statut</li>
@endsection

@section('content')
<h2 class="mt-4">Formulaire d'édition</h1>

<div class="container">
    <form action="{{ route('admin.status.update', $status) }}" method="post">
        @csrf
        @method('PATCH')

        @include('includes.form.input', [
            'name' => 'name',
            'type' => 'text',
            'label' => 'Nom',
            'placeholder' => 'Le nom du statut',
            'property' => $status,
            'helper' => null,
            'required' => true
        ])

        <div class="row align-items-center">
            <div class="col-1">
                <span id="colorExample" class="badge badge-{{ $status->color->name }}" style="height:25px;width:25px;">&emsp;</span>
            </div>
            <div class="col-11">
                @include('includes.form.select', [
                    'name' => 'color_id',
                    'label' => 'Choisissez une couleur',
                    'collection' => $colors,
                    'helper' => null,
                    'required' => true,
                    'selected' => true,
                    'property' => $status->color,
                ])
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-info">Modifier</button>
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
