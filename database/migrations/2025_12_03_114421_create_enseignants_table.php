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
        Schema::create('enseignants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('id_departement_rattachement')->nullable()->constrained('departements')->onDelete('set null');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email_pro')->unique();
            $table->string('telephone_pro')->nullable();
            $table->enum('statut', ['Permanent', 'Vacataire', 'Chercheur']);
            $table->string('bureau')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enseignants');
    }
};
