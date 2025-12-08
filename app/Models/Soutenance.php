<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_stage',
        'id_salle',
        'date_soutenance',
        'note_finale',
        'commentaires_jury',
    ];

    public function stage()
    {
        return $this->belongsTo(Stage::class, 'id_stage');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'id_salle');
    }
}
