@extends('layouts.admin')

@section('titre', 'Détails du Parcours')

@section('content')
<div class="container-fluid">

    {{-- Bannière de la filière parente --}}
    @if($parcours->filiere && $parcours->filiere->image_path)
    <div class="card shadow-sm mb-4">
        <img src="{{ $parcours->filiere->image_path }}" class="card-img-top" alt="Bannière de {{ $parcours->filiere->nom }}" style="max-height: 250px; object-fit: cover;">
    </div>
    @endif

    {{-- En-tête de la page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Parcours : {{ $parcours->nom }}</h1>
        <div>
            <a href="{{ route('academique.parcours.edit', $parcours) }}" class="btn btn-warning btn-sm shadow-sm">
                <i class="bx bx-edit"></i> Modifier
            </a>
            <a href="{{ route('academique.parcours.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="bx bx-arrow-back"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Colonne de Gauche : Informations Clés --}}
        <div class="col-lg-4">
            {{-- Carte Rattachement --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rattachement Académique</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Filière</span>
                            <a href="{{ route('academique.filieres.show', $parcours->filiere) }}" class="badge badge-info">{{ $parcours->filiere->nom ?? 'N/A' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Département</span>
                            <span>{{ $parcours->filiere->departement->nom ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Carte Frais --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Frais de Scolarité</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Frais d'inscription</span>
                            <span class="text-success font-weight-bold">{{ number_format($parcours->frais_inscription, 0, ',', ' ') }} F CFA</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Frais de formation</span>
                            <span class="text-success font-weight-bold">{{ number_format($parcours->frais_formation, 0, ',', ' ') }} F CFA</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Colonne de Droite : Détails --}}
        <div class="col-lg-8">
            {{-- Description --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Description du Parcours</h6>
                </div>
                <div class="card-body">
                    <p>{{ $parcours->description ?? 'Aucune description fournie.' }}</p>
                </div>
            </div>

            {{-- Semestres Associés --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Semestres Associés</h6>
                </div>
                <div class="card-body">
                    @if($parcours->semestres->isNotEmpty())
                        <div class="list-group">
                            @foreach($parcours->semestres as $semestre)
                                {{-- Le lien sera décommenté quand la route existera --}}
                                {{-- <a href="{{ route('academique.semestres.show', $semestre) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"> --}}
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <h6 class="mb-1">{{ $semestre->nom }}</h6>
                                    <i class="bx bx-chevron-right text-gray-400"></i>
                                </div>
                                {{-- </a> --}}
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bx bx-error-circle fa-2x text-gray-400 my-2"></i>
                            <p class="text-muted">Aucun semestre n'est encore associé à ce parcours.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
