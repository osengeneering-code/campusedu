@extends('layouts.admin')

@section('titre', 'Portail Secrétaire')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Portail Secrétaire /</span> Tableau de bord
    </h4>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Bienvenue, Secrétaire !</h5>
                    <p class="mb-4">
                        Ceci est votre tableau de bord. Des fonctionnalités spécifiques seront ajoutées ici.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection