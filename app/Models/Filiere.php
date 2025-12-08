<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departement;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_departement',
        'nom',
        'description',
        'image_path',
        // 'frais_inscription', // Supprimé
        // 'frais_formation',   // Supprimé
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement');
    }

    public function parcours()
    {
        return $this->hasMany(Parcours::class, 'id_filiere');
    }

    public function candidatures()
    {
        return $this->hasMany(Candidature::class, 'id_filiere_souhaitee');
    }

    public function ues()
    {
        return $this->hasMany(Ue::class);
    }

     public function cours()
    {
        return $this->hasMany(Cours::class, 'id_filiere');
    }
}
