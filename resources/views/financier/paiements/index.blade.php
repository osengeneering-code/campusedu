@extends('layouts.admin')

@section('titre', 'Tableau de Bord Financier')

@section('content')
<div class="container-fluid">
    <!-- En-tête du tableau de bord -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1 fw-bold">Direction Financière</h4>
            <p class="text-muted mb-0">Vue d'ensemble des transactions et paiements</p>
        </div>
        @can('gerer_paiements')
        <a href="{{ route('paiements.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i>Nouveau Paiement
        </a>
        @endcan
    </div>

    <!-- KPIs Financiers -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 kpi-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Recettes totales</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['total_paiements'] ?? 0, 0, ',', ' ') }}</h3>
                            <small class="text-muted">F CFA</small>
                        </div>
                        <div class="kpi-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bx bx-wallet"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <small class="text-success"><i class="bx bx-trending-up"></i> +12.5% vs mois dernier</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 kpi-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Paiements validés</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['paiements_payes'] ?? 0 }}</h3>
                            <small class="text-muted">Transactions</small>
                        </div>
                        <div class="kpi-icon bg-success bg-opacity-10 text-success">
                            <i class="bx bx-check-circle"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <small class="text-muted">Taux: {{ number_format($stats['taux_recouvrement'] ?? 0, 1) }}%</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 kpi-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">En attente</p>
                            <h3 class="mb-0 fw-bold">{{ $stats['paiements_en_attente'] ?? 0 }}</h3>
                            <small class="text-muted">À traiter</small>
                        </div>
                        <div class="kpi-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bx bx-time-five"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <small class="text-warning"><i class="bx bx-error-circle"></i> Requiert attention</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100 kpi-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted text-uppercase mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Taux de recouvrement</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($stats['taux_recouvrement'] ?? 0, 1) }}%</h3>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar bg-info" style="width: {{ $stats['taux_recouvrement'] ?? 0 }}%"></div>
                            </div>
                        </div>
                        <div class="kpi-icon bg-info bg-opacity-10 text-info">
                            <i class="bx bx-trending-up"></i>
                        </div>
                    </div>
                    <div class="mt-3 pt-2 border-top">
                        <small class="text-muted">Objectif: 95%</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques compacts -->
    <div class="row g-3 mb-4">
        <div class="col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">Évolution des recettes</h6>
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active">Année</button>
                            <button type="button" class="btn btn-outline-secondary">Trimestre</button>
                            <button type="button" class="btn btn-outline-secondary">Mois</button>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-2">
                    <canvas id="evolutionChart" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">Répartition des frais</h6>
                </div>
                <div class="card-body pt-2">
                    <canvas id="typesChart" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques secondaires en format compact -->
    <div class="row g-3 mb-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">Top 10 contributeurs</h6>
                </div>
                <div class="card-body pt-2">
                    <canvas id="topEtudiantsChart" style="max-height: 240px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="mb-0 fw-semibold">Statut des transactions</h6>
                </div>
                <div class="card-body pt-2">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <canvas id="statutChart" style="max-height: 200px;"></canvas>
                        </div>
                        <div class="col-md-6">
                            <div class="statut-legend">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="legend-color bg-success me-2"></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">Validés</span>
                                            <strong>{{ $stats['paiements_payes'] ?? 0 }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <div class="legend-color bg-warning me-2"></div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between">
                                            <span class="text-muted">En attente</span>
                                            <strong>{{ $stats['paiements_en_attente'] ?? 0 }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des transactions récentes -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">Transactions récentes</h6>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="Rechercher..." style="width: 200px;">
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-filter"></i> Filtrer
                    </button>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-export"></i> Exporter
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-3">Référence</th>
                            <th class="border-0">Étudiant</th>
                            <th class="border-0">Type</th>
                            <th class="border-0">Montant</th>
                            <th class="border-0">Date</th>
                            <th class="border-0">Statut</th>
                            <th class="border-0 text-end pe-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paiements as $paiement)
                        <tr>
                            <td class="ps-3">
                                <strong class="text-dark">{{ $paiement->reference_paiement }}</strong>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-initials me-2">
                                        {{ strtoupper(substr($paiement->inscriptionAdmin->etudiant->nom ?? 'N', 0, 1)) }}{{ strtoupper(substr($paiement->inscriptionAdmin->etudiant->prenom ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $paiement->inscriptionAdmin->etudiant->nom ?? 'N/A' }} {{ $paiement->inscriptionAdmin->etudiant->prenom ?? '' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $paiement->type_frais }}</span>
                            </td>
                            <td>
                                <strong>{{ number_format($paiement->montant, 0, ',', ' ') }}</strong>
                                <small class="text-muted d-block">F CFA</small>
                            </td>
                            <td class="text-muted">{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $paiement->statut_paiement == 'Payé' ? 'success' : 'warning' }}">
                                    {{ $paiement->statut_paiement }}
                                </span>
                            </td>
                            <td class="text-end pe-3">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('paiements.show', $paiement) }}" class="btn btn-outline-secondary" title="Voir">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    @can('gerer_paiements')
                                    <a href="{{ route('paiements.edit', $paiement) }}" class="btn btn-outline-secondary" title="Modifier">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="{{ route('paiements.receipt', $paiement) }}" target="_blank" class="btn btn-outline-secondary" title="Reçu">
                                        <i class="bx bx-download"></i>
                                    </a>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bx bx-folder-open bx-lg d-block mb-2"></i>
                                Aucune transaction trouvée
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3">
            {{ $paiements->links() }}
        </div>
    </div>
</div>
@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const chartData = @json($chartData);

// Configuration par défaut pour tous les graphiques
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.color = '#6c757d';

// Graphique d'évolution - Line Chart minimaliste
const evolutionCtx = document.getElementById('evolutionChart').getContext('2d');
new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: chartData.evolution.labels,
        datasets: [{
            label: 'Montant (F CFA)',
            data: chartData.evolution.data,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.05)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#000',
                bodyColor: '#666',
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12,
                displayColors: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f0f0f0', drawBorder: false },
                ticks: { padding: 10 }
            },
            x: {
                grid: { display: false, drawBorder: false },
                ticks: { padding: 10 }
            }
        }
    }
});

// Graphique par type - Doughnut moderne
const typesCtx = document.getElementById('typesChart').getContext('2d');
new Chart(typesCtx, {
    type: 'doughnut',
    data: {
        labels: chartData.types.labels,
        datasets: [{
            data: chartData.types.data,
            backgroundColor: [
                '#0d6efd',
                '#6610f2',
                '#6f42c1',
                '#d63384',
                '#dc3545'
            ],
            borderWidth: 0,
            hoverOffset: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15, usePointStyle: true, pointStyle: 'circle' }
            },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#000',
                bodyColor: '#666',
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12
            }
        }
    }
});

// Graphique Top étudiants - Barres horizontales
const topEtudiantsCtx = document.getElementById('topEtudiantsChart').getContext('2d');
new Chart(topEtudiantsCtx, {
    type: 'bar',
    data: {
        labels: chartData.topEtudiants.labels,
        datasets: [{
            label: 'Montant (F CFA)',
            data: chartData.topEtudiants.data,
            backgroundColor: '#0d6efd',
            borderRadius: 6,
            barThickness: 20
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#000',
                bodyColor: '#666',
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: '#f0f0f0', drawBorder: false },
                ticks: { padding: 10 }
            },
            y: {
                grid: { display: false, drawBorder: false },
                ticks: { padding: 10, font: { size: 11 } }
            }
        }
    }
});

// Graphique statut - Pie chart simple
const statutCtx = document.getElementById('statutChart').getContext('2d');
new Chart(statutCtx, {
    type: 'doughnut',
    data: {
        labels: chartData.statuts.labels,
        datasets: [{
            data: chartData.statuts.data,
            backgroundColor: ['#198754', '#ffc107', '#dc3545'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        cutout: '60%',
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#000',
                bodyColor: '#666',
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12
            }
        }
    }
});
</script>
@endsection

@section('header')
<style>
:root {
    --finance-primary: #0d6efd;
    --finance-success: #198754;
    --finance-warning: #ffc107;
    --finance-info: #0dcaf0;
}

.kpi-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.kpi-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1) !important;
}

.kpi-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.avatar-initials {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 600;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
    flex-shrink: 0;
}

.card {
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
}

.table thead th {
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
    color: #6c757d;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.5rem rgba(0,0,0,0.075) !important;
}

canvas {
    max-height: 300px;
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>
@endsection