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
        Schema::create('inscription_admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_etudiant')->constrained('etudiants')->cascadeOnDelete();
            $table->foreignId('id_parcours')->constrained('parcours')->restrictOnDelete();
            $table->string('annee_academique');
            $table->date('date_inscription');
            $table->enum('statut', ['Inscrit', 'Redoublant', 'Réorienté', 'Archivé']);
            $table->timestamps();
            $table->unique(['id_etudiant', 'annee_academique']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscription_admins');
    }
};
