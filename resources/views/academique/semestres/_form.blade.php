@csrf
<div class="mb-3">
    <label class="form-label" for="libelle">Libellé du semestre (ex: S1, S2)</label>
    <input type="text" class="form-control @error('libelle') is-invalid @enderror" id="libelle" name="libelle" value="{{ old('libelle', $semestre->libelle ?? '') }}" required />
    @error('libelle')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="niveau">Niveau</label>
    <select name="niveau" id="niveau" class="form-select @error('niveau') is-invalid @enderror" required>
        <option value="">Sélectionnez un niveau</option>
        @foreach($niveaux as $n)
            <option value="{{ $n }}" @selected(old('niveau', $semestre->niveau ?? '') == $n)>
                {{ $n }}
            </option>
        @endforeach
    </select>
    @error('niveau')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="mb-3">
    <label class="form-label" for="id_parcours">Parcours de rattachement</label>
    <select name="id_parcours" id="id_parcours" class="form-select @error('id_parcours') is-invalid @enderror" required>
        <option value="">Sélectionnez un parcours</option>
        @foreach($parcours as $p)
            <option value="{{ $p->id }}" @selected(old('id_parcours', $semestre->id_parcours ?? '') == $p->id)>
                {{ $p->nom }} ({{ $p->filiere->nom ?? '' }})
            </option>
        @endforeach
    </select>
    @error('id_parcours')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">{{ isset($semestre) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('academique.semestres.index') }}" class="btn btn-label-secondary">Annuler</a>
