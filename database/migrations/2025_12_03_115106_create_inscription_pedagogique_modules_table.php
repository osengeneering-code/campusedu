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
        Schema::create('inscription_pedagogique_modules', function (Blueprint $table) {
            $table->foreignId('id_inscription_admin')->constrained('inscription_admins')->cascadeOnDelete();
            $table->foreignId('id_module')->constrained('modules')->cascadeOnDelete();
            $table->primary(['id_inscription_admin', 'id_module']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscription_pedagogique_modules');
    }
};
