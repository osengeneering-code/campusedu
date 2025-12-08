<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InscriptionPedagogiqueModule extends Pivot
{
    protected $table = 'inscription_pedagogique_module';

    public $incrementing = false;

    public $timestamps = false;
}
