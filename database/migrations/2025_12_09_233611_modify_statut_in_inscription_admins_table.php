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
        Schema::table('inscription_admins', function (Blueprint $table) {
            $table->enum('statut', ['Inscrit', 'Redoublant', 'Réorienté', 'Archivé', 'En attente de paiement'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscription_admins', function (Blueprint $table) {
            $table->enum('statut', ['Inscrit', 'Redoublant', 'Réorienté', 'Archivé'])->change();
        });
    }
};
