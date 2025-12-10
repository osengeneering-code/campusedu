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

    <div class="px-4">
        <ul class="nav nav-tabs nav-pills">
            <li class="nav-item">
                <a class="nav-link {{ $status == 'En attente' ? 'active' : '' }}" href="{{ route('inscriptions.candidatures.index', ['status' => 'En attente']) }}">En attente</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'Validée' ? 'active' : '' }}" href="{{ route('inscriptions.candidatures.index', ['status' => 'Validée']) }}">Validées</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $status == 'Rejetée' ? 'active' : '' }}" href="{{ route('inscriptions.candidatures.index', ['status' => 'Rejetée']) }}">Rejetées</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ !$status ? 'active' : '' }}" href="{{ route('inscriptions.candidatures.index') }}">Toutes</a>
            </li>
        </ul>
    </div>

    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Nom Complet</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Parcours Demandé</th>
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
                    <td>{{ $candidature->parcours->nom ?? 'N/A' }}</td>
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
                    <td colspan="6" class="text-center">Aucune candidature trouvée pour ce statut.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3 px-3">
        {{ $candidatures->appends(['status' => $status])->links() }}
    </div>
</div>
@endsection