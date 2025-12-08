@csrf
<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label" for="libelle">Libellé du module</label>
        <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $module->libelle ?? '') }}" required />
        @error('libelle') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="code_module">Code du module</label>
        <input type="text" class="form-control @error('code_module') is-invalid @enderror" id="code_module" name="code_module" value="{{ old('code_module', $module->code_module ?? '') }}" required />
        @error('code_module') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="id_ue">Unité d'Enseignement (UE) de rattachement</label>
        <select name="id_ue" id="id_ue" class="form-select @error('id_ue') is-invalid @enderror" required>
            <option value="">Sélectionnez une UE</option>
            @foreach($ues as $ue)
                <option value="{{ $ue->id }}" @selected(old('id_ue', $module->id_ue ?? '') == $ue->id)>
                    {{ $ue->code_ue }} - {{ $ue->libelle }} ({{ $ue->semestre->parcours->nom ?? 'N/A' }} - {{ $ue->semestre->niveau ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        @error('id_ue') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="volume_horaire">Volume Horaire (heures)</label>
        <input type="number" class="form-control @error('volume_horaire') is-invalid @enderror" id="volume_horaire" name="volume_horaire" value="{{ old('volume_horaire', $module->volume_horaire ?? '') }}" required min="0" />
        @error('volume_horaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="coefficient">Coefficient</label>
        <input type="number" step="0.1" class="form-control @error('coefficient') is-invalid @enderror" id="coefficient" name="coefficient" value="{{ old('coefficient', $module->coefficient ?? '') }}" required min="0" />
        @error('coefficient') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-3">
        <label class="form-label" for="enseignant_ids">Enseignants responsables</label>
        <select name="enseignant_ids[]" id="enseignant_ids" class="form-select" multiple>
            @foreach($enseignants as $enseignant)
                <option value="{{ $enseignant->id }}" @selected(in_array($enseignant->id, old('enseignant_ids', isset($module) ? $module->enseignants->pluck('id')->toArray() : [])))>
                    {{ $enseignant->nom }} {{ $enseignant->prenom }}
                </option>
            @endforeach
        </select>
        @error('enseignant_ids') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ isset($module) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('academique.modules.index') }}" class="btn btn-label-secondary">Annuler</a>
