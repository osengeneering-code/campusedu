@extends('layouts.admin')

@section('titre', 'Nouveau Semestre')

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
                        Voici les étapes pour ajouter un nouveau semestre :
                    </p>
                    <ol class="ps-3">
                        <li>Sélectionnez le Parcours correspondant.</li>
                        <li>Indiquez le libellé du semestre.</li>
                        <li>Définissez le niveau associé (ex: L1, L2, M1, etc.).</li>
                        <li>Vérifiez les informations et soumettez le formulaire.</li>
                    </ol>
                    <hr>
                    <p class="text-muted small">
                        Les semestres sont essentiels pour organiser les UE et le calendrier académique.
                    </p>
                    <div class="text-center mt-3">
                        <i class="bx bx-calendar fs-1 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulaire à droite --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bx bx-plus-circle me-2"></i> Ajouter un semestre</h5>
                </div>
                <div class="card-body">
                    <br>
                    <form action="{{ route('academique.semestres.store') }}" method="POST">
                        @csrf
                        @include('academique.semestres._form')
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
