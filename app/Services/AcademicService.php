<?php

namespace App\Services;

use App\Models\Module;
use App\Models\InscriptionAdmin;
use App\Models\Evaluation;

class AcademicService
{
    /**
     * Récupère les étudiants inscrits à un parcours pour une année académique donnée,
     * en se basant sur le module de l'évaluation.
     *
     * @param Evaluation $evaluation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getEnrolledStudentsForEvaluation(Evaluation $evaluation)
    {
        $evaluation->loadMissing('module.ue.semestre.parcours');

        if (!$evaluation->module?->ue?->semestre?->parcours) {
            return collect(); // Retourne une collection vide si la structure est incomplète
        }

        $parcoursId = $evaluation->module->ue->semestre->parcours->id;

        return InscriptionAdmin::where('annee_academique', $evaluation->annee_academique)
            ->where('id_parcours', $parcoursId)
            ->with('etudiant')
            ->get();
    }
}
