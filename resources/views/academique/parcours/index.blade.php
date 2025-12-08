@extends('layouts.admin')

@section('titre', 'Gestion des Parcours')

@section('content')
<div class="container-fluid">

    {{-- TITRE DE PAGE --}}
    <div class="mb-4">
        <h1 class="fw-bold">Gestion des Parcours</h1>
        <p class="text-muted">Visualisation hiérarchique des départements, filières et parcours.</p>

        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item">Académique</li>
                <li class="breadcrumb-item active">Parcours</li>
            </ol>
        </nav>
    </div>

    {{-- BOUTONS --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('academique.parcours.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajouter un parcours
        </a>

        <a href="" class="btn btn-danger">
            <i class="bx bxs-file-pdf me-1"></i> Télécharger PDF
        </a>

        <button onclick="window.print();" class="btn btn-secondary">
            <i class="bx bx-printer me-1"></i> Imprimer
        </button>
    </div>

    {{-- BOUCLE DES DÉPARTEMENTS --}}
    @forelse ($departements as $departement)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bx bxs-school me-2"></i>
                Département : <strong>{{ $departement->nom }}</strong>
            </h5>
        </div>

        <div class="card-body">
            <br>
            {{-- TABLE FILIERES --}}
            <h6 class="fw-bold mb-3">
                <i class="bx bx-layer me-1"></i> Filières du département
            </h6>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Filière</th>
                            <th>Parcours disponibles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($departement->filieres as $filiere)
                        <tr>
                            <td>
                                <span class="badge bg-info text-dark px-3 py-2">
                                    {{ $filiere->nom }}
                                </span>
                            </td>

                            <td>

                                {{-- TABLE INTERNE DES PARCOURS --}}
                                <table class="table table-sm table-hover bg-white mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nom du parcours</th>
                                            <th>Frais Inscription</th>
                                            <th>Frais Formation</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($filiere->parcours as $parcour)
                                        <tr>
                                            <td><strong>{{ $parcour->nom }}</strong></td>
                                            <td>{{ number_format($parcour->frais_inscription, 0, ',', ' ') }} F CFA</td>
                                            <td>{{ number_format($parcour->frais_formation, 0, ',', ' ') }} F CFA</td>

                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown">
                                                        <i class="bx bx-dots-vertical-rounded"></i>
                                                    </button>
                                                    <div class="dropdown-menu">

                                                        <a class="dropdown-item"
                                                           href="{{ route('academique.parcours.edit', $parcour) }}">
                                                            <i class="bx bx-edit-alt me-1"></i> Modifier
                                                        </a>

                                                        <form action="{{ route('academique.parcours.destroy', $parcour) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Supprimer ce parcours ?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="bx bx-trash me-1"></i> Supprimer
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-muted text-center">
                                                Aucun parcours dans cette filière.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-muted text-center">
                                Aucune filière pour ce département.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    @empty
    <div class="alert alert-info">
        <i class="bx bx-info-circle me-1"></i> Aucun département trouvé.
    </div>
    @endforelse

</div>
@endsection
