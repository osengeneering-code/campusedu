<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;

    protected $table = 'niveaux'; // Nom de la table

    protected $fillable = [
        'nom',
        'description',
    ];

    // Relations (si un niveau peut avoir plusieurs filières par exemple, ou une filière par niveau)
}