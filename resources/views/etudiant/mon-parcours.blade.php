@extends('layouts.admin')

@section('titre', 'Mon Parcours Académique')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Mon Espace /</span> Mon Parcours Académique</h4>

    @if($parcours)
        <div class="card mb-4">
            <h5 class="card-header">Parcours: {{ $parcours->nom }} (Année Académique: {{ $parcours->filiere->nom ?? 'N/A' }})</h5>
            <div class="card-body">
                @if($parcours->semestres->isEmpty())
                    <p>Aucun semestre défini pour ce parcours.</p>
                @else
                    <div class="accordion" id="accordionParcours">
                        @foreach($parcours->semestres as $semestre)
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingSemestre{{ $semestre->id }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSemestre{{ $semestre->id }}" aria-expanded="false" aria-controls="collapseSemestre{{ $semestre->id }}">
                                        Semestre {{ $semestre->libelle }}
                                    </button>
                                </h2>
                                <div id="collapseSemestre{{ $semestre->id }}" class="accordion-collapse collapse" aria-labelledby="headingSemestre{{ $semestre->id }}" data-bs-parent="#accordionParcours">
                                    <div class="accordion-body">
                                        @if($semestre->ues->isEmpty())
                                            <p>Aucune Unité d'Enseignement (UE) pour ce semestre.</p>
                                        @else
                                            <div class="accordion accordion-flush" id="accordionUE{{ $semestre->id }}">
                                                @foreach($semestre->ues as $ue)
                                                    <div class="accordion-item">
                                                        <h3 class="accordion-header" id="headingUE{{ $ue->id }}">
                                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUE{{ $ue->id }}" aria-expanded="false" aria-controls="collapseUE{{ $ue->id }}">
                                                                {{ $ue->libelle }} ({{ $ue->code_ue }}) - {{ $ue->credits_ects }} crédits
                                                            </button>
                                                        </h3>
                                                        <div id="collapseUE{{ $ue->id }}" class="accordion-collapse collapse" aria-labelledby="headingUE{{ $ue->id }}" data-bs-parent="#accordionUE{{ $semestre->id }}">
                                                            <div class="accordion-body">
                                                                @if($ue->modules->isEmpty())
                                                                    <p>Aucun module pour cette UE.</p>
                                                                @else
                                                                    <ul class="list-group">
                                                                        @foreach($ue->modules as $module)
                                                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                                <div>
                                                                                    <strong>{{ $module->libelle }}</strong> ({{ $module->code_module }})
                                                                                    <small class="text-muted"> - Vol. Horaire: {{ $module->volume_horaire }}h, Coeff: {{ $module->coefficient }}</small>
                                                                                    @if($module->enseignants->isNotEmpty())
                                                                                        <br><small class="text-muted">Enseignant(s):
                                                                                            @foreach($module->enseignants as $enseignant)
                                                                                                {{ $enseignant->prenom }} {{ $enseignant->nom }}@if(!$loop->last), @endif
                                                                                            @endforeach
                                                                                        </small>
                                                                                    @else
                                                                                        <br><small class="text-muted">Enseignant(s): Non attribué</small>
                                                                                    @endif
                                                                                </div>
                                                                                {{-- Optionnel: Ajouter des actions ou des détails supplémentaires --}}
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Vous n'êtes pas encore inscrit à un parcours ou les informations ne sont pas disponibles.
        </div>
    @endif
</div>
@endsection
