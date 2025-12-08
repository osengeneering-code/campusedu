<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_departement_rattachement',
        'nom',
        'prenom',
        'email_pro',
        'telephone_pro',
        'statut',
        'bureau',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement_rattachement');
    }

    // public function cours()
    // {
    //     return $this->hasMany(Cours::class, 'id_enseignant');
    // }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'id_enseignant_tuteur');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'enseignant_module', 'enseignant_id', 'module_id');
    }
}
