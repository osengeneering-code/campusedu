<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_salle',
        'capacite',
        'type_salle',
    ];

    public function cours()
    {
        return $this->hasMany(Cours::class, 'id_salle');
    }

    public function soutenances()
    {
        return $this->hasMany(Soutenance::class, 'id_salle');
    }
}
