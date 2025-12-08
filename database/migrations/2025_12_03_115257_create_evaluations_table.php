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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_module')->constrained('modules')->cascadeOnDelete();
            $table->string('annee_academique');
            $table->string('libelle');
            $table->date('date_evaluation');
            $table->decimal('bareme_total', 5, 2)->default(20.00);
            $table->enum('type_evaluation', ['Contrôle Continu', 'Examen Terminal', 'Rattrapage', 'Projet']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
