@csrf
<div class="mb-3">
    <label class="form-label" for="nom">Nom du département</label>
    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $departement->nom ?? '') }}" required />
    @error('nom')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="id_faculte">Faculté de rattachement</label>
    <select name="id_faculte" id="id_faculte" class="form-select @error('id_faculte') is-invalid @enderror" required>
        <option value="">Sélectionnez une faculté</option>
        @foreach($facultes as $faculte)
            <option value="{{ $faculte->id }}" @selected(old('id_faculte', $departement->id_faculte ?? '') == $faculte->id)>
                {{ $faculte->nom }}
            </option>
        @endforeach
    </select>
    @error('id_faculte')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" class="form-control">{{ old('description', $departement->description ?? '') }}</textarea>
</div>

<button type="submit" class="btn btn-primary">{{ $departement ?? null ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('academique.departements.index') }}" class="btn btn-label-secondary">Annuler</a>
