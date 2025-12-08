@extends('layouts.admin')

@section('titre', 'Profil Enseignant')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Profil de {{ $enseignant->nom }} {{ $enseignant->prenom }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6>Informations personnelles</h6>
                <p><strong>Email Pro:</strong> {{ $enseignant->email_pro }}</p>
                <p><strong>Téléphone Pro:</strong> {{ $enseignant->telephone_pro ?? 'N/A' }}</p>
                <p><strong>Statut:</strong> {{ $enseignant->statut }}</p>
                <p><strong>Bureau:</strong> {{ $enseignant->bureau ?? 'N/A' }}</p>
                <p><strong>Département:</strong> {{ $enseignant->departement->nom ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <h6>Compte utilisateur</h6>
                @if ($enseignant->user)
                    <p><strong>Nom d'utilisateur:</strong> {{ $enseignant->user->nom }} {{ $enseignant->user->prenom }}</p>
                    <p><strong>Email du compte:</strong> {{ $enseignant->user->email }}</p>
                    <p><strong>Rôles:</strong> 
                        @foreach($enseignant->user->getRoleNames() as $role)
                            <span class="badge bg-primary">{{ $role }}</span>
                        @endforeach
                    </p>
                @else
                    <p class="text-warning">Aucun compte utilisateur associé.</p>
                @endif
            </div>
        </div>

        <h6 class="mt-4">Cours dispensés</h6>
        @if($enseignant->cours->isNotEmpty())
        <ul class="list-group mb-3">
            @foreach($enseignant->cours as $cours)
            <li class="list-group-item">
                <strong>{{ $cours->module->libelle ?? 'Module inconnu' }}</strong> ({{ $cours->annee_academique }} - {{ $cours->type_cours }})
                <br> {{ $cours->jour }} de {{ $cours->heure_debut }} à {{ $cours->heure_fin }} en salle {{ $cours->salle->nom_salle ?? 'N/A' }}
            </li>
            @endforeach
        </ul>
        @else
        <p>Aucun cours affecté pour le moment.</p>
        @endif

        <h6 class="mt-4">Stages tutorés</h6>
        @if($enseignant->stages->isNotEmpty())
        <ul class="list-group">
            @foreach($enseignant->stages as $stage)
            <li class="list-group-item">
                <strong>{{ $stage->sujet_stage }}</strong> ({{ $stage->date_debut }} - {{ $stage->date_fin }})
                <br> Étudiant: {{ $stage->inscriptionAdmin->etudiant->nom ?? 'N/A' }} {{ $stage->inscriptionAdmin->etudiant->prenom ?? '' }}
                chez {{ $stage->entreprise->nom_entreprise ?? 'N/A' }}
            </li>
            @endforeach
        </ul>
        @else
        <p>Aucun stage tutoré pour le moment.</p>
        @endif

        <div class="mt-4">
            <a href="{{ route('personnes.enseignants.edit', $enseignant) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('personnes.enseignants.index') }}" class="btn btn-label-secondary">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
