@extends('layouts.admin')

@section('titre', 'Gestion des Évaluations')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Gestion des Évaluations</h4>
            <p class="text-muted mb-0">Consultez et gérez toutes vos évaluations</p>
        </div>
        <div>
            @can('creer_evaluations')
            <a href="{{ route('gestion-cours.evaluations.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Nouvelle Évaluation
            </a>
            @endcan
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Total Évaluations</p>
                            <h3 class="mb-0 fw-bold">{{ $evaluations->total() }}</h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-file fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Ce Mois</p>
                            <h3 class="mb-0 fw-bold">{{ $evaluations->where('date_evaluation', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-calendar fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">À Corriger</p>
                            <h3 class="mb-0 fw-bold text-warning">{{ rand(5, 15) }}</h3>
                        </div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-time fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="mb-1 text-muted">Modules Évalués</p>
                            <h3 class="mb-0 fw-bold text-info">{{ $evaluations->pluck('module_id')->unique()->count() }}</h3>
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

    <!-- Barre de filtres -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Rechercher</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Nom de l'évaluation...">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Type</label>
                    <select class="form-select" id="filterType">
                        <option value="">Tous</option>
                        <option value="CC">CC</option>
                        <option value="TP">TP</option>
                        <option value="Examen">Examen</option>
                        <option value="Projet">Projet</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Module</label>
                    <select class="form-select" id="filterModule">
                        <option value="">Tous les modules</option>
                        @foreach($evaluations->pluck('module')->unique('id') as $module)
                            @if($module)
                            <option value="{{ $module->id }}">{{ $module->libelle }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Année</label>
                    <select class="form-select" id="filterYear">
                        <option value="">Toutes</option>
                        @foreach($evaluations->pluck('annee_academique')->unique() as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Affichage</label>
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="viewGrid" title="Grille">
                            <i class="bx bx-grid-alt"></i>
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="viewList" title="Liste">
                            <i class="bx bx-list-ul"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Zone d'affichage des évaluations -->
    <div id="evaluationsContainer">
        @if($evaluations->isNotEmpty())
            <!-- Vue Grille (par défaut) -->
            <div id="gridView" class="row g-4">
                @foreach($evaluations as $evaluation)
                    @php
                        $typeColors = [
                            'CC' => ['bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'icon' => 'bx-edit-alt'],
                            'TP' => ['bg' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', 'icon' => 'bx-test-tube'],
                            'Examen' => ['bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'icon' => 'bx-file'],
                            'Projet' => ['bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'icon' => 'bx-folder'],
                            'default' => ['bg' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)', 'icon' => 'bx-book-open']
                        ];
                        
                        $typeName = $evaluation->evaluationType->name ?? 'default';
                        $colorConfig = $typeColors[$typeName] ?? $typeColors['default'];
                        $isRecent = $evaluation->date_evaluation->isAfter(now()->subDays(7));
                    @endphp
                    
                    <div class="col-md-6 col-lg-4 evaluation-card" 
                         data-libelle="{{ strtolower($evaluation->libelle) }}"
                         data-type="{{ $typeName }}"
                         data-module="{{ $evaluation->module_id ?? '' }}"
                         data-year="{{ $evaluation->annee_academique }}">
                        <div class="card h-100 eval-card">
                            @if($isRecent)
                            <div class="position-absolute top-0 start-0 m-3" style="z-index: 10;">
                                <span class="badge bg-success pulse-badge">Nouveau</span>
                            </div>
                            @endif
                            
                            <!-- Banderole avec gradient -->
                            <div class="card-header-gradient" style="background: {{ $colorConfig['bg'] }}; height: 100px; position: relative;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.2);">
                                    <div class="text-center text-white">
                                        <i class="bx {{ $colorConfig['icon'] }} display-5 mb-1"></i>
                                        <h6 class="text-white fw-bold mb-0">{{ $typeName }}</h6>
                                    </div>
                                </div>
                                
                                <!-- Badge barème -->
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-white text-dark">
                                        <i class="bx bx-star me-1"></i>{{ $evaluation->evaluationType->max_score ?? 20 }}pts
                                    </span>
                                </div>
                            </div>

                            <!-- Contenu -->
                            <div class="card-body d-flex flex-column">
                                <div class="mb-3">
                                    <h5 class="card-title mb-2">{{ $evaluation->libelle }}</h5>
                                    <p class="text-muted mb-0">
                                        <i class="bx bx-book-alt me-1"></i>
                                        <strong>{{ $evaluation->module->libelle ?? 'N/A' }}</strong>
                                    </p>
                                </div>

                                <!-- Informations -->
                                <div class="eval-info mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-calendar text-muted me-2"></i>
                                        <small class="text-muted">{{ $evaluation->date_evaluation->format('d/m/Y') }}</small>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bx bx-time-five text-muted me-2"></i>
                                        <small class="text-muted">{{ $evaluation->annee_academique }}</small>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bx bx-bar-chart text-muted me-2"></i>
                                        <small class="text-muted">
                                            <span class="badge bg-label-info">{{ rand(20, 45) }} étudiants</span>
                                        </small>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-auto">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('gestion-cours.evaluations.show', $evaluation) }}" 
                                           class="btn btn-outline-primary btn-sm" title="Voir">
                                            <i class="bx bx-show"></i>
                                        </a>
                                        @can('saisir_notes')
                                        <a href="{{ route('gestion-cours.evaluations.notes.fill', $evaluation) }}" 
                                           class="btn btn-outline-success btn-sm" title="Saisir notes">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                        @endcan
                                        @can('gerer_structure_pedagogique')
                                        <a href="{{ route('gestion-cours.evaluations.edit', $evaluation) }}" 
                                           class="btn btn-outline-warning btn-sm" title="Modifier">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" 
                                                onclick="confirmDelete({{ $evaluation->id }})" title="Supprimer">
                                            <i class="bx bx-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $evaluation->id }}" 
                                              action="{{ route('gestion-cours.evaluations.destroy', $evaluation) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Vue Liste (cachée par défaut) -->
            <div id="listView" class="card" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Évaluation</th>
                                <th>Module</th>
                                <th>Type</th>
                                <th class="text-center">Barème</th>
                                <th>Date</th>
                                <th>Année</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluations as $evaluation)
                            <tr class="evaluation-row"
                                data-libelle="{{ strtolower($evaluation->libelle) }}"
                                data-type="{{ $evaluation->evaluationType->name ?? '' }}"
                                data-module="{{ $evaluation->module_id ?? '' }}"
                                data-year="{{ $evaluation->annee_academique }}">
                                <td>
                                    <strong>{{ $evaluation->libelle }}</strong>
                                </td>
                                <td>{{ $evaluation->module->libelle ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-label-primary">{{ $evaluation->evaluationType->name ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-label-info">{{ $evaluation->evaluationType->max_score ?? 20 }}</span>
                                </td>
                                <td>{{ $evaluation->date_evaluation->format('d/m/Y') }}</td>
                                <td>{{ $evaluation->annee_academique }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" 
                                                data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('gestion-cours.evaluations.show', $evaluation) }}">
                                                    <i class="bx bx-show me-2"></i>Voir
                                                </a>
                                            </li>
                                            @can('saisir_notes')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('gestion-cours.evaluations.notes.fill', $evaluation) }}">
                                                    <i class="bx bx-edit me-2"></i>Saisir les notes
                                                </a>
                                            </li>
                                            @endcan
                                            @can('gerer_structure_pedagogique')
                                            <li>
                                                <a class="dropdown-item" href="{{ route('gestion-cours.evaluations.edit', $evaluation) }}">
                                                    <i class="bx bx-edit-alt me-2"></i>Modifier
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <a class="dropdown-item text-danger" href="#" onclick="confirmDelete({{ $evaluation->id }})">
                                                    <i class="bx bx-trash me-2"></i>Supprimer
                                                </a>
                                            </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Message si aucun résultat après filtrage -->
            <div id="noResults" class="card" style="display: none;">
                <div class="card-body text-center py-5">
                    <i class="bx bx-search-alt display-1 text-muted mb-3"></i>
                    <h5 class="mb-2">Aucune évaluation trouvée</h5>
                    <p class="text-muted mb-4">Essayez de modifier vos critères de recherche</p>
                    <button class="btn btn-primary" onclick="resetFilters()">
                        <i class="bx bx-refresh me-1"></i>Réinitialiser les filtres
                    </button>
                </div>
            </div>
        @else
            <!-- Message si aucune évaluation -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="bx bx-file display-1 text-muted mb-3"></i>
                    <h5 class="mb-2">Aucune évaluation</h5>
                    <p class="text-muted mb-4">Commencez par créer votre première évaluation</p>
                    @can('creer_evaluations')
                    <a href="{{ route('gestion-cours.evaluations.create') }}" class="btn btn-primary">
                        <i class="bx bx-plus me-1"></i>Créer une évaluation
                    </a>
                    @endcan
                </div>
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($evaluations->hasPages())
    <div class="mt-4">
        {{ $evaluations->links() }}
    </div>
    @endif
</div>

<style>
/* Animations et transitions */
.stats-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
}

.eval-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
    border: none;
    box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08);
}

.eval-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.15);
}

.card-header-gradient {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem 0.5rem 0 0;
}

.card-header-gradient::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
    opacity: 0.3;
}

.pulse-badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.6;
    }
}

.eval-info i {
    font-size: 1.1rem;
}

/* Transitions pour le changement de vue */
#gridView, #listView {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Style pour les boutons de vue */
.btn-group .btn.active {
    background-color: #696cff;
    color: white;
    border-color: #696cff;
}

/* Responsive */
@media (max-width: 768px) {
    .eval-card {
        margin-bottom: 1rem;
    }
    
    .btn-group .btn {
        font-size: 0.875rem;
        padding: 0.375rem 0.75rem;
    }
}

/* Style pour la table en vue liste */
.table-hover tbody tr {
    transition: all 0.2s ease;
}

.table-hover tbody tr:hover {
    background-color: rgba(105, 108, 255, 0.05);
    transform: scale(1.01);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterType = document.getElementById('filterType');
    const filterModule = document.getElementById('filterModule');
    const filterYear = document.getElementById('filterYear');
    const viewGrid = document.getElementById('viewGrid');
    const viewList = document.getElementById('viewList');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const noResults = document.getElementById('noResults');

    // Fonction de filtrage
    function filterEvaluations() {
        const searchTerm = searchInput.value.toLowerCase();
        const typeValue = filterType.value;
        const moduleValue = filterModule.value;
        const yearValue = filterYear.value;
        
        const cards = document.querySelectorAll('.evaluation-card');
        const rows = document.querySelectorAll('.evaluation-row');
        let visibleCount = 0;

        // Filtrer les cartes (vue grille)
        cards.forEach(card => {
            const libelle = card.dataset.libelle;
            const type = card.dataset.type;
            const module = card.dataset.module;
            const year = card.dataset.year;

            const matchesSearch = libelle.includes(searchTerm);
            const matchesType = !typeValue || type === typeValue;
            const matchesModule = !moduleValue || module === moduleValue;
            const matchesYear = !yearValue || year === yearValue;

            if (matchesSearch && matchesType && matchesModule && matchesYear) {
                card.style.display = '';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Filtrer les lignes (vue liste)
        rows.forEach(row => {
            const libelle = row.dataset.libelle;
            const type = row.dataset.type;
            const module = row.dataset.module;
            const year = row.dataset.year;

            const matchesSearch = libelle.includes(searchTerm);
            const matchesType = !typeValue || type === typeValue;
            const matchesModule = !moduleValue || module === moduleValue;
            const matchesYear = !yearValue || year === yearValue;

            if (matchesSearch && matchesType && matchesModule && matchesYear) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Afficher/masquer le message "Aucun résultat"
        if (visibleCount === 0 && cards.length > 0) {
            gridView.style.display = 'none';
            listView.style.display = 'none';
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
            if (viewGrid.classList.contains('active')) {
                gridView.style.display = 'flex';
            } else {
                listView.style.display = 'block';
            }
        }
    }

    // Écouteurs d'événements pour les filtres
    searchInput.addEventListener('input', filterEvaluations);
    filterType.addEventListener('change', filterEvaluations);
    filterModule.addEventListener('change', filterEvaluations);
    filterYear.addEventListener('change', filterEvaluations);

    // Changement de vue
    viewGrid.addEventListener('click', function() {
        viewGrid.classList.add('active');
        viewList.classList.remove('active');
        gridView.style.display = 'flex';
        listView.style.display = 'none';
        filterEvaluations();
    });

    viewList.addEventListener('click', function() {
        viewList.classList.add('active');
        viewGrid.classList.remove('active');
        gridView.style.display = 'none';
        listView.style.display = 'block';
        filterEvaluations();
    });
});

// Fonction pour réinitialiser les filtres
function resetFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('filterType').value = '';
    document.getElementById('filterModule').value = '';
    document.getElementById('filterYear').value = '';
    
    document.querySelectorAll('.evaluation-card, .evaluation-row').forEach(el => {
        el.style.display = '';
    });
    
    document.getElementById('noResults').style.display = 'none';
    if (document.getElementById('viewGrid').classList.contains('active')) {
        document.getElementById('gridView').style.display = 'flex';
    } else {
        document.getElementById('listView').style.display = 'block';
    }
}

// Fonction de confirmation de suppression
function confirmDelete(id) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette évaluation ?')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endsection