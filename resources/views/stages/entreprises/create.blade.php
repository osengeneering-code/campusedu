@extends('layouts.admin')

@section('titre', 'Nouvelle Entreprise')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ajouter une nouvelle entreprise</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('stages.entreprises.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom_entreprise" class="form-label">Nom de l'entreprise</label>
                    <input type="text" id="nom_entreprise" name="nom_entreprise" class="form-control" value="{{ old('nom_entreprise') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="secteur_activite" class="form-label">Secteur d'activité</label>
                    <input type="text" id="secteur_activite" name="secteur_activite" class="form-control" value="{{ old('secteur_activite') }}">
                </div>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" id="adresse" name="adresse" class="form-control" value="{{ old('adresse') }}">
            </div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="code_postal" class="form-label">Code Postal</label>
                    <input type="text" id="code_postal" name="code_postal" class="form-control" value="{{ old('code_postal') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="ville" class="form-label">Ville</label>
                    <input type="text" id="ville" name="ville" class="form-control" value="{{ old('ville') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label for="pays" class="form-label">Pays</label>
                    <input type="text" id="pays" name="pays" class="form-control" value="{{ old('pays') }}">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="text" id="telephone" name="telephone" class="form-control" value="{{ old('telephone') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email_contact" class="form-label">Email de contact</label>
                    <input type="email" id="email_contact" name="email_contact" class="form-control" value="{{ old('email_contact') }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('stages.entreprises.index') }}" class="btn btn-label-secondary">Annuler</a>
        </form>
    </div>
</div>
@endsection
