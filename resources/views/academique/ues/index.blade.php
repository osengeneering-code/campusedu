@extends('layouts.admin')

@section('titre', 'Gestion des Unités d\'Enseignement (UE)')

@section('content')
<div class="container-fluid">

    {{-- TITRE DE PAGE --}}
    <div class="mb-4">
        <h1 class="fw-bold">Gestion des UE</h1>
        <p class="text-muted">Visualisation hiérarchique des départements, filières, parcours, semestres et unités d’enseignement.</p>

        {{-- BREADCRUMB --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Tableau de bord</a></li>
                <li class="breadcrumb-item">Académique</li>
                <li class="breadcrumb-item active">UE</li>
            </ol>
        </nav>
    </div>

    {{-- BOUTONS --}}
    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('academique.ues.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajouter une UE
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
        <div class="card-header bg-light">
            <h5><i class="bx bxs-school me-2"></i> Département : <strong>{{ $departement->nom }}</strong></h5>
        </div>
        <br>
        <div class="card-body">

            {{-- FILIERES --}}
            @forelse ($departement->filieres as $filiere)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-light">
                    <h6><i class="bx bx-layer me-1"></i> Filière : <span class="badge bg-info text-dark">{{ $filiere->nom }}</span></h6>
                </div>
                  <br>
                <div class="card-body">

                    {{-- PARCOURS --}}
                    @forelse ($filiere->parcours as $parcour)
                    <div class="card mb-2 shadow-sm">
                        <div class="card-header bg-light">
                            <h6><i class="bx bx-bookmark me-1"></i> Parcours : <span class="badge bg-warning text-dark">{{ $parcour->nom }}</span></h6>
                        </div>
                          <br>
                        <div class="card-body">

                            {{-- SEMESTRES --}}
                            @forelse ($parcour->semestres as $semestre)
                            <div class="card mb-2 shadow-sm">
                                <div class="card-header bg-light">
                                    <h6><i class="bx bx-calendar me-1"></i> Semestre : <span class="badge bg-secondary text-dark">{{ $semestre->libelle }} ({{ $semestre->niveau }})</span></h6>
                                </div>
                                  <br>
                                <div class="card-body">

                                    {{-- TABLE UE --}}
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Code UE</th>
                                                    <th>Libellé</th>
                                                    <th>Crédits ECTS</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($semestre->ues as $ue)
                                                <tr>
                                                    <td><strong>{{ $ue->code_ue }}</strong></td>
                                                    <td>{{ $ue->libelle }}</td>
                                                    <td>{{ $ue->credits_ects }}</td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn p-0 dropdown-toggle" data-bs-toggle="dropdown">
                                                                <i class="bx bx-dots-vertical-rounded"></i>
                                                            </button>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item" href="{{ route('academique.ues.edit', $ue) }}">
                                                                    <i class="bx bx-edit-alt me-1"></i> Modifier
                                                                </a>
                                                                <form action="{{ route('academique.ues.destroy', $ue) }}" method="POST" onsubmit="return confirm('Supprimer cette UE ?');">
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
                                                    <td colspan="4" class="text-center text-muted">Aucune UE</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                            @empty
                            <div class="text-muted mb-2">Aucun semestre pour ce parcours.</div>
                            @endforelse

                        </div>
                    </div>
                    @empty
                    <div class="text-muted mb-2">Aucun parcours pour cette filière.</div>
                    @endforelse

                </div>
            </div>
            @empty
            <div class="text-muted mb-2">Aucune filière pour ce département.</div>
            @endforelse

        </div>
    </div>
    @empty
    <div class="alert alert-info">
        <i class="bx bx-info-circle me-1"></i> Aucun département trouvé.
    </div>
    @endforelse

</div>
@endsection
