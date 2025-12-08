@extends('layouts.admin')

@section('titre', 'Gestion des Candidatures')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Liste des Candidatures</h5>
        @can('gerer_candidatures')
        <a href="{{ route('inscriptions.candidatures.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Ajouter une Candidature
        </a>
        @endcan
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Niveau Demandé</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($candidatures as $candidature)
                <tr>
                    <td><strong>{{ $candidature->prenom }} {{ $candidature->nom }}</strong></td>
                    <td>{{ $candidature->email }}</td>
                    <td>{{ $candidature->telephone }}</td>
                    <td>{{ $candidature->niveau_etude_demande }}</td>
                    <td><span class="badge bg-label-info">{{ $candidature->statut ?? 'En attente' }}</span></td>
                    <td>
                        <a href="{{ route('inscriptions.candidatures.show', $candidature) }}" class="btn btn-sm btn-info">Détails</a>
                        <a href="{{ route('inscriptions.candidatures.edit', $candidature) }}" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="{{ route('inscriptions.candidatures.destroy', $candidature) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette candidature ?');" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Aucune candidature trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 px-3">
        {{ $candidatures->links() }}
    </div>
</div>
@endsection