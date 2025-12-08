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
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            // Informations personnelles
            $table->string('nom');
            $table->string('prenom');
            $table->string('nom_pere')->nullable();
            $table->string('prenom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('prenom_mere')->nullable();
            $table->date('date_naissance'); // Ajouté
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();
            $table->string('sexe')->nullable(); // Ex: 'Masculin', 'Féminin', 'Autre'
            $table->string('situation_matrimoniale')->nullable();
            $table->string('photo_identite_path')->nullable(); // Chemin vers le fichier uploadé

            // Coordonnées de l’étudiant
            $table->string('email')->unique();
            $table->string('email_secondaire')->nullable();
            $table->string('telephone');
            $table->string('telephone_secondaire')->nullable();
            $table->text('adresse_complete')->nullable();
            $table->string('ville')->nullable();
            $table->string('pays')->nullable();

            // Informations sur le tuteur / parent
            $table->string('nom_tuteur')->nullable();
            $table->string('prenom_tuteur')->nullable();
            $table->string('profession_tuteur')->nullable();
            $table->string('lien_parente_tuteur')->nullable();
            $table->text('adresse_tuteur')->nullable();
            $table->string('telephone_tuteur')->nullable();
            $table->string('email_tuteur')->nullable();

            // Niveau d’entrée / Formation souhaitée
            $table->string('annee_admission')->nullable();
            $table->string('type_niveau')->nullable(); // Ex: 'Licence 1', 'Master 2', etc.
            $table->foreignId('parcours_id')->nullable()->constrained('parcours')->onDelete('set null'); // Clé étrangère
            $table->string('specialite_souhaitee')->nullable();
            $table->string('option_souhaitee')->nullable();
            $table->string('type_inscription')->nullable(); // Ex: 'Nouveau', 'Réinscription', 'Transfert'

            // Parcours académique antérieur
            $table->string('dernier_etablissement')->nullable();
            $table->string('serie_bac')->nullable();
            $table->integer('annee_obtention_bac')->nullable();
            $table->string('mention_bac')->nullable();
            $table->string('numero_diplome_bac')->nullable();
            $table->string('scan_diplome_bac_path')->nullable(); // Chemin vers le fichier uploadé
            $table->string('dernier_diplome_obtenu')->nullable();
            $table->string('etablissement_origine')->nullable();
            $table->string('releves_notes_path')->nullable(); // Chemin vers le fichier uploadé (JSON pour multiples)
            $table->string('attestation_reussite_path')->nullable(); // Chemin vers le fichier uploadé

            // Documents à téléverser
            $table->string('piece_identite_path')->nullable();
            $table->string('certificat_naissance_path')->nullable();
            $table->string('certificat_medical_path')->nullable();
            $table->string('cv_path')->nullable();

            // Informations administratives
            $table->string('type_bourse')->nullable();
            $table->boolean('est_premiere_inscription')->default(false);
            $table->string('mode_paiement_prevu')->nullable();
            $table->boolean('declaration_engagement_acceptee')->default(false);

            // Choix des modalités de paiement
            $table->string('paiement_modalite')->nullable();
            $table->boolean('acceptation_conditions_inscription')->default(false);

            // Anciens champs qui restent
            // $table->foreignId('id_filiere_souhaitee')->constrained('filieres')->restrictOnDelete(); // Retire car remplacé par parcours_id
            $table->dateTime('date_candidature')->useCurrent();
            $table->string('statut')->default('En attente');
            $table->text('dossier_pieces_jointes')->nullable(); // A revoir si on le garde avec les chemins individuels

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatures');
    }
};