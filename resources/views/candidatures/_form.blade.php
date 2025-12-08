<div class="row">
    {{-- 1. Informations personnelles --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">1. Informations personnelles</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="{{ old('nom', $candidature->nom ?? '') }}" required>
                @error('nom')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="{{ old('prenom', $candidature->prenom ?? '') }}" required>
                @error('prenom')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nom_pere" class="form-label">Nom du Père</label>
                <input type="text" class="form-control" id="nom_pere" name="nom_pere" value="{{ old('nom_pere', $candidature->nom_pere ?? '') }}">
                @error('nom_pere')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="prenom_pere" class="form-label">Prénom du Père</label>
                <input type="text" class="form-control" id="prenom_pere" name="prenom_pere" value="{{ old('prenom_pere', $candidature->prenom_pere ?? '') }}">
                @error('prenom_pere')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nom_mere" class="form-label">Nom de la Mère</label>
                <input type="text" class="form-control" id="nom_mere" name="nom_mere" value="{{ old('nom_mere', $candidature->nom_mere ?? '') }}">
                @error('nom_mere')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="prenom_mere" class="form-label">Prénom de la Mère</label>
                <input type="text" class="form-control" id="prenom_mere" name="prenom_mere" value="{{ old('prenom_mere', $candidature->prenom_mere ?? '') }}">
                @error('prenom_mere')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="date_naissance" class="form-label">Date de Naissance</label>
                <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $candidature->date_naissance ?? '') }}" required>
                @error('date_naissance')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="lieu_naissance" class="form-label">Lieu de Naissance</label>
                <input type="text" class="form-control" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $candidature->lieu_naissance ?? '') }}">
                @error('lieu_naissance')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="nationalite" class="form-label">Nationalité</label>
                <input type="text" class="form-control" id="nationalite" name="nationalite" value="{{ old('nationalite', $candidature->nationalite ?? '') }}">
                @error('nationalite')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="sexe" class="form-label">Sexe</label>
                <select class="form-select" id="sexe" name="sexe">
                    <option value="">Sélectionner</option>
                    <option value="M" {{ old('sexe', $candidature->sexe ?? '') == 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ old('sexe', $candidature->sexe ?? '') == 'F' ? 'selected' : '' }}>Féminin</option>
                    <option value="Autre" {{ old('sexe', $candidature->sexe ?? '') == 'Autre' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('sexe')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="situation_matrimoniale" class="form-label">Situation Matrimoniale</label>
                <select class="form-select" id="situation_matrimoniale" name="situation_matrimoniale">
                    <option value="">Sélectionner</option>
                    <option value="Célibataire" {{ old('situation_matrimoniale', $candidature->situation_matrimoniale ?? '') == 'Célibataire' ? 'selected' : '' }}>Célibataire</option>
                    <option value="Marié(e)" {{ old('situation_matrimoniale', $candidature->situation_matrimoniale ?? '') == 'Marié(e)' ? 'selected' : '' }}>Marié(e)</option>
                    <option value="Divorcé(e)" {{ old('situation_matrimoniale', $candidature->situation_matrimoniale ?? '') == 'Divorcé(e)' ? 'selected' : '' }}>Divorcé(e)</option>
                    <option value="Veuf(ve)" {{ old('situation_matrimoniale', $candidature->situation_matrimoniale ?? '') == 'Veuf(ve)' ? 'selected' : '' }}>Veuf(ve)</option>
                </select>
                @error('situation_matrimoniale')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="photo_identite" class="form-label">Photo d'identité (JPEG, PNG, max 2MB)</label>
                <input type="file" class="form-control" id="photo_identite" name="photo_identite">
                @error('photo_identite')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->photo_identite_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->photo_identite_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
        </div>
    </div>

    {{-- 2. Coordonnées de l’étudiant --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">2. Coordonnées de l'étudiant</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="email" class="form-label">Email principal</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $candidature->email ?? '') }}" required>
                @error('email')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="email_secondaire" class="form-label">Email secondaire (Optionnel)</label>
                <input type="email" class="form-control" id="email_secondaire" name="email_secondaire" value="{{ old('email_secondaire', $candidature->email_secondaire ?? '') }}">
                @error('email_secondaire')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="telephone" class="form-label">Téléphone principal</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone', $candidature->telephone ?? '') }}" required>
                @error('telephone')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="telephone_secondaire" class="form-label">Téléphone secondaire (Optionnel)</label>
                <input type="text" class="form-control" id="telephone_secondaire" name="telephone_secondaire" value="{{ old('telephone_secondaire', $candidature->telephone_secondaire ?? '') }}">
                @error('telephone_secondaire')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="adresse_complete" class="form-label">Adresse complète</label>
                <textarea class="form-control" id="adresse_complete" name="adresse_complete" rows="3">{{ old('adresse_complete', $candidature->adresse_complete ?? '') }}</textarea>
                @error('adresse_complete')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="ville" class="form-label">Ville</label>
                <input type="text" class="form-control" id="ville" name="ville" value="{{ old('ville', $candidature->ville ?? '') }}">
                @error('ville')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="pays" class="form-label">Pays</label>
                <input type="text" class="form-control" id="pays" name="pays" value="{{ old('pays', $candidature->pays ?? '') }}">
                @error('pays')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- 3. Informations sur le tuteur / parent --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">3. Informations sur le tuteur / parent</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nom_tuteur" class="form-label">Nom du Tuteur Légal</label>
                <input type="text" class="form-control" id="nom_tuteur" name="nom_tuteur" value="{{ old('nom_tuteur', $candidature->nom_tuteur ?? '') }}">
                @error('nom_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="prenom_tuteur" class="form-label">Prénom du Tuteur Légal</label>
                <input type="text" class="form-control" id="prenom_tuteur" name="prenom_tuteur" value="{{ old('prenom_tuteur', $candidature->prenom_tuteur ?? '') }}">
                @error('prenom_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="profession_tuteur" class="form-label">Profession du Tuteur</label>
                <input type="text" class="form-control" id="profession_tuteur" name="profession_tuteur" value="{{ old('profession_tuteur', $candidature->profession_tuteur ?? '') }}">
                @error('profession_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="lien_parente_tuteur" class="form-label">Lien de Parenté</label>
                <input type="text" class="form-control" id="lien_parente_tuteur" name="lien_parente_tuteur" value="{{ old('lien_parente_tuteur', $candidature->lien_parente_tuteur ?? '') }}">
                @error('lien_parente_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-12 mb-3">
                <label for="adresse_tuteur" class="form-label">Adresse du Tuteur</label>
                <textarea class="form-control" id="adresse_tuteur" name="adresse_tuteur" rows="3">{{ old('adresse_tuteur', $candidature->adresse_tuteur ?? '') }}</textarea>
                @error('adresse_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="telephone_tuteur" class="form-label">Téléphone du Tuteur</label>
                <input type="text" class="form-control" id="telephone_tuteur" name="telephone_tuteur" value="{{ old('telephone_tuteur', $candidature->telephone_tuteur ?? '') }}">
                @error('telephone_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="email_tuteur" class="form-label">Email du Tuteur</label>
                <input type="email" class="form-control" id="email_tuteur" name="email_tuteur" value="{{ old('email_tuteur', $candidature->email_tuteur ?? '') }}">
                @error('email_tuteur')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- 4. Niveau d’entrée / Formation souhaitée --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">4. Niveau d'entrée / Formation souhaitée</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="annee_admission" class="form-label">Année d'Admission</label>
                <input type="text" class="form-control" id="annee_admission" name="annee_admission" value="{{ old('annee_admission', $candidature->annee_admission ?? '') }}">
                @error('annee_admission')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="type_niveau" class="form-label">Niveau d'Étude Demandé</label>
                <select class="form-select" id="type_niveau" name="type_niveau">
                    <option value="">Sélectionner un niveau</option>
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau }}" {{ old('type_niveau', $candidature->type_niveau ?? '') == $niveau ? 'selected' : '' }}>{{ $niveau }}</option>
                    @endforeach
                </select>
                @error('type_niveau')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="parcours_id" class="form-label">Parcours Souhaité</label>
                <select class="form-select" id="parcours_id" name="parcours_id">
                    <option value="">Sélectionner un parcours</option>
                    @foreach($parcours as $p) {{-- $parcours doit être passé par le contrôleur --}}
                        <option value="{{ $p->id }}" {{ old('parcours_id', $candidature->parcours_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nom }}</option>
                    @endforeach
                </select>
                @error('parcours_id')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="specialite_souhaitee" class="form-label">Spécialité</label>
                <input type="text" class="form-control" id="specialite_souhaitee" name="specialite_souhaitee" value="{{ old('specialite_souhaitee', $candidature->specialite_souhaitee ?? '') }}">
                @error('specialite_souhaitee')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="option_souhaitee" class="form-label">Option (si applicable)</label>
                <input type="text" class="form-control" id="option_souhaitee" name="option_souhaitee" value="{{ old('option_souhaitee', $candidature->option_souhaitee ?? '') }}">
                @error('option_souhaitee')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="type_inscription" class="form-label">Type d'Inscription</label>
                <select class="form-select" id="type_inscription" name="type_inscription">
                    <option value="">Sélectionner</option>
                    <option value="Nouveau" {{ old('type_inscription', $candidature->type_inscription ?? '') == 'Nouveau' ? 'selected' : '' }}>Nouveau</option>
                    <option value="Réinscription" {{ old('type_inscription', $candidature->type_inscription ?? '') == 'Réinscription' ? 'selected' : '' }}>Réinscription</option>
                    <option value="Transfert" {{ old('type_inscription', $candidature->type_inscription ?? '') == 'Transfert' ? 'selected' : '' }}>Transfert</option>
                </select>
                @error('type_inscription')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- 5. Parcours académique antérieur --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">5. Parcours académique antérieur</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="dernier_etablissement" class="form-label">Dernier Établissement Fréquenté</label>
                <input type="text" class="form-control" id="dernier_etablissement" name="dernier_etablissement" value="{{ old('dernier_etablissement', $candidature->dernier_etablissement ?? '') }}">
                @error('dernier_etablissement')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="serie_bac" class="form-label">Série du BAC</label>
                <input type="text" class="form-control" id="serie_bac" name="serie_bac" value="{{ old('serie_bac', $candidature->serie_bac ?? '') }}">
                @error('serie_bac')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="annee_obtention_bac" class="form-label">Année d'Obtention du BAC</label>
                <input type="number" class="form-control" id="annee_obtention_bac" name="annee_obtention_bac" value="{{ old('annee_obtention_bac', $candidature->annee_obtention_bac ?? '') }}">
                @error('annee_obtention_bac')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="mention_bac" class="form-label">Mention au BAC</label>
                <input type="text" class="form-control" id="mention_bac" name="mention_bac" value="{{ old('mention_bac', $candidature->mention_bac ?? '') }}">
                @error('mention_bac')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="numero_diplome_bac" class="form-label">Numéro du Diplôme du BAC</label>
                <input type="text" class="form-control" id="numero_diplome_bac" name="numero_diplome_bac" value="{{ old('numero_diplome_bac', $candidature->numero_diplome_bac ?? '') }}">
                @error('numero_diplome_bac')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="scan_diplome_bac" class="form-label">Scan du Diplôme du BAC (PDF, max 5MB)</label>
                <input type="file" class="form-control" id="scan_diplome_bac" name="scan_diplome_bac">
                @error('scan_diplome_bac')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->scan_diplome_bac_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->scan_diplome_bac_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="dernier_diplome_obtenu" class="form-label">Dernier Diplôme Obtenu (Niveau Supérieur)</label>
                <input type="text" class="form-control" id="dernier_diplome_obtenu" name="dernier_diplome_obtenu" value="{{ old('dernier_diplome_obtenu', $candidature->dernier_diplome_obtenu ?? '') }}">
                @error('dernier_diplome_obtenu')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="etablissement_origine" class="form-label">Établissement d'Origine</label>
                <input type="text" class="form-control" id="etablissement_origine" name="etablissement_origine" value="{{ old('etablissement_origine', $candidature->etablissement_origine ?? '') }}">
                @error('etablissement_origine')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="releves_notes" class="form-label">Relevés de Notes Universitaires (PDF, max 5MB)</label>
                <input type="file" class="form-control" id="releves_notes" name="releves_notes[]" multiple>
                @error('releves_notes')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->releves_notes_path)
                    <small>Fichier(s) actuel(s): <a href="{{ Storage::url($candidature->releves_notes_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="attestation_reussite" class="form-label">Attestation de Réussite / Diplôme (PDF, max 5MB)</label>
                <input type="file" class="form-control" id="attestation_reussite" name="attestation_reussite">
                @error('attestation_reussite')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->attestation_reussite_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->attestation_reussite_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
        </div>
    </div>

    {{-- 6. Documents à téléverser --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">6. Documents à téléverser</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="piece_identite" class="form-label">Pièce d'Identité (CNI / Passeport - PDF, max 5MB)</label>
                <input type="file" class="form-control" id="piece_identite" name="piece_identite">
                @error('piece_identite')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->piece_identite_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->piece_identite_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="certificat_naissance" class="form-label">Certificat de Naissance (PDF, max 5MB)</label>
                <input type="file" class="form-control" id="certificat_naissance" name="certificat_naissance">
                @error('certificat_naissance')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->certificat_naissance_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->certificat_naissance_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="certificat_medical" class="form-label">Certificat Médical (Optionnel - PDF, max 5MB)</label>
                <input type="file" class="form-control" id="certificat_medical" name="certificat_medical">
                @error('certificat_medical')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->certificat_medical_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->certificat_medical_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
            <div class="col-md-6 mb-3">
                <label for="cv" class="form-label">CV (Optionnel - PDF, max 5MB)</label>
                <input type="file" class="form-control" id="cv" name="cv">
                @error('cv')<div class="text-danger">{{ $message }}</div>@enderror
                @if (isset($candidature) && $candidature->cv_path)
                    <small>Fichier actuel: <a href="{{ Storage::url($candidature->cv_path) }}" target="_blank">Voir</a></small>
                @endif
            </div>
        </div>
    </div>

    {{-- 7. Informations administratives --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">7. Informations administratives</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="type_bourse" class="form-label">Type de Bourse</label>
                <select class="form-select" id="type_bourse" name="type_bourse">
                    <option value="">Sélectionner</option>
                    <option value="Aucune" {{ old('type_bourse', $candidature->type_bourse ?? '') == 'Aucune' ? 'selected' : '' }}>Aucune</option>
                    <option value="État" {{ old('type_bourse', $candidature->type_bourse ?? '') == 'État' ? 'selected' : '' }}>État</option>
                    <option value="Entreprise" {{ old('type_bourse', $candidature->type_bourse ?? '') == 'Entreprise' ? 'selected' : '' }}>Entreprise</option>
                    <option value="Institution" {{ old('type_bourse', $candidature->type_bourse ?? '') == 'Institution' ? 'selected' : '' }}>Institution</option>
                </select>
                @error('type_bourse')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="mode_paiement_prevu" class="form-label">Mode de Paiement Prévu</label>
                <select class="form-select" id="mode_paiement_prevu" name="mode_paiement_prevu">
                    <option value="">Sélectionner</option>
                    <option value="Mobile Money" {{ old('mode_paiement_prevu', $candidature->mode_paiement_prevu ?? '') == 'Mobile Money' ? 'selected' : '' }}>Mobile Money</option>
                    <option value="Banque" {{ old('mode_paiement_prevu', $candidature->mode_paiement_prevu ?? '') == 'Banque' ? 'selected' : '' }}>Banque</option>
                    <option value="Cash" {{ old('mode_paiement_prevu', $candidature->mode_paiement_prevu ?? '') == 'Cash' ? 'selected' : '' }}>Cash</option>
                </select>
                @error('mode_paiement_prevu')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="est_premiere_inscription" name="est_premiere_inscription" value="1" {{ old('est_premiere_inscription', $candidature->est_premiere_inscription ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="est_premiere_inscription">Première inscription dans l'établissement</label>
                @error('est_premiere_inscription')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="declaration_engagement_acceptee" name="declaration_engagement_acceptee" value="1" {{ old('declaration_engagement_acceptee', $candidature->declaration_engagement_acceptee ?? false) ? 'checked' : '' }} required>
                <label class="form-check-label" for="declaration_engagement_acceptee">J'accepte la déclaration d'engagement</label>
                @error('declaration_engagement_acceptee')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    {{-- 8. Choix des modalités de paiement --}}
    <div class="col-md-12 mb-4">
        <h6 class="pb-1 mb-4">8. Choix des modalités de paiement</h6>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="paiement_modalite" class="form-label">Modalité de Paiement</label>
                <select class="form-select" id="paiement_modalite" name="paiement_modalite">
                    <option value="">Sélectionner</option>
                    <option value="Total" {{ old('paiement_modalite', $candidature->paiement_modalite ?? '') == 'Total' ? 'selected' : '' }}>Total</option>
                    <option value="Échelonné" {{ old('paiement_modalite', $candidature->paiement_modalite ?? '') == 'Échelonné' ? 'selected' : '' }}>Échelonné</option>
                </select>
                @error('paiement_modalite')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6 mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="acceptation_conditions_inscription" name="acceptation_conditions_inscription" value="1" {{ old('acceptation_conditions_inscription', $candidature->acceptation_conditions_inscription ?? false) ? 'checked' : '' }} required>
                <label class="form-check-label" for="acceptation_conditions_inscription">J'accepte les conditions d'inscription</label>
                @error('acceptation_conditions_inscription')<div class="text-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>
</div>