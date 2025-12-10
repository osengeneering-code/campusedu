<?php

namespace App\Policies;

use App\Models\Stage;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class StagePolicy
{
    /**
     * Perform pre-authorization checks.
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
        return $user->can('suivre_stages_tuteur') || $user->can('gerer_stages');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Stage $stage): bool
    {
        // L'étudiant peut voir son propre stage
        if ($user->hasRole('etudiant') && $user->etudiant && $stage->inscriptionAdmin->id_etudiant === $user->etudiant->id) {
            return true;
        }

        // Enseignant peut voir son stage tutoré
        if ($user->can('suivre_stages_tuteur') && $user->enseignant && $stage->id_enseignant_tuteur === $user->enseignant->id) {
            return true;
        }
        // Responsable stage/Admin peut voir tous les stages
        if ($user->can('gerer_stages')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('gerer_stages');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Stage $stage): bool
    {
        // Responsable stage/Admin peut modifier tous les stages
        return $user->can('gerer_stages');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Stage $stage): bool
    {
        // Responsable stage/Admin peut supprimer tous les stages
        return $user->can('gerer_stages');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Stage $stage): bool
    {
        return $user->can('gerer_stages');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Stage $stage): bool
    {
        return $user->can('gerer_stages');
    }
}