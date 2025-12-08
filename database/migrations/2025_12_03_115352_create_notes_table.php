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
        Schema::create('notes', function (Blueprint $table) {
            $table->foreignId('id_evaluation')->constrained('evaluations')->cascadeOnDelete();
            $table->foreignId('id_inscription_admin')->constrained('inscription_admins')->cascadeOnDelete();
            $table->decimal('note_obtenue', 5, 2)->nullable();
            $table->text('appreciation')->nullable();
            $table->boolean('est_absent')->default(false);
            $table->primary(['id_evaluation', 'id_inscription_admin']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
