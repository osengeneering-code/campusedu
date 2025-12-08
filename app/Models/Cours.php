<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Cours extends Model
{
    protected $fillable = [
        'id_module', 'id_salle', 'id_filiere', 'id_parcours', 'id_semestre',
        'annee_academique', 'jour', 'heure_debut', 'heure_fin', 'type_cours'
    ];

    public function module() {
        return $this->belongsTo(Module::class, 'id_module');
    }

    public function salle() {
        return $this->belongsTo(Salle::class, 'id_salle');
    }

    public function filiere() {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }

    public function parcours() {
        return $this->belongsTo(Parcours::class, 'id_parcours');
    }

    public function semestre() {
        return $this->belongsTo(Semestre::class, 'id_semestre');
    }
}
