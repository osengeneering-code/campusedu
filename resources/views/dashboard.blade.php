@extends('layouts.admin')

@section('content')
<!-- En-tête -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Tableau de bord</h4>
        <p class="text-muted mb-0">Vue d'ensemble de votre établissement</p>
    </div>
    <div>
        <button class="btn btn-primary">
            <i class="bx bx-download me-1"></i> Exporter
        </button>
    </div>
</div>

<!-- Cartes statistiques -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-muted">Étudiants</p>
                        <h3 class="mb-0">2,847</h3>
                        <small class="text-success">+12.5%</small>
                    </div>
                    <div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="bx bx-user fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-muted">Enseignants</p>
                        <h3 class="mb-0">187</h3>
                        <small class="text-success">+5.2%</small>
                    </div>
                    <div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="bx bx-briefcase fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-muted">Revenus ce mois</p>
                        <h3 class="mb-0">845M</h3>
                        <small class="text-success">+18.2%</small>
                    </div>
                    <div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="bx bx-wallet fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="mb-1 text-muted">Taux présence</p>
                        <h3 class="mb-0">94.3%</h3>
                        <small class="text-warning">-2.1%</small>
                    </div>
                    <div>
                        <div class="avatar">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="bx bx-check-circle fs-4"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="row mb-4">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">Évolution des inscriptions</h5>
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
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Par niveau</h5>
            </div>
            <div class="card-body">
                <canvas id="niveauxChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Emploi du temps aujourd'hui -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Emploi du temps - Aujourd'hui</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
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
                            <tr>
                                <td><strong>08h00 - 10h00</strong></td>
                                <td>Programmation Web</td>
                                <td>Dr. DIALLO</td>
                                <td>Salle A101</td>
                                <td><span class="badge bg-label-primary">L3 Info</span></td>
                                <td><span class="badge bg-success">En cours</span></td>
                            </tr>
                            <tr>
                                <td><strong>10h00 - 12h00</strong></td>
                                <td>Comptabilité Générale</td>
                                <td>Prof. KONE</td>
                                <td>Salle B204</td>
                                <td><span class="badge bg-label-info">L1 Gestion</span></td>
                                <td><span class="badge bg-primary">Planifié</span></td>
                            </tr>
                            <tr>
                                <td><strong>14h00 - 16h00</strong></td>
                                <td>Droit Civil</td>
                                <td>Me. KOUASSI</td>
                                <td>Amphi C</td>
                                <td><span class="badge bg-label-warning">L2 Droit</span></td>
                                <td><span class="badge bg-primary">Planifié</span></td>
                            </tr>
                            <tr>
                                <td><strong>16h00 - 18h00</strong></td>
                                <td>Anatomie</td>
                                <td>Dr. TRAORE</td>
                                <td>Labo 3</td>
                                <td><span class="badge bg-label-success">L1 Médecine</span></td>
                                <td><span class="badge bg-primary">Planifié</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des départements et Bourses -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Départements</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Département</th>
                            <th>Chef</th>
                            <th>Étudiants</th>
                            <th>Enseignants</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                    Informatique
                                </div>
                            </td>
                            <td>Dr. DIALLO</td>
                            <td>687</td>
                            <td>24</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                    Gestion
                                </div>
                            </td>
                            <td>Prof. KONE</td>
                            <td>542</td>
                            <td>18</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                    Droit
                                </div>
                            </td>
                            <td>Me. KOUASSI</td>
                            <td>498</td>
                            <td>22</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                    Médecine
                                </div>
                            </td>
                            <td>Dr. TRAORE</td>
                            <td>425</td>
                            <td>32</td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger rounded-circle me-2" style="width: 8px; height: 8px;"></span>
                                    Architecture
                                </div>
                            </td>
                            <td>Arch. OUATTARA</td>
                            <td>387</td>
                            <td>15</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Bourses actives</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">Gérer</a>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">Bourse d'Excellence</h6>
                            <small class="text-muted">245 bénéficiaires</small>
                        </div>
                        <span class="badge bg-success">100%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">Bourse Sociale</h6>
                            <small class="text-muted">187 bénéficiaires</small>
                        </div>
                        <span class="badge bg-warning">75%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-warning" style="width: 75%"></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">Bourse Sportive</h6>
                            <small class="text-muted">42 bénéficiaires</small>
                        </div>
                        <span class="badge bg-info">80%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-info" style="width: 80%"></div>
                    </div>
                </div>

                <div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <h6 class="mb-0">Bourse Internationale</h6>
                            <small class="text-muted">28 bénéficiaires</small>
                        </div>
                        <span class="badge bg-primary">60%</span>
                    </div>
                    <div class="progress" style="height: 6px;">
                        <div class="progress-bar bg-primary" style="width: 60%"></div>
                    </div>
                </div>

                <div class="mt-3 p-3 bg-label-success rounded">
                    <div class="d-flex justify-content-between">
                        <span>Budget total bourses</span>
                        <strong>450M CFA</strong>
                    </div>
                    <div class="d-flex justify-content-between mt-1">
                        <span class="text-muted">Distribué</span>
                        <strong class="text-success">365M CFA (81%)</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Palmarès des résultats et Semestres -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Palmarès - Top 10 Étudiants</h5>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Semestre 1</option>
                    <option>Semestre 2</option>
                </select>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Rang</th>
                            <th>Étudiant</th>
                            <th>Filière</th>
                            <th>Moyenne</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-success">
                            <td><span class="badge bg-warning">🥇 1</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <span class="fw-semibold">Aïcha TOURE</span>
                                </div>
                            </td>
                            <td>L3 Médecine</td>
                            <td><strong class="text-success">18.75</strong></td>
                        </tr>
                        <tr class="table-info">
                            <td><span class="badge bg-secondary">🥈 2</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <span class="fw-semibold">Kofi MENSAH</span>
                                </div>
                            </td>
                            <td>L3 Info</td>
                            <td><strong class="text-success">18.42</strong></td>
                        </tr>
                        <tr class="table-warning">
                            <td><span class="badge bg-dark">🥉 3</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <span class="fw-semibold">Marie KOFFI</span>
                                </div>
                            </td>
                            <td>L2 Gestion</td>
                            <td><strong class="text-success">17.98</strong></td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <span>Jean DIALLO</span>
                                </div>
                            </td>
                            <td>L1 Droit</td>
                            <td><strong>17.65</strong></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <span>Fatou SORO</span>
                                </div>
                            </td>
                            <td>L2 Info</td>
                            <td><strong>17.32</strong></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/6.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 30px; height: 30px;">
                                    <span>Yao KOUAME</span>
                                </div>
                            </td>
                            <td>M1 Gestion</td>
                            <td><strong>17.08</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Semestres en cours</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Semestre 1 - 2024/2025</h6>
                                <p class="mb-2 text-muted">Licence 1, 2, 3</p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-label-success">En cours</span>
                                    <span class="badge bg-label-info">2,245 étudiants</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Progression: 65%</small>
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar bg-success" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Fin: 15 Jan 2025</small>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Semestre 3 - 2024/2025</h6>
                                <p class="mb-2 text-muted">Master 1, 2</p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-label-success">En cours</span>
                                    <span class="badge bg-label-info">602 étudiants</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Progression: 58%</small>
                                    <div class="progress mt-1" style="height: 6px;">
                                        <div class="progress-bar bg-primary" style="width: 58%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">Fin: 20 Jan 2025</small>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Semestre 2 - Rattrapages</h6>
                                <p class="mb-2 text-muted">Tous niveaux</p>
                                <div class="d-flex gap-2">
                                    <span class="badge bg-label-warning">Planifié</span>
                                    <span class="badge bg-label-info">145 étudiants</span>
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">Début dans 2 semaines</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <small class="text-muted">18-22 Déc 2024</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Liste des enseignants et Finances -->
<div class="row mb-4">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Enseignants actifs</h5>
                <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Enseignant</th>
                            <th>Département</th>
                            <th>Cours</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/1.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                    <div>
                                        <h6 class="mb-0">Dr. DIALLO</h6>
                                        <small class="text-muted">Programmation</small>
                                    </div>
                                </div>
                            </td>
                            <td>Informatique</td>
                            <td><span class="badge bg-label-primary">5</span></td>
                            <td><span class="badge bg-success">Actif</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/2.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                    <div>
                                        <h6 class="mb-0">Prof. KONE</h6>
                                        <small class="text-muted">Comptabilité</small>
                                    </div>
                                </div>
                            </td>
                            <td>Gestion</td>
                            <td><span class="badge bg-label-primary">4</span></td>
                            <td><span class="badge bg-success">Actif</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/3.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                    <div>
                                        <h6 class="mb-0">Me. KOUASSI</h6>
                                        <small class="text-muted">Droit</small>
                                    </div>
                                </div>
                            </td>
                            <td>Droit</td>
                            <td><span class="badge bg-label-primary">6</span></td>
                            <td><span class="badge bg-warning">En congé</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/4.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                    <div>
                                        <h6 class="mb-0">Dr. TRAORE</h6>
                                        <small class="text-muted">Anatomie</small>
                                    </div>
                                </div>
                            </td>
                            <td>Médecine</td>
                            <td><span class="badge bg-label-primary">7</span></td>
                            <td><span class="badge bg-success">Actif</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('Pro/assets/img/avatars/5.png') }}" alt="Avatar" class="rounded-circle me-2" style="width: 32px; height: 32px;">
                                    <div>
                                        <h6 class="mb-0">Arch. OUATTARA</h6>
                                        <small class="text-muted">Design</small>
                                    </div>
                                </div>
                            </td>
                            <td>Architecture</td>
                            <td><span class="badge bg-label-primary">3</span></td>
                            <td><span class="badge bg-success">Actif</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Finances</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Revenus totaux</span>
                        <strong>1.2Md CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Encaissé</span>
                        <strong>845M CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 70%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>En attente</span>
                        <strong>287M CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 24%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Impayés</span>
                        <strong>68M CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: 6%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Finances</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Revenus totaux</span>
                        <strong>1.2Md CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: 100%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>Encaissé</span>
                        <strong>845M CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-primary" style="width: 70%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <span>En attente</span>
                        <strong>287M CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-warning" style="width: 24%"></div>
                    </div>
                </div>
                <div>
                    <div class="d-flex justify-content-between mb-1">
                        <span>Impayés</span>
                        <strong>68M CFA</strong>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar bg-danger" style="width: 6%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Activités récentes -->
<div class="row">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Activités récentes</h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <div class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <span class="badge bg-primary rounded-circle p-2">
                                    <i class="bx bx-user-plus"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Nouvelle inscription</h6>
                                <p class="mb-0 text-muted">Marie KOFFI s'est inscrite en L1 Informatique</p>
                                <small class="text-muted">Il y a 2 minutes</small>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <span class="badge bg-success rounded-circle p-2">
                                    <i class="bx bx-dollar"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Paiement reçu</h6>
                                <p class="mb-0 text-muted">Jean MENSAH - 250,000 CFA</p>
                                <small class="text-muted">Il y a 15 minutes</small>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <span class="badge bg-info rounded-circle p-2">
                                    <i class="bx bx-briefcase"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Nouvel enseignant</h6>
                                <p class="mb-0 text-muted">Dr. DIALLO ajouté au département Informatique</p>
                                <small class="text-muted">Il y a 1 heure</small>
                            </div>
                        </div>
                    </div>

                    <div class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <span class="badge bg-warning rounded-circle p-2">
                                    <i class="bx bx-error"></i>
                                </span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">Alerte absence</h6>
                                <p class="mb-0 text-muted">15 étudiants absents au cours de Mathématiques</p>
                                <small class="text-muted">Il y a 2 heures</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="card mb-3">
            <div class="card-header">
                <h5 class="mb-0">Actions rapides</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <button class="btn btn-primary">
                        <i class="bx bx-user-plus me-1"></i> Nouvelle inscription
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="bx bx-file me-1"></i> Générer rapport
                    </button>
                    <button class="btn btn-outline-primary">
                        <i class="bx bx-calendar me-1"></i> Planifier cours
                    </button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Alertes</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning mb-2">
                    <strong>42</strong> paiements en retard
                </div>
                <div class="alert alert-info mb-2">
                    Examens dans <strong>2 semaines</strong>
                </div>
                <div class="alert alert-success mb-0">
                    <strong>15</strong> salles disponibles
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('footer')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Graphique des inscriptions
const inscriptionsCtx = document.getElementById('inscriptionsChart');
if (inscriptionsCtx) {
    new Chart(inscriptionsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            datasets: [{
                label: 'Inscriptions',
                data: [120, 180, 250, 420, 680, 890, 1200, 1580, 2140, 2450, 2680, 2847],
                borderColor: 'rgb(105, 108, 255)',
                backgroundColor: 'rgba(105, 108, 255, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: true
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

// Graphique niveaux
const niveauxCtx = document.getElementById('niveauxChart');
if (niveauxCtx) {
    new Chart(niveauxCtx, {
        type: 'doughnut',
        data: {
            labels: ['L1', 'L2', 'L3', 'Master'],
            datasets: [{
                data: [854, 742, 685, 566],
                backgroundColor: [
                    'rgb(105, 108, 255)',
                    'rgb(3, 195, 236)',
                    'rgb(255, 171, 0)',
                    'rgb(113, 221, 55)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}
</script>
@endsection