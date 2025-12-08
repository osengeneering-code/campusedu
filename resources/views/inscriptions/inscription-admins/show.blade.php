@extends('layouts.admin')

@section('titre', 'Détails de l\'Inscription Administrative')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Détails de l\'Inscription Administrative</h5>
        <div>
            {{-- Boutons pour actions sur l\'inscription administrative (ex: valider paiement, etc.) --}}
            {{-- Ces boutons seront ajoutés plus tard par le comptable --}}
            <a href="{{ route('inscriptions.inscription-admins.edit', $inscriptionAdmin) }}" class="btn btn-warning btn-sm">Modifier</a>
            <a href="{{ route('inscriptions.inscription-admins.index') }}" class="btn btn-secondary btn-sm">Retour</a>
        </div>
    </div>
    <div class="card-body">
        <h6 class="pb-1 mb-4">Informations de l\'Inscription</h6>
        <dl class="row">
            <dt class="col-sm-3">Étudiant:</dt>
            <dd class="col-sm-9">{{ $inscriptionAdmin->etudiant->nom ?? 'N/A' }} {{ $inscriptionAdmin->etudiant->prenom ?? '' }} (Matricule: {{ $inscriptionAdmin->etudiant->matricule ?? 'N/A' }})</dd>

            <dt class="col-sm-3">Parcours:</dt>
            <dd class="col-sm-9">{{ $inscriptionAdmin->parcours->nom ?? 'N/A' }} (Filière: {{ $inscriptionAdmin->parcours->filiere->nom ?? 'N/A' }})</dd>

            <dt class="col-sm-3">Année Académique:</dt>
            <dd class="col-sm-9">{{ $inscriptionAdmin->annee_academique }}</dd>

            <dt class="col-sm-3">Date d\'Inscription:</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($inscriptionAdmin->date_inscription)->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Statut:</dt>
            <dd class="col-sm-9">
                <span class="badge bg-label-{{ $inscriptionAdmin->statut == 'Inscrit' ? 'success' : ($inscriptionAdmin->statut == 'En attente de paiement' ? 'warning' : 'info') }}">
                    {{ $inscriptionAdmin->statut }}
                </span>
            </dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">Frais Associés au Parcours</h6>
        <dl class="row">
            <dt class="col-sm-3">Frais d\'Inscription:</dt>
            <dd class="col-sm-9">{{ number_format($inscriptionAdmin->parcours->frais_inscription ?? 0, 0, ',', ' ') }} F CFA</dd>

            <dt class="col-sm-3">Frais de Formation:</dt>
            <dd class="col-sm-9">{{ number_format($inscriptionAdmin->parcours->frais_formation ?? 0, 0, ',', ' ') }} F CFA</dd>

            <dt class="col-sm-3">Total à Payer:</dt>
            <dd class="col-sm-9">{{ number_format(($inscriptionAdmin->parcours->frais_inscription ?? 0) + ($inscriptionAdmin->parcours->frais_formation ?? 0), 0, ',', ' ') }} F CFA</dd>
        </dl>

        {{-- Section pour les paiements déjà effectués si nécessaire --}}
        {{-- <h6 class="pb-1 mb-4 mt-4">Historique des Paiements</h6> --}}
        {{-- ... tableau des paiements ... --}}

    </div>
</div>
@endsection
