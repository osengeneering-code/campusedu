@extends('layouts.admin')

@section('titre', 'Détails de la Candidature')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Détails de la Candidature de {{ $candidature->prenom }} {{ $candidature->nom }}</h5>
        <div>
            @if ($candidature->statut == 'En attente' && Gate::allows('valider_candidatures'))
                <form action="{{ route('inscriptions.candidatures.validate', $candidature) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir VALIDER cette candidature ? Cela créera un compte utilisateur et une inscription administrative.');">Valider la Candidature</button>
                </form>
                <form action="{{ route('inscriptions.candidatures.reject', $candidature) }}" method="POST" class="d-inline ms-2">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir REJETER cette candidature ?');">Rejeter la Candidature</button>
                </form>
            @endif
            <a href="{{ route('inscriptions.candidatures.edit', $candidature) }}" class="btn btn-warning btn-sm ms-2">Modifier</a>
            <a href="{{ route('inscriptions.candidatures.index') }}" class="btn btn-secondary btn-sm ms-2">Retour à la liste</a>
        </div>
    </div>
    <div class="card-body">
        <h6 class="pb-1 mb-4">1. Informations personnelles</h6>
        <dl class="row">
            <dt class="col-sm-3">Nom Complet:</dt>
            <dd class="col-sm-9">{{ $candidature->prenom }} {{ $candidature->nom }}</dd>

            <dt class="col-sm-3">Statut de la Candidature:</dt>
            <dd class="col-sm-9"><span class="badge bg-label-{{ $candidature->statut == 'Validée' ? 'success' : ($candidature->statut == 'Rejetée' ? 'danger' : 'info') }}">{{ $candidature->statut }}</span></dd>

            <dt class="col-sm-3">Nom Père:</dt>
            <dd class="col-sm-9">{{ $candidature->nom_pere ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Prénom Père:</dt>
            <dd class="col-sm-9">{{ $candidature->prenom_pere ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Nom Mère:</dt>
            <dd class="col-sm-9">{{ $candidature->nom_mere ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Prénom Mère:</dt>
            <dd class="col-sm-9">{{ $candidature->prenom_mere ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Date de Naissance:</dt>
            <dd class="col-sm-9">{{ \Carbon\Carbon::parse($candidature->date_naissance)->format('d/m/Y') }}</dd>

            <dt class="col-sm-3">Lieu de Naissance:</dt>
            <dd class="col-sm-9">{{ $candidature->lieu_naissance ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Nationalité:</dt>
            <dd class="col-sm-9">{{ $candidature->nationalite ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Sexe:</dt>
            <dd class="col-sm-9">{{ $candidature->sexe ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Situation Matrimoniale:</dt>
            <dd class="col-sm-9">{{ $candidature->situation_matrimoniale ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Photo d'identité:</dt>
            <dd class="col-sm-9">
                @if ($candidature->photo_identite_path)
                    <a href="{{ Storage::url($candidature->photo_identite_path) }}" target="_blank">Voir Photo</a>
                @else
                    N/A
                @endif
            </dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">2. Coordonnées de l'étudiant</h6>
        <dl class="row">
            <dt class="col-sm-3">Email principal:</dt>
            <dd class="col-sm-9">{{ $candidature->email }}</dd>

            <dt class="col-sm-3">Email secondaire:</dt>
            <dd class="col-sm-9">{{ $candidature->email_secondaire ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Téléphone principal:</dt>
            <dd class="col-sm-9">{{ $candidature->telephone }}</dd>

            <dt class="col-sm-3">Téléphone secondaire:</dt>
            <dd class="col-sm-9">{{ $candidature->telephone_secondaire ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Adresse complète:</dt>
            <dd class="col-sm-9">{{ $candidature->adresse_complete ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Ville:</dt>
            <dd class="col-sm-9">{{ $candidature->ville ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Pays:</dt>
            <dd class="col-sm-9">{{ $candidature->pays ?? 'N/A' }}</dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">3. Informations sur le tuteur / parent</h6>
        <dl class="row">
            <dt class="col-sm-3">Nom Tuteur:</dt>
            <dd class="col-sm-9">{{ $candidature->nom_tuteur ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Prénom Tuteur:</dt>
            <dd class="col-sm-9">{{ $candidature->prenom_tuteur ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Profession Tuteur:</dt>
            <dd class="col-sm-9">{{ $candidature->profession_tuteur ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Lien de Parenté:</dt>
            <dd class="col-sm-9">{{ $candidature->lien_parente_tuteur ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Adresse Tuteur:</dt>
            <dd class="col-sm-9">{{ $candidature->adresse_tuteur ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Téléphone Tuteur:</dt>
            <dd class="col-sm-9">{{ $candidature->telephone_tuteur ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Email Tuteur:</dt>
            <dd class="col-sm-9">{{ $candidature->email_tuteur ?? 'N/A' }}</dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">4. Niveau d'entrée / Formation souhaitée</h6>
        <dl class="row">
            <dt class="col-sm-3">Année d'Admission:</dt>
            <dd class="col-sm-9">{{ $candidature->annee_admission ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Niveau d'Étude Demandé:</dt>
            <dd class="col-sm-9">{{ $candidature->type_niveau ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Parcours Souhaité:</dt>
            <dd class="col-sm-9">{{ $candidature->parcours->nom ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Spécialité:</dt>
            <dd class="col-sm-9">{{ $candidature->specialite_souhaitee ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Option:</dt>
            <dd class="col-sm-9">{{ $candidature->option_souhaitee ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Type d'Inscription:</dt>
            <dd class="col-sm-9">{{ $candidature->type_inscription ?? 'N/A' }}</dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">5. Parcours académique antérieur</h6>
        <dl class="row">
            <dt class="col-sm-3">Dernier Établissement:</dt>
            <dd class="col-sm-9">{{ $candidature->dernier_etablissement ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Série BAC:</dt>
            <dd class="col-sm-9">{{ $candidature->serie_bac ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Année Obtention BAC:</dt>
            <dd class="col-sm-9">{{ $candidature->annee_obtention_bac ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Mention BAC:</dt>
            <dd class="col-sm-9">{{ $candidature->mention_bac ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Numéro Diplôme BAC:</dt>
            <dd class="col-sm-9">{{ $candidature->numero_diplome_bac ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Scan Diplôme BAC:</dt>
            <dd class="col-sm-9">
                @if ($candidature->scan_diplome_bac_path)
                    <a href="{{ Storage::url($candidature->scan_diplome_bac_path) }}" target="_blank">Voir Fichier</a>
                @else
                    N/A
                @endif
            </dd>

            <dt class="col-sm-3">Dernier Diplôme Obtenu:</dt>
            <dd class="col-sm-9">{{ $candidature->dernier_diplome_obtenu ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Établissement d'Origine:</dt>
            <dd class="col-sm-9">{{ $candidature->etablissement_origine ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Relevés de Notes:</dt>
            <dd class="col-sm-9">
                @if ($candidature->releves_notes_path)
                    @foreach(json_decode($candidature->releves_notes_path) as $path)
                        <a href="{{ Storage::url($path) }}" target="_blank">Voir Relevé</a><br>
                    @endforeach
                @else
                    N/A
                @endif
            </dd>

            <dt class="col-sm-3">Attestation de Réussite:</dt>
            <dd class="col-sm-9">
                @if ($candidature->attestation_reussite_path)
                    <a href="{{ Storage::url($candidature->attestation_reussite_path) }}" target="_blank">Voir Fichier</a>
                @else
                    N/A
                @endif
            </dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">6. Documents à téléverser</h6>
        <dl class="row">
            <dt class="col-sm-3">Pièce d'Identité:</dt>
            <dd class="col-sm-9">
                @if ($candidature->piece_identite_path)
                    <a href="{{ Storage::url($candidature->piece_identite_path) }}" target="_blank">Voir Fichier</a>
                @else
                    N/A
                @endif
            </dd>

            <dt class="col-sm-3">Certificat de Naissance:</dt>
            <dd class="col-sm-9">
                @if ($candidature->certificat_naissance_path)
                    <a href="{{ Storage::url($candidature->certificat_naissance_path) }}" target="_blank">Voir Fichier</a>
                @else
                    N/A
                @endif
            </dd>

            <dt class="col-sm-3">Certificat Médical:</dt>
            <dd class="col-sm-9">
                @if ($candidature->certificat_medical_path)
                    <a href="{{ Storage::url($candidature->certificat_medical_path) }}" target="_blank">Voir Fichier</a>
                @else
                    N/A
                @endif
            </dd>

            <dt class="col-sm-3">CV:</dt>
            <dd class="col-sm-9">
                @if ($candidature->cv_path)
                    <a href="{{ Storage::url($candidature->cv_path) }}" target="_blank">Voir Fichier</a>
                @else
                    N/A
                @endif
            </dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">7. Informations administratives</h6>
        <dl class="row">
            <dt class="col-sm-3">Type de Bourse:</dt>
            <dd class="col-sm-9">{{ $candidature->type_bourse ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Première inscription:</dt>
            <dd class="col-sm-9">{{ $candidature->est_premiere_inscription ? 'Oui' : 'Non' }}</dd>

            <dt class="col-sm-3">Mode de Paiement Prévu:</dt>
            <dd class="col-sm-9">{{ $candidature->mode_paiement_prevu ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Déclaration d'Engagement:</dt>
            <dd class="col-sm-9">{{ $candidature->declaration_engagement_acceptee ? 'Acceptée' : 'Non acceptée' }}</dd>
        </dl>

        <h6 class="pb-1 mb-4 mt-4">8. Choix des modalités de paiement</h6>
        <dl class="row">
            <dt class="col-sm-3">Modalité de Paiement:</dt>
            <dd class="col-sm-9">{{ $candidature->paiement_modalite ?? 'N/A' }}</dd>

            <dt class="col-sm-3">Conditions d'Inscription:</dt>
            <dd class="col-sm-9">{{ $candidature->acceptation_conditions_inscription ? 'Acceptées' : 'Non acceptées' }}</dd>
        </dl>
    </div>
</div>
@endsection
