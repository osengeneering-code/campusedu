@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nom">Nom</label>
        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $etudiant->nom ?? '') }}" required />
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="prenom">Prénom</label>
        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom ?? '') }}" required />
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="email_perso">Email Personnel</label>
        <input type="email" class="form-control @error('email_perso') is-invalid @enderror" id="email_perso" name="email_perso" value="{{ old('email_perso', $etudiant->email_perso ?? '') }}" required />
        @error('email_perso') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="telephone_perso">Téléphone Personnel</label>
        <input type="text" class="form-control @error('telephone_perso') is-invalid @enderror" id="telephone_perso" name="telephone_perso" value="{{ old('telephone_perso', $etudiant->telephone_perso ?? '') }}" />
        @error('telephone_perso') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="date_naissance">Date de Naissance</label>
        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance ?? '') }}" required />
        @error('date_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="lieu_naissance">Lieu de Naissance</label>
        <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $etudiant->lieu_naissance ?? '') }}" />
        @error('lieu_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="sexe">Sexe</label>
        <select name="sexe" id="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
            <option value="">Sélectionnez le sexe</option>
            @foreach(['M', 'F', 'Autre'] as $sexe)
                <option value="{{ $sexe }}" @selected(old('sexe', $etudiant->sexe ?? '') == $sexe)>{{ $sexe }}</option>
            @endforeach
        </select>
        @error('sexe') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="adresse_postale">Adresse Postale</label>
        <textarea class="form-control @error('adresse_postale') is-invalid @enderror" id="adresse_postale" name="adresse_postale">{{ old('adresse_postale', $etudiant->adresse_postale ?? '') }}</textarea>
        @error('adresse_postale') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

@if (!isset($etudiant)) {{-- Seulement pour la création --}}
<h5 class="mt-4">Informations de connexion</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="user_email">Email du compte utilisateur</label>
        <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" name="user_email" value="{{ old('user_email') }}" required />
        @error('user_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="user_password">Mot de passe</label>
        <input type="password" class="form-control @error('user_password') is-invalid @enderror" id="user_password" name="user_password" required />
        @error('user_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
@endif

<button type="submit" class="btn btn-primary">{{ isset($etudiant) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('personnes.etudiants.index') }}" class="btn btn-label-secondary">Annuler</a>
