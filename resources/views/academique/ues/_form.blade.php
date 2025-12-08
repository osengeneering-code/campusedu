@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="libelle">Libellé de l'UE</label>
        <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $ue->libelle ?? '') }}" required />
        @error('libelle')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="code_ue">Code de l'UE</label>
        <input type="text" class="form-control @error('code_ue') is-invalid @enderror" id="code_ue" name="code_ue" value="{{ old('code_ue', $ue->code_ue ?? '') }}" required />
        @error('code_ue')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="id_semestre">Semestre de rattachement</label>
        <select name="id_semestre" id="id_semestre" class="form-select @error('id_semestre') is-invalid @enderror" required>
            <option value="">Sélectionnez un semestre</option>
            @foreach($semestres as $semestre)
                <option value="{{ $semestre->id }}" @selected(old('id_semestre', $ue->id_semestre ?? '') == $semestre->id)>
                    {{ $semestre->parcours->filiere->nom ?? '' }} - {{ $semestre->parcours->nom ?? '' }} - {{ $semestre->niveau }} - {{ $semestre->libelle }}
                </option>
            @endforeach
        </select>
        @error('id_semestre')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="credits_ects">Crédits ECTS</label>
        <input type="number" class="form-control @error('credits_ects') is-invalid @enderror" id="credits_ects" name="credits_ects" value="{{ old('credits_ects', $ue->credits_ects ?? '') }}" required min="0" />
        @error('credits_ects')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary">
    <i class="bx bx-save me-1"></i> {{ isset($ue) ? 'Mettre à jour' : 'Enregistrer' }}
</button>
<a href="{{ route('academique.ues.index') }}" class="btn btn-label-secondary">Annuler</a>
