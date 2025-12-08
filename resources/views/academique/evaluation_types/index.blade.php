@extends('layouts.admin')

@section('titre', 'Types d\'Évaluation')

@section('content')
<div class="card">

    {{-- En-tête --}}
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-task me-2"></i> Types d'Évaluation</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('academique.evaluation-types.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Ajouter un type
            </a>
            <a href="" class="btn btn-danger">
                <i class="bx bxs-file-pdf me-1"></i> PDF
            </a>
            <button onclick="window.print();" class="btn btn-secondary">
                <i class="bx bx-printer me-1"></i> Imprimer
            </button>
        </div>
    </div>

    {{-- Table des types --}}
    <div class="table-responsive text-nowrap">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom</th>
                    <th>Barème Max</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @forelse($evaluationTypes as $type)
                    <tr>
                        <td>
                            <span class="badge bg-info text-dark px-3 py-2">{{ $type->name }}</span>
                        </td>
                        <td>{{ $type->max_score }}</td>
                        <td class="text-center">
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{ route('academique.evaluation-types.edit', $type) }}">
                                        <i class="bx bx-edit-alt me-1"></i> Modifier
                                    </a>
                                    <form action="{{ route('academique.evaluation-types.destroy', $type) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce type d\'évaluation ?');">
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
                        <td colspan="3" class="text-center text-muted">Aucun type d'évaluation trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="card-footer d-flex justify-content-end">
        {{ $evaluationTypes->links() }}
    </div>
</div>
@endsection
