@extends('layouts.admin')

@section('titre', 'Détails du Semestre')

@section('content')
<div class="container-fluid">

    {{-- Bannière de la filière parente --}}
    @if($semestre->parcours->filiere && $semestre->parcours->filiere->image_path)
    <div class="card shadow-sm mb-4">
        <img src="{{ $semestre->parcours->filiere->image_path }}" class="card-img-top" alt="Bannière de {{ $semestre->parcours->filiere->nom }}" style="max-height: 250px; object-fit: cover;">
    </div>
    @endif

    {{-- En-tête de la page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Semestre : {{ $semestre->libelle }}</h1>
        <div>
            <a href="{{ route('academique.semestres.edit', $semestre) }}" class="btn btn-warning btn-sm shadow-sm">
                <i class="bx bx-edit"></i> Modifier
            </a>
            <a href="{{ route('academique.semestres.index') }}" class="btn btn-secondary btn-sm shadow-sm">
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
                            <span class="font-weight-bold">Libellé</span>
                            <span>{{ $semestre->libelle }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Niveau</span>
                            <span class="badge badge-success">{{ $semestre->niveau }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Parcours</span>
                            <a href="{{ route('academique.parcours.show', $semestre->parcours) }}" class="badge badge-info">{{ $semestre->parcours->nom ?? 'N/A' }}</a>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Filière</span>
                            <span>{{ $semestre->parcours->filiere->nom ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Département</span>
                            <span>{{ $semestre->parcours->filiere->departement->nom ?? 'N/A' }}</span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Nombre d'UEs</span>
                            <span class="badge badge-primary badge-pill">{{ $semestre->ues->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Colonne de Droite : Détails --}}
        <div class="col-lg-8">
            {{-- UEs Associées --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Unités d'Enseignement (UEs) Associées</h6>
                </div>
                <div class="card-body">
                    @if($semestre->ues->isNotEmpty())
                        <div class="list-group">
                            @foreach($semestre->ues as $ue)
                                {{-- Le lien sera décommenté quand la route existera --}}
                                {{-- <a href="{{ route('academique.ues.show', $ue) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"> --}}
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $ue->libelle }}</h6>
                                        <small class="text-muted">Crédits : {{ $ue->credit }}</small>
                                    </div>
                                    <i class="bx bx-chevron-right text-gray-400"></i>
                                </div>
                                {{-- </a> --}}
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bx bx-error-circle fa-2x text-gray-400 my-2"></i>
                            <p class="text-muted">Aucune UE n'est encore associée à ce semestre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
