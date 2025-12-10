@extends('layouts.admin')

@section('titre', 'Détails de l\'entreprise')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">{{ $entreprise->nom_entreprise }}</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Secteur d\'activité:</strong> {{ $entreprise->secteur_activite }}</p>
                <p><strong>Adresse:</strong> {{ $entreprise->adresse }}</p>
                <p><strong>Code Postal:</strong> {{ $entreprise->code_postal }}</p>
                <p><strong>Ville:</strong> {{ $entreprise->ville }}</p>
                <p><strong>Pays:</strong> {{ $entreprise->pays }}</p>
                <p><strong>Téléphone:</strong> {{ $entreprise->telephone }}</p>
                <p><strong>Email de contact:</strong> {{ $entreprise->email_contact }}</p>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <a href="{{ route('stages.entreprises.index') }}" class="btn btn-label-secondary">Retour à la liste</a>
        <a href="{{ route('stages.entreprises.edit', $entreprise->id) }}" class="btn btn-primary">Éditer</a>
    </div>
</div>
@endsection
