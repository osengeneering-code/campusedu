@extends('layouts.admin')

@section('titre', 'Gestion des Enseignants')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des Enseignants</h5>
        <a href="{{ route('personnes.enseignants.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajouter un enseignant
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nom & Prénom</th>
                    <th>Email Pro</th>
                    <th>Département</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($enseignants as $enseignant)
                <tr>
                    <td><strong>{{ $enseignant->nom }} {{ $enseignant->prenom }}</strong></td>
                    <td>{{ $enseignant->email_pro }}</td>
                    <td>{{ $enseignant->departement->nom ?? 'N/A' }}</td>
                    <td>{{ $enseignant->statut }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('personnes.enseignants.show', $enseignant) }}"><i class="bx bx-show me-1"></i> Voir</a>
                                <a class="dropdown-item" href="{{ route('personnes.enseignants.edit', $enseignant) }}"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                <form action="{{ route('personnes.enseignants.destroy', $enseignant) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i> Supprimer</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Aucun enseignant trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 px-3">
        {{ $enseignants->links() }}
    </div>
</div>
@endsection
