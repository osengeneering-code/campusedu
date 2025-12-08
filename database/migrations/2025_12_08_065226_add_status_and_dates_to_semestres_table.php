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
        Schema::table('semestres', function (Blueprint $table) {
            // Statut du semestre : début, en cours, terminé
            $table->enum('status', ['début', 'en cours', 'terminé'])->default('début')->after('libelle');

            // Dates de début et de fin du semestre
            $table->date('date_debut')->nullable()->after('status');
            $table->date('date_fin')->nullable()->after('date_debut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semestres', function (Blueprint $table) {
            $table->dropColumn(['status', 'date_debut', 'date_fin']);
        });
    }
};
