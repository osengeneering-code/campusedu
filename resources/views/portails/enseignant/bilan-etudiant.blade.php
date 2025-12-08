@extends('layouts.admin')

@section('titre', 'Bilan Étudiant : ' . $etudiant->nom . ' ' . $etudiant->prenom)

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Espace Enseignant / Bilan Étudiant /</span> {{ $etudiant->nom }} {{ $etudiant->prenom }}
    </h4>

    <div class="row">
        {{-- Informations Générales de l'Étudiant --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informations Générales</h5>
                </div>
                <div class="card-body">
                    <p><strong>Matricule:</strong> {{ $etudiant->matricule }}</p>
                    <p><strong>Email:</strong> {{ $etudiant->user->email ?? 'N/A' }}</p>
                    <p><strong>Parcours Actuel:</strong> {{ $inscriptionAdminActuelle->parcours->nom ?? 'N/A' }}</p>
                    <p><strong>Année Académique:</strong> {{ $anneeAcademique }}</p>
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary">Retour</a>
                </div>
            </div>
        </div>

        {{-- Moyennes par Module --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Moyennes par Module ({{ $anneeAcademique }})</h5>
                </div>
                <div class="card-body">
                    @if($moyennesModules->isNotEmpty())
                    <ul class="list-group list-group-flush">
                        @foreach($inscriptionAdminActuelle->modules as $module)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $module->libelle }} ({{ $module->code_module }})</span>
                                @if(isset($moyennesModules[$module->id]))
                                    <span class="badge {{ $moyennesModules[$module->id] >= 10 ? 'bg-label-success' : 'bg-label-danger' }} fs-6">
                                        {{ $moyennesModules[$module->id] }} / 20
                                    </span>
                                @else
                                    <span class="badge bg-label-secondary">N/A</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">Aucune moyenne par module disponible.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Graphique des Moyennes par Module --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Performance par Module</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartMoyennesModules" height="200"></canvas>
                </div>
            </div>
        </div>

        {{-- Graphique d'Évolution Semestrielle --}}
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Évolution des Moyennes Semestrielles</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartEvolutionSemestre" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@parent
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Données des graphiques passées depuis le contrôleur
    const donneesMoyennesModules = @json($donneesGraphiqueMoyennesModules);
    const donneesEvolutionSemestre = @json($donneesGraphiqueEvolutionSemestre);

    // Graphique des Moyennes par Module
    if (donneesMoyennesModules.labels.length > 0) {
        const ctxModules = document.getElementById('chartMoyennesModules');
        new Chart(ctxModules, {
            type: 'bar', // Type de graphique à barres
            data: donneesMoyennesModules,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Graphique d'Évolution Semestrielle
    if (donneesEvolutionSemestre.labels.length > 0) {
        const ctxSemestre = document.getElementById('chartEvolutionSemestre');
        new Chart(ctxSemestre, {
            type: 'line', // Type de graphique linéaire
            data: donneesEvolutionSemestre,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 20
                    }
                },
                plugins: {
                    legend: {
                        display: true
                    }
                }
            }
        });
    }
});
</script>
@endsection
