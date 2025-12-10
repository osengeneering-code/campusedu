@extends('layouts.admin')

@section('titre', 'Détails du Module')

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
    @if($module->ue->semestre->parcours->filiere && $module->ue->semestre->parcours->filiere->image_path)
    <div class="hero-banner" style="background-image: url('{{ Storage::url($module->ue->semestre->parcours->filiere->image_path) }}');">
        <div class="hero-banner-content">
            <h1 class="hero-banner-title">{{ $module->ue->semestre->parcours->filiere->nom ?? 'Filière' }}</h1>
            <p class="hero-banner-subtitle">Module : {{ $module->libelle }} ({{ $module->code_module }})</p>
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
                            <span class="font-weight-bold">Code Module</span>
                            <span class="badge badge-dark">{{ $module->code_module }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Libellé</span>
                            <span>{{ $module->libelle }}</span>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Volume Horaire</span>
                            <span class="badge badge-primary badge-pill">{{ $module->volume_horaire }} heures</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Coefficient</span>
                            <span class="badge badge-primary badge-pill">{{ $module->coefficient }}</span>
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
                            <span class="font-weight-bold">Unité d'Enseignement (UE)</span>
                             <a href="{{ route('academique.ues.show', $module->ue) }}" class="badge badge-primary">{{ $module->ue->libelle ?? 'N/A' }}</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Semestre</span>
                             <a href="{{ route('academique.semestres.show', $module->ue->semestre) }}" class="badge badge-success">{{ $module->ue->semestre->libelle ?? 'N/A' }}</a>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Parcours</span>
                            <a href="{{ route('academique.parcours.show', $module->ue->semestre->parcours) }}" class="badge badge-info">{{ $module->ue->semestre->parcours->nom ?? 'N/A' }}</a>
                        </li>
                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Filière</span>
                            <span>{{ $module->ue->semestre->parcours->filiere->nom ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">Département</span>
                            <span>{{ $module->ue->semestre->parcours->filiere->departement->nom ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Colonne de Droite : Détails --}}
        <div class="col-lg-8">
            {{-- Enseignants Associés --}}
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Enseignants responsables</h6>
                </div>
                <div class="card-body">
                    @if($module->enseignants->isNotEmpty())
                        <div class="list-group">
                            @foreach($module->enseignants as $enseignant)
                                <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $enseignant->nom }} {{ $enseignant->prenom }}</h6>
                                        <small class="text-muted">{{ $enseignant->grade }}</small>
                                    </div>
                                    <i class="bx bx-link-external text-gray-400"></i>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center">
                            <i class="bx bx-user-x fa-2x text-gray-400 my-2"></i>
                            <p class="text-muted">Aucun enseignant n'est encore associé à ce module.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
