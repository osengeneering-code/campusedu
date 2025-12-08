@extends('layouts.admin')

@section('titre', 'Détails de l\'Évaluation')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    @php
        // Configuration des couleurs selon le type
        $typeColors = [
            'CC' => ['bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'icon' => 'bx-edit-alt', 'color' => '#667eea'],
            'TP' => ['bg' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', 'icon' => 'bx-test-tube', 'color' => '#f093fb'],
            'Examen' => ['bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'icon' => 'bx-file', 'color' => '#4facfe'],
            'Projet' => ['bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'icon' => 'bx-folder', 'color' => '#43e97b'],
            'default' => ['bg' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)', 'icon' => 'bx-book-open', 'color' => '#fa709a']
        ];
        
        $typeName = $evaluation->evaluationType->name ?? 'default';
        $colorConfig = $typeColors[$typeName] ?? $typeColors['default'];
    @endphp

    <!-- En-tête avec banderole -->
    <div class="card mb-4 overflow-hidden">
        <div class="card-header-gradient" style="background: {{ $colorConfig['bg'] }}; height: 180px; position: relative;">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center" style="background: rgba(0,0,0,0.2);">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center text-white">
                                <div class="avatar avatar-xl me-3" style="width: 80px; height: 80px;">
                                    <span class="avatar-initial rounded" style="background: rgba(255,255,255,0.2); font-size: 2.5rem;">
                                        <i class="bx {{ $colorConfig['icon'] }}"></i>
                                    </span>
                                </div>
                                <div>
                                    <span class="badge bg-white text-dark mb-2">{{ $typeName }}</span>
                                    <h3 class="text-white mb-1">{{ $evaluation->libelle }}</h3>
                                    <p class="text-white-50 mb-0">
                                        <i class="bx bx-book-alt me-1"></i>{{ $evaluation->module->libelle ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="{{ route('gestion-cours.evaluations.index') }}" class="btn btn-white">
                                <i class="bx bx-arrow-back me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Effet de vague -->
            <div class="position-absolute bottom-0 start-0 w-100" style="height: 50px; overflow: hidden;">
                <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 100%; height: 100%;">
                    <path d="M0,40 C360,80 720,0 1080,40 C1200,53.33 1320,66.67 1440,80 L1440,80 L0,80 Z" fill="white" fill-opacity="0.3"/>
                    <path d="M0,60 C360,30 720,90 1080,60 C1200,53.33 1320,46.67 1440,40 L1440,80 L0,80 Z" fill="white"/>
                </svg>
            </div>
        </div>
        
        <!-- Actions rapides -->
        <div class="card-body">
            <div class="d-flex flex-wrap gap-2">
                @can('saisir-notes', $evaluation)
                <a href="{{ route('gestion-cours.evaluations.notes.fill', $evaluation) }}" class="btn btn-success">
                    <i class="bx bx-edit me-1"></i>Remplir les notes
                </a>
                @endcan
                <a href="{{ route('gestion-cours.evaluations.edit', $evaluation) }}" class="btn btn-warning">
                    <i class="bx bx-edit-alt me-1"></i>Modifier
                </a>
                <button class="btn btn-info">
                    <i class="bx bx-download me-1"></i>Exporter
                </button>
                <button class="btn btn-outline-primary">
                    <i class="bx bx-printer me-1"></i>Imprimer
                </button>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Barème</p>
                            <h3 class="mb-0 fw-bold" style="color: {{ $colorConfig['color'] }}">
                                {{ $evaluation->evaluationType->max_score ?? 20 }}
                            </h3>
                            <small class="text-muted">points</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded" style="background-color: {{ $colorConfig['color'] }}20;">
                                <i class="bx bx-star fs-4" style="color: {{ $colorConfig['color'] }}"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Étudiants</p>
                            <h3 class="mb-0 fw-bold text-primary">{{ rand(25, 45) }}</h3>
                            <small class="text-muted">inscrits</small>
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

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Notes Saisies</p>
                            <h3 class="mb-0 fw-bold text-success">{{ rand(15, 40) }}</h3>
                            <small class="text-muted">/ {{ rand(25, 45) }}</small>
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

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Moyenne</p>
                            <h3 class="mb-0 fw-bold text-info">{{ number_format(rand(1000, 1500) / 100, 2) }}</h3>
                            <small class="text-muted">/ {{ $evaluation->evaluationType->max_score ?? 20 }}</small>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="bx bx-bar-chart-alt-2 fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations détaillées -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Informations de l'Évaluation</h5>
                    <span class="badge" style="background-color: {{ $colorConfig['color'] }}">{{ $typeName }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-book-alt text-primary me-2 fs-5"></i>
                                        <strong>Module</strong>
                                    </div>
                                    <p class="mb-0 ms-4 text-muted">{{ $evaluation->module->libelle ?? 'N/A' }}</p>
                                    @if($evaluation->module && $evaluation->module->code_module)
                                    <small class="ms-4 text-muted">Code: {{ $evaluation->module->code_module }}</small>
                                    @endif
                                </li>
                                
                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-category text-primary me-2 fs-5"></i>
                                        <strong>Type d'évaluation</strong>
                                    </div>
                                    <p class="mb-0 ms-4">
                                        <span class="badge bg-label-primary">{{ $evaluation->evaluationType->name ?? 'N/A' }}</span>
                                    </p>
                                </li>
                                
                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-star text-primary me-2 fs-5"></i>
                                        <strong>Barème</strong>
                                    </div>
                                    <p class="mb-0 ms-4 text-muted">{{ $evaluation->evaluationType->max_score ?? 20 }} points</p>
                                </li>

                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-percentage text-primary me-2 fs-5"></i>
                                        <strong>Coefficient</strong>
                                    </div>
                                    <p class="mb-0 ms-4 text-muted">{{ $evaluation->evaluationType->weight ?? 1 }}</p>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-calendar text-primary me-2 fs-5"></i>
                                        <strong>Date d'évaluation</strong>
                                    </div>
                                    <p class="mb-0 ms-4 text-muted">{{ $evaluation->date_evaluation->format('d/m/Y') }}</p>
                                    <small class="ms-4 text-muted">{{ $evaluation->date_evaluation->diffForHumans() }}</small>
                                </li>
                                
                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-time-five text-primary me-2 fs-5"></i>
                                        <strong>Année Académique</strong>
                                    </div>
                                    <p class="mb-0 ms-4 text-muted">{{ $evaluation->annee_academique }}</p>
                                </li>

                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-git-branch text-primary me-2 fs-5"></i>
                                        <strong>Parcours</strong>
                                    </div>
                                    <p class="mb-0 ms-4 text-muted">
                                        {{ $evaluation->module->ue->semestre->parcours->nom ?? 'N/A' }}
                                    </p>
                                </li>

                                <li class="mb-3 pb-3 border-bottom">
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="bx bx-user-check text-primary me-2 fs-5"></i>
                                        <strong>Statut</strong>
                                    </div>
                                    <p class="mb-0 ms-4">
                                        @if($evaluation->date_evaluation->isPast())
                                            <span class="badge bg-success">Passée</span>
                                        @else
                                            <span class="badge bg-warning">À venir</span>
                                        @endif
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>

                    @if($evaluation->description)
                    <div class="alert alert-info mt-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>Description</strong>
                        </div>
                        <p class="mb-0">{{ $evaluation->description }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiques et graphiques -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0">Statistiques des Notes</h5>
                </div>
                <div class="card-body">
                    <!-- Graphique circulaire de progression -->
                    <div class="text-center mb-4">
                        <canvas id="progressChart" height="200"></canvas>
                    </div>

                    <!-- Statistiques détaillées -->
                    <div class="stats-details">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <i class="bx bx-trending-up text-success me-2"></i>
                                <span>Note la plus haute</span>
                            </div>
                            <strong class="text-success">{{ number_format(rand(1500, 2000) / 100, 2) }}</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <i class="bx bx-trending-down text-danger me-2"></i>
                                <span>Note la plus basse</span>
                            </div>
                            <strong class="text-danger">{{ number_format(rand(200, 800) / 100, 2) }}</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <i class="bx bx-bar-chart text-info me-2"></i>
                                <span>Médiane</span>
                            </div>
                            <strong class="text-info">{{ number_format(rand(1000, 1400) / 100, 2) }}</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="bx bx-check-circle text-success me-2"></i>
                                <span>Taux de réussite</span>
                            </div>
                            <strong class="text-success">{{ rand(60, 95) }}%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Distribution des notes -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Distribution des Notes</h5>
                </div>
                <div class="card-body">
                    <canvas id="distributionChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card-header-gradient {
    position: relative;
    overflow: hidden;
}

.btn-white {
    background-color: white;
    color: #333;
    border: none;
}

.btn-white:hover {
    background-color: rgba(255, 255, 255, 0.9);
    color: #333;
}

.stats-details {
    font-size: 0.875rem;
}

.stats-details i {
    font-size: 1.1rem;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuration commune
    Chart.defaults.font.family = 'Public Sans, sans-serif';
    Chart.defaults.color = '#697a8d';

    // Graphique circulaire de progression
    const progressCtx = document.getElementById('progressChart');
    const notesCorrigees = {{ rand(15, 40) }};
    const totalNotes = {{ rand(25, 45) }};
    const pourcentage = Math.round((notesCorrigees / totalNotes) * 100);

    new Chart(progressCtx, {
        type: 'doughnut',
        data: {
            labels: ['Corrigées', 'En attente'],
            datasets: [{
                data: [notesCorrigees, totalNotes - notesCorrigees],
                backgroundColor: ['{{ $colorConfig["color"] }}', '#e7e7ff'],
                borderWidth: 0,
                cutout: '70%'
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
                        usePointStyle: true
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            return label + ': ' + value + ' (' + Math.round((value / totalNotes) * 100) + '%)';
                        }
                    }
                }
            }
        },
        plugins: [{
            id: 'centerText',
            afterDraw: function(chart) {
                const ctx = chart.ctx;
                const centerX = (chart.chartArea.left + chart.chartArea.right) / 2;
                const centerY = (chart.chartArea.top + chart.chartArea.bottom) / 2;
                
                ctx.save();
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.font = 'bold 24px Public Sans';
                ctx.fillStyle = '{{ $colorConfig["color"] }}';
                ctx.fillText(pourcentage + '%', centerX, centerY - 10);
                
                ctx.font = '12px Public Sans';
                ctx.fillStyle = '#697a8d';
                ctx.fillText('Complété', centerX, centerY + 15);
                ctx.restore();
            }
        }]
    });

    // Graphique de distribution
    const distributionCtx = document.getElementById('distributionChart');
    new Chart(distributionCtx, {
        type: 'bar',
        data: {
            labels: ['0-5', '5-10', '10-12', '12-14', '14-16', '16-18', '18-20'],
            datasets: [{
                label: 'Nombre d\'étudiants',
                data: [2, 5, 8, 12, 10, 6, 3],
                backgroundColor: '{{ $colorConfig["color"] }}80',
                borderColor: '{{ $colorConfig["color"] }}',
                borderWidth: 2,
                borderRadius: 8
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
                        stepSize: 2
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
});
</script>
@endsection