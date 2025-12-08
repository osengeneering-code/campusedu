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
        Schema::create('semestres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_parcours')->constrained('parcours')->cascadeOnDelete();
            $table->enum('niveau', ['L1', 'L2', 'L3', 'M1', 'M2']);
            $table->string('libelle');
            $table->timestamps();
            $table->unique(['id_parcours', 'niveau', 'libelle']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};
