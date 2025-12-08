<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscription_pedagogique_module', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_module')->constrained('modules')->onDelete('cascade');
            $table->foreignId('id_inscription_admin')->constrained('inscription_admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscription_pedagogique_module');
    }
};
