@extends('layouts.admin')

@section('titre', 'Profil Étudiant')

@section('content')
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Profil de {{ $etudiant->nom }} {{ $etudiant->prenom }} ({{ $etudiant->matricule }})</h5>
        <a href="{{ route('personnes.etudiants.exportPdf', $etudiant) }}" class="btn btn-sm btn-outline-primary float-end">
            <i class="bx bx-download"></i> Exporter PDF
        </a>
    </div>
    <div class="card-body">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">Informations</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-notes" aria-controls="navs-top-notes" aria-selected="false">Notes</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-stages" aria-controls="navs-top-stages" aria-selected="false">Stages</button>
                </li>
                <li class="nav-item">
                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-documents" aria-controls="navs-top-documents" aria-selected="false">Documents</button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                    <p><strong>Matricule:</strong> {{ $etudiant->matricule }}</p>
                    <p><strong>Date de naissance:</strong> {{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</p>
                    <p><strong>Lieu de naissance:</strong> {{ $etudiant->lieu_naissance ?? 'N/A' }}</p>
                    <p><strong>Sexe:</strong> {{ $etudiant->sexe }}</p>
                    <p><strong>Email Personnel:</strong> {{ $etudiant->email_perso }}</p>
                    <p><strong>Téléphone:</strong> {{ $etudiant->telephone_perso ?? 'N/A' }}</p>
                    <p><strong>Adresse:</strong> {{ $etudiant->adresse_postale ?? 'N/A' }}</p>
                    
                    <h6>Inscription(s) Administrative(s)</h6>
                    @if($etudiant->inscriptionAdmins->isNotEmpty())
                    <ul class="list-group">
                        @foreach($etudiant->inscriptionAdmins as $inscription)
                        <li class="list-group-item">
                            Année: {{ $inscription->annee_academique }} - Parcours: {{ $inscription->parcours->nom ?? 'N/A' }} ({{ $inscription->parcours->filiere->nom ?? 'N/A' }}) - Statut: {{ $inscription->statut }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>Aucune inscription administrative.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="navs-top-notes" role="tabpanel">
                    <h6>Notes de l'étudiant</h6>
                    @if($etudiant->inscriptionAdmins->isNotEmpty())
                        @foreach($etudiant->inscriptionAdmins as $inscription)
                            <div class="mb-3">
                                <strong>Année Académique: {{ $inscription->annee_academique }}</strong>
                                @if($inscription->notes->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach($inscription->notes as $note)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    {{ $note->evaluation->module->libelle ?? 'N/A' }} ({{ $note->evaluation->libelle ?? 'N/A' }})
                                                </div>
                                                @if($note->est_absent)
                                                    <span class="badge bg-label-danger">Absent</span>
                                                @else
                                                    <span class="badge bg-label-{{ $note->note_obtenue >= 10 ? 'success' : 'danger' }}">{{ $note->note_obtenue }}/{{ $note->evaluation->bareme_total }}</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>Aucune note pour cette année.</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p>L'étudiant n'a pas d'inscriptions administratives.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="navs-top-stages" role="tabpanel">
                    <h6>Stages de l'étudiant</h6>
                    @if($etudiant->inscriptionAdmins->isNotEmpty())
                        @foreach($etudiant->inscriptionAdmins as $inscription)
                            <div class="mb-3">
                                <strong>Année Académique: {{ $inscription->annee_academique }}</strong>
                                @if($inscription->stages->isNotEmpty())
                                    <ul class="list-group">
                                        @foreach($inscription->stages as $stage)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                <div>
                                                    <strong>{{ $stage->sujet_stage }}</strong> chez {{ $stage->entreprise->nom_entreprise ?? 'N/A' }}
                                                    <br><small>Du {{ \Carbon\Carbon::parse($stage->date_debut)->format('d/m/Y') }} au {{ \Carbon\Carbon::parse($stage->date_fin)->format('d/m/Y') }}</small>
                                                </div>
                                                <span class="badge bg-label-info">{{ $stage->statut_validation }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p>Aucun stage enregistré pour cette année.</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p>L'étudiant n'a pas d'inscriptions administratives.</p>
                    @endif
                </div>
                <div class="tab-pane fade" id="navs-top-documents" role="tabpanel">
                    <h6>Documents de l'étudiant</h6>
                    @if($etudiant->documents->isNotEmpty())
                    <ul class="list-group">
                        @foreach($etudiant->documents as $document)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $document->nom_fichier }} ({{ $document->type_document }})</span>
                            <a href="{{ asset('storage/' . $document->chemin_fichier) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Voir</a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p>Aucun document.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('personnes.etudiants.edit', $etudiant) }}" class="btn btn-warning">Modifier</a>
            <a href="{{ route('personnes.etudiants.index') }}" class="btn btn-label-secondary">Retour à la liste</a>
        </div>
    </div>
</div>
@endsection
