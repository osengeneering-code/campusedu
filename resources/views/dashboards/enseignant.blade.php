@extends('layouts.admin')

@section('content')

<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Tableau de bord</h4>
        <p class="text-muted mb-0">Vue d'ensemble de votre établissement</p>
    </div>
    <div class="d-flex gap-2">
        @can('creer_evaluations')
        <a href="{{ route('gestion-cours.evaluations.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Créer une évaluation
        </a>
        @endcan
        <button class="btn btn-outline-primary">
            <i class="bx bx-download me-1"></i> Exporter 
        </button>
    </div>
</div>

<!-- Carte de bienvenue -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <h5 class="card-title text-primary mb-3">Bienvenue, {{ $enseignant->prenom }} {{ $enseignant->nom }} ! 🎉</h5>
                        <p class="mb-4">
                            Cette plateforme a été conçue pour offrir à chaque acteur de l'établissement 
                            un espace numérique simple, efficace et centralisé. Elle permet aux enseignants 
                            de suivre leurs modules, consulter leur emploi du temps, gérer leurs devoirs, 
                            interagir avec les étudiants et accéder rapidement aux informations essentielles 
                            liées à leurs activités pédagogiques.
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Email Pro:</strong> {{ $enseignant->email_pro }}</p>
                                <p class="mb-2"><strong>Téléphone Pro:</strong> {{ $enseignant->telephone_pro ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Statut:</strong> <span class="badge bg-label-primary">{{ $enseignant->statut }}</span></p>
                                <p class="mb-2"><strong>Bureau:</strong> {{ $enseignant->bureau ?? 'N/A' }}</p>
                                <p class="mb-2"><strong>Département:</strong> {{ $enseignant->departement->nom ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 text-center">
                        <img src="{{ asset('Pro/assets/img/illustrations/ens.png') }}" 
                             alt="Enseignant" 
                             class="img-fluid"
                             style="max-height: 305px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Cartes statistiques -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 text-muted">Étudiants Suivis</p>
                        <h3 class="mb-0 fw-bold">{{ $totalEtudiants }}</h3>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="bx bx-user fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 text-muted">Évaluations Saisies</p>
                        <h3 class="mb-0 fw-bold">{{ $totalEvaluationsSaisies }}</h3>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="bx bx-check-double fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="mb-1 text-muted">Modules Affectés</p>
                        <h3 class="mb-0 fw-bold">{{ $modulesTaught->count() }}</h3>
                    </div>
                    <div class="avatar">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="bx bx-book-alt fs-4"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="row mb-4">
    <div class="col-lg-8 mb-3">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Évolution des étudiants</h5>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>2024-2025</option>
                    <option>2023-2024</option>
                </select>
            </div>
            <div class="card-body">
                <canvas id="inscriptionsChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Répartition par module</h5>
            </div>
            <div class="card-body">
                <canvas id="niveauxChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Emploi du temps et performances -->
<div class="row mb-4">
    <div class="col-12 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Mon emploi du temps aujourd'hui</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Heure</th>
                                <th>Cours</th>
                                <th>Enseignant</th>
                                <th>Salle</th>
                                <th>Niveau</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coursAujourdhui as $cours)
                                <tr>
                                    <td class="fw-semibold">{{ \Carbon\Carbon::parse($cours->heure_debut)->format('H\hi') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H\hi') }}</td>
                                    <td>{{ $cours->module->libelle }}</td>
                                    <td>{{ $enseignant->nom }} {{ $enseignant->prenom }}</td>
                                    <td>{{ $cours->salle->nom_salle }}</td>
                                    <td><span class="badge bg-label-primary">{{ $cours->parcours->libelle }}</span></td>
                                    <td>
                                        @php
                                            $now = now();
                                            $start = \Carbon\Carbon::parse($cours->heure_debut);
                                            $end = \Carbon\Carbon::parse($cours->heure_fin);
                                            if ($now->between($start, $end)) {
                                                $status = 'En cours';
                                                $badgeClass = 'bg-success';
                                            } elseif ($now->lt($start)) {
                                                $status = 'Planifié';
                                                $badgeClass = 'bg-primary';
                                            } else {
                                                $status = 'Terminé';
                                                $badgeClass = 'bg-secondary';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">Aucun cours prévu pour aujourd'hui.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Meilleures performances et bilan semestres -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Meilleures performances</h5>
                <span class="badge bg-label-primary">{{ $meilleurs_etudiants_module['module_libelle'] ?? 'N/A' }}</span>
            </div>
            <div class="card-body">
                @if($meilleurs_etudiants_module->isNotEmpty() && $meilleurs_etudiants_module['etudiants']->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Rang</th>
                                    <th>Étudiant</th>
                                    <th class="text-end">Moyenne</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($meilleurs_etudiants_module['etudiants'] as $dataEtudiant)
                                <tr>
                                    <td>
                                        <span class="badge {{ $loop->iteration <= 3 ? 'bg-warning' : 'bg-label-secondary' }}">
                                            #{{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $dataEtudiant['etudiant']->user->profile_photo_url ?? asset('Pro/assets/img/avatars/default-avatar.png') }}" 
                                                 alt="Avatar" 
                                                 class="rounded-circle me-2" 
                                                 style="width: 32px; height: 32px; object-fit: cover;">
                                            <a href="{{ route('portail.enseignant.etudiant-bilan', ['enseignant' => $enseignant->id, 'etudiant' => $dataEtudiant['etudiant']->id]) }}" 
                                               class="text-dark text-decoration-none">
                                                {{ $dataEtudiant['etudiant']->nom }} {{ $dataEtudiant['etudiant']->prenom }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <strong class="{{ $dataEtudiant['moyenne'] >= 10 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format($dataEtudiant['moyenne'], 2) }}/20
                                        </strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0" role="alert">
                        <i class="bx bx-info-circle me-2"></i>
                        Aucun étudiant avec une note calculable pour ce module.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">Bilan Semestres</h5>
            </div>
            <div class="card-body">
                @forelse($semestres_enseignant as $semestre)
                <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $semestre['libelle'] }} - {{ $anneeAcademiqueActuelle }}</h6>
                            <p class="mb-2 text-muted small">{{ $semestre['niveau'] }}</p>
                        </div>
                        <span class="badge {{ $semestre['statut'] == 'En cours' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $semestre['statut'] }}
                        </span>
                    </div>
                    <div class="d-flex gap-2 mb-3">
                        <span class="badge bg-label-primary">
                            <i class="bx bx-book me-1"></i>{{ $semestre['modules_count'] }} modules
                        </span>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="text-muted">Progression</small>
                            <small class="fw-semibold">{{ $semestre['progression'] }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar {{ $semestre['statut'] == 'En cours' ? 'bg-success' : 'bg-secondary' }}" 
                                 style="width: {{ $semestre['progression'] }}%"
                                 role="progressbar"
                                 aria-valuenow="{{ $semestre['progression'] }}"
                                 aria-valuemin="0"
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <div class="alert alert-info mb-0" role="alert">
                        <i class="bx bx-info-circle me-2"></i>
                        Aucun semestre pertinent trouvé pour vos modules.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Configuration commune pour les graphiques
Chart.defaults.font.family = 'Public Sans, -apple-system, BlinkMacSystemFont, "Segoe UI", Oxygen, Ubuntu, Cantarell, "Fira Sans", "Droid Sans", "Helvetica Neue", sans-serif';
Chart.defaults.color = '#697a8d';

// Graphique des étudiants par mois
const evolutionEtudiantsParMois = @json($evolutionEtudiantsParMois);
const inscriptionsCtx = document.getElementById('inscriptionsChart');
if (inscriptionsCtx && evolutionEtudiantsParMois.labels.length > 0) {
    new Chart(inscriptionsCtx, {
        type: 'line',
        data: {
            labels: evolutionEtudiantsParMois.labels,
            datasets: [{
                label: "Nombre d'étudiants uniques",
                data: evolutionEtudiantsParMois.data,
                borderColor: '#696cff',
                backgroundColor: 'rgba(105, 108, 255, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#696cff',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    cornerRadius: 8
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        precision: 0
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Graphique de répartition
const donneesGraphiqueRepartitionNiveaux = @json($donneesGraphiqueRepartitionNiveaux);
const niveauxCtx = document.getElementById('niveauxChart');
if (niveauxCtx && donneesGraphiqueRepartitionNiveaux.labels.length > 0) {
    new Chart(niveauxCtx, {
        type: 'doughnut',
        data: {
            labels: donneesGraphiqueRepartitionNiveaux.labels,
            datasets: [{
                data: donneesGraphiqueRepartitionNiveaux.data,
                backgroundColor: [
                    '#696cff',
                    '#03c3ec',
                    '#ffab00',
                    '#71dd37',
                    '#8592a3',
                    '#ff3e1d'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });
}

// Graphiques d'évolution des notes par module
const donneesGraphiqueEvolution = @json($donneesGraphiqueEvolution);
for (const moduleLibelle in donneesGraphiqueEvolution) {
    if (donneesGraphiqueEvolution.hasOwnProperty(moduleLibelle)) {
        const data = donneesGraphiqueEvolution[moduleLibelle];
        const labels = data.map(item => item.date_evaluation);
        const moyennes = data.map(item => item.moyenne);
        const canvasId = `chartEvolution${moduleLibelle.toLowerCase().replace(/[^a-z0-9]+/g, '-')}`;
        const ctx = document.getElementById(canvasId);
        
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Moyenne des notes',
                        data: moyennes,
                        borderColor: '#4bc0c0',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 20,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }
    }
}
</script>
@endsection