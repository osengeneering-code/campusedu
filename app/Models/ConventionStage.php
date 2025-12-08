<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConventionStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_stage',
        'date_generation',
        'chemin_fichier_pdf',
        'statut_signature',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'id_stage');
    }
}
