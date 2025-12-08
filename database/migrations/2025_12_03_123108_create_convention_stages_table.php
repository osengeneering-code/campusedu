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
        Schema::create('convention_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stage')->unique()->constrained('stages')->cascadeOnDelete();
            $table->date('date_generation');
            $table->string('chemin_fichier_pdf')->nullable();
            $table->enum('statut_signature', ['Non signé', 'Signé par étudiant', 'Signé par entreprise', 'Entièrement signé'])->default('Non signé');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convention_stages');
    }
};
