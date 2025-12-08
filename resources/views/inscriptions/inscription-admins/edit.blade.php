@extends('layouts.admin')

@section('titre', 'Modifier l\'Inscription Administrative')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier l\'Inscription Administrative de {{ $inscriptionAdmin->etudiant->nom ?? 'N/A' }} {{ $inscriptionAdmin->etudiant->prenom ?? '' }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('inscriptions.inscription-admins.update', $inscriptionAdmin) }}" method="POST">
            @csrf
            @method('PUT') {{-- Pour les requêtes de mise à jour --}}
            @include('inscriptions.inscription-admins._form', ['inscriptionAdmin' => $inscriptionAdmin])
            <button type="submit" class="btn btn-primary mt-3">Mettre à jour l\'Inscription</button>
            <a href="{{ route('inscriptions.inscription-admins.index') }}" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>
</div>
@endsection