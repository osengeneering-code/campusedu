<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_module',
        'annee_academique',
        'libelle',
        'date_evaluation',
        'evaluation_type_id',
        'created_by',
    ];

    protected $casts = [
        'date_evaluation' => 'datetime',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'id_module');
    }

    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'id_evaluation');
    }
}
