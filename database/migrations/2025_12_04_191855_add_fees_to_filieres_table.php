<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Vide, car les frais sont maintenant gérés par une table pivot filiere_niveau_frais
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Vide
    }
};
