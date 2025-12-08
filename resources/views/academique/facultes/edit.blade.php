@extends('layouts.admin')

@section('titre', 'Modifier la faculté')

@section('content')
<div class="container-fluid">

    {{-- TITRE DE PAGE --}}
    <div class="page-title mb-4">
        <h1 class="fw-bold">Modifier la faculté</h1>
        <p class="text-muted">Mettre à jour les informations de la faculté sélectionnée.</p>
    </div>

    <div class="row">

        {{-- FORMULAIRE À GAUCHE --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Formulaire d’édition</h5>
                    <a href="{{ route('academique.facultes.index') }}" class="btn btn-secondary btn-sm">
                        <i class="ri-arrow-left-line"></i> Retour
                    </a>
                </div>

                <div class="card-body">

                    {{-- Messages d'erreurs --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Veuillez corriger les erreurs :</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $erreur)
                                    <li>{{ $erreur }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('academique.facultes.update', $faculte->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Champ Nom --}}
                        <div class="mb-3">
                            <label for="nom" class="form-label fw-bold">Nom <span class="text-danger">*</span></label>
                            <input type="text"
                                   name="nom"
                                   id="nom"
                                   class="form-control @error('nom') is-invalid @enderror"
                                   value="{{ old('nom', $faculte->nom) }}" required>
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Champ Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" rows="4"
                                      class="form-control @error('description') is-invalid @enderror">{{ old('description', $faculte->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-3-fill"></i> Enregistrer
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        {{-- CARTE D’INFORMATION À DROITE --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100 text-center p-4 d-flex flex-column justify-content-center">

                <i class="ri-building-4-fill text-primary" style="font-size: 80px;"></i>

                <h4 class="mt-3 fw-bold">{{ $faculte->nom }}</h4>

                <p class="text-muted mt-2">
                    {{ $faculte->description ?: 'Aucune description fournie.' }}
                </p>

                <div class="mt-4">
                    <span class="badge bg-primary px-3 py-2" style="font-size: 14px;">
                        Faculté ID : {{ $faculte->id }}
                    </span>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection
