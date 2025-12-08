@extends('layouts.admin')

@section('titre', 'Portail Responsable des Études')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Portail Responsable des Études /</span> Tableau de bord
    </h4>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bonjour {{ Auth::user()->prenom }} ! 👋</h5>
                            <p class="mb-4">
                                Bienvenue sur votre espace Responsable des Études. Supervisez la structure académique, les programmes et la performance des étudiants.
                            </p>
                            <a href="{{ route('academique.filieres.index') }}" class="btn btn-sm btn-outline-primary">Gérer les Filières</a>
                            <a href="{{ route('gestion-cours.evaluations.index') }}" class="btn btn-sm btn-outline-primary">Gérer les Évaluations</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('Pro/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="Responsable des Études"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TODO: Ajouter des widgets et des statistiques spécifiques au responsable des études --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Statistiques Pédagogiques</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt4" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt4">
                            <a class="dropdown-item" href="javascript:void(0);">Voir plus</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-group"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Effectif total étudiants</h6>
                                    <small class="text-muted">Toutes filières confondues</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">1200</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-chalkboard"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Nombre de filières actives</h6>
                                    <small class="text-muted">Programmes d'études proposés</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">8</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-2">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-book-open"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Taux de réussite moyen</h6>
                                    <small class="text-muted">Tous semestres confondus</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">85%</small>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Alertes & Actions</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="javascript:void(0);">Voir toutes les alertes</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-danger"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Nouvelles demandes de dérogation</h6>
                                    <small class="text-muted">Il y a 1h</small>
                                </div>
                                <p class="mb-2">Étudiants à examiner : 3</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-warning"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Évaluations à planifier</h6>
                                    <small class="text-muted">Il y a 1 jour</small>
                                </div>
                                <p class="mb-2">Modules concernés : 5</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-info"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Consultations d'emploi du temps enseignant</h6>
                                    <small class="text-muted">Il y a 3 jours</small>
                                </div>
                                <p class="mb-2">Vérifier les disponibilités</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
