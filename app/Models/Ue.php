<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ue extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_semestre',
        'code_ue',
        'libelle',
        'credits_ects',
    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'id_semestre');
    }

    public function modules()
    {
        return $this->hasMany(Module::class, 'id_ue');
    }
}
