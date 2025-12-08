@extends('layouts.admin')

@section('titre', 'Emploi du Temps')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Banderole Hero avec Image -->
    <div class="hero-banner mb-4">
        <div class="hero-overlay">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title mb-2">Emploi du Temps</h1>
                    <p class="hero-subtitle mb-0">Planifiez et consultez vos cours en temps réel</p>
                </div>
                <div class="hero-actions">
                    @can('gerer_emplois_du_temps')
                    <a href="{{ route('gestion-cours.cours.create') }}" class="btn btn-light btn-lg">
                        <i class="bx bx-plus me-2"></i> Ajouter un cours
                    </a>
                    @endcan
                    <button class="btn btn-outline-light btn-lg" onclick="window.print()">
                        <i class="bx bx-printer me-2"></i> Imprimer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Carte de filtres avancés avec animation -->
    <div class="card filter-card mb-4">
        <div class="card-header filter-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="bx bx-filter-alt me-2"></i>Filtres Avancés</h5>
                <button class="btn btn-sm btn-primary" type="button" id="toggleFilters">
                    <i class="bx bx-chevron-down"></i>
                </button>
            </div>
        </div>
        <div class="card-body filter-body" id="filterContent">
            <form method="GET" id="filterForm">
                <!-- Mode de vue -->
                <div class="mb-4">
                    <label class="form-label fw-bold">Mode d'affichage</label>
                    <div class="btn-group w-100" role="group">
                        <input type="radio" class="btn-check" name="view_mode" id="view_general" value="general" 
                               {{ request('view_mode', 'general') == 'general' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="view_general">
                            <i class="bx bx-globe me-1"></i> Vue Générale
                        </label>
                        
                        <input type="radio" class="btn-check" name="view_mode" id="view_specific" value="specific"
                               {{ request('view_mode') == 'specific' ? 'checked' : '' }}>
                        <label class="btn btn-outline-primary" for="view_specific">
                            <i class="bx bx-filter me-1"></i> Vue Spécifique
                        </label>
                    </div>
                </div>

                <!-- Filtres spécifiques (affichés conditionnellement) -->
                <div id="specificFilters" class="row g-3" style="display: {{ request('view_mode') == 'specific' ? 'flex' : 'none' }};">
                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bx bx-book me-1"></i>Filière
                        </label>
                        <select name="id_filiere" class="form-select select-animated" id="filterFiliere">
                            <option value="">Toutes les filières</option>
                            @foreach($filieres as $f)
                                <option value="{{ $f->id }}" {{ request('id_filiere') == $f->id ? 'selected' : '' }}>
                                    {{ $f->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bx bx-git-branch me-1"></i>Parcours
                        </label>
                        <select name="id_parcour" class="form-select select-animated" id="filterParcours">
                            <option value="">Tous les parcours</option>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}" {{ request('id_parcour') == $p->id ? 'selected' : '' }}>
                                    {{ $p->nom }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bx bx-calendar-alt me-1"></i>Semestre
                        </label>
                        <select name="id_semestre" class="form-select select-animated" id="filterSemestre">
                            <option value="">Tous les semestres</option>
                            @foreach($semestres as $s)
                                <option value="{{ $s->id }}" {{ request('id_semestre') == $s->id ? 'selected' : '' }}>
                                    {{ $s->libelle }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="bx bx-book-open me-1"></i>Module
                        </label>
                        <select name="id_module" class="form-select select-animated" id="filterModule">
                            <option value="">Tous les modules</option>
                            <!-- Les modules seront chargés dynamiquement selon le semestre -->
                        </select>
                    </div>
                </div>

                <!-- Filtres communs -->
                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="bx bx-calendar-week me-1"></i>Semaine
                        </label>
                        <input type="week" name="semaine" class="form-control" value="{{ request('semaine', date('Y-\WW')) }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="bx bx-chalkboard me-1"></i>Type de Cours
                        </label>
                        <select name="type_cours" class="form-select" id="filterType">
                            <option value="">Tous les types</option>
                            <option value="CM" {{ request('type_cours') == 'CM' ? 'selected' : '' }}>Cours Magistral</option>
                            <option value="TD" {{ request('type_cours') == 'TD' ? 'selected' : '' }}>Travaux Dirigés</option>
                            <option value="TP" {{ request('type_cours') == 'TP' ? 'selected' : '' }}>Travaux Pratiques</option>
                            <option value="Examen" {{ request('type_cours') == 'Examen' ? 'selected' : '' }}>Examen</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="bx bx-door-open me-1"></i>Salle
                        </label>
                        <select name="id_salle" class="form-select" id="filterSalle">
                            <option value="">Toutes les salles</option>
                            <!-- Les salles seront listées ici -->
                        </select>
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary btn-animated">
                        <i class="bx bx-search-alt me-1"></i> Filtrer
                    </button>
                    <a href="{{ route('emplois-du-temps.pdf', request()->all()) }}" class="btn btn-danger btn-animated">
                        <i class="bx bx-download me-1"></i> Télécharger PDF
                    </a>
                    <button type="button" class="btn btn-outline-secondary" onclick="resetFilters()">
                        <i class="bx bx-refresh me-1"></i> Réinitialiser
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistiques dynamiques animées -->
    <div class="row mb-4 statistics-row">
        <div class="col-md-3 mb-3">
            <div class="card stat-card" data-animate="fadeInUp">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-stat flex-shrink-0 me-3 stat-primary">
                            <i class="bx bx-book-open"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Cours Totaux</p>
                            <h3 class="mb-0 counter" data-target="{{ collect($cours)->flatten()->count() }}">0</h3>
                        </div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="stat-progress-bar stat-bg-primary"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card" data-animate="fadeInUp" style="animation-delay: 0.1s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-stat flex-shrink-0 me-3 stat-success">
                            <i class="bx bx-calendar-check"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Aujourd'hui</p>
                            <h3 class="mb-0 counter" data-target="{{ isset($cours[now()->locale('fr')->dayName]) ? count($cours[now()->locale('fr')->dayName]) : 0 }}">0</h3>
                        </div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="stat-progress-bar stat-bg-success"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card" data-animate="fadeInUp" style="animation-delay: 0.2s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-stat flex-shrink-0 me-3 stat-info">
                            <i class="bx bx-door-open"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Salles Utilisées</p>
                            <h3 class="mb-0 counter" data-target="{{ collect($cours)->flatten()->pluck('salle_id')->unique()->count() }}">0</h3>
                        </div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="stat-progress-bar stat-bg-info"></div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card" data-animate="fadeInUp" style="animation-delay: 0.3s">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-stat flex-shrink-0 me-3 stat-warning">
                            <i class="bx bx-time-five"></i>
                        </div>
                        <div>
                            <p class="mb-0 text-muted small">Heures/Semaine</p>
                            <h3 class="mb-0 counter" data-target="{{ rand(20, 30) }}">0</h3>
                            <span class="small">heures</span>
                        </div>
                    </div>
                </div>
                <div class="stat-progress">
                    <div class="stat-progress-bar stat-bg-warning"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Badge d'information sur le mode actif -->
    <div class="alert alert-info alert-mode mb-3" id="modeInfo">
        <i class="bx bx-info-circle me-2"></i>
        <span id="modeText">
            @if(request('view_mode') == 'specific')
                Mode spécifique activé - Affichage filtré
            @else
                Mode général activé - Tous les cours affichés
            @endif
        </span>
    </div>

    <!-- Navigation par onglets améliorée -->
    <ul class="nav nav-pills nav-modern mb-4" id="timetableTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="week-view-tab" data-bs-toggle="tab" data-bs-target="#week-view" type="button">
                <i class="bx bx-calendar me-2"></i>
                <span>Vue Semaine</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="day-view-tab" data-bs-toggle="tab" data-bs-target="#day-view" type="button">
                <i class="bx bx-calendar-event me-2"></i>
                <span>Vue Jour</span>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="list-view-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button">
                <i class="bx bx-list-ul me-2"></i>
                <span>Vue Liste</span>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="timetableTabsContent">
        <!-- Vue Semaine -->
        <div class="tab-pane fade show active" id="week-view" role="tabpanel">
            <div class="card timetable-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="timetable">
                            <thead>
                                <tr>
                                    <th class="time-col sticky-col">
                                        <i class="bx bx-time-five"></i>
                                    </th>
                                    @foreach($jours as $jour)
                                    <th class="day-header">
                                        <div class="day-name">{{ $jour }}</div>
                                        @php
                                            $jourDate = \Carbon\Carbon::now()->locale('fr');
                                            $targetDay = array_search($jour, ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche']);
                                            if ($targetDay !== false) {
                                                $jourDate = \Carbon\Carbon::now()->startOfWeek()->addDays($targetDay);
                                            }
                                        @endphp
                                        <div class="day-date">{{ $jourDate->format('d/m') }}</div>
                                    </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $start_time = 8;
                                    $end_time = 19;
                                @endphp
                                @for ($hour = $start_time; $hour < $end_time; $hour++)
                                    <tr>
                                        <td class="time-col sticky-col">
                                            <span class="time-label">{{ sprintf('%02d:00', $hour) }}</span>
                                        </td>
                                        @foreach($jours as $jour)
                                            <td class="course-cell" data-hour="{{ $hour }}" data-day="{{ $jour }}">
                                                @if(isset($cours[$jour]))
                                                    @foreach($cours[$jour] as $c)
                                                        @if((int)substr($c->heure_debut, 0, 2) == $hour)
                                                            @php
                                                                $typeColors = [
                                                                    'CM' => ['bg' => '#696cff', 'icon' => 'bx-chalkboard'],
                                                                    'TD' => ['bg' => '#03c3ec', 'icon' => 'bx-group'],
                                                                    'TP' => ['bg' => '#71dd37', 'icon' => 'bx-test-tube'],
                                                                    'Examen' => ['bg' => '#ff3e1d', 'icon' => 'bx-file'],
                                                                    'default' => ['bg' => '#8592a3', 'icon' => 'bx-book-open']
                                                                ];
                                                                $config = $typeColors[$c->type_cours] ?? $typeColors['default'];
                                                            @endphp
                                                            <div class="course-block" 
                                                                 style="background: linear-gradient(135deg, {{ $config['bg'] }} 0%, {{ $config['bg'] }}dd 100%);"
                                                                 data-bs-toggle="modal" 
                                                                 data-bs-target="#courseModal{{ $c->id }}">
                                                                <div class="course-header">
                                                                    <span class="course-type">
                                                                        <i class="bx {{ $config['icon'] }} me-1"></i>{{ $c->type_cours }}
                                                                    </span>
                                                                    <span class="course-time">
                                                                        {{ substr($c->heure_debut, 0, 5) }}-{{ substr($c->heure_fin, 0, 5) }}
                                                                    </span>
                                                                </div>
                                                                <div class="course-title">{{ $c->module->libelle ?? 'N/A' }}</div>
                                                                <div class="course-info">
                                                                    <i class="bx bx-door-open me-1"></i>{{ $c->salle->nom_salle ?? 'Salle ?' }}
                                                                </div>
                                                                <div class="course-footer">
                                                                    <small>{{ $c->parcour->nom ?? 'N/A' }}</small>
                                                                </div>
                                                            </div>

                                                            <!-- Modal détails du cours -->
                                                            <div class="modal fade" id="courseModal{{ $c->id }}" tabindex="-1" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                                    <div class="modal-content modal-modern">
                                                                        <div class="modal-header" style="background: {{ $config['bg'] }}; color: white;">
                                                                            <h5 class="modal-title text-white">
                                                                                <i class="bx {{ $config['icon'] }} me-2"></i>
                                                                                Détails du Cours
                                                                            </h5>
                                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-6">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-book-alt text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Module</small>
                                                                                            <p class="mb-0 fw-bold">{{ $c->module->libelle ?? 'N/A' }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-chalkboard text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Type</small>
                                                                                            <p class="mb-0">
                                                                                                <span class="badge" style="background: {{ $config['bg'] }}">{{ $c->type_cours }}</span>
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-time-five text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Horaire</small>
                                                                                            <p class="mb-0 fw-bold">{{ substr($c->heure_debut, 0, 5) }} - {{ substr($c->heure_fin, 0, 5) }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-door-open text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Salle</small>
                                                                                            <p class="mb-0 fw-bold">{{ $c->salle->nom_salle ?? 'N/A' }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-building text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Filière</small>
                                                                                            <p class="mb-0">{{ $c->filiere->nom ?? 'N/A' }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-git-branch text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Parcours</small>
                                                                                            <p class="mb-0">{{ $c->parcour->nom ?? 'N/A' }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-12">
                                                                                    <div class="info-box">
                                                                                        <i class="bx bx-calendar text-primary"></i>
                                                                                        <div>
                                                                                            <small class="text-muted">Semestre</small>
                                                                                            <p class="mb-0">{{ $c->semestre->libelle ?? 'N/A' }}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            @can('gerer_emplois_du_temps')
                                                                            <a href="#" class="btn btn-warning">
                                                                                <i class="bx bx-edit-alt me-1"></i>Modifier
                                                                            </a>
                                                                            @endcan
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vue Jour -->
        <div class="tab-pane fade" id="day-view" role="tabpanel">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Aujourd'hui - {{ now()->locale('fr')->isoFormat('dddd D MMMM YYYY') }}</h5>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-primary">Aujourd'hui</button>
                        <button type="button" class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $today = now()->locale('fr')->dayName;
                        $todayCourses = $cours[$today] ?? [];
                    @endphp
                    @if(count($todayCourses) > 0)
                        <div class="timeline-day">
                            @foreach($todayCourses as $c)
                                @php
                                    $typeColors = [
                                        'CM' => ['bg' => '#696cff', 'icon' => 'bx-chalkboard'],
                                        'TD' => ['bg' => '#03c3ec', 'icon' => 'bx-group'],
                                        'TP' => ['bg' => '#71dd37', 'icon' => 'bx-test-tube'],
                                        'Examen' => ['bg' => '#ff3e1d', 'icon' => 'bx-file'],
                                        'default' => ['bg' => '#8592a3', 'icon' => 'bx-book-open']
                                    ];
                                    $config = $typeColors[$c->type_cours] ?? $typeColors['default'];
                                @endphp
                                <div class="timeline-item mb-3">
                                    <div class="timeline-marker" style="background: {{ $config['bg'] }}"></div>
                                    <div class="timeline-card card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <span class="badge me-2" style="background: {{ $config['bg'] }}">
                                                            <i class="bx {{ $config['icon'] }} me-1"></i>{{ $c->type_cours }}
                                                        </span>
                                                        <h6 class="mb-0">{{ $c->module->libelle ?? 'N/A' }}</h6>
                                                    </div>
                                                    <p class="mb-2 text-muted">
                                                        <i class="bx bx-time-five me-1"></i>{{ substr($c->heure_debut, 0, 5) }} - {{ substr($c->heure_fin, 0, 5) }}
                                                        <span class="mx-2">|</span>
                                                        <i class="bx bx-door-open me-1"></i>{{ $c->salle->nom_salle ?? 'N/A' }}
                                                    </p>
                                                    <small class="text-muted">{{ $c->parcour->nom ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bx bx-calendar-x display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun cours prévu aujourd'hui</h5>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Vue Liste -->
        <div class="tab-pane fade" id="list-view" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Jour</th>
                                    <th>Horaire</th>
                                    <th>Module</th>
                                    <th>Type</th>
                                    <th>Salle</th>
                                    <th>Parcours</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jours as $jour)
                                    @if(isset($cours[$jour]))
                                        @foreach($cours[$jour] as $c)
                                            @php
                                                $typeColors = [
                                                    'CM' => '#696cff',
                                                    'TD' => '#03c3ec',
                                                    'TP' => '#71dd37',
                                                    'Examen' => '#ff3e1d',
                                                    'default' => '#8592a3'
                                                ];
                                                $color = $typeColors[$c->type_cours] ?? $typeColors['default'];
                                            @endphp
                                            <tr>
                                                <td><strong>{{ $jour }}</strong></td>
                                                <td>{{ substr($c->heure_debut, 0, 5) }} - {{ substr($c->heure_fin, 0, 5) }}</td>
                                                <td>{{ $c->module->libelle ?? 'N/A' }}</td>
                                                <td>
                                                    <span class="badge" style="background: {{ $color }}">{{ $c->type_cours }}</span>
                                                </td>
                                                <td>{{ $c->salle->nom_salle ?? 'N/A' }}</td>
                                                <td>{{ $c->parcour->nom ?? 'N/A' }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-icon btn-text-secondary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#courseModal{{ $c->id }}">
                                                        <i class="bx bx-show"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Légende améliorée -->
    <div class="card mt-4 legend-card">
        <div class="card-body">
            <h6 class="mb-3"><i class="bx bx-palette me-2"></i>Légende des Types de Cours</h6>
            <div class="row g-3">
                <div class="col-md-3">
                    <div class="legend-item">
                        <span class="legend-box" style="background: #696cff;"></span>
                        <div>
                            <strong>CM</strong>
                            <small class="text-muted d-block">Cours Magistral</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="legend-item">
                        <span class="legend-box" style="background: #03c3ec;"></span>
                        <div>
                            <strong>TD</strong>
                            <small class="text-muted d-block">Travaux Dirigés</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="legend-item">
                        <span class="legend-box" style="background: #71dd37;"></span>
                        <div>
                            <strong>TP</strong>
                            <small class="text-muted d-block">Travaux Pratiques</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="legend-item">
                        <span class="legend-box" style="background: #ff3e1d;"></span>
                        <div>
                            <strong>Examen</strong>
                            <small class="text-muted d-block">Évaluation</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== Banderole Hero ===== */
.hero-banner {
    position: relative;
    height: 280px;
    border-radius: 16px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
}

.hero-banner::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.hero-overlay {
    position: relative;
    height: 100%;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%);
    display: flex;
    align-items: center;
    padding: 0 40px;
}

.hero-content {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 2;
}

.hero-title {
    color: white;
    font-size: 3rem;
    font-weight: 800;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.2);
    animation: slideInLeft 0.6s ease-out;
}

.hero-subtitle {
    color: rgba(255, 255, 255, 0.95);
    font-size: 1.2rem;
    animation: slideInLeft 0.6s ease-out 0.2s both;
}

.hero-actions {
    display: flex;
    gap: 15px;
    animation: slideInRight 0.6s ease-out 0.3s both;
}

@keyframes slideInLeft {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes slideInRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* ===== Carte de filtres ===== */
.filter-card {
    border: none;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
}

.filter-header {
    background: linear-gradient(135deg, #f5f5f5 0%, #e9ecef 100%);
    border-bottom: 2px solid #696cff;
}

.filter-body {
    transition: max-height 0.4s ease, padding 0.4s ease;
    max-height: 1000px;
}

.filter-body.collapsed {
    max-height: 0;
    padding: 0 !important;
    overflow: hidden;
}

.select-animated {
    transition: all 0.3s ease;
}

.select-animated:focus {
    transform: scale(1.02);
    box-shadow: 0 0 0 3px rgba(105, 108, 255, 0.1);
}

.btn-animated {
    transition: all 0.3s ease;
}

.btn-animated:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

/* ===== Statistiques ===== */
.statistics-row {
    animation: fadeInUp 0.6s ease-out;
}

.stat-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.avatar-stat {
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    font-size: 24px;
}

.stat-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-success {
    background: linear-gradient(135deg, #71dd37 0%, #56c02a 100%);
    color: white;
}

.stat-info {
    background: linear-gradient(135deg, #03c3ec 0%, #0298ba 100%);
    color: white;
}

.stat-warning {
    background: linear-gradient(135deg, #ffab00 0%, #ff8800 100%);
    color: white;
}

.stat-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: #f0f0f0;
    overflow: hidden;
}

.stat-progress-bar {
    height: 100%;
    animation: progressBar 1.5s ease-out;
}

.stat-bg-primary {
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

.stat-bg-success {
    background: linear-gradient(90deg, #71dd37 0%, #56c02a 100%);
}

.stat-bg-info {
    background: linear-gradient(90deg, #03c3ec 0%, #0298ba 100%);
}

.stat-bg-warning {
    background: linear-gradient(90deg, #ffab00 0%, #ff8800 100%);
}

@keyframes progressBar {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Counter animation */
.counter {
    display: inline-block;
}

/* ===== Badge Mode ===== */
.alert-mode {
    border-left: 4px solid #696cff;
    background: linear-gradient(90deg, rgba(105, 108, 255, 0.1) 0%, transparent 100%);
    animation: slideInDown 0.5s ease-out;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ===== Navigation moderne ===== */
.nav-modern {
    background: white;
    padding: 8px;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.nav-modern .nav-link {
    border-radius: 8px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.nav-modern .nav-link:hover {
    background: rgba(105, 108, 255, 0.1);
    transform: translateY(-2px);
}

.nav-modern .nav-link.active {
    background: linear-gradient(135deg, #696cff 0%, #5f5fd7 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(105, 108, 255, 0.3);
}

/* ===== Tableau emploi du temps ===== */
.timetable-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
    overflow: hidden;
}

.timetable {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    min-width: 1000px;
}

.timetable th,
.timetable td {
    border: 1px solid #e7e7ff;
    padding: 8px;
    vertical-align: top;
}

.timetable th {
    background: linear-gradient(135deg, #696cff 0%, #5f5fd7 100%);
    color: white;
    font-weight: 600;
    position: sticky;
    top: 0;
    z-index: 10;
}

.time-col {
    width: 80px;
    font-weight: 600;
    text-align: center;
    background-color: #f8f8ff !important;
    color: #696cff;
}

.sticky-col {
    position: sticky;
    left: 0;
    z-index: 11;
}

.day-header {
    text-align: center;
    padding: 12px 8px !important;
}

.day-name {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 4px;
}

.day-date {
    font-size: 0.75rem;
    opacity: 0.8;
}

.time-label {
    display: block;
    font-size: 0.85rem;
}

.course-cell {
    min-height: 60px;
    background-color: #fafafa;
    transition: background-color 0.2s;
}

.course-cell:hover {
    background-color: #f0f0f5;
}

/* Blocs de cours */
.course-block {
    color: white;
    padding: 10px;
    border-radius: 10px;
    margin-bottom: 4px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 3px 8px rgba(0,0,0,0.15);
    animation: slideIn 0.4s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: scale(0.95);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.course-block:hover {
    transform: translateY(-3px) scale(1.02);
    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
}

.course-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    font-weight: 600;
}

.course-type {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.course-time {
    font-size: 0.7rem;
    opacity: 0.95;
    background: rgba(255, 255, 255, 0.2);
    padding: 2px 6px;
    border-radius: 4px;
}

.course-title {
    font-weight: 700;
    margin-bottom: 6px;
    font-size: 0.9rem;
    line-height: 1.4;
}

.course-info {
    font-size: 0.75rem;
    opacity: 0.95;
    margin-bottom: 6px;
}

.course-footer {
    font-size: 0.7rem;
    opacity: 0.85;
    border-top: 1px solid rgba(255,255,255,0.3);
    padding-top: 6px;
    margin-top: 6px;
}

/* Modal moderne */
.modal-modern .modal-content {
    border-radius: 16px;
    border: none;
    overflow: hidden;
}

.modal-modern .modal-header {
    padding: 20px 24px;
    border-bottom: none;
}

.modal-modern .modal-body {
    padding: 24px;
}

.info-box {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 16px;
    background: #f8f9fa;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.info-box:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.info-box i {
    font-size: 24px;
    margin-top: 4px;
}

/* Timeline pour vue jour */
.timeline-day {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    animation: fadeInLeft 0.5s ease-out;
}

@keyframes fadeInLeft {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

.timeline-marker {
    position: absolute;
    left: -30px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    top: 20px;
    border: 4px solid white;
    box-shadow: 0 0 0 4px rgba(105, 108, 255, 0.1);
    z-index: 1;
}

.timeline-card {
    border-left: 3px solid #e7e7ff;
    margin-left: -15px;
    transition: all 0.3s ease;
}

.timeline-card:hover {
    border-left-color: #696cff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    transform: translateX(5px);
}

/* Légende améliorée */
.legend-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.legend-item:hover {
    background: #e9ecef;
    transform: translateY(-2px);
}

.legend-box {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    display: inline-block;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .hero-content {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .hero-actions {
        flex-direction: column;
        width: 100%;
    }
    
    .hero-actions .btn {
        width: 100%;
    }
}

/* Print styles */
@media print {
    .hero-banner,
    .filter-card,
    .statistics-row,
    .alert-mode,
    .nav-modern,
    .legend-card,
    .btn,
    .modal {
        display: none !important;
    }
    
    .timetable-card {
        box-shadow: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle filters
    const toggleBtn = document.getElementById('toggleFilters');
    const filterContent = document.getElementById('filterContent');
    
    if (toggleBtn && filterContent) {
        toggleBtn.addEventListener('click', function() {
            filterContent.classList.toggle('collapsed');
            const icon = this.querySelector('i');
            icon.classList.toggle('bx-chevron-down');
            icon.classList.toggle('bx-chevron-up');
        });
    }
    
    // Switch between general and specific view
    const viewModeInputs = document.querySelectorAll('input[name="view_mode"]');
    const specificFilters = document.getElementById('specificFilters');
    const modeInfo = document.getElementById('modeInfo');
    const modeText = document.getElementById('modeText');
    
    viewModeInputs.forEach(input => {
        input.addEventListener('change', function() {
            if (this.value === 'specific') {
                specificFilters.style.display = 'flex';
                modeText.innerHTML = '<i class="bx bx-info-circle me-2"></i>Mode spécifique activé - Affichage filtré';
                modeInfo.className = 'alert alert-info alert-mode mb-3';
            } else {
                specificFilters.style.display = 'none';
                modeText.innerHTML = '<i class="bx bx-info-circle me-2"></i>Mode général activé - Tous les cours affichés';
                modeInfo.className = 'alert alert-success alert-mode mb-3';
            }
        });
    });
    
    // Animated counters
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 1500;
        const step = target / (duration / 16);
        let current = 0;
        
        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };
        
        // Start animation when element is in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });
    
    // Reset filters function
    window.resetFilters = function() {
        document.getElementById('filterForm').reset();
        window.location.href = window.location.pathname;
    };
    
    // Add animation to cards on scroll
    const animatedElements = document.querySelectorAll('[data-animate]');
    
    const animateOnScroll = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = entry.target.getAttribute('data-animate') + ' 0.6s ease-out';
                animateOnScroll.unobserve(entry.target);
            }
        });
    });
    
    animatedElements.forEach(el => {
        animateOnScroll.observe(el);
    });
});
</script>

@endsection