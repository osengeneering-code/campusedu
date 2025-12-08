@csrf
<div class="mb-3">
    <label class="form-label" for="nom">Nom du parcours</label>
    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $parcours->nom ?? '') }}" required />
    @error('nom')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="id_filiere">Filière de rattachement</label>
    <select name="id_filiere" id="id_filiere" class="form-select @error('id_filiere') is-invalid @enderror" required>
        <option value="">Sélectionnez une filière</option>
        @foreach($filieres as $filiere)
            <option value="{{ $filiere->id }}" @selected(old('id_filiere', $parcours->id_filiere ?? '') == $filiere->id)>
                {{ $filiere->nom }}
            </option>
        @endforeach
    </select>
    @error('id_filiere')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="frais_inscription">Frais d'inscription (F CFA)</label>
    <input type="number" step="0.01" class="form-control @error('frais_inscription') is-invalid @enderror" id="frais_inscription" name="frais_inscription" value="{{ old('frais_inscription', $parcours->frais_inscription ?? 0) }}" required />
    @error('frais_inscription')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="frais_formation">Frais de formation (F CFA)</label>
    <input type="number" step="0.01" class="form-control @error('frais_formation') is-invalid @enderror" id="frais_formation" name="frais_formation" value="{{ old('frais_formation', $parcours->frais_formation ?? 0) }}" required />
    @error('frais_formation')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" class="form-control">{{ old('description', $parcours->description ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">{{ isset($parcours) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('academique.parcours.index') }}" class="btn btn-label-secondary">Annuler</a>