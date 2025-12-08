@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="id_etudiant" class="form-label">Étudiant</label>
        <select id="id_etudiant" name="id_etudiant" class="form-select @error('id_etudiant') is-invalid @enderror" required>
            <option value="">Sélectionnez un étudiant</option>
            @foreach($etudiants as $etudiant)
            <option value="{{ $etudiant->id }}" @selected(old('id_etudiant', $inscriptionAdmin->id_etudiant ?? '') == $etudiant->id)>
                {{ $etudiant->nom }} {{ $etudiant->prenom }} ({{ $etudiant->matricule }})
            </option>
            @endforeach
        </select>
        @error('id_etudiant') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="id_parcours" class="form-label">Parcours</label>
        <select id="id_parcours" name="id_parcours" class="form-select @error('id_parcours') is-invalid @enderror" required>
            <option value="">Sélectionnez un parcours</option>
            @foreach($parcours as $p)
            <option value="{{ $p->id }}" @selected(old('id_parcours', $inscriptionAdmin->id_parcours ?? '') == $p->id)>
                {{ $p->nom }} ({{ $p->filiere->nom ?? '' }})
            </option>
            @endforeach
        </select>
        @error('id_parcours') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="annee_academique" class="form-label">Année Académique</label>
        <input type="text" id="annee_academique" name="annee_academique" class="form-control @error('annee_academique') is-invalid @enderror" value="{{ old('annee_academique', $inscriptionAdmin->annee_academique ?? date('Y').'-'.(date('Y')+1)) }}" required>
        @error('annee_academique') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="date_inscription" class="form-label">Date d'inscription</label>
        <input type="date" id="date_inscription" name="date_inscription" class="form-control @error('date_inscription') is-invalid @enderror" value="{{ old('date_inscription', isset($inscriptionAdmin) ? \Carbon\Carbon::parse($inscriptionAdmin->date_inscription)->format('Y-m-d') : \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
        @error('date_inscription') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="statut" class="form-label">Statut</label>
    <select id="statut" name="statut" class="form-select @error('statut') is-invalid @enderror" required>
        @foreach(['Inscrit', 'Redoublant', 'Réorienté', 'Archivé'] as $statut)
        <option value="{{ $statut }}" @selected(old('statut', $inscriptionAdmin->statut ?? '') == $statut)>
            {{ $statut }}
        </option>
        @endforeach
    </select>
    @error('statut') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

{{-- Section pour la création automatique du compte utilisateur --}}
@unless(isset($inscriptionAdmin) && $inscriptionAdmin->etudiant && $inscriptionAdmin->etudiant->user) {{-- Ne pas montrer si l'étudiant a déjà un compte --}}
<div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="creer_compte_utilisateur" name="creer_compte_utilisateur" value="1" {{ old('creer_compte_utilisateur') ? 'checked' : '' }}>
    <label class="form-check-label" for="creer_compte_utilisateur">Créer un compte utilisateur pour cet étudiant</label>
</div>

<div id="user_account_fields" style="display: {{ old('creer_compte_utilisateur') ? 'block' : 'none' }};">
    <div class="mb-3">
        <label for="email_compte_user" class="form-label">Email de connexion du compte utilisateur</label>
        <input type="email" class="form-control @error('email_compte_user') is-invalid @enderror" id="email_compte_user" name="email_compte_user" value="{{ old('email_compte_user') }}">
        @error('email_compte_user') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkbox = document.getElementById('creer_compte_utilisateur');
        const fields = document.getElementById('user_account_fields');

        checkbox.addEventListener('change', function() {
            if (this.checked) {
                fields.style.display = 'block';
            } else {
                fields.style.display = 'none';
            }
        });
    });
</script>
@endunless

<button type="submit" class="btn btn-primary">{{ isset($inscriptionAdmin) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('inscriptions.inscription-admins.index') }}" class="btn btn-label-secondary">Annuler</a>