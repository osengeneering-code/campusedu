@extends('layouts.admin')

@section('titre', 'Détails du Module')

@section('content')
<div class="container-fluid">

    {{-- Bannière de la filière parente --}}
    @if($module->ue->semestre->parcours->filiere && $module->ue->semestre->parcours->filiere->image_path)
    <div class="card shadow-sm mb-4">
        <img src="{{ $module->ue->semestre->parcours->filiere->image_path }}" class="card-img-top" alt="Bannière de {{ $module->ue->semestre->parcours->filiere->nom }}" style="max-height: 250px; object-fit: cover;">
    </div>
    @endif

    {{-- En-tête de la page --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Module : {{ $module->libelle }}</h1>
        <div>
            <a href="{{ route('academique.modules.edit', $module) }}" class="btn btn-warning btn-sm shadow-sm">
                <i class="bx bx-edit"></i> Modifier
            </a>
            <a href="{{ route('academique.modules.index') }}" class="btn btn-secondary btn-sm shadow-sm">
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
