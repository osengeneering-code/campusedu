<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_inscription_admin',
        'reference_paiement',
        'montant',
        'type_frais',
        'mois_concerne',
        'date_paiement',
        'methode_paiement',
        'statut_paiement',
        'facture_url',
        'recu_url',
    ];

    public function inscriptionAdmin()
    {
        return $this->belongsTo(InscriptionAdmin::class, 'id_inscription_admin');
    }
}
