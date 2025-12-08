@extends('layouts.admin')

@section('titre', 'Gestion des Inscriptions Administratives')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des Inscriptions Administratives</h5>
        @can('gerer_inscriptions')
        <a href="{{ route('inscriptions.inscription-admins.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Inscrire un étudiant
        </a>
        @endcan
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Étudiant</th>
                    <th>Matricule</th>
                    <th>Année Académique</th>
                    <th>Parcours</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($inscriptions as $inscription)
                <tr>
                    <td><strong>{{ $inscription->etudiant->nom ?? 'N/A' }} {{ $inscription->etudiant->prenom ?? '' }}</strong></td>
                    <td>{{ $inscription->etudiant->matricule ?? 'N/A' }}</td>
                    <td>{{ $inscription->annee_academique }}</td>
                    <td>{{ $inscription->parcours->nom ?? 'N/A' }}</td>
                    <td>
                        <span class="badge bg-label-{{ $inscription->statut == 'Inscrit' ? 'success' : ($inscription->statut == 'En attente de paiement' ? 'warning' : 'info') }}">
                            {{ $inscription->statut }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('inscriptions.inscription-admins.show', $inscription) }}" class="btn btn-sm btn-info">Détails</a>
                        <a href="{{ route('inscriptions.inscription-admins.edit', $inscription) }}" class="btn btn-sm btn-warning">Modifier</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune inscription administrative trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 px-3">
        {{ $inscriptions->links() }}
    </div>
</div>
@endsection