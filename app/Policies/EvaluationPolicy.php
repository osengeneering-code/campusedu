<?php

namespace App\Policies;

use App\Models\Evaluation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EvaluationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole(['admin', 'directeur_general'])) {
            return true; // Admins and Director General can do anything
        }

        return null; // Let the policy continue to check other methods
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['enseignant', 'etudiant']) || $user->can('gerer_structure_pedagogique');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Evaluation $evaluation): bool
    {
        if ($user->can('gerer_structure_pedagogique')) { // Roles admin, responsable_etude
            return true;
        }

        if ($user->hasRole('enseignant')) {
            return $user->enseignant && $user->enseignant->modules->contains($evaluation->id_module);
        }
        
        if ($user->hasRole('etudiant')) {
            $evaluation->loadMissing('module.ue.semestre.parcours');

            if (!$evaluation->module?->ue?->semestre?->parcours) {
                return false;
            }

            $parcoursId = $evaluation->module->ue->semestre->parcours->id;

            return $user->etudiant->inscriptionAdmins
                ->where('annee_academique', $evaluation->annee_academique)
                ->where('id_parcours', $parcoursId)
                ->isNotEmpty();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('creer_evaluations') || $user->can('gerer_structure_pedagogique');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Evaluation $evaluation): bool
    {
        // Un enseignant peut modifier une évaluation s'il a la permission et s'il est affecté au module de l'évaluation
        if ($user->can('creer_evaluations') && $user->hasRole('enseignant') && $user->enseignant && $user->enseignant->modules->contains($evaluation->id_module)) {
            return true;
        }
        // Un utilisateur peut modifier une évaluation s'il en est le créateur
        if ($user->id === $evaluation->created_by) {
            return true;
        }
        // Un rôle administratif avec gerer_structure_pedagogique peut modifier
        return $user->can('gerer_structure_pedagogique');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Evaluation $evaluation): bool
    {
        return $user->can('gerer_structure_pedagogique');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Evaluation $evaluation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Evaluation $evaluation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can fill/edit grades for the evaluation.
     */
    public function fillNotes(User $user, Evaluation $evaluation): bool
    {
        return $user->can('saisir_notes');
    }
}
