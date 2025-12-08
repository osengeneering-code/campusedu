<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Cette migration est désactivée et remplacée par des migrations individuelles.
        // Les tables seront créées par des migrations spécifiques.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Assurez-vous que toutes les tables créées par cette migration monolithique
        // sont supprimées lors du rollback, si elles ont été créées.
        Schema::dropIfExists('note');
        Schema::dropIfExists('evaluation');
        Schema::dropIfExists('cours');
        Schema::dropIfExists('inscription_pedagogique_module');
        Schema::dropIfExists('paiement');
        Schema::dropIfExists('inscription_admin');
        Schema::dropIfExists('candidature');
        Schema::dropIfExists('document_etudiant');
        Schema::dropIfExists('etudiant');
        Schema::dropIfExists('enseignant');
        Schema::dropIfExists('soutenance');
        Schema::dropIfExists('convention_stage');
        Schema::dropIfExists('stage');
        Schema::dropIfExists('entreprise');
        Schema::dropIfExists('module');
        Schema::dropIfExists('ue');
        Schema::dropIfExists('semestre');
        Schema::dropIfExists('parcours');
        Schema::dropIfExists('filiere');
        Schema::dropIfExists('departement');
        Schema::dropIfExists('faculte');
        Schema::dropIfExists('salle'); // Ajouter la table salle
    }
};