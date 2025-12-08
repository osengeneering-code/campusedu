<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Note extends Pivot
{
    use HasFactory;

    protected $table = 'notes'; // Changé de 'note' à 'notes'

    protected $primaryKey = ['id_evaluation', 'id_inscription_admin'];
    public $incrementing = false;
    public $timestamps = false;


    protected $fillable = [
        'id_evaluation',
        'id_inscription_admin',
        'note_obtenue',
        'appreciation',
        'est_absent',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'id_evaluation');
    }

    public function inscriptionAdmin()
    {
        return $this->belongsTo(InscriptionAdmin::class, 'id_inscription_admin');
    }
}