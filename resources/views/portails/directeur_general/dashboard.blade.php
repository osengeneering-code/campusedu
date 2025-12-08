@extends('layouts.admin')

@section('titre', 'Portail Directeur Général')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Portail Direction Générale /</span> Tableau de bord
    </h4>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bonjour {{ Auth::user()->prenom }} ! 👋</h5>
                            <p class="mb-4">
                                Bienvenue sur votre espace Directeur Général. Vue d'ensemble stratégique et gestion des opérations globales.
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir les Rapports Financiers</a>
                            <a href="#" class="btn btn-sm btn-outline-primary">Gérer le Personnel</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('Pro/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="Directeur Général"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TODO: Ajouter des widgets et des statistiques spécifiques au directeur général --}}
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title m-0 me-2">Indicateurs Clés de Performance (KPI)</h5>
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
                                <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-trending-up"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Taux de croissance annuel</h6>
                                    <small class="text-muted">Inscriptions vs année précédente</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">+12%</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-4 pb-1">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-success"><i class="bx bx-dollar"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Revenus Générés</h6>
                                    <small class="text-muted">Total des frais de scolarité</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">2.5M €</small>
                                </div>
                            </div>
                        </li>
                        <li class="d-flex mb-2">
                            <div class="avatar flex-shrink-0 me-3">
                                <span class="avatar-initial rounded bg-label-info"><i class="bx bx-check-circle"></i></span>
                            </div>
                            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                <div class="me-2">
                                    <h6 class="mb-0">Taux de satisfaction étudiant</h6>
                                    <small class="text-muted">Dernière enquête</small>
                                </div>
                                <div class="user-progress">
                                    <small class="fw-semibold">92%</small>
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
                    <h5 class="card-title m-0 me-2">Décisions Stratégiques</h5>
                    <div class="dropdown">
                        <button class="btn p-0" type="button" id="cardOpt1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="cardOpt1">
                            <a class="dropdown-item" href="javascript:void(0);">Voir toutes les décisions</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="timeline">
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-primary"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Lancement nouvelle filière "IA & Data Science"</h6>
                                    <small class="text-muted">Date prévue: Sept 2025</small>
                                </div>
                                <p class="mb-2">Phase de planification avancée</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-info"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Partenariat avec l'Université de Bordeaux</h6>
                                    <small class="text-muted">Signature: Q2 2025</small>
                                </div>
                                <p class="mb-2">Programme d'échange étudiant</p>
                            </div>
                        </li>
                        <li class="timeline-item timeline-item-transparent ps-4">
                            <span class="timeline-point timeline-point-success"></span>
                            <div class="timeline-event pb-0">
                                <div class="timeline-header mb-1">
                                    <h6 class="mb-0">Extension des locaux du campus</h6>
                                    <small class="text-muted">Fin des travaux: Fin 2026</small>
                                </div>
                                <p class="mb-2">Ajout de 3 nouvelles salles de cours</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
