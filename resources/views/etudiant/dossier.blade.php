@extends('layouts.admin')

@section('titre', 'Mon Dossier')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mon Espace /</span> Mon Dossier</h4>

    @if($etudiant)
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Informations Personnelles</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Matricule</label>
                            <p class="form-control-static">{{ $etudiant->matricule }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Nom Complet</label>
                            <p class="form-control-static">{{ $etudiant->prenom }} {{ $etudiant->nom }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Date de Naissance</label>
                            <p class="form-control-static">{{ $etudiant->date_naissance }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Lieu de Naissance</label>
                            <p class="form-control-static">{{ $etudiant->lieu_naissance }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Sexe</label>
                            <p class="form-control-static">{{ $etudiant->sexe == 'M' ? 'Masculin' : 'Féminin' }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Adresse Postale</label>
                            <p class="form-control-static">{{ $etudiant->adresse_postale }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Email Personnel</label>
                            <p class="form-control-static">{{ $etudiant->email_perso }}</p>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Téléphone Personnel</label>
                            <p class="form-control-static">{{ $etudiant->telephone_perso }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <h5 class="card-header">Inscriptions Administratives</h5>
                <div class="card-body">
                    @if($etudiant->inscriptionAdmins->isEmpty())
                        <p>Aucune inscription administrative trouvée pour cet étudiant.</p>
                    @else
                        @foreach($etudiant->inscriptionAdmins as $inscription)
                            <div class="border p-3 mb-3 rounded">
                                <h6 class="pb-2 mb-2 border-bottom">Inscription pour l'année {{ $inscription->annee_academique }}</h6>
                                <div class="row">
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label">Date d'inscription</label>
                                        <p class="form-control-static">{{ \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') }}</p>
                                    </div>
                                    <div class="mb-2 col-md-6">
                                        <label class="form-label">Statut</label>
                                        <p class="form-control-static">{{ ucfirst($inscription->statut) }}</p>
                                    </div>
                                    <div class="mb-2 col-md-12">
                                        <label class="form-label">Parcours</label>
                                        <p class="form-control-static">
                                            @if($inscription->parcours)
                                                {{ $inscription->parcours->nom }} (Filière: {{ $inscription->parcours->filiere->nom ?? 'N/A' }})
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
        <p>Impossible de charger le dossier de l'étudiant. Veuillez contacter l'administration.</p>
    @endif
</div>
@endsection
