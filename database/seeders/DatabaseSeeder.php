<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomRole;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Faculte;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Parcours;
use App\Models\Semestre;
use App\Models\Ue;
use App\Models\Module;
use App\Models\Enseignant;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === LOGIQUE DE ROLESANDPERMISSIONSSEEDER ===
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer toutes les permissions
        $permissions = [
            'gerer_structure_pedagogique', 'gerer_enseignants', 'lister_etudiants',
            'creer_etudiant', 'modifier_etudiant', 'supprimer_etudiant',
            'consulter_dossier_etudiant', 'gerer_candidatures', 'gerer_inscriptions',
            'saisir_notes', 'creer_evaluations', 'modifier_toutes_les_notes', 'consulter_ses_notes',
            'gerer_stages', 'suivre_stages_tuteur', 'gerer_son_stage',
            'gerer_emplois_du_temps', 'consulter_son_emploi_du_temps',
            'gerer_paiements', 'consulter_ses_paiements', 'voir_roles',
            'consulter_stats_generales', 'gerer_parametre_generaux',
            'gerer_roles_permissions', 'consulter_journal_activites',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Créer les rôles et assigner les permissions
        $etudiantRole = Role::firstOrCreate(['name' => 'etudiant', 'guard_name' => 'web']);
        $etudiantRole->givePermissionTo([
            'consulter_dossier_etudiant', 'consulter_ses_notes', 'gerer_son_stage',
            'consulter_son_emploi_du_temps', 'consulter_ses_paiements',
        ]);

        $enseignantRole = Role::firstOrCreate(['name' => 'enseignant', 'guard_name' => 'web']);
        $enseignantRole->givePermissionTo([
            'consulter_dossier_etudiant', // Pour les étudiants de ses cours
            'saisir_notes',
            'creer_evaluations',
            'suivre_stages_tuteur',
            'consulter_son_emploi_du_temps',
        ]);


        $responsableStageRole = Role::firstOrCreate(['name' => 'responsable_stage', 'guard_name' => 'web']);
        $responsableStageRole->givePermissionTo([
            'gerer_stages',
            'lister_etudiants',
            'consulter_dossier_etudiant',
            'consulter_son_emploi_du_temps',
        ]);
        
        $responsableEtudeRole = Role::firstOrCreate(['name' => 'responsable_etude', 'guard_name' => 'web']);
        $responsableEtudeRole->givePermissionTo([
            'gerer_structure_pedagogique', 'gerer_enseignants', 'lister_etudiants',
            'consulter_dossier_etudiant', 'modifier_etudiant',
            'gerer_candidatures', 'gerer_inscriptions',
            'modifier_toutes_les_notes', 'gerer_emplois_du_temps', 'voir_roles',
            'consulter_son_emploi_du_temps',
        ]);

        $comptableRole = Role::firstOrCreate(['name' => 'comptable', 'guard_name' => 'web']);
        $comptableRole->givePermissionTo([
            'gerer_paiements',
            'lister_etudiants',
            'consulter_dossier_etudiant',
        ]);

        $directeurGeneralRole = Role::firstOrCreate(['name' => 'directeur_general', 'guard_name' => 'web']);
        $directeurGeneralRole->givePermissionTo(Permission::all());

        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        // --- CRÉATION D'UTILISATEURS DE TEST ---
        $adminUser = User::firstOrCreate(['email' => 'admin@edustage.com'], ['nom' => 'Admin', 'prenom' => 'Super', 'password' => Hash::make('password'), 'statut' => 'actif', 'telephone' => '0123456789']);
        $adminUser->assignRole($adminRole);
        
        $etudiantUser = User::firstOrCreate(['email' => 'etudiant@edustage.com'], ['nom' => 'Dupont', 'prenom' => 'Jean', 'password' => Hash::make('password'), 'statut' => 'actif', 'telephone' => '0123456780']);
        $etudiantUser->assignRole($etudiantRole);
        // ... (autres utilisateurs)

        // === LOGIQUE DE STRUCTUREACADEMIQUESEEDER ===
        $faculteSciences = Faculte::firstOrCreate(['nom' => 'Faculté des Sciences et Technologies']);
        $faculteLettres = Faculte::firstOrCreate(['nom' => 'Faculté des Lettres et Sciences Humaines']);
        $faculteDroit = Faculte::firstOrCreate(['nom' => 'Faculté de Droit']);

        $departements = [
            Departement::firstOrCreate(['nom' => 'Département Informatique', 'id_faculte' => $faculteSciences->id]),
            Departement::firstOrCreate(['nom' => 'Département Mathématiques', 'id_faculte' => $faculteSciences->id]),
            Departement::firstOrCreate(['nom' => 'Département Physique', 'id_faculte' => $faculteSciences->id]),
        ];

        $filiereLicenceInfo = Filiere::firstOrCreate(['nom' => 'Licence Informatique'], ['id_departement' => $departements[0]->id]);
        
        $parcoursGIL = Parcours::firstOrCreate(['nom' => 'Génie Logiciel'], ['id_filiere' => $filiereLicenceInfo->id]);
        
        $semestreL3_S5 = Semestre::firstOrCreate(['libelle' => 'Semestre 5', 'niveau' => 'L3', 'id_parcours' => $parcoursGIL->id]);
        
        $ueDevWeb = Ue::firstOrCreate(['code_ue' => 'UE5.1'], ['id_semestre' => $semestreL3_S5->id, 'libelle' => 'Développement Web Avancé', 'credits_ects' => 6]);
        
        Module::firstOrCreate(['code_module' => 'MOD511'], ['id_ue' => $ueDevWeb->id, 'libelle' => 'Frameworks PHP', 'volume_horaire' => 50, 'coefficient' => 2]);
        
        $enseignantsData = [
            ['nom' => 'Ndong', 'prenom' => 'Marc', 'email_pro' => 'marc.ndong@univ.ga', 'telephone_pro' => '062000001', 'statut' => 'Permanent', 'bureau' => 'B101'],
            // ... (autres enseignants)
        ];
        
        foreach ($enseignantsData as $key => $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email_pro']],
                ['nom' => $data['nom'], 'prenom' => $data['prenom'], 'password' => Hash::make('password'), 'statut' => 'actif', 'telephone' => $data['telephone_pro']]
            );
            $user->assignRole($enseignantRole);

            $departement = $departements[$key % count($departements)];

            Enseignant::firstOrCreate(
                ['email_pro' => $data['email_pro']],
                $data + ['id_user' => $user->id, 'id_departement_rattachement' => $departement->id]
            );
        }
    }
}