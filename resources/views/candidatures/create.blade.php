@extends('layouts.guest')

@section('titre', 'Formulaire de Pré-inscription')

@section('header')
<style>
    .header-card {
        width: 100%;
        height: 120px;
        background-image: url('{{ asset("Pro/img/1.png") }}');
        background-size: cover;
        background-position: center;
        border-radius: 10px;
        margin-bottom: 25px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }

    .card {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 6px 20px rgba(0,0,0,0.10);
    }

    .card-header {
        background: linear-gradient(135deg, #03346E, #0056b3);
        color: #fff;
        padding: 20px;
        border-bottom: none;
    }

    .card-body {
        background-color: #fafafa;
        padding: 30px;
    }

    h5.section-title {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 20px;
        color: #03346E;
        border-left: 4px solid #03346E;
        padding-left: 10px;
    }

    .btn-primary {
        background-color: #03346E;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        transition: 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #021f3f;
    }

    .btn-secondary {
        border-radius: 6px;
        padding: 10px 20px;
    }

    .form-container {
        margin-top: 20px;
    }
</style>
@endsection

@section('content')

<div class="container my-4">
    
    <!-- Bandeau graphique -->

    <div class="card">

        <!-- Titre -->
        <div class="card-header text-center">
            <h4 class="mb-0 text-white"><b>Formulaire de Pré-inscription</b></h4>
        </div>

        <!-- Formulaire -->
        <div class="card-body">
            <form action="{{ route('inscriptions.candidatures.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="form-container">

                @csrf

                {{-- Appel du formulaire dynamique --}}
                @include('candidatures._form', [
                    'candidature' => new App\Models\Candidature(),
                    'parcours' => $parcours,
                    'niveaux' => $niveaux
                ])

                <div class="mt-4 d-flex gap-3">
                    <button type="submit" class="btn btn-primary">
                        Envoyer ma Candidature
                    </button>

                    <a href="{{ url('/') }}" class="btn btn-secondary">
                        Retour à l'accueil
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

@endsection
