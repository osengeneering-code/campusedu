<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_parcours',
        'niveau',
        'libelle',
    ];

    public function parcours()
    {
        return $this->belongsTo(Parcours::class, 'id_parcours');
    }

    public function ues()
    {
        return $this->hasMany(Ue::class, 'id_semestre');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'id_semestre');
    }
}
