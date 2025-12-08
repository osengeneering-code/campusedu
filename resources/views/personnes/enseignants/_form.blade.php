@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nom">Nom</label>
        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $enseignant->nom ?? '') }}" required />
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="prenom">Prénom</label>
        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $enseignant->prenom ?? '') }}" required />
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="email_pro">Email Professionnel</label>
        <input type="email" class="form-control @error('email_pro') is-invalid @enderror" id="email_pro" name="email_pro" value="{{ old('email_pro', $enseignant->email_pro ?? '') }}" required />
        @error('email_pro') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="telephone_pro">Téléphone Professionnel</label>
        <input type="text" class="form-control @error('telephone_pro') is-invalid @enderror" id="telephone_pro" name="telephone_pro" value="{{ old('telephone_pro', $enseignant->telephone_pro ?? '') }}" />
        @error('telephone_pro') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="statut">Statut</label>
        <select name="statut" id="statut" class="form-select @error('statut') is-invalid @enderror" required>
            <option value="">Sélectionnez un statut</option>
            @foreach(['Permanent', 'Vacataire', 'Chercheur'] as $statut)
                <option value="{{ $statut }}" @selected(old('statut', $enseignant->statut ?? '') == $statut)>{{ $statut }}</option>
            @endforeach
        </select>
        @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="bureau">Bureau</label>
        <input type="text" class="form-control @error('bureau') is-invalid @enderror" id="bureau" name="bureau" value="{{ old('bureau', $enseignant->bureau ?? '') }}" />
        @error('bureau') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="id_departement_rattachement">Département de Rattachement</label>
    <select name="id_departement_rattachement" id="id_departement_rattachement" class="form-select @error('id_departement_rattachement') is-invalid @enderror">
        <option value="">Sélectionnez un département (optionnel)</option>
        @foreach($departements as $departement)
            <option value="{{ $departement->id }}" @selected(old('id_departement_rattachement', $enseignant->id_departement_rattachement ?? '') == $departement->id)>
                {{ $departement->nom }}
            </option>
        @endforeach
    </select>
    @error('id_departement_rattachement') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="id_user">Associer à un compte utilisateur existant (optionnel)</label>
    <select name="id_user" id="id_user" class="form-select @error('id_user') is-invalid @enderror">
        <option value="">Ne pas associer ou créer un nouveau compte</option>
        @foreach($usersSansEnseignant as $user)
            <option value="{{ $user->id }}" @selected(old('id_user', $enseignant->id_user ?? '') == $user->id)>
                {{ $user->nom }} {{ $user->prenom }} ({{ $user->email }})
            </option>
        @endforeach
    </select>
    <small class="form-text text-muted">Si aucun compte n'est sélectionné et que c'est une création, un nouveau compte utilisateur sera créé avec l'email et un mot de passe temporaire.</small>
    @error('id_user') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

@if (!isset($enseignant) || !$enseignant->id_user) {{-- Si création ou pas d'utilisateur associé --}}
<div id="new-user-fields" class="mt-3">
    <h5>Créer un nouveau compte utilisateur (si non associé)</h5>
    <div class="mb-3">
        <label class="form-label" for="user_email">Email du compte utilisateur</label>
        <input type="email" class="form-control @error('user_email') is-invalid @enderror" id="user_email" name="user_email" value="{{ old('user_email') }}" />
        @error('user_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="mb-3">
        <label class="form-label" for="user_password">Mot de passe</label>
        <input type="password" class="form-control @error('user_password') is-invalid @enderror" id="user_password" name="user_password" />
        @error('user_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
@endif

<button type="submit" class="btn btn-primary">{{ isset($enseignant) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('personnes.enseignants.index') }}" class="btn btn-label-secondary">Annuler</a>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const idUserSelect = document.getElementById('id_user');
        const newUserFields = document.getElementById('new-user-fields');

        function toggleNewUserFields() {
            if (idUserSelect.value === '' && !{{ isset($enseignant) && $enseignant->id_user ? 'true' : 'false' }}) {
                newUserFields.style.display = 'block';
                newUserFields.querySelectorAll('input').forEach(input => input.setAttribute('required', 'required'));
            } else {
                newUserFields.style.display = 'none';
                newUserFields.querySelectorAll('input').forEach(input => input.removeAttribute('required'));
            }
        }

        idUserSelect.addEventListener('change', toggleNewUserFields);
        toggleNewUserFields(); // Appeler au chargement de la page
    });
</script>
