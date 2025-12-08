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
        Schema::dropIfExists('filiere_niveau_frais');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('filiere_niveau_frais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filiere_id')->constrained('filieres')->onDelete('cascade');
            $table->foreignId('niveau_id')->constrained('niveaux')->onDelete('cascade');
            $table->decimal('frais_inscription', 10, 2);
            $table->decimal('frais_formation', 10, 2);
            $table->timestamps();

            $table->unique(['filiere_id', 'niveau_id']);
        });
    }
};
