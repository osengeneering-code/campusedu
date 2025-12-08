<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_filiere',
        'nom',
        'description',
        'frais_inscription',
        'frais_formation',
    ];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class, 'id_parcours');
    }

    public function inscriptionAdmins()
    {
        return $this->hasMany(InscriptionAdmin::class, 'id_parcours');
    }
    
    public function cours()
    {
        return $this->hasMany(Cours::class, 'id_parcours');
    }
}
