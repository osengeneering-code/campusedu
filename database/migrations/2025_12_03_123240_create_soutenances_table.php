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
        Schema::create('soutenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_stage')->nullable()->unique()->constrained('stages')->cascadeOnDelete();
            $table->foreignId('id_salle')->nullable()->constrained('salles')->onDelete('set null');
            $table->dateTime('date_soutenance');
            $table->decimal('note_finale', 4, 2)->nullable();
            $table->text('commentaires_jury')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soutenances');
    }
};
