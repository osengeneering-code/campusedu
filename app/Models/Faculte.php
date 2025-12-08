<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculte extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];

    public function departements()
    {
        return $this->hasMany(Departement::class, 'id_faculte');
    }
}
