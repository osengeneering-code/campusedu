@extends('layouts.admin')

@section('titre', 'Bulletins Semestriels')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Bulletins /</span> Semestriels
    </h4>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Sélectionner un Semestre et une Année Académique</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('bulletins.semestriel.index') }}" method="GET" class="mb-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="semestre_id" class="form-label">Semestre</label>
                        <select name="semestre_id" id="semestre_id" class="form-select">
                            <option value="">Tous les semestres</option>
                            @foreach($semestres as $semestre)
                                <option value="{{ $semestre->id }}" {{ request('semestre_id') == $semestre->id ? 'selected' : '' }}>{{ $semestre->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="annee_academique" class="form-label">Année Académique</label>
                        <input type="text" name="annee_academique" id="annee_academique" class="form-control" value="{{ request('annee_academique', $anneeAcademique) }}" placeholder="Ex: 2023-2024">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">Filtrer</button>
                    </div>
                </div>
            </form>

            @if(request('semestre_id') && request('annee_academique'))
                <h5 class="mt-4 mb-3">Bulletins pour le Semestre: {{ $semestres->firstWhere('id', request('semestre_id'))->libelle ?? 'N/A' }} ({{ request('annee_academique') }})</h5>
                
                @php
                    $selectedSemestre = $semestres->firstWhere('id', request('semestre_id'));
                    $etudiantsInscrits = [];

                    // Ceci est un exemple simplifié. Dans une vraie application, vous devrez
                    // récupérer les étudiants inscrits à ce semestre/année académique via InscriptionAdmin.
                    // Pour la démo, nous allons utiliser une liste factice ou une relation existante.
                    if ($selectedSemestre && $selectedSemestre->ues->isNotEmpty()) {
                        // Supposons que nous pouvons obtenir les étudiants via les modules d'une UE
                        // et leurs inscriptions administratives
                        $etudiantsInscrits = \App\Models\Etudiant::whereHas('inscriptionAdmins', function ($query) use ($selectedSemestre, $anneeAcademique) {
                            $query->where('annee_academique', $anneeAcademique)
                                  ->whereHas('parcours.semestres', function($q) use ($selectedSemestre) {
                                      $q->where('semestres.id', $selectedSemestre->id);
                                  });
                        })->get();
                    }
                @endphp

                @if($etudiantsInscrits->isNotEmpty())
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
                                @foreach($etudiantsInscrits as $etudiant)
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
                    <p class="text-center mt-3">Aucun étudiant trouvé pour ce semestre et cette année académique.</p>
                @endif
            @else
                <p class="text-center mt-3">Veuillez sélectionner un semestre et une année académique pour afficher les bulletins.</p>
            @endif
        </div>
    </div>
</div>
@endsection
