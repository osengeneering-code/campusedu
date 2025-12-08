@extends('layouts.admin')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4">Gestion des Notes</h4>

    @foreach($modules as $module)
        <div class="card mb-4">
            <h5 class="card-header">
                {{ $module->nom }} 
                <small class="text-muted">({{ $module->semestre->nom ?? '' }} / {{ $module->filiere->nom ?? '' }})</small>
            </h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Évaluation</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($module->evaluations as $evaluation)
                            <tr>
                                <td>{{ $evaluation->libelle }}</td>
                                <td>{{ $evaluation->evaluationType->name ?? 'N/A' }} </td>
                                <td>{{ \Carbon\Carbon::parse($evaluation->date_evaluation)->format('d/m/Y') }}</td>


                                <td>
                                    <a href="{{ route('gestion-cours.notes.create', ['evaluation_id' => $evaluation->id]) }}" class="btn btn-sm btn-primary">
                                        Saisir/Voir Notes
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Aucune évaluation trouvée pour ce module.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
