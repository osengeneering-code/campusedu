@extends('layouts.admin')

@section('titre', 'Gestion des Candidatures')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Liste des Candidatures</h5>
        {{-- Le formulaire de création est public, donc pas de bouton "Ajouter" ici --}}
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Candidat</th>
                    <th>Email</th>
                    <th>Filière Souhaitée</th>
                    <th>Date</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse ($candidatures as $candidature)
                <tr>
                    <td><strong>{{ $candidature->nom }} {{ $candidature->prenom }}</strong></td>
                    <td>{{ $candidature->email }}</td>
                    <td>{{ $candidature->filiere->nom ?? 'N/A' }}</td>
                    <td>{{ $candidature->date_candidature->format('d/m/Y') }}</td>
                    <td><span class="badge bg-label-warning">{{ $candidature->statut }}</span></td>
                    <td>
                        <a href="{{ route('inscriptions.candidatures.show', $candidature) }}" class="btn btn-sm btn-info">Détails</a>
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
