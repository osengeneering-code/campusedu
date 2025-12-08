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
        Schema::create('cours', function (Blueprint $table) {
            $table->id();

            // Niveaux académiques
            $table->foreignId('id_filiere')->constrained('filieres')->cascadeOnDelete();
            $table->foreignId('id_parcours')->constrained('parcours')->cascadeOnDelete();
            $table->foreignId('id_semestre')->constrained('semestres')->cascadeOnDelete();

            // Module
            $table->foreignId('id_module')->constrained('modules')->cascadeOnDelete();

            // Salle
            $table->foreignId('id_salle')->constrained('salles')->restrictOnDelete();

            // Informations emploi du temps
            $table->string('annee_academique');
            $table->enum('jour', ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi']);
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->enum('type_cours', ['CM', 'TD', 'TP']);

            $table->timestamps();

            // Conflit salle
            $table->unique(
                ['id_salle', 'annee_academique', 'jour', 'heure_debut', 'heure_fin'],
                'uq_conflit_salle'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};
