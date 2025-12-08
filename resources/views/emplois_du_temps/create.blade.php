@extends('layouts.admin')

@section('titre', 'Planifier un Cours')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Planifier une nouvelle session de cours</h5>
    </div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('gestion-cours.cours.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="id_filiere" class="form-label">Filière</label>
                    <select name="id_filiere" id="id_filiere" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="id_parcours" class="form-label">Parcours</label>
                    <select name="id_parcours" id="id_parcours" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach($parcours as $p)
                            <option value="{{ $p->id }}">{{ $p->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="id_semestre" class="form-label">Semestre</label>
                    <select name="id_semestre" id="id_semestre" class="form-select" required>
                        <option value="">-- Choisir --</option>
                        @foreach($semestres as $s)
                            <option value="{{ $s->id }}">{{ $s->libelle }} ({{ $s->niveau }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="id_module" class="form-label">Module</label>
                    <select name="id_module" id="id_module" class="form-select" required>
                        @foreach($modules as $module)
                        <option value="{{ $module->id }}">{{ $module->libelle }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="id_salle" class="form-label">Salle</label>
                    <select name="id_salle" id="id_salle" class="form-select" required>
                        @foreach($salles as $salle)
                        <option value="{{ $salle->id }}">{{ $salle->nom_salle }} (Cap: {{ $salle->capacite }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="annee_academique" class="form-label">Année Académique</label>
                    <input type="text" name="annee_academique" class="form-control" value="{{ date('Y') }}-{{ date('Y') + 1 }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="jour" class="form-label">Jour</label>
                    <select name="jour" id="jour" class="form-select" required>
                       @foreach($jours as $jour)
                        <option value="{{ $jour }}">{{ $jour }}</option>
                       @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="type_cours" class="form-label">Type</label>
                    <select name="type_cours" id="type_cours" class="form-select" required>
                       @foreach($types as $type)
                        <option value="{{ $type }}">{{ $type }}</option>
                       @endforeach
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="heure_debut" class="form-label">Heure de début</label>
                    <input type="time" name="heure_debut" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="heure_fin" class="form-label">Heure de fin</label>
                    <input type="time" name="heure_fin" class="form-control" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="{{ route('gestion-cours.cours.index') }}" class="btn btn-label-secondary">Annuler</a>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const filiereSelect = document.getElementById('id_filiere');
    const parcoursSelect = document.getElementById('id_parcours');
    const semestreSelect = document.getElementById('id_semestre');

    const parcoursData = @json($parcours);
    const semestresData = @json($semestres);

    filiereSelect.addEventListener('change', function() {
        const filiereId = parseInt(this.value);
        parcoursSelect.innerHTML = '<option value="">-- Choisir --</option>';
        semestreSelect.innerHTML = '<option value="">-- Choisir --</option>';

        parcoursData.forEach(p => {
            if (p.id_filiere === filiereId) {
                const option = document.createElement('option');
                option.value = p.id;
                option.text = p.nom;
                parcoursSelect.appendChild(option);
            }
        });
    });

    parcoursSelect.addEventListener('change', function() {
        const parcoursId = parseInt(this.value);
        semestreSelect.innerHTML = '<option value="">-- Choisir --</option>';

        semestresData.forEach(s => {
            if (s.id_parcours === parcoursId) {
                const option = document.createElement('option');
                option.value = s.id;
                option.text = `${s.libelle} (${s.niveau})`;
                semestreSelect.appendChild(option);
            }
        });
    });
});
</script>

@endsection
