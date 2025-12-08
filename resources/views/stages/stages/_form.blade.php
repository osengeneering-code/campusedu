@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="id_inscription_admin" class="form-label">Étudiant (Inscription Annuelle)</label>
        <select id="id_inscription_admin" name="id_inscription_admin" class="form-select @error('id_inscription_admin') is-invalid @enderror" required>
            <option value="">Sélectionnez un étudiant</option>
            @foreach($inscriptions as $inscription)
            <option value="{{ $inscription->id }}" @selected(old('id_inscription_admin', $stage->id_inscription_admin ?? '') == $inscription->id)>
                {{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }} ({{ $inscription->annee_academique }})
            </option>
            @endforeach
        </select>
        @error('id_inscription_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="id_entreprise" class="form-label">Entreprise</label>
        <select id="id_entreprise" name="id_entreprise" class="form-select @error('id_entreprise') is-invalid @enderror" required>
            <option value="">Sélectionnez une entreprise</option>
            @foreach($entreprises as $entreprise)
            <option value="{{ $entreprise->id }}" @selected(old('id_entreprise', $stage->id_entreprise ?? '') == $entreprise->id)>
                {{ $entreprise->nom_entreprise }}
            </option>
            @endforeach
        </select>
        @error('id_entreprise') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label for="sujet_stage" class="form-label">Sujet du stage</label>
    <textarea id="sujet_stage" name="sujet_stage" class="form-control @error('sujet_stage') is-invalid @enderror" required>{{ old('sujet_stage', $stage->sujet_stage ?? '') }}</textarea>
    @error('sujet_stage') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="date_debut" class="form-label">Date de début</label>
        <input type="date" id="date_debut" name="date_debut" class="form-control @error('date_debut') is-invalid @enderror" value="{{ old('date_debut', isset($stage) ? \Carbon\Carbon::parse($stage->date_debut)->format('Y-m-d') : '') }}" required>
        @error('date_debut') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="date_fin" class="form-label">Date de fin</label>
        <input type="date" id="date_fin" name="date_fin" class="form-control @error('date_fin') is-invalid @enderror" value="{{ old('date_fin', isset($stage) ? \Carbon\Carbon::parse($stage->date_fin)->format('Y-m-d') : '') }}" required>
        @error('date_fin') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="id_enseignant_tuteur" class="form-label">Enseignant Tuteur</label>
        <select id="id_enseignant_tuteur" name="id_enseignant_tuteur" class="form-select @error('id_enseignant_tuteur') is-invalid @enderror" required>
             <option value="">Sélectionnez un tuteur</option>
            @foreach($enseignants as $enseignant)
            <option value="{{ $enseignant->id }}" @selected(old('id_enseignant_tuteur', $stage->id_enseignant_tuteur ?? '') == $enseignant->id)>
                {{ $enseignant->nom }} {{ $enseignant->prenom }}
            </option>
            @endforeach
        </select>
        @error('id_enseignant_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="nom_tuteur_entreprise" class="form-label">Nom du Tuteur en Entreprise</label>
        <input type="text" id="nom_tuteur_entreprise" name="nom_tuteur_entreprise" class="form-control @error('nom_tuteur_entreprise') is-invalid @enderror" value="{{ old('nom_tuteur_entreprise', $stage->nom_tuteur_entreprise ?? '') }}">
        @error('nom_tuteur_entreprise') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

@if(isset($stage))
<div class="mb-3">
    <label for="statut_validation" class="form-label">Statut de validation</label>
    <select id="statut_validation" name="statut_validation" class="form-select">
        @foreach(['En attente', 'Validé par tuteur', 'Validé par admin', 'Refusé'] as $statut)
        <option value="{{ $statut }}" @selected($stage->statut_validation == $statut)>{{ $statut }}</option>
        @endforeach
    </select>
</div>
@endif

<button type="submit" class="btn btn-primary">{{ isset($stage) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('stages.stages.index') }}" class="btn btn-label-secondary">Annuler</a>
