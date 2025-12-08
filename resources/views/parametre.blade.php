@extends('layouts.admin')

@section('titre', 'Paramètres de l\'Application')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Administration /</span> Paramètres
    </h4>

    <div class="row g-4">
        <!-- Carte Utilisateurs -->
        @can('lister_etudiants') {{-- Ou une permission plus générique comme 'gerer_utilisateurs' --}}
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-user fs-2"></i></span>
                    </div>
                    <h5 class="card-title mb-2">Utilisateurs</h5>
                    <p class="card-text">Gérer les comptes utilisateurs et leurs accès.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary">Accéder</a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Carte Rôles & Permissions -->
        @can('voir_roles')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-info"><i class="bx bx-shield-alt-2 fs-2"></i></span>
                    </div>
                    <h5 class="card-title mb-2">Rôles & Permissions</h5>
                    <p class="card-text">Définir les rôles et attribuer les permissions.</p>
                    <a href="{{ route('roles.index') }}" class="btn btn-info">Accéder</a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Carte Structure Pédagogique -->
        @can('gerer_structure_pedagogique')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-sitemap fs-2"></i></span>
                    </div>
                    <h5 class="card-title mb-2">Structure Pédagogique</h5>
                    <p class="card-text">Gérer facultés, départements, filières, modules...</p>
                    <a href="{{ route('academique.filieres.index') }}" class="btn btn-success">Accéder</a>
                </div>
            </div>
        </div>
        @endcan

        <!-- Carte Journal des Activités -->
        @role('admin')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-danger"><i class="bx bx-list-ul fs-2"></i></span>
                    </div>
                    <h5 class="card-title mb-2">Journal des Activités</h5>
                    <p class="card-text">Consulter l'historique des actions des utilisateurs.</p>
                    <a href="{{ route('activitylogs.index') }}" class="btn btn-danger">Accéder</a>
                </div>
            </div>
        </div>
        @endrole
        
        <!-- Carte Paramètres Généraux -->
        @role('admin')
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-warning"><i class="bx bx-cog fs-2"></i></span>
                    </div>
                    <h5 class="card-title mb-2">Paramètres Généraux</h5>
                    <p class="card-text">Configurer les paramètres globaux de l\'application.</p>
                    <a href="{{ route('settings.index') }}" class="btn btn-warning">Accéder</a>
                </div>
            </div>
        </div>
        @endrole
    </div>
</div>
@endsection
