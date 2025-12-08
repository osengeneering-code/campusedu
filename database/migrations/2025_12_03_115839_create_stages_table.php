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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_inscription_admin')->constrained('inscription_admins')->cascadeOnDelete();
            $table->foreignId('id_entreprise')->constrained('entreprises')->restrictOnDelete();
            $table->foreignId('id_enseignant_tuteur')->constrained('enseignants')->restrictOnDelete();
            $table->text('sujet_stage');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('nom_tuteur_entreprise')->nullable();
            $table->string('email_tuteur_entreprise')->nullable();
            $table->enum('statut_validation', ['En attente', 'Validé par tuteur', 'Validé par admin', 'Refusé'])->default('En attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
