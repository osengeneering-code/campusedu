<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidature extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_naissance',
        'adresse',

        'nom_pere',
        'prenom_pere',
        'nom_mere',
        'prenom_mere',
        'lieu_naissance',
        'nationalite',
        'sexe',
        'situation_matrimoniale',
        'photo_identite_path',

        'adresse_complete',
        'ville',
        'pays',
        'telephone_secondaire',
        'email_secondaire',

        'nom_tuteur',
        'prenom_tuteur',
        'profession_tuteur',
        'adresse_tuteur',
        'telephone_tuteur',
        'email_tuteur',
        'lien_parente_tuteur',

        'annee_admission',
        'type_niveau',
        'parcours_id',
        'specialite_souhaitee',
        'option_souhaitee',
        'type_inscription',

        'dernier_etablissement',
        'serie_bac',
        'annee_obtention_bac',
        'mention_bac',
        'numero_diplome_bac',
        'scan_diplome_bac_path',
        'dernier_diplome_obtenu',
        'etablissement_origine',
        'releves_notes_path',
        'attestation_reussite_path',

        'piece_identite_path',
        'certificat_naissance_path',
        'certificat_medical_path',
        'cv_path',

        'type_bourse',
        'est_premiere_inscription',
        'mode_paiement_prevu',
        'declaration_engagement_acceptee',

        'paiement_modalite',
        'acceptation_conditions_inscription',

        'statut',
        'dossier_pieces_jointes',
    ];

    public const STATUT_EN_ATTENTE = 'En attente';
    public const STATUT_VALIDEE = 'Validée';
    public const STATUT_REJETEE = 'Rejetée';
    public const STATUT_LISTE_ATTENTE = 'Liste d\'attente';

    public function parcours()
    {
        return $this->belongsTo(Parcours::class);
    }
}