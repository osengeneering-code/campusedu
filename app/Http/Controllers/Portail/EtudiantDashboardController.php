<?php

namespace App\Http\Controllers\Portail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Cours;

class EtudiantDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $etudiant = $user->etudiant; 

        if (!$etudiant) {
            abort(404, "Profil étudiant non trouvé.");
        }
        
        // Charger les relations nécessaires pour la vue
        $etudiant->load([
            'inscriptionAdmins.parcours.filiere',
            'inscriptionAdmins.paiements',
            'inscriptionAdmins.notes.evaluation.evaluationType',
            'inscriptionAdmins.notes.evaluation.module.ue.semestre.parcours.filiere',
            'inscriptionAdmins.stages.entreprise',
            'documents'
        ]);

        $anneeAcademique = date('Y').'-'.(date('Y')+1); // Année académique actuelle
        $inscriptionAdmin = $etudiant->inscriptionAdmins->where('annee_academique', $anneeAcademique)->first();

        $edt = collect();
        $moyennesModules = collect(); // Nouvelle collection pour les moyennes par module

        if ($inscriptionAdmin) {
            // Récupérer l'emploi du temps
            $modulesIds = $inscriptionAdmin->modules->pluck('id');
            $edt = Cours::whereIn('id_module', $modulesIds)
                         ->where('annee_academique', $inscriptionAdmin->annee_academique)
                         ->with('module.enseignants', 'salle')
                         ->get()
                         ->groupBy('jour');

            // Calculer la moyenne pour chaque module de l'étudiant
            foreach ($inscriptionAdmin->modules as $module) {
                // S'assurer que le module a la relation ue.semestre.parcours chargée pour la méthode getMoyenneModule
                $module->loadMissing('ue.semestre.parcours'); 
                $moyenne = $etudiant->getMoyenneModule($module, $anneeAcademique);
                $moyennesModules->put($module->id, $moyenne);
            }
        }

        return view('portails.etudiant.dashboard', compact('etudiant', 'edt', 'moyennesModules'));
    }
}
