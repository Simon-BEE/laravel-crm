@extends('layouts.app')

@section('title')
    Paramètres
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item">Paramètres</li>
@endsection

@section('content')
<h2 class="mt-4">Choisissez les paramètres liés à l'application</h1>

<div class="container">
    <form action="" method="post" class="mb-3">
        @csrf
        @method('PATCH')

        @include('includes.form.input', [
            'name' => 'pagination',
            'type' => 'text',
            'label' => 'Nombre de résultats par page',
            'placeholder' => 'Choisissez le nombre de résultats par page (défaut : 10)',
            'property' => $user->settings,
            'helper' => 'Il s\'agit du nombre d\'éléments que vous verrez par défaut sur chaque page. Veuillez rentrer un nombre entre 5 et 50.',
            'required' => true
        ])

        <div class="text-right">
            <button type="submit" class="btn btn-info">Enregistrer</button>
        </div>

    </form>
</div>

@endsection

