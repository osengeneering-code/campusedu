@extends('layouts.admin')

@section('titre', 'Nouvelle UE')

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
                        Voici les étapes pour créer une nouvelle Unité d’Enseignement (UE) :
                    </p>
                    <ol class="ps-3">
                        <li>Sélectionnez le Département, la Filière et le Parcours correspondant.</li>
                        <li>Choisissez le Semestre approprié.</li>
                        <li>Indiquez le code UE et le libellé complet.</li>
                        <li>Définissez le nombre de crédits ECTS.</li>
                        <li>Vérifiez les informations et soumettez le formulaire.</li>
                    </ol>
                    <hr>
                    <p class="text-muted small">
                        Les UE sont essentielles pour le suivi académique et l’attribution des crédits aux étudiants.
                    </p>
                    <div class="text-center mt-3">
                        <i class="bx bx-book-open fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire à droite --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Ajouter une UE</h5>
                </div>
                <div class="card-body">
                    <br>
                    <form action="{{ route('academique.ues.store') }}" method="POST">
                        @csrf
                        @include('academique.ues._form')
                       
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
