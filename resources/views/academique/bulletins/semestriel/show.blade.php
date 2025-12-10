@extends('layouts.admin')

@section('titre', 'Bulletin Semestriel')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Bulletins / Semestriels /</span> Détail
    </h4>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Bulletin Semestriel de {{ $etudiant->nom }} {{ $etudiant->prenom }}</h5>
            {{-- Option pour imprimer ou exporter --}}
            {{-- <a href="#" class="btn btn-primary btn-sm"><i class="bx bx-printer me-1"></i> Imprimer</a> --}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <strong>Matricule:</strong> {{ $etudiant->matricule }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Année Académique:</strong> {{ $anneeAcademique }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Semestre:</strong> {{ $semestre->libelle }}
                </div>
                <div class="col-md-6 mb-3">
                    <strong>Filière:</strong> {{ $etudiant->inscriptionAdmins->where('annee_academique', $anneeAcademique)->first()->parcours->filiere->libelle ?? 'N/A' }}
                </div>
            </div>

            <hr class="my-4">

            <h6 class="mb-3">Résultats Globaux du Semestre</h6>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <strong>Moyenne Générale:</strong> <span class="badge bg-label-primary">{{ number_format($results['moyenne_generale'], 2) }}/20</span>
                </div>
                <div class="col-md-4 mb-3">
                    <strong>Statut:</strong> <span class="badge {{ $results['validation'] == 'Validé' ? 'bg-label-success' : 'bg-label-danger' }}">{{ $results['validation'] }}</span>
                </div>
                <div class="col-md-4 mb-3">
                    <strong>Mention:</strong> <span class="badge bg-label-info">{{ $results['mention'] }}</span>
                </div>
            </div>

            <hr class="my-4">

            <h6 class="mb-3">Détails par Unité d'Enseignement (UE)</h6>
            @forelse($ueAverages as $ueAverage)
            <div class="card card-body mb-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 text-primary">{{ $ueAverage['ue']->libelle }} (Coef: {{ $ueAverage['ue']->coefficient ?? 1 }})</h6>
                    <span class="badge bg-label-success">Moyenne UE: {{ number_format($ueAverage['moyenne'], 2) }}/20</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Module</th>
                                <th>Coef Module</th>
                                <th>Moyenne Module</th>
                                <th>Détails Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ueAverage['ue']->modules as $module)
                            <tr>
                                <td>{{ $module->libelle }}</td>
                                <td>{{ $module->coefficient ?? 1 }}</td>
                                <td>
                                    @php
                                        $moyenneModule = app(\App\Services\AcademicAverageService::class)
                                                            ->getMoyenneModule($module, $etudiant, $anneeAcademique);
                                    @endphp
                                    <span class="badge bg-label-secondary">{{ number_format($moyenneModule, 2) }}/20</span>
                                </td>
                                <td>
                                    @php
                                        $evaluations = $module->evaluations->filter(fn($eval) => $eval->annee_academique == $anneeAcademique);
                                    @endphp
                                    @forelse($evaluations as $evaluation)
                                        @php
                                            $noteEtudiant = $evaluation->notes->firstWhere('inscriptionAdmin.id_etudiant', $etudiant->id);
                                            $noteAffichee = $noteEtudiant ? ($noteEtudiant->est_absent ? 'Absent' : number_format($noteEtudiant->note_obtenue, 2)) : 'N/A';
                                            $bareme = $evaluation->evaluationType->max_score ?? 20;
                                        @endphp
                                        <div>
                                            {{ $evaluation->libelle }} ({{ $evaluation->evaluationType->name ?? 'N/A' }} sur {{ $bareme }}):
                                            <strong>{{ $noteAffichee }}</strong>
                                        </div>
                                    @empty
                                        <div>Aucune évaluation.</div>
                                    @endforelse
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @empty
            <p class="text-center mt-3">Aucune UE trouvée pour ce semestre.</p>
            @endforelse

            <div class="mt-4 text-end">
                <a href="{{ route('bulletins.semestriel.index', ['semestre_id' => $semestre->id, 'annee_academique' => $anneeAcademique]) }}" class="btn btn-label-secondary">Retour aux Bulletins</a>
            </div>
        </div>
    </div>
</div>
@endsection
