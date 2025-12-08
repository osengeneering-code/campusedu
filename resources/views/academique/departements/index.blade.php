@extends('layouts.admin')

@section('titre', 'Gestion des Départements')

@section('content')
<div class="container-fluid">

    {{-- TITRE DE PAGE --}}
    <div class="mb-4">
        <h1 class="fw-bold">Gestion des Départements</h1>
        <p class="text-muted mb-1">Gérez et exportez la liste des départements académiques.</p>

        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item">Académique</li>
                <li class="breadcrumb-item active" aria-current="page">Départements</li>
            </ol>
        </nav>
    </div>

    {{-- CARTE PRINCIPALE --}}
    <div class="card shadow-sm">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bx bx-list-ul me-2"></i> Liste des Départements</h5>

            <div class="d-flex gap-2">

                {{-- Bouton PDF --}}
                <a href="" 
                   class="btn btn-danger">
                    <i class="bx bxs-file-pdf me-1"></i> PDF
                </a>

                {{-- Bouton Imprimer --}}
                <button onclick="window.print();" 
                        class="btn btn-secondary">
                    <i class="bx bx-printer me-1"></i> Imprimer
                </button>

                {{-- Bouton Ajouter --}}
                <a href="{{ route('academique.departements.create') }}" 
                   class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i> Ajouter
                </a>
            </div>
        </div>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom du département</th>
                        <th>Faculté</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="table-border-bottom-0">
                    @forelse ($departements as $departement)
                    <tr>
                        <td><strong>{{ $departement->nom }}</strong></td>

                        <td>
                            <span class="badge bg-label-info px-3 py-2">
                                {{ $departement->faculte->nom ?? 'N/A' }}
                            </span>
                        </td>

                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" 
                                        class="btn p-0 dropdown-toggle hide-arrow" 
                                        data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded fs-4"></i>
                                </button>

                                <div class="dropdown-menu">
                                    <a class="dropdown-item" 
                                       href="{{ route('academique.departements.edit', $departement) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>

                                    <form action="{{ route('academique.departements.destroy', $departement) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce département ?');">
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
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="bx bx-info-circle me-1"></i> Aucun département trouvé.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="mt-3 px-3">
            {{ $departements->links() }}
        </div>
    </div>

</div>
@endsection
