@csrf
<div class="row">
    <div class="col-md-8 mb-3">
        <label class="form-label" for="name">Nom du type d'évaluation</label>
        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $evaluationType->name ?? '') }}" required />
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-4 mb-3">
        <label class="form-label" for="max_score">Barème Max</label>
        <input type="number" class="form-control @error('max_score') is-invalid @enderror" id="max_score" name="max_score" value="{{ old('max_score', $evaluationType->max_score ?? '') }}" required min="1" />
        @error('max_score') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<button type="submit" class="btn btn-primary">{{ isset($evaluationType) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('academique.evaluation-types.index') }}" class="btn btn-label-secondary">Annuler</a>
