@extends('layouts.admin')

@section('titre', 'Créer une Salle')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Académique / Salles /</span> Créer
    </h4>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Nouvelle Salle</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('academique.salles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="nom_salle">Nom de la Salle</label>
                    <input type="text" class="form-control @error('nom_salle') is-invalid @enderror" id="nom_salle" name="nom_salle" value="{{ old('nom_salle') }}" placeholder="Ex: Salle A101" required />
                    @error('nom_salle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="capacite">Capacité</label>
                    <input type="number" class="form-control @error('capacite') is-invalid @enderror" id="capacite" name="capacite" value="{{ old('capacite') }}" placeholder="Ex: 30" required />
                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="type_salle">Type de Salle</label>
                    <input type="text" class="form-control @error('type_salle') is-invalid @enderror" id="type_salle" name="type_salle" value="{{ old('type_salle') }}" placeholder="Ex: Salle de cours, Laboratoire" />
                    @error('type_salle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('academique.salles.index') }}" class="btn btn-label-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
