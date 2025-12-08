@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Créer un nouvel utilisateur</h5>
                <a href="{{ route('users.index') }}" class="btn btn-primary">Retour à la liste</a>
            </div>
            <div class="card-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="entreprise_id" class="form-label">Entreprise</label>
                            <select name="entreprise_id" id="entreprise_id" class="form-select @error('entreprise_id') is-invalid @enderror">
                                <option value="">Sélectionner une entreprise</option>
                                @foreach ($entreprises as $entreprise)
                                    <option value="{{ $entreprise->id }}" {{ old('entreprise_id') == $entreprise->id ? 'selected' : '' }}>{{ $entreprise->nom }}</option>
                                @endforeach
                            </select>
                            @error('entreprise_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}" placeholder="Nom de l'utilisateur">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom') }}" placeholder="Prénom de l'utilisateur">
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email de l'utilisateur">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone') }}" placeholder="Numéro de téléphone">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="3" placeholder="Adresse de l'utilisateur">{{ old('adresse') }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                                <option value="">Sélectionner un statut</option>
                                @foreach ($userStatuses as $status)
                                    <option value="{{ $status->value }}" {{ old('statut') == $status->value ? 'selected' : '' }}>{{ $status->value }}</option>
                                @endforeach
                            </select>
                            @error('statut')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="partenaire_id" class="form-label">Partenaire (Optionnel)</label>
                            <select name="partenaire_id" id="partenaire_id" class="form-select @error('partenaire_id') is-invalid @enderror">
                                <option value="">Sélectionner un partenaire</option>
                                @foreach ($partenaires as $partenaire)
                                    <option value="{{ $partenaire->id }}" {{ old('partenaire_id') == $partenaire->id ? 'selected' : '' }}>{{ $partenaire->nom_partenaire }}</option>
                                @endforeach
                            </select>
                            @error('partenaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="roles" class="form-label">Rôles</label>
                            <select name="roles[]" id="roles" class="form-select @error('roles') is-invalid @enderror" multiple>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', [])) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success me-2">Créer l'utilisateur</button>
                        <button type="reset" class="btn btn-label-secondary">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection