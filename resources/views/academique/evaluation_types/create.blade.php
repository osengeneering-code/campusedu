@extends('layouts.admin')

@section('titre', 'Ajouter un Type d\'Évaluation')

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
                        Suivez ces étapes pour ajouter un nouveau Type d'Évaluation :
                    </p>
                    <ol class="ps-3">
                        <li>Indiquez le nom du type d'évaluation (ex : Examen, Contrôle Continu, Projet).</li>
                        <li>Fournissez une description ou précision si nécessaire.</li>
                        <li>Vérifiez les informations avant de soumettre.</li>
                        <li>Soumettez le formulaire pour enregistrer le type.</li>
                    </ol>
                    <hr>
                    <p class="text-muted small">
                        Les types d'évaluation permettent de structurer le système d’évaluation des UE et semestres.
                    </p>
                    <div class="text-center mt-3">
                        <i class="bx bx-clipboard fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire à droite --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Ajouter un Type d'Évaluation</h5>
                </div>
                <div class="card-body">
                    <br>
                    <form action="{{ route('academique.evaluation-types.store') }}" method="POST">
                        @csrf
                        @include('academique.evaluation_types._form')
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
