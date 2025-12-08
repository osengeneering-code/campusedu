@extends('layouts.admin')

@section('titre', 'Gestion des Étudiants')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des Étudiants</h5>
        @can('creer_etudiant')
        <a href="{{ route('personnes.etudiants.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajouter un étudiant
        </a>
        @endcan
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Matricule</th>
                    <th>Nom & Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($etudiants as $etudiant)
                <tr>
                    <td><strong>{{ $etudiant->matricule }}</strong></td>
                    <td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                    <td>{{ $etudiant->email_perso }}</td>
                    <td>
                        <div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu">
                                @can('consulter_dossier_etudiant')
                                <a class="dropdown-item" href="{{ route('personnes.etudiants.show', $etudiant) }}"><i class="bx bx-show me-1"></i> Voir</a>
                                @endcan
                                @can('modifier_etudiant')
                                <a class="dropdown-item" href="{{ route('personnes.etudiants.edit', $etudiant) }}"><i class="bx bx-edit-alt me-1"></i> Modifier</a>
                                @endcan
                                @can('supprimer_etudiant')
                                <form action="{{ route('personnes.etudiants.destroy', $etudiant) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i> Supprimer</button>
                                </form>
                                @endcan
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center">Aucun étudiant trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 px-3">
        {{ $etudiants->links() }}
    </div>
</div>
@endsection
