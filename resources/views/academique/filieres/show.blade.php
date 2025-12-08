@extends('layouts.admin')

@section('titre', 'Détails de la Filière')

@section('content')
<div class="container-fluid">

    {{-- Bannière de la filière --}}
    @if($filiere->image_path)
    <div class="card shadow-sm mb-4">
        <img src="{{ $filiere->image_path }}" class="card-img-top" alt="Bannière de {{ $filiere->nom }}" style="max-height: 250px; object-fit: cover;">
    </div>
    @endif

    {{-- En-tête de la page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Filière : {{ $filiere->nom }}</h1>
        <div>
            <a href="{{ route('academique.filieres.edit', $filiere) }}" class="btn btn-warning btn-sm shadow-sm">
                <i class="bx bx-edit"></i> Modifier
            </a>
            <a href="{{ route('academique.filieres.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="bx bx-arrow-back"></i> Retour à la liste
            </a>
        </div>
    </div>

    <div class="row">
        {{-- Colonne de Gauche : Informations Clés --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informations Principales</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Nom</span>
                            <span>{{ $filiere->nom }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Département</span>
                            <a href="#" class="badge badge-info">{{ $filiere->departement->nom ?? 'N/A' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Nombre de parcours</span>
                            <span class="badge badge-primary badge-pill">{{ $filiere->parcours->count() }}</span>
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
                    <h6 class="m-0 font-weight-bold text-primary">Description</h6>
                </div>
                <div class="card-body">
                    <p>{{ $filiere->description ?? 'Aucune description fournie.' }}</p>
                </div>
            </div>

            {{-- Parcours Associés --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Parcours Associés</h6>
                </div>
                <div class="card-body">
                    @if($filiere->parcours->isNotEmpty())
                        <div class="list-group">
                            @foreach($filiere->parcours as $parcour)
                                <a href="{{ route('academique.parcours.show', $parcour) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $parcour->nom }}</h6>
                                        <small class="text-muted">{{ Str::limit($parcour->description, 70) }}</small>
                                    </div>
                                    <i class="bx bx-chevron-right text-gray-400"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bx bx-error-circle fa-2x text-gray-400 my-2"></i>
                            <p class="text-muted">Aucun parcours n'est encore associé à cette filière.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection