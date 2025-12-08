@extends('layouts.admin')

@section('titre', 'Détails du Paiement')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Détails du paiement #{{ $paiement->reference_paiement }}</h5>
    </div>
    <div class="card-body">
        <p><strong>Étudiant:</strong> {{ $paiement->inscriptionAdmin->etudiant->nom }} {{ $paiement->inscriptionAdmin->etudiant->prenom }}</p>
        <p><strong>Année Académique:</strong> {{ $paiement->inscriptionAdmin->annee_academique }}</p>
        <p><strong>Montant:</strong> {{ number_format($paiement->montant, 2, ',', ' ') }} F CFA</p>
        <p><strong>Type de frais:</strong> {{ $paiement->type_frais }}</p>
        <p><strong>Date de paiement:</strong> {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</p>
        <p><strong>Méthode:</strong> {{ $paiement->methode_paiement }}</p>
        <p><strong>Statut:</strong> <span class="badge bg-label-{{ $paiement->statut_paiement == 'Payé' ? 'success' : 'warning' }}">{{ $paiement->statut_paiement }}</span></p>
        
        <div class="mt-4">
            <a href="{{ route('paiements.edit', $paiement) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('paiements.receipt', $paiement) }}" class="btn btn-info" target="_blank">Télécharger Reçu</a>
            <a href="{{ route('paiements.index') }}" class="btn btn-label-secondary">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
