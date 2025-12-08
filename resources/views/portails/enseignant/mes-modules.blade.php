@extends('layouts.admin')

@section('titre', 'Mes Modules')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Mes Modules</h4>
            <p class="text-muted mb-0">Gérez vos modules et consultez les étudiants inscrits</p>
        </div>
        <div>
            <span class="badge bg-primary fs-6 px-3 py-2">
                <i class="bx bx-book-alt me-1"></i>
                {{ $modules->count() }} Module(s)
            </span>
        </div>
    </div>

    @if($modules->isNotEmpty())
        <!-- Grille de modules -->
        <div class="row g-4">
            @foreach($modules as $module)
                @php
                    $filiere = $module->ue->semestre->parcours->filiere ?? null;
                    $parcours = $module->ue->semestre->parcours ?? null;
                    $semestre = $module->ue->semestre ?? null;
                    $ue = $module->ue ?? null;
                    
                    // Couleurs par filière (vous pouvez personnaliser selon vos filières)
                    $filiereColors = [
                        'Informatique' => ['bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)', 'icon' => 'bx-code-alt'],
                        'Gestion' => ['bg' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)', 'icon' => 'bx-briefcase'],
                        'Mathématiques' => ['bg' => 'linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)', 'icon' => 'bx-calculator'],
                        'Physique' => ['bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)', 'icon' => 'bx-atom'],
                        'default' => ['bg' => 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)', 'icon' => 'bx-book']
                    ];
                    
                    $filiereNom = $filiere->nom ?? 'default';
                    $colorConfig = $filiereColors[$filiereNom] ?? $filiereColors['default'];
                @endphp
                
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 module-card">
                        <!-- Banderole Filière avec image/gradient -->
                        <div class="card-header-gradient" style="background: {{ $colorConfig['bg'] }}; height: 120px; position: relative; border-radius: 0.5rem 0.5rem 0 0;">
                            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.2);">
                                <div class="text-center text-white">
                                    <i class="bx {{ $colorConfig['icon'] }} display-4 mb-2"></i>
                                    <h6 class="text-white fw-bold mb-0">{{ $filiere->nom ?? 'Filière' }}</h6>
                                </div>
                            </div>
                            <!-- Badge nombre d'étudiants -->
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-white text-dark">
                                    <i class="bx bx-user me-1"></i>{{ $module->inscriptionAdmins->count() }}
                                </span>
                            </div>
                        </div>

                        <!-- Contenu de la carte -->
                        <div class="card-body d-flex flex-column">
                            <!-- Informations du module -->
                            <div class="mb-3">
                                <div class="d-flex align-items-start mb-2">
                                    <span class="badge bg-primary me-2">{{ $module->code_module }}</span>
                                    <h5 class="card-title mb-0 flex-grow-1">{{ $module->libelle }}</h5>
                                </div>
                            </div>

                            <!-- Détails du module -->
                            <div class="module-details mb-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-git-branch text-muted me-2"></i>
                                    <small class="text-muted">
                                        <strong>Parcours:</strong> {{ $parcours->nom ?? 'N/A' }}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bx bx-calendar text-muted me-2"></i>
                                    <small class="text-muted">
                                        <strong>Semestre:</strong> {{ $semestre->libelle ?? 'N/A' }}
                                    </small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bx bx-folder text-muted me-2"></i>
                                    <small class="text-muted">
                                        <strong>UE:</strong> {{ $ue->libelle ?? 'N/A' }}
                                    </small>
                                </div>
                            </div>

                            <!-- Bouton pour voir les étudiants -->
                            <div class="mt-auto">
                                <button class="btn btn-outline-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#modalEtudiants{{ $module->id }}">
                                    <i class="bx bx-list-ul me-2"></i>Voir les étudiants
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal pour la liste des étudiants -->
                <div class="modal fade" id="modalEtudiants{{ $module->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header" style="background: {{ $colorConfig['bg'] }};">
                                <div class="text-white">
                                    <h5 class="modal-title text-white">
                                        <i class="bx {{ $colorConfig['icon'] }} me-2"></i>
                                        {{ $module->code_module }} - {{ $module->libelle }}
                                    </h5>
                                    <small class="text-white-50">{{ $filiere->nom ?? 'Filière' }} - {{ $parcours->nom ?? 'Parcours' }}</small>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <h6 class="text-muted">
                                        <i class="bx bx-user-check me-2"></i>
                                        Liste des Étudiants Inscrits ({{ $module->inscriptionAdmins->count() }})
                                    </h6>
                                </div>
                                
                                @if($module->inscriptionAdmins->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Nom complet</th>
                                                    <th>Email</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($module->inscriptionAdmins as $inscription)
                                                    @if($inscription->etudiant)
                                                    <tr>
                                                        <td>
                                                            <span class="badge bg-label-primary">{{ $loop->iteration }}</span>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="avatar avatar-sm me-2">
                                                                    <span class="avatar-initial rounded-circle bg-label-primary">
                                                                        {{ strtoupper(substr($inscription->etudiant->nom, 0, 1)) }}{{ strtoupper(substr($inscription->etudiant->prenom, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <strong>{{ $inscription->etudiant->nom }} {{ $inscription->etudiant->prenom }}</strong>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="text-muted">{{ $inscription->etudiant->user->email ?? 'N/A' }}</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <div class="dropdown">
                                                                <button type="button" class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <i class="bx bx-user me-2"></i>Voir profil
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="#">
                                                                            <i class="bx bx-envelope me-2"></i>Envoyer un email
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-info mb-0" role="alert">
                                        <i class="bx bx-info-circle me-2"></i>
                                        Aucun étudiant n'est inscrit à ce module pour le moment.
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                <button type="button" class="btn btn-primary">
                                    <i class="bx bx-download me-2"></i>Exporter la liste
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Message si aucun module -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="bx bx-book-open display-1 text-muted mb-3"></i>
                        <h5 class="mb-2">Aucun module assigné</h5>
                        <p class="text-muted mb-4">Aucun module ne vous est assigné pour le moment.</p>
                        <button class="btn btn-primary">
                            <i class="bx bx-plus me-2"></i>Demander une affectation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.module-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.module-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15);
}

.card-header-gradient {
    position: relative;
    overflow: hidden;
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

.module-details {
    font-size: 0.875rem;
}

.module-details i {
    font-size: 1rem;
}

.modal-header {
    border-bottom: none;
}

.avatar-sm {
    width: 32px;
    height: 32px;
}

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    font-weight: 600;
}

@media (max-width: 768px) {
    .module-card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection