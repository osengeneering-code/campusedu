@csrf
<h5 class="mb-4">Informations Générales</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nom">Nom</label>
        <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $etudiant->nom ?? '') }}" required />
        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="prenom">Prénom</label>
        <input type="text" class="form-control @error('prenom') is-invalid @enderror" id="prenom" name="prenom" value="{{ old('prenom', $etudiant->prenom ?? '') }}" required />
        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="date_naissance">Date de Naissance</label>
        <input type="date" class="form-control @error('date_naissance') is-invalid @enderror" id="date_naissance" name="date_naissance" value="{{ old('date_naissance', $etudiant->date_naissance ?? '') }}" required />
        @error('date_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="lieu_naissance">Lieu de Naissance</label>
        <input type="text" class="form-control @error('lieu_naissance') is-invalid @enderror" id="lieu_naissance" name="lieu_naissance" value="{{ old('lieu_naissance', $etudiant->lieu_naissance ?? '') }}" />
        @error('lieu_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nationalite">Nationalité</label>
        <input type="text" class="form-control @error('nationalite') is-invalid @enderror" id="nationalite" name="nationalite" value="{{ old('nationalite', $etudiant->nationalite ?? '') }}" />
        @error('nationalite') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="sexe">Sexe</label>
        <select name="sexe" id="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
            <option value="">Sélectionnez le sexe</option>
            @foreach(['M', 'F', 'Autre'] as $sexe)
                <option value="{{ $sexe }}" @selected(old('sexe', $etudiant->sexe ?? '') == $sexe)>{{ $sexe }}</option>
            @endforeach
        </select>
        @error('sexe') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="situation_matrimoniale">Situation Matrimoniale</label>
        <select class="form-select @error('situation_matrimoniale') is-invalid @enderror" id="situation_matrimoniale" name="situation_matrimoniale">
    <option value="">Sélectionner</option>
    <option value="Célibataire" @selected(old('situation_matrimoniale', $etudiant->situation_matrimoniale ?? '') == 'Célibataire')>Célibataire</option>
    <option value="Marié(e)" @selected(old('situation_matrimoniale', $etudiant->situation_matrimoniale ?? '') == 'Marié(e)')>Marié(e)</option>
    <option value="Divorcé(e)" @selected(old('situation_matrimoniale', $etudiant->situation_matrimoniale ?? '') == 'Divorcé(e)')>Divorcé(e)</option>
    <option value="Veuf(ve)" @selected(old('situation_matrimoniale', $etudiant->situation_matrimoniale ?? '') == 'Veuf(ve)')>Veuf(ve)</option>
</select>
        @error('situation_matrimoniale') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label for="photo_identite" class="form-label">Photo d'identité</label>
        <input class="form-control @error('photo_identite') is-invalid @enderror" type="file" id="photo_identite" name="photo_identite" accept="image/*">
        @error('photo_identite') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->photo_identite_path)
            <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->photo_identite_path) }}" target="_blank">Voir</a></small>
        @endif
    </div>
</div>

<h5 class="mt-4 mb-3">Coordonnées de l'étudiant</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="email_perso">Email Personnel</label>
        <input type="email" class="form-control @error('email_perso') is-invalid @enderror" id="email_perso" name="email_perso" value="{{ old('email_perso', $etudiant->email_perso ?? '') }}" required />
        @error('email_perso') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="email_secondaire">Email Secondaire</label>
        <input type="email" class="form-control @error('email_secondaire') is-invalid @enderror" id="email_secondaire" name="email_secondaire" value="{{ old('email_secondaire', $etudiant->email_secondaire ?? '') }}" />
        @error('email_secondaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="telephone_perso">Téléphone Principal</label>
        <input type="text" class="form-control @error('telephone_perso') is-invalid @enderror" id="telephone_perso" name="telephone_perso" value="{{ old('telephone_perso', $etudiant->telephone_perso ?? '') }}" />
        @error('telephone_perso') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="telephone_secondaire">Téléphone Secondaire</label>
        <input type="text" class="form-control @error('telephone_secondaire') is-invalid @enderror" id="telephone_secondaire" name="telephone_secondaire" value="{{ old('telephone_secondaire', $etudiant->telephone_secondaire ?? '') }}" />
        @error('telephone_secondaire') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label" for="adresse_postale">Adresse Complète</label>
    <textarea class="form-control @error('adresse_postale') is-invalid @enderror" id="adresse_postale" name="adresse_postale">{{ old('adresse_postale', $etudiant->adresse_postale ?? '') }}</textarea>
    @error('adresse_postale') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="ville">Ville</label>
        <input type="text" class="form-control @error('ville') is-invalid @enderror" id="ville" name="ville" value="{{ old('ville', $etudiant->ville ?? '') }}" />
        @error('ville') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="pays">Pays</label>
        <input type="text" class="form-control @error('pays') is-invalid @enderror" id="pays" name="pays" value="{{ old('pays', $etudiant->pays ?? '') }}" />
        @error('pays') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<h5 class="mt-4 mb-3">Informations Parentales</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nom_pere">Nom du Père</label>
        <input type="text" class="form-control @error('nom_pere') is-invalid @enderror" id="nom_pere" name="nom_pere" value="{{ old('nom_pere', $etudiant->nom_pere ?? '') }}" />
        @error('nom_pere') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="prenom_pere">Prénom du Père</label>
        <input type="text" class="form-control @error('prenom_pere') is-invalid @enderror" id="prenom_pere" name="prenom_pere" value="{{ old('prenom_pere', $etudiant->prenom_pere ?? '') }}" />
        @error('prenom_pere') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nom_mere">Nom de la Mère</label>
        <input type="text" class="form-control @error('nom_mere') is-invalid @enderror" id="nom_mere" name="nom_mere" value="{{ old('nom_mere', $etudiant->nom_mere ?? '') }}" />
        @error('nom_mere') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="prenom_mere">Prénom de la Mère</label>
        <input type="text" class="form-control @error('prenom_mere') is-invalid @enderror" id="prenom_mere" name="prenom_mere" value="{{ old('prenom_mere', $etudiant->prenom_mere ?? '') }}" />
        @error('prenom_mere') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<h5 class="mt-4 mb-3">Informations sur le Tuteur</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="nom_tuteur">Nom du Tuteur</label>
        <input type="text" class="form-control @error('nom_tuteur') is-invalid @enderror" id="nom_tuteur" name="nom_tuteur" value="{{ old('nom_tuteur', $etudiant->nom_tuteur ?? '') }}" />
        @error('nom_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="prenom_tuteur">Prénom du Tuteur</label>
        <input type="text" class="form-control @error('prenom_tuteur') is-invalid @enderror" id="prenom_tuteur" name="prenom_tuteur" value="{{ old('prenom_tuteur', $etudiant->prenom_tuteur ?? '') }}" />
        @error('prenom_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="profession_tuteur">Profession du Tuteur</label>
        <input type="text" class="form-control @error('profession_tuteur') is-invalid @enderror" id="profession_tuteur" name="profession_tuteur" value="{{ old('profession_tuteur', $etudiant->profession_tuteur ?? '') }}" />
        @error('profession_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="lien_parente_tuteur">Lien de Parenté</label>
        <input type="text" class="form-control @error('lien_parente_tuteur') is-invalid @enderror" id="lien_parente_tuteur" name="lien_parente_tuteur" value="{{ old('lien_parente_tuteur', $etudiant->lien_parente_tuteur ?? '') }}" />
        @error('lien_parente_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="adresse_tuteur">Adresse du Tuteur</label>
    <textarea class="form-control @error('adresse_tuteur') is-invalid @enderror" id="adresse_tuteur" name="adresse_tuteur">{{ old('adresse_tuteur', $etudiant->adresse_tuteur ?? '') }}</textarea>
    @error('adresse_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="telephone_tuteur">Téléphone du Tuteur</label>
        <input type="text" class="form-control @error('telephone_tuteur') is-invalid @enderror" id="telephone_tuteur" name="telephone_tuteur" value="{{ old('telephone_tuteur', $etudiant->telephone_tuteur ?? '') }}" />
        @error('telephone_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="email_tuteur">Email du Tuteur</label>
        <input type="email" class="form-control @error('email_tuteur') is-invalid @enderror" id="email_tuteur" name="email_tuteur" value="{{ old('email_tuteur', $etudiant->email_tuteur ?? '') }}" />
        @error('email_tuteur') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>

<h5 class="mt-4 mb-3">Parcours Académique Antérieur</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="dernier_etablissement">Dernier Établissement Fréquenté</label>
        <input type="text" class="form-control @error('dernier_etablissement') is-invalid @enderror" id="dernier_etablissement" name="dernier_etablissement" value="{{ old('dernier_etablissement', $etudiant->dernier_etablissement ?? '') }}" />
        @error('dernier_etablissement') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="dernier_diplome_obtenu">Dernier Diplôme Obtenu</label>
        <input type="text" class="form-control @error('dernier_diplome_obtenu') is-invalid @enderror" id="dernier_diplome_obtenu" name="dernier_diplome_obtenu" value="{{ old('dernier_diplome_obtenu', $etudiant->dernier_diplome_obtenu ?? '') }}" />
        @error('dernier_diplome_obtenu') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="serie_bac">Série du Bac</label>
        <input type="text" class="form-control @error('serie_bac') is-invalid @enderror" id="serie_bac" name="serie_bac" value="{{ old('serie_bac', $etudiant->serie_bac ?? '') }}" />
        @error('serie_bac') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="annee_obtention_bac">Année d'obtention du Bac</label>
        <input type="number" class="form-control @error('annee_obtention_bac') is-invalid @enderror" id="annee_obtention_bac" name="annee_obtention_bac" value="{{ old('annee_obtention_bac', $etudiant->annee_obtention_bac ?? '') }}" />
        @error('annee_obtention_bac') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label" for="mention_bac">Mention au Bac</label>
        <input type="text" class="form-control @error('mention_bac') is-invalid @enderror" id="mention_bac" name="mention_bac" value="{{ old('mention_bac', $etudiant->mention_bac ?? '') }}" />
        @error('mention_bac') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label" for="numero_diplome_bac">Numéro Diplôme Bac</label>
        <input type="text" class="form-control @error('numero_diplome_bac') is-invalid @enderror" id="numero_diplome_bac" name="numero_diplome_bac" value="{{ old('numero_diplome_bac', $etudiant->numero_diplome_bac ?? '') }}" />
        @error('numero_diplome_bac') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
</div>
<div class="mb-3">
    <label class="form-label" for="etablissement_origine">Établissement d'Origine</label>
    <input type="text" class="form-control @error('etablissement_origine') is-invalid @enderror" id="etablissement_origine" name="etablissement_origine" value="{{ old('etablissement_origine', $etudiant->etablissement_origine ?? '') }}" />
    @error('etablissement_origine') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<h5 class="mt-4 mb-3">Pièces Jointes</h5>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="scan_diplome_bac" class="form-label">Scan du Diplôme du Bac (PDF)</label>
        <input class="form-control @error('scan_diplome_bac') is-invalid @enderror" type="file" id="scan_diplome_bac" name="scan_diplome_bac" accept=".pdf">
        @error('scan_diplome_bac') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->scan_diplome_bac_path)
            <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->scan_diplome_bac_path) }}" target="_blank">Voir</a></small>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label for="releves_notes" class="form-label">Relevés de Notes (PDF)</label>
        <input class="form-control @error('releves_notes') is-invalid @enderror" type="file" id="releves_notes" name="releves_notes[]" accept=".pdf" multiple>
        @error('releves_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->releves_notes_path)
            <small class="text-muted">Fichier(s) actuel(s):
                @foreach(json_decode($etudiant->releves_notes_path) as $path)
                    <a href="{{ Storage::url($path) }}" target="_blank">Voir</a>
                @endforeach
            </small>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="attestation_reussite" class="form-label">Attestation de Réussite (PDF)</label>
        <input class="form-control @error('attestation_reussite') is-invalid @enderror" type="file" id="attestation_reussite" name="attestation_reussite" accept=".pdf">
        @error('attestation_reussite') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->attestation_reussite_path)
            <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->attestation_reussite_path) }}" target="_blank">Voir</a></small>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label for="piece_identite" class="form-label">Pièce d'identité (PDF)</label>
        <input class="form-control @error('piece_identite') is-invalid @enderror" type="file" id="piece_identite" name="piece_identite" accept=".pdf">
        @error('piece_identite') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->piece_identite_path)
            <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->piece_identite_path) }}" target="_blank">Voir</a></small>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label for="certificat_naissance" class="form-label">Certificat de Naissance (PDF)</label>
        <input class="form-control @error('certificat_naissance') is-invalid @enderror" type="file" id="certificat_naissance" name="certificat_naissance" accept=".pdf">
        @error('certificat_naissance') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->certificat_naissance_path)
            <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->certificat_naissance_path) }}" target="_blank">Voir</a></small>
        @endif
    </div>
    <div class="col-md-6 mb-3">
        <label for="certificat_medical" class="form-label">Certificat Médical (PDF)</label>
        <input class="form-control @error('certificat_medical') is-invalid @enderror" type="file" id="certificat_medical" name="certificat_medical" accept=".pdf">
        @error('certificat_medical') <div class="invalid-feedback">{{ $message }}</div> @enderror
        @if(isset($etudiant) && $etudiant->certificat_medical_path)
            <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->certificat_medical_path) }}" target="_blank">Voir</a></small>
        @endif
    </div>
</div>
<div class="mb-3">
    <label for="cv" class="form-label">CV (PDF)</label>
    <input class="form-control @error('cv') is-invalid @enderror" type="file" id="cv" name="cv" accept=".pdf">
    @error('cv') <div class="invalid-feedback">{{ $message }}</div> @enderror
    @if(isset($etudiant) && $etudiant->cv_path)
        <small class="text-muted">Fichier actuel: <a href="{{ Storage::url($etudiant->cv_path) }}" target="_blank">Voir</a></small>
    @endif
</div>



<button type="submit" class="btn btn-primary">{{ isset($etudiant) ? 'Mettre à jour' : 'Enregistrer' }}</button>
<a href="{{ route('personnes.etudiants.index') }}" class="btn btn-label-secondary">Annuler</a>
