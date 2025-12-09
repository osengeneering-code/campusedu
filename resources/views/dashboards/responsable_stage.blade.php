@extends('layouts.admin')

@section('titre', 'Portail Responsable de Stage')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Portail Responsable de Stage /</span> Tableau de bord
    </h4>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bonjour {{ Auth::user()->prenom }} ! 👋</h5>
                            <p class="mb-4">
                                Bienvenue sur votre espace Responsable de Stage. Suivez les stages, gérez les entreprises partenaires et les conventions.
                            </p>
                            <a href="{{ route('stages.stages.index') }}" class="btn btn-sm btn-outline-primary">Voir les Stages</a>
                            <a href="{{ route('stages.entreprises.index') }}" class="btn btn-sm btn-outline-primary">Gérer les Entreprises</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('Pro/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="Responsable de Stage"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TODO: Ajouter des widgets et des statistiques spécifiques au responsable de stage --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Statistiques Stages</h5>
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
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-file"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Stages en cours</h6>
                                    <small class="text-muted">Étudiants actuellement en stage</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">25</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-warning"><i class="bx bx-time"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Stages à venir</h6>
                                    <small class="text-muted">Prochaines démarrages de stage</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">10</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-2">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-building"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Entreprises partenaires</h6>
                                    <small class="text-muted">Nombre total d'entreprises</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">50</small>
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
                    <h5 class="card-title m-0 me-2">Tâches Récentes</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="javascript:void(0);">Voir toutes les tâches</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Valider convention de stage pour Jean Dupont</h6>
                                    <small class="text-muted">Il y a 3h</small>
                                </div>
                                <p class="mb-2">Filière: Licence Informatique</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-success"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Planifier visite de stage chez InnovTech</h6>
                                    <small class="text-muted">Il y a 1 jour</small>
                                </div>
                                <p class="mb-2">Étudiant: Sarah Mouity</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-info"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Mettre à jour la base des entreprises partenaires</h6>
                                    <small class="text-muted">Il y a 5 jours</small>
                                </div>
                                <p class="mb-2">Nouvelles entreprises à ajouter</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
