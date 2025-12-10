@extends('layouts.admin')

@section('titre', 'Gestion des Salles')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Académique /</span> Gestion des Salles
    </h4>

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Liste des Salles</h5>
            <a href="{{ route('academique.salles.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Ajouter une Salle
            </a>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nom de la Salle</th>
                        <th>Capacité</th>
                        <th>Type de Salle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($salles as $salle)
                    <tr>
                        <td><strong>{{ $salle->nom_salle }}</strong></td>
                        <td>{{ $salle->capacite }}</td>
                        <td>{{ $salle->type_salle }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('academique.salles.edit', $salle) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('academique.salles.destroy', $salle) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette salle ?');">
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
                        <td colspan="4" class="text-center">Aucune salle trouvée.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
