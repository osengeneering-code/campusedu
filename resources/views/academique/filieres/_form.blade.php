@csrf
<div class="mb-3">
    <label class="form-label" for="nom">Nom de la filière</label>
    <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $filiere->nom ?? '') }}" required />
    @error('nom')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="id_departement">Département de rattachement</label>
    <select name="id_departement" id="id_departement" class="form-select @error('id_departement') is-invalid @enderror" required>
        <option value="">Sélectionnez un département</option>
        @foreach($departements as $departement)
            <option value="{{ $departement->id }}" @selected(old('id_departement', $filiere->id_departement ?? '') == $departement->id)>
                {{ $departement->nom }}
            </option>
        @endforeach
    </select>
    @error('id_departement')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>



<div class="mb-3">
    <label class="form-label" for="description">Description</label>
    <textarea id="description" name="description" class="form-control">{{ old('description', $filiere->description ?? '') }}</textarea>
</div>

<div class="mb-3">
    <label for="image_path" class="form-label">Image de la bannière</label>
    <input class="form-control @error('image_path') is-invalid @enderror" type="file" id="image_path" name="image_path">
    @error('image_path')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

@if(isset($filiere) && $filiere->image_path)
    <div class="mb-3">
        <label class="form-label">Bannière actuelle</label>
        <img src="{{ $filiere->image_path }}" alt="Bannière de la filière {{ $filiere->nom }}" class="img-fluid rounded" style="max-height: 150px;">
    </div>
@endif

<button type="submit" class="btn btn-primary">{{ $filiere ?? null ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('academique.filieres.index') }}" class="btn btn-label-secondary">Annuler</a>
