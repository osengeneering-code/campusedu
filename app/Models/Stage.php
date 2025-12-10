<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_inscription_admin',
        'id_entreprise',
        'id_enseignant_tuteur',
        'sujet_stage',
        'date_debut',
        'date_fin',
        'nom_tuteur_entreprise',
        'email_tuteur_entreprise',
        'statut_validation',
        'rapport_path',
        'feedback',
        'statut_rapport',
    ];

    public function inscriptionAdmin()
    {
        return $this->belongsTo(InscriptionAdmin::class, 'id_inscription_admin');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise');
    }

    public function enseignant()
    {
        return $this->belongsTo(Enseignant::class, 'id_enseignant_tuteur');
    }

    public function convention()
    {
        return $this->hasOne(ConventionStage::class, 'id_stage');
    }

    public function soutenance()
    {
        return $this->hasOne(Soutenance::class, 'id_stage');
    }
}
