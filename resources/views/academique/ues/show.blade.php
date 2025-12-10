@extends('layouts.admin')

@section('titre', 'Détails de l\'UE')

@section('header')
<style>
    .hero-banner {
        height: 250px; /* Hauteur de la bannière */
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .hero-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.4); /* Assombrir l'image pour que le texte soit lisible */
        border-radius: 8px;
    }

    .hero-banner-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    .hero-banner-title {
        font-size: 2.5rem;
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .hero-banner-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">

    {{-- Bannière de la filière parente --}}
    @if($ue->semestre->parcours->filiere && $ue->semestre->parcours->filiere->image_path)
    <div class="hero-banner" style="background-image: url('{{ Storage::url($ue->semestre->parcours->filiere->image_path) }}');">
        <div class="hero-banner-content">
            <h1 class="hero-banner-title">{{ $ue->semestre->parcours->filiere->nom ?? 'Filière' }}</h1>
            <p class="hero-banner-subtitle">UE : {{ $ue->libelle }} ({{ $ue->code_ue }})</p>
        </div>
    </div>
    @endif

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
                            <span class="font-weight-bold">Code UE</span>
                            <span class="badge badge-dark">{{ $ue->code_ue }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Libellé</span>
                            <span>{{ $ue->libelle }}</span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Crédits ECTS</span>
                            <span class="badge badge-primary badge-pill">{{ $ue->credits_ects }}</span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Nombre de modules</span>
                            <span class="badge badge-primary badge-pill">{{ $ue->modules->count() }}</span>
                        </li>
                    </ul>
                </div>
            </div>
             <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Rattachement Académique</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Semestre</span>
                             <a href="{{ route('academique.semestres.show', $ue->semestre) }}" class="badge badge-success">{{ $ue->semestre->libelle ?? 'N/A' }}</a>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Parcours</span>
                            <a href="{{ route('academique.parcours.show', $ue->semestre->parcours) }}" class="badge badge-info">{{ $ue->semestre->parcours->nom ?? 'N/A' }}</a>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Filière</span>
                            <span>{{ $ue->semestre->parcours->filiere->nom ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Département</span>
                            <span>{{ $ue->semestre->parcours->filiere->departement->nom ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Colonne de Droite : Détails --}}
        <div class="col-lg-8">
            {{-- Modules Associés --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Modules Associés</h6>
                </div>
                <div class="card-body">
                    @if($ue->modules->isNotEmpty())
                        <div class="list-group">
                            @foreach($ue->modules as $module)
                                {{-- Le lien sera décommenté quand la route existera --}}
                                {{-- <a href="{{ route('academique.modules.show', $module) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"> --}}
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $module->libelle }}</h6>
                                        <small class="text-muted">Masse Horaire : {{ $module->masse_horaire }}h</small>
                                    </div>
                                    <i class="bx bx-chevron-right text-gray-400"></i>
                                </div>
                                {{-- </a> --}}
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bx bx-error-circle fa-2x text-gray-400 my-2"></i>
                            <p class="text-muted">Aucun module n'est encore associé à cette UE.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
