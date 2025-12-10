@extends('layouts.admin')

@section('titre', 'Détails du Parcours')

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
    @if($parcours->filiere && $parcours->filiere->image_path)
    <div class="hero-banner" style="background-image: url('{{ Storage::url($parcours->filiere->image_path) }}');">
        <div class="hero-banner-content">
            <h1 class="hero-banner-title">{{ $parcours->filiere->nom ?? 'Filière' }}</h1>
            <p class="hero-banner-subtitle">Parcours : {{ $parcours->nom }}</p>
        </div>
    </div>
    @endif



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
