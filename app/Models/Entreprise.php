<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_entreprise',
        'secteur_activite',
        'adresse',
        'code_postal',
        'ville',
        'pays',
        'telephone',
        'email_contact',
    ];

    public function stages()
    {
        return $this->hasMany(Stage::class, 'id_entreprise');
    }
}
