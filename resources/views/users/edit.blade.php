@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Modifier l'utilisateur : {{ $user->prenom }} {{ $user->nom }}</h5>
                @role('admin')
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Retour à la liste</a>
                @endrole
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        {{-- Section pour la photo de profil --}}
                        <div class="col-md-12 mb-4 text-center">
                            <img src="{{ $user->profile_photo_url }}" alt="Photo de profil" class="img-fluid rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="mt-3">
                                <label for="profile_photo" class="form-label">Changer la photo de profil</label>
                                <input class="form-control @error('profile_photo') is-invalid @enderror" type="file" id="profile_photo" name="profile_photo">
                                @error('profile_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="entreprise_id" class="form-label">Entreprise</label>
                            <select name="entreprise_id" id="entreprise_id" class="form-select @error('entreprise_id') is-invalid @enderror">
                                <option value="">Sélectionner une entreprise</option>
                                @foreach ($entreprises as $entreprise)
                                    <option value="{{ $entreprise->id }}" {{ old('entreprise_id', $user->entreprise_id) == $entreprise->id ? 'selected' : '' }}>{{ $entreprise->nom }}</option>
                                @endforeach
                            </select>
                            @error('entreprise_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom', $user->nom) }}" placeholder="Nom de l'utilisateur">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" id="prenom" class="form-control @error('prenom') is-invalid @enderror" value="{{ old('prenom', $user->prenom) }}" placeholder="Prénom de l'utilisateur">
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" placeholder="Email de l'utilisateur">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mot de passe">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror" value="{{ old('telephone', $user->telephone) }}" placeholder="Numéro de téléphone">
                            @error('telephone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea name="adresse" id="adresse" class="form-control @error('adresse') is-invalid @enderror" rows="3" placeholder="Adresse de l'utilisateur">{{ old('adresse', $user->adresse) }}</textarea>
                            @error('adresse')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="statut" class="form-label">Statut</label>
                            <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror">
                                <option value="">Sélectionner un statut</option>
                                @foreach ($userStatuses as $status)
                                    <option value="{{ $status->value }}" {{ old('statut', $user->statut) == $status->value ? 'selected' : '' }}>{{ $status->value }}</option>
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
                                    <option value="{{ $partenaire->id }}" {{ old('partenaire_id', $user->partenaire_id) == $partenaire->id ? 'selected' : '' }}>{{ $partenaire->nom_partenaire }}</option>
                                @endforeach
                            </select>
                            @error('partenaire_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="roles" class="form-label">Rôles</label>
                            @role('admin')
                                <select name="roles[]" id="roles" class="form-select @error('roles') is-invalid @enderror" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" {{ in_array($role->name, old('roles', $user->getRoleNames()->toArray())) ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <select name="roles[]" id="roles" class="form-select" multiple disabled>
                                    @foreach ($user->roles as $role)
                                        <option value="{{ $role->name }}" selected>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-muted mt-2">Seul un administrateur peut modifier les rôles.</p>
                            @endrole
                            @error('roles')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-success me-2">Mettre à jour l'utilisateur</button>
                        <button type="reset" class="btn btn-label-secondary">Annuler</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection