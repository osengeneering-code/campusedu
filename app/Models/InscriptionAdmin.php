<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscriptionAdmin extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_etudiant',
        'id_parcours',
        'annee_academique',
        'date_inscription',
        'statut',
    ];


        public function modules()
    {
        return $this->belongsToMany(Module::class,
            'inscription_pedagogique_module',
            'id_inscription_admin',
            'id_module'
        );
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'id_etudiant');
    }

    public function parcours()
    {
        return $this->belongsTo(Parcours::class, 'id_parcours');
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'id_inscription_admin');
    }

    public function stages()
    {
        return $this->hasMany(Stage::class, 'id_inscription_admin');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'id_inscription_admin');
    }

   
}
