@extends('layouts.admin')

@section('titre', 'Profil Étudiant')

@section('content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0">Profil de {{ $etudiant->nom }} {{ $etudiant->prenom }} ({{ $etudiant->matricule }})</h5>
            @if($etudiant->photo_identite_path)
                <a href="{{ Storage::url($etudiant->photo_identite_path) }}" target="_blank">
                    <img src="{{ Storage::url($etudiant->photo_identite_path) }}" alt="Photo d'identité" class="rounded-circle mt-2" style="width: 80px; height: 80px; object-fit: cover;">
                </a>
            @endif
        </div>
        <a href="{{ route('personnes.etudiants.exportPdf', $etudiant) }}" class="btn btn-sm btn-outline-primary">
            <i class="bx bx-download"></i> Exporter en PDF
        </a>
    </div>
    <div class="card-body">
        <div class="nav-align-top mb-4">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-info" aria-controls="navs-top-info" aria-selected="true">Informations</button>
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
                <div class="tab-pane fade show active" id="navs-top-info" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="card mb-3">
                                <h5 class="card-header">Informations Personnelles</h5>
                                <div class="card-body">
                                    <p><strong>Matricule:</strong> {{ $etudiant->matricule }}</p>
                                    <p><strong>Date de naissance:</strong> {{ \Carbon\Carbon::parse($etudiant->date_naissance)->format('d/m/Y') }}</p>
                                    <p><strong>Lieu de naissance:</strong> {{ $etudiant->lieu_naissance ?? 'N/A' }}</p>
                                    <p><strong>Sexe:</strong> {{ $etudiant->sexe }}</p>
                                    <p><strong>Nationalité:</strong> {{ $etudiant->nationalite ?? 'N/A' }}</p>
                                    <p><strong>Situation Matrimoniale:</strong> {{ $etudiant->situation_matrimoniale ?? 'N/A' }}</p>
                                    <hr>
                                    <p><strong>Parents:</strong> {{ $etudiant->prenom_pere }} {{ $etudiant->nom_pere }} et {{ $etudiant->prenom_mere }} {{ $etudiant->nom_mere }}</p>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <h5 class="card-header">Coordonnées</h5>
                                <div class="card-body">
                                    <p><strong>Email Personnel:</strong> {{ $etudiant->email_perso }}</p>
                                    <p><strong>Email Secondaire:</strong> {{ $etudiant->email_secondaire ?? 'N/A' }}</p>
                                    <p><strong>Téléphone Principal:</strong> {{ $etudiant->telephone_perso ?? 'N/A' }}</p>
                                    <p><strong>Téléphone Secondaire:</strong> {{ $etudiant->telephone_secondaire ?? 'N/A' }}</p>
                                    <p><strong>Adresse:</strong> {{ $etudiant->adresse_postale ?? 'N/A' }}</p>
                                    <p><strong>Ville:</strong> {{ $etudiant->ville ?? 'N/A' }}</p>
                                    <p><strong>Pays:</strong> {{ $etudiant->pays ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="card mb-3 mb-lg-0">
                                <h5 class="card-header">Personne à Contacter (Tuteur / Parent)</h5>
                                <div class="card-body">
                                    <p><strong>Nom du tuteur:</strong> {{ $etudiant->prenom_tuteur }} {{ $etudiant->nom_tuteur }}</p>
                                    <p><strong>Lien de parenté:</strong> {{ $etudiant->lien_parente_tuteur ?? 'N/A' }}</p>
                                    <p><strong>Profession:</strong> {{ $etudiant->profession_tuteur ?? 'N/A' }}</p>
                                    <p><strong>Téléphone:</strong> {{ $etudiant->telephone_tuteur ?? 'N/A' }}</p>
                                    <p><strong>Email:</strong> {{ $etudiant->email_tuteur ?? 'N/A' }}</p>
                                    <p><strong>Adresse:</strong> {{ $etudiant->adresse_tuteur ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                             <div class="card mb-3">
                                <h5 class="card-header">Dossier Académique Antérieur</h5>
                                <div class="card-body">
                                    <p><strong>Dernier établissement:</strong> {{ $etudiant->dernier_etablissement ?? 'N/A' }}</p>
                                    <p><strong>Dernier diplôme:</strong> {{ $etudiant->dernier_diplome_obtenu ?? 'N/A' }}</p>
                                    <p><strong>Série du Bac:</strong> {{ $etudiant->serie_bac ?? 'N/A' }}</p>
                                    <p><strong>Année du Bac:</strong> {{ $etudiant->annee_obtention_bac ?? 'N/A' }}</p>
                                    <p><strong>Mention au Bac:</strong> {{ $etudiant->mention_bac ?? 'N/A' }}</p>
                                    <p><strong>Numéro du diplôme du Bac:</strong> {{ $etudiant->numero_diplome_bac ?? 'N/A' }}</p>
                                </div>
                            </div>
                             <div class="card">
                                <h5 class="card-header">Inscriptions Administratives</h5>
                                <div class="card-body">
                                     @if($etudiant->inscriptionAdmins->isNotEmpty())
                                        <ul class="list-group list-group-flush">
                                            @foreach($etudiant->inscriptionAdmins as $inscription)
                                            <li class="list-group-item">
                                                {{ $inscription->annee_academique }} - {{ $inscription->parcours->nom ?? 'N/A' }} ({{ $inscription->statut }})
                                            </li>
                                            @endforeach
                                        </ul>
                                     @else
                                        <p>Aucune inscription administrative.</p>
                                     @endif
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    <span class="badge bg-label-{{ $note->note_obtenue >= 10 ? 'success' : 'danger' }}">{{ $note->note_obtenue }}/{{ $note->evaluation->bareme_total ?? '20' }}</span>
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
                    <h6>Pièces Jointes</h6>
                     <div class="list-group list-group-flush">
                        @if($etudiant->scan_diplome_bac_path) <a href="{{ Storage::url($etudiant->scan_diplome_bac_path) }}" target="_blank" class="list-group-item list-group-item-action">Scan du diplôme du Bac</a> @endif
                        @if($etudiant->releves_notes_path) <a href="{{ Storage::url($etudiant->releves_notes_path) }}" target="_blank" class="list-group-item list-group-item-action">Relevés de notes</a> @endif
                        @if($etudiant->attestation_reussite_path) <a href="{{ Storage::url($etudiant->attestation_reussite_path) }}" target="_blank" class="list-group-item list-group-item-action">Attestation de réussite</a> @endif
                        @if($etudiant->piece_identite_path) <a href="{{ Storage::url($etudiant->piece_identite_path) }}" target="_blank" class="list-group-item list-group-item-action">Pièce d'identité</a> @endif
                        @if($etudiant->certificat_naissance_path) <a href="{{ Storage::url($etudiant->certificat_naissance_path) }}" target="_blank" class="list-group-item list-group-item-action">Certificat de naissance</a> @endif
                        @if($etudiant->certificat_medical_path) <a href="{{ Storage::url($etudiant->certificat_medical_path) }}" target="_blank" class="list-group-item list-group-item-action">Certificat médical</a> @endif
                        @if($etudiant->cv_path) <a href="{{ Storage::url($etudiant->cv_path) }}" target="_blank" class="list-group-item list-group-item-action">CV</a> @endif
                        @if(!$etudiant->scan_diplome_bac_path && !$etudiant->releves_notes_path && !$etudiant->attestation_reussite_path && !$etudiant->piece_identite_path && !$etudiant->certificat_naissance_path && !$etudiant->certificat_medical_path && !$etudiant->cv_path)
                            <p>Aucune pièce jointe trouvée.</p>
                        @endif
                    </div>
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
