@extends('layouts.admin')

@section('titre', 'Gestion des Filières')

@section('content')
<div class="container-fluid">

    {{-- TITRE DE PAGE --}}
    <div class="mb-4">
        <h1 class="fw-bold"><i class="bx bx-building-house me-2"></i> Gestion des Filières</h1>
        <p class="text-muted">Liste complète des filières académiques et options disponibles.</p>

        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item">Académique</li>
                <li class="breadcrumb-item active" aria-current="page">Filières</li>
            </ol>
        </nav>
    </div>
    
    {{-- ZONE D'INFORMATION / STATISTIQUES --}}
    <div class="row mt-4">
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bx bx-building-house fs-1 text-primary mb-2"></i>
                    <h6 class="mb-1">Total Départements</h6>
                    <p class="text-muted">{{ $departements_count ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bx bx-layer fs-1 text-success mb-2"></i>
                    <h6 class="mb-1">Total Filières</h6>
                    <p class="text-muted">{{ $filieres_count ?? $filieres->count() }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <i class="bx bx-book-alt fs-1 text-warning mb-2"></i>
                    <h6 class="mb-1">Filières Actives</h6>
                    <p class="text-muted">{{ $active_filieres_count ?? $filieres->where('active', 1)->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- CARTE PRINCIPALE --}}
    <div class="card shadow-sm">

        {{-- EN-TÊTE CARTE --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-list-ul me-2"></i> Liste des Filières</h5>

            <div class="d-flex gap-2">
                <a href="" class="btn btn-danger">
                    <i class="bx bxs-file-pdf me-1"></i> PDF
                </a>
                <button onclick="window.print();" class="btn btn-secondary">
                    <i class="bx bx-printer me-1"></i> Imprimer
                </button>
                <a href="{{ route('academique.filieres.create') }}" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Ajouter
                </a>
            </div>
        </div>

        {{-- TABLEAU DES FILIÈRES --}}
        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom de la filière</th>
                        <th>Département</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @forelse ($filieres as $filiere)
                        <tr>
                            <td><strong>{{ $filiere->nom }}</strong></td>

                            <td>
                                <span class="badge bg-info text-dark px-3 py-2">
                                    <i class="bx bx-building-house me-1"></i> {{ $filiere->departement->nom ?? 'N/A' }}
                                </span>
                            </td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                    </button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('academique.filieres.edit', $filiere) }}">
                                            <i class="bx bx-edit-alt me-1"></i> Modifier
                                        </a>

                                        <a class="dropdown-item" href="{{ route('academique.filieres.show', $filiere) }}"> {{-- Ajouté un lien vers la page show --}}
                                            <i class="bx bx-show me-1"></i> Détails
                                        </a>

                                        <form action="{{ route('academique.filieres.destroy', $filiere) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette filière ?');">
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
                            <td colspan="3" class="text-center text-muted py-4"> {{-- Span mis à jour --}}
                                <i class="bx bx-info-circle me-1"></i> Aucune filière trouvée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="card-footer d-flex justify-content-end">
           
        </div>

    </div>


</div>
@endsection
