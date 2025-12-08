<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faculte;
use App\Models\Departement;
use App\Models\Filiere;
use App\Models\Parcours;
use App\Models\Semestre;
use App\Models\Ue;
use App\Models\Module;

class StructureAcademiqueSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer une Faculté
        $faculteSciences = Faculte::create(['nom' => 'Faculté des Sciences et Technologies']);

        // 2. Créer un Département dans cette faculté
        $depInfo = Departement::create(['id_faculte' => $faculteSciences->id, 'nom' => 'Département Informatique']);

        // 3. Créer une Filière dans ce département
        $filiereLicenceInfo = Filiere::create(['id_departement' => $depInfo->id, 'nom' => 'Licence Informatique']);

        // 4. Créer un Parcours dans cette filière
        $parcoursGIL = Parcours::create(['id_filiere' => $filiereLicenceInfo->id, 'nom' => 'Génie Logiciel']);

        // 5. Créer des Semestres pour ce parcours
        $semestreL3_S5 = Semestre::create(['id_parcours' => $parcoursGIL->id, 'niveau' => 'L3', 'libelle' => 'Semestre 5']);
        
        // 6. Créer des UE pour ce semestre
        $ueDevWeb = Ue::create(['id_semestre' => $semestreL3_S5->id, 'code_ue' => 'UE5.1', 'libelle' => 'Développement Web Avancé', 'credits_ects' => 6]);
        $ueBDD = Ue::create(['id_semestre' => $semestreL3_S5->id, 'code_ue' => 'UE5.2', 'libelle' => 'Bases de Données Avancées', 'credits_ects' => 6]);

        // 7. Créer des Modules pour ces UE
        Module::create(['id_ue' => $ueDevWeb->id, 'code_module' => 'MOD511', 'libelle' => 'Frameworks PHP', 'volume_horaire' => 50, 'coefficient' => 2]);
        Module::create(['id_ue' => $ueDevWeb->id, 'code_module' => 'MOD512', 'libelle' => 'Frameworks JavaScript', 'volume_horaire' => 50, 'coefficient' => 2]);
        Module::create(['id_ue' => $ueBDD->id, 'code_module' => 'MOD521', 'libelle' => 'SQL et Optimisation', 'volume_horaire' => 40, 'coefficient' => 2]);
    }
}
