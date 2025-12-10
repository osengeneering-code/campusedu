@extends('layouts.admin')

@section('titre', 'Mes Notes')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mon Espace /</span> Mes Notes</h4>

    @if($inscriptions->isEmpty())
        <div class="alert alert-info">
            Vous n'avez aucune inscription active pour le moment.
        </div>
    @else
        @foreach($inscriptions as $inscription)
            <div class="card mb-4">
                <h5 class="card-header">Notes pour l'année académique {{ $inscription->annee_academique }} - {{ $inscription->parcours->nom }}</h5>
                <div class="card-body">
                    @if($inscription->parcours->semestres->isEmpty())
                        <p>Aucun semestre défini pour ce parcours.</p>
                    @else
                        @foreach($inscription->parcours->semestres as $semestre)
                            <div class="accordion mb-3" id="accordion-{{ $semestre->id }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-{{ $semestre->id }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $semestre->id }}" aria-expanded="false" aria-controls="collapse-{{ $semestre->id }}">
                                            <strong>{{ $semestre->libelle }}</strong>
                                        </button>
                                    </h2>
                                    <div id="collapse-{{ $semestre->id }}" class="accordion-collapse collapse" aria-labelledby="heading-{{ $semestre->id }}" data-bs-parent="#accordion-{{ $semestre->id }}">
                                        <div class="accordion-body">
                                            @if($semestre->ues->isEmpty())
                                                <p>Aucune Unité d'Enseignement pour ce semestre.</p>
                                            @else
                                                @foreach($semestre->ues as $ue)
                                                    <div class="card mb-3">
                                                        <div class="card-header d-flex justify-content-between">
                                                            <span>{{ $ue->libelle }} ({{ $ue->code_ue }})</span>
                                                            <span class="badge bg-label-primary">Crédits: {{ $ue->credits_ects }}</span>
                                                        </div>
                                                        <div class="card-body">
                                                            @if($ue->modules->isEmpty())
                                                                <p>Aucun module pour cette UE.</p>
                                                            @else
                                                                @foreach($ue->modules as $module)
                                                                    <div class="mb-3">
                                                                        <h6>{{ $module->libelle }}</h6>
                                                                        @if($module->evaluations->isEmpty())
                                                                            <p class="text-muted">Aucune évaluation pour ce module.</p>
                                                                        @else
                                                                            <table class="table table-bordered table-sm">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Évaluation</th>
                                                                                        <th>Note</th>
                                                                                        <th>Coefficient</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    @foreach($module->evaluations as $evaluation)
                                                                                        <tr>
                                                                                            <td>{{ $evaluation->type->nom ?? 'N/A' }}</td>
                                                                                            <td>
                                                                                                @php
                                                                                                    $note = $evaluation->notes->first();
                                                                                                @endphp
                                                                                                @if($note)
                                                                                                    {{ $note->note_obtenue }}
                                                                                                @else
                                                                                                    -
                                                                                                @endif
                                                                                            </td>
                                                                                            <td>{{ $evaluation->coefficient ?? 1 }}</td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        @endif
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
