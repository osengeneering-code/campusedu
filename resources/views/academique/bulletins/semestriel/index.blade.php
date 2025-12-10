@extends('layouts.admin')

@section('titre', 'Bulletins Semestriels')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Bulletins /</span> Semestriels
    </h4>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Filtres des Bulletins</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('bulletins.semestriel.index') }}" method="GET" id="filterForm" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="annee_academique" class="form-label">Année Académique</label>
                        <input type="text" name="annee_academique" id="annee_academique" class="form-control" value="{{ request('annee_academique', $anneeAcademique) }}" placeholder="Ex: 2023-2024">
                    </div>
                    <div class="col-md-3">
                        <label for="departement_id" class="form-label">Département</label>
                        <select name="departement_id" id="departement_id" class="form-select">
                            <option value="">Sélectionner un département</option>
                            @foreach($departements as $departement)
                                <option value="{{ $departement->id }}" {{ request('departement_id') == $departement->id ? 'selected' : '' }}>{{ $departement->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="filiere_id" class="form-label">Filière</label>
                        <select name="filiere_id" id="filiere_id" class="form-select">
                            <option value="">Sélectionner une filière</option>
                            @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}" {{ request('filiere_id') == $filiere->id ? 'selected' : '' }}>{{ $filiere->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="parcours_id" class="form-label">Parcours</label>
                        <select name="parcours_id" id="parcours_id" class="form-select">
                            <option value="">Sélectionner un parcours</option>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}" {{ request('parcours_id') == $p->id ? 'selected' : '' }}>{{ $p->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="semestre_id" class="form-label">Semestre</label>
                        <select name="semestre_id" id="semestre_id" class="form-select">
                            <option value="">Sélectionner un semestre</option>
                            @foreach($semestres as $semestre)
                                <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>{{ $semestre->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Appliquer les filtres</button>
                    </div>
                </div>
            </form>

            @if(request('semestre_id') && request('annee_academique') && request('parcours_id'))
                <h5 class="mt-4 mb-3">Bulletins pour le Semestre: {{ $semestres->firstWhere('id', request('semestre_id'))->libelle ?? 'N/A' }} ({{ request('annee_academique') }})</h5>
                
                @if($etudiants->isNotEmpty())
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom et Prénom</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach($etudiants as $etudiant)
                                <tr>
                                    <td>{{ $etudiant->matricule }}</td>
                                    <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                                    <td>
                                        <a href="{{ route('bulletins.semestriel.show', [
                                            'anneeAcademique' => request('annee_academique'),
                                            'semestre' => request('semestre_id'),
                                            'etudiant' => $etudiant->id
                                        ]) }}" class="btn btn-sm btn-primary">
                                            Voir Bulletin
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center mt-3">Aucun étudiant trouvé pour les critères sélectionnés.</p>
                @endif
            @else
                <p class="text-center mt-3">Veuillez sélectionner une année académique, un département, une filière, un parcours et un semestre pour afficher les bulletins.</p>
            @endif
        </div>
    </div>
</div>

@section('footer')
<script>
    document.getElementById('departement_id').addEventListener('change', function() {
        var departementId = this.value;
        var filiereSelect = document.getElementById('filiere_id');
        var parcoursSelect = document.getElementById('parcours_id');

        filiereSelect.innerHTML = '<option value="">Sélectionner une filière</option>';
        parcoursSelect.innerHTML = '<option value="">Sélectionner un parcours</option>';

        if (departementId) {
            fetch('/api/filieres-by-departement/' + departementId) // Supposons une API route
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(filiere) {
                        var option = document.createElement('option');
                        option.value = filiere.id;
                        option.textContent = filiere.libelle;
                        filiereSelect.appendChild(option);
                    });
                });
        }
    });

    document.getElementById('filiere_id').addEventListener('change', function() {
        var filiereId = this.value;
        var parcoursSelect = document.getElementById('parcours_id');

        parcoursSelect.innerHTML = '<option value="">Sélectionner un parcours</option>';

        if (filiereId) {
            fetch('/api/parcours-by-filiere/' + filiereId) // Supposons une API route
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(parcours) {
                        var option = document.createElement('option');
                        option.value = parcours.id;
                        option.textContent = parcours.nom;
                        parcoursSelect.appendChild(option);
                    });
                });
        }
    });
</script>
@endsection

