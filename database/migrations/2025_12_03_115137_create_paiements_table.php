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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_inscription_admin')->constrained('inscription_admins')->cascadeOnDelete();
            $table->string('reference_paiement')->unique();
            $table->decimal('montant', 10, 2);
            $table->enum('type_frais', ['Inscription', 'Scolarité', 'Autre']);
            $table->dateTime('date_paiement');
            $table->enum('methode_paiement', ['Carte bancaire', 'Virement', 'Chèque', 'Espèces']);
            $table->enum('statut_paiement', ['Payé', 'En attente', 'Annulé', 'Impayé']);
            $table->string('facture_url')->nullable();
            $table->string('recu_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiements');
    }
};
