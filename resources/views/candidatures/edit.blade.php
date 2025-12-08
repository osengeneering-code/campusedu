@extends('layouts.admin')

@section('titre', 'Modifier la Candidature')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Modifier la Candidature de {{ $candidature->prenom }} {{ $candidature->nom }}</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('inscriptions.candidatures.update', $candidature) }}" method="POST" enctype="multipart/form-data"> {{-- Important pour les uploads --}}
            @csrf
            @method('PUT')
            @include('candidatures._form', ['candidature' => $candidature, 'parcours' => $parcours, 'niveaux' => $niveaux]) {{-- Passage de parcours et niveaux --}}
            <button type="submit" class="btn btn-primary mt-3">Mettre à jour la Candidature</button>
            <a href="{{ route('inscriptions.candidatures.index') }}" class="btn btn-secondary mt-3">Annuler</a>
        </form>
    </div>
</div>
@endsection