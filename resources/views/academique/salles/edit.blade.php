@extends('layouts.admin')

@section('titre', 'Modifier Salle')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Académique / Salles /</span> Modifier
    </h4>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Modifier la Salle : {{ $salle->nom_salle }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('academique.salles.update', $salle) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="nom_salle">Nom de la Salle</label>
                    <input type="text" class="form-control @error('nom_salle') is-invalid @enderror" id="nom_salle" name="nom_salle" value="{{ old('nom_salle', $salle->nom_salle) }}" placeholder="Ex: Salle A101" required />
                    @error('nom_salle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="capacite">Capacité</label>
                    <input type="number" class="form-control @error('capacite') is-invalid @enderror" id="capacite" name="capacite" value="{{ old('capacite', $salle->capacite) }}" placeholder="Ex: 30" required />
                    @error('capacite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="type_salle">Type de Salle</label>
                    <select class="form-select @error('type_salle') is-invalid @enderror" id="type_salle" name="type_salle">
                        <option value="">Sélectionner un type</option>
                        <option value="Amphithéâtre" {{ old('type_salle', $salle->type_salle) == 'Amphithéâtre' ? 'selected' : '' }}>Amphithéâtre</option>
                        <option value="Salle de TD" {{ old('type_salle', $salle->type_salle) == 'Salle de TD' ? 'selected' : '' }}>Salle de TD</option>
                        <option value="Salle TP" {{ old('type_salle', $salle->type_salle) == 'Salle TP' ? 'selected' : '' }}>Salle TP</option>
                        <option value="Bureau" {{ old('type_salle', $salle->type_salle) == 'Bureau' ? 'selected' : '' }}>Bureau</option>
                    </select>
                    @error('type_salle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('academique.salles.index') }}" class="btn btn-label-secondary">Annuler</a>
            </form>
        </div>
    </div>
</div>
@endsection
