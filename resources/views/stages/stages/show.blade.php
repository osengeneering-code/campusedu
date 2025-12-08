@extends('layouts.admin')

@section('titre', 'Détails du Stage')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Détails du stage</h5>
            </div>
            <div class="card-body">
                <p><strong>Étudiant:</strong> {{ $stage->inscriptionAdmin->etudiant->nom }} {{ $stage->inscriptionAdmin->etudiant->prenom }}</p>
                <p><strong>Entreprise:</strong> {{ $stage->entreprise->nom_entreprise }}</p>
                <p><strong>Sujet:</strong> {{ $stage->sujet_stage }}</p>
                <p><strong>Dates:</strong> du {{ \Carbon\Carbon::parse($stage->date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($stage->date_fin)->format('d/m/Y') }}</p>
                <p><strong>Tuteur Pédagogique:</strong> {{ $stage->enseignant->nom }} {{ $stage->enseignant->prenom }}</p>
                <p><strong>Tuteur Entreprise:</strong> {{ $stage->nom_tuteur_entreprise ?? 'Non spécifié' }}</p>
                <p><strong>Statut:</strong> <span class="badge bg-label-primary">{{ $stage->statut_validation }}</span></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card mb-4">
             <div class="card-header"><h5 class="mb-0">Convention</h5></div>
             <div class="card-body">
                @if($stage->convention)
                    <p>Convention générée le {{ $stage->convention->date_generation }}</p>
                    <p>Statut: {{ $stage->convention->statut_signature }}</p>
                    <a href="{{-- route to download --}}" class="btn btn-sm btn-outline-primary">Télécharger</a>
                @else
                    <p>Aucune convention générée.</p>
                    @can('gerer_stages')
                    <a href="{{-- route to generate convention --}}" class="btn btn-sm btn-primary">Générer la convention</a>
                    @endcan
                @endif
             </div>
        </div>
        <div class="card">
            <div class="card-header"><h5 class="mb-0">Soutenance</h5></div>
            <div class="card-body">
                @if($stage->soutenance)
                    <p>Soutenance prévue le {{ $stage->soutenance->date_soutenance }}</p>
                    <p>Note finale: {{ $stage->soutenance->note_finale ?? 'Non notée' }} / 20</p>
                @else
                    <p>Aucune soutenance planifiée.</p>
                    @can('gerer_stages')
                    <a href="{{-- route to plan soutenance --}}" class="btn btn-sm btn-primary">Planifier la soutenance</a>
                    @endcan
                @endif
            </div>
        </div>
    </div>
</div>
<div class="mt-2">
    <a href="{{ route('stages.stages.index') }}" class="btn btn-label-secondary">Retour à la liste</a>
</div>
@endsection
