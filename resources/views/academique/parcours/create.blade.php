@extends('layouts.admin')

@section('titre', 'Nouveau Parcours')

@section('content')
<div class="container-fluid">

    <div class="row">
        {{-- Carte informative à gauche --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bx bx-info-circle me-2"></i> Processus / Informations</h5>
                </div>
                <br>
                <div class="card-body">
                    <p class="mb-2">
                        Voici les étapes pour créer un nouveau parcours :
                    </p>
                    <ol class="ps-3">
                        <li>Sélectionnez le Département et la Filière correspondants.</li>
                        <li>Indiquez le nom du parcours.</li>
                        <li>Vérifiez les informations saisies.</li>
                        <li>Soumettez le formulaire pour enregistrer le parcours.</li>
                    </ol>
                    <hr>
                    <p class="text-muted small">
                        Les parcours permettent d’organiser les semestres et les UE pour les étudiants.
                    </p>
                    <div class="text-center mt-3">
                        <i class="bx bx-bookmark fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire à droite --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Ajouter un parcours</h5>
                </div>
                <div class="card-body">
                    <br>
                    <form action="{{ route('academique.parcours.store') }}" method="POST">
                        @csrf
                        @include('academique.parcours._form')
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
