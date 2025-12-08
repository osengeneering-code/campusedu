@csrf
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="libelle">Libellé de l'évaluation</label>
        <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $evaluation->libelle ?? '') }}" required />
        @error('libelle') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="date_evaluation">Date de l'évaluation</label>
        <input type="date" class="form-control @error('date_evaluation') is-invalid @enderror" id="date_evaluation" name="date_evaluation" value="{{ old('date_evaluation', optional($evaluation->date_evaluation)->format('Y-m-d') ?? '') }}" required />
        @error('date_evaluation') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="id_module">Module de rattachement</label>
        <select name="id_module" id="id_module" class="form-select @error('id_module') is-invalid @enderror" required>
            <option value="">Sélectionnez un module</option>
            @foreach($modules as $module)
                <option value="{{ $module->id }}" @selected(old('id_module', $evaluation->id_module ?? '') == $module->id)>
                    {{ $module->libelle }} ({{ $module->ue->semestre->parcours->nom ?? 'N/A' }} - {{ $module->ue->semestre->niveau ?? 'N/A' }})
                </option>
            @endforeach
        </select>
        @error('id_module') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="evaluation_type_id">Type d'évaluation</label>
        <select name="evaluation_type_id" id="evaluation_type_id" class="form-select @error('evaluation_type_id') is-invalid @enderror" required>
            <option value="">Sélectionnez un type</option>
            @foreach($evaluationTypes as $type)
                <option value="{{ $type->id }}" @selected(old('evaluation_type_id', $evaluation->evaluation_type_id ?? '') == $type->id)>
                    {{ $type->name }} (Barème: {{ $type->max_score }})
                </option>
            @endforeach
        </select>
        @error('evaluation_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="annee_academique">Année Académique</label>
        <input type="text" class="form-control @error('annee_academique') is-invalid @enderror" id="annee_academique" name="annee_academique" value="{{ old('annee_academique', $evaluation->annee_academique ?? '') }}" placeholder="Ex: 2023-2024" required />
        @error('annee_academique') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ isset($evaluation) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('gestion-cours.evaluations.index') }}" class="btn btn-label-secondary">Annuler</a>
