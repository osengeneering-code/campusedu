@extends('layouts.admin')

@section('titre', 'Liste des Entreprises')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Entreprises</h5>
        <a href="{{ route('stages.entreprises.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Nouvelle Entreprise
        </a>
    </div>
    <div class="table-responsive text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Nom de l'entreprise</th>
                    <th>Secteur d'activité</th>
                    <th>Adresse</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($entreprises as $entreprise)
                <tr>
                    <td><strong>{{ $entreprise->nom_entreprise }}</strong></td>
                    <td>{{ $entreprise->secteur_activite }}</td>
                    <td>{{ $entreprise->adresse }}, {{ $entreprise->ville }}</td>
                    <td>{{ $entreprise->telephone }}</td>
                    <td>
                        <div class="d-flex">
                            <a class="btn btn-sm btn-label-info me-2" href="{{ route('stages.entreprises.show', $entreprise->id) }}"><i class="bx bx-show me-1"></i> Voir</a>
                            <a class="btn btn-sm btn-label-primary me-2" href="{{ route('stages.entreprises.edit', $entreprise->id) }}"><i class="bx bx-edit me-1"></i> Éditer</a>
                            <form action="{{ route('stages.entreprises.destroy', $entreprise->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette entreprise ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-label-danger"><i class="bx bx-trash me-1"></i> Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Aucune entreprise trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $entreprises->links() }}
    </div>
</div>
@endsection
