@extends('layouts.admin')

@section('titre', 'Résultats Semestriels')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Mon Espace /</span> Résultats Semestriels ({{ $semestre->libelle }})
    </h4>

    <div class="card mb-4">
        <h5 class="card-header">Vue d'ensemble du Semestre</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Semestre:</strong> {{ $semestre->libelle }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Année Académique:</strong> {{ $anneeAcademique }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Moyenne Générale:</strong> <span class="badge bg-label-primary">{{ number_format($results['moyenne_generale'], 2) }}/20</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Statut:</strong> <span class="badge {{ $results['validation'] == 'Validé' ? 'bg-label-success' : 'bg-label-danger' }}">{{ $results['validation'] }}</span>
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Mention:</strong> <span class="badge bg-label-info">{{ $results['mention'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Détail par Unité d'Enseignement (UE)</h5>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>UE</th>
                        <th>Coefficient</th>
                        <th>Moyenne UE</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse($ueAverages as $ueAverage)
                    <tr>
                        <td><strong>{{ $ueAverage['ue']->libelle }}</strong></td>
                        <td>{{ $ueAverage['ue']->coefficient ?? 1 }}</td>
                        <td><span class="badge bg-label-secondary">{{ number_format($ueAverage['moyenne'], 2) }}/20</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">Aucune UE trouvée pour ce semestre.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
