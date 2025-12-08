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
        return $user->hasRole(['enseignant', 'etudiant']); // Teachers and students can view lists
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Evaluation $evaluation): bool
    {
        if ($user->hasRole('enseignant')) {
            return $user->enseignant->modules->contains($evaluation->module_id);
        }
        if ($user->hasRole('etudiant')) {
            // Check if the student is enrolled in the module of this evaluation
            return $user->etudiant->inscriptionAdmins->where('annee_academique', $evaluation->annee_academique)
                                                     ->whereHas('parcours.semestres.ues', function($query) use ($evaluation) {
                                                         $query->where('id', $evaluation->module->ue->id);
                                                     })->isNotEmpty();
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('enseignant'); // Only teachers can create evaluations
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Evaluation $evaluation): bool
    {
        return $user->hasRole('enseignant'); // Only teachers can update their evaluations
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Evaluation $evaluation): bool
    {
        // Deletion will be handled by admin/director_general before method
        return false;
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
        if ($user->hasRole('enseignant')) {
            return $user->enseignant->modules->contains($evaluation->id_module);
        }
        return false;
    }
}
