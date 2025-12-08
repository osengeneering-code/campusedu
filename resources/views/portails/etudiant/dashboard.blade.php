@extends('layouts.admin')

@section('titre', 'Mon Portail Étudiant')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">Portail Étudiant /</span> Tableau de bord
    </h4>

    <div class="row">
        {{-- Carte de Bienvenue / Informations Générales --}}
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Bonjour {{ $etudiant->user->prenom }} ! 👋</h5>
                            <p class="mb-4">
                                Bienvenue sur votre espace étudiant. Retrouvez ici vos informations clés, emploi du temps, notes et évaluations.
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-primary">Voir mon profil</a>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img
                                src="{{ asset('Pro/assets/img/illustrations/man-with-laptop-light.png') }}"
                                height="140"
                                alt="View Badge User"
                                data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                data-app-light-img="illustrations/man-with-laptop-light.png" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Notes et Évaluations --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <h5 class="card-header">Mes Notes et Évaluations</h5>
                <div class="card-body">
                    @forelse($etudiant->inscriptionAdmins as $inscription)
                        @if($inscription->notes->isNotEmpty())
                            <h6 class="text-primary mb-3">Parcours: {{ $inscription->parcours->nom ?? 'N/A' }} ({{ $inscription->annee_academique }})</h6>
                            <div class="table-responsive text-nowrap mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Module</th>
                                            <th>UE</th>
                                            <th>Semestre</th>
                                            <th>Filière</th>
                                            <th>Type d'Évaluation</th>
                                            <th>Date</th>
                                            <th>Note Obtenue</th>
                                            <th>Appréciation</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscription->notes as $note)
                                            <tr>
                                                <td>{{ $note->evaluation->module->libelle ?? 'N/A' }}</td>
                                                <td>{{ $note->evaluation->module->ue->libelle ?? 'N/A' }}</td>
                                                <td>{{ $note->evaluation->module->ue->semestre->libelle ?? 'N/A' }}</td>
                                                <td>{{ $note->evaluation->module->ue->semestre->parcours->filiere->nom ?? 'N/A' }}</td>
                                                <td>{{ $note->evaluation->evaluationType->name ?? 'N/A' }}</td>
                                                <td>{{ $note->evaluation->date_evaluation->format('d/m/Y') ?? 'N/A' }}</td>
                                                <td>
                                                    @if($note->est_absent)
                                                        <span class="badge bg-label-warning">Absent(e)</span>
                                                    @else
                                                        {{ $note->note_obtenue }} / {{ $note->evaluation->evaluationType->max_score ?? '?' }}
                                                    @endif
                                                </td>
                                                <td>{{ $note->appreciation ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Aucune note enregistrée pour le parcours {{ $inscription->parcours->nom ?? 'N/A' }} ({{ $inscription->annee_academique }}).</p>
                        @endif
                    @empty
                        <div class="alert alert-info" role="alert">
                            Vous n'êtes inscrit(e) à aucun parcours ou aucune note n'est encore disponible.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Section Moyennes par Module --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <h5 class="card-header">Mes Moyennes par Module</h5>
                <div class="card-body">
                    @if($moyennesModules->isNotEmpty())
                        <div class="table-responsive text-nowrap">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Module</th>
                                        <th>Code Module</th>
                                        <th>Moyenne</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($etudiant->inscriptionAdmins->first()->modules ?? [] as $module)
                                        <tr>
                                            <td>{{ $module->libelle ?? 'N/A' }}</td>
                                            <td>{{ $module->code_module ?? 'N/A' }}</td>
                                            <td>
                                                @if(isset($moyennesModules[$module->id]))
                                                    <span class="badge {{ $moyennesModules[$module->id] >= 10 ? 'bg-label-success' : 'bg-label-danger' }}">
                                                        {{ $moyennesModules[$module->id] }} / 20
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            Aucune moyenne de module disponible pour le moment.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Section Emploi du temps --}}
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card">
                <h5 class="card-header">Mon Emploi du Temps</h5>
                <div class="card-body">
                    @if($edt->isNotEmpty())
                        @foreach($edt as $jour => $coursDuJour)
                            <h6 class="text-primary mb-2 mt-3">{{ \Carbon\Carbon::parse($jour)->isoFormat('dddd D MMMM') }}</h6>
                            <div class="table-responsive text-nowrap mb-3">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Heure</th>
                                            <th>Module</th>
                                            <th>Enseignant</th>
                                            <th>Salle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coursDuJour->sortBy('heure_debut') as $cours)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($cours->heure_debut)->format('H:i') }} - {{ \Carbon\Carbon::parse($cours->heure_fin)->format('H:i') }}</td>
                                                <td>{{ $cours->module->libelle ?? 'N/A' }}</td>
                                                <td>
                                                    @foreach($cours->module->enseignants as $enseignant)
                                                        {{ $enseignant->nom }} {{ $enseignant->prenom }}{{ !$loop->last ? ', ' : '' }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $cours->salle->nom ?? 'N/A' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info" role="alert">
                            Votre emploi du temps n'est pas encore disponible.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection