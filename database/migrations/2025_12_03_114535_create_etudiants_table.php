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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            // id_user maintenant unique, non nullable, et cascade on delete
            $table->foreignId('id_user')->unique()->constrained('users')->onDelete('cascade');
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->enum('sexe', ['M', 'F', 'Autre']);
            $table->text('adresse_postale')->nullable();
            $table->string('email_perso')->unique();
            $table->string('telephone_perso')->nullable();


            $table->string('nom_pere')->nullable();
            $table->string('prenom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->string('prenom_mere')->nullable();
            $table->date('date_naissance'); // Ajouté
            $table->string('lieu_naissance')->nullable();
            $table->string('nationalite')->nullable();
             $table->string('situation_matrimoniale')->nullable();
           
            // Coordonnées de l’étudiant
            $table->string('email_secondaire')->nullable();
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
            $table->string('photo_identite_path')->nullable();
            $table->string('lettre_motivation_path')->nullable();
          
            // Anciens champs qui restent
            $table->text('dossier_pieces_jointes')->nullable(); // A revoir si on le garde avec les chemins individuels

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};