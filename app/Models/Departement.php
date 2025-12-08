<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_faculte',
        'nom',
        'description',
    ];

    public function faculte()
    {
        return $this->belongsTo(Faculte::class, 'id_faculte');
    }
 

    public function filieres()
    {
        return $this->hasMany(Filiere::class, 'id_departement');
    }

    public function enseignants()
    {
        return $this->hasMany(Enseignant::class, 'id_departement_rattachement');
    }
}
