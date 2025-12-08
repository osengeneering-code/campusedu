<?php

namespace App\Policies;

use App\Models\Partenaire;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PartenairePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('voir-partenaires');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Partenaire $partenaire): bool
    {
        return $user->can('voir-partenaires');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('creer-partenaires');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Partenaire $partenaire): bool
    {
        return $user->can('modifier-partenaires');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Partenaire $partenaire): bool
    {
        return $user->can('supprimer-partenaires');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Partenaire $partenaire): bool
    {
        return $user->can('gerer-partenaires'); // Assuming 'gerer-partenaires' includes restore
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Partenaire $partenaire): bool
    {
        return $user->can('gerer-partenaires'); // Assuming 'gerer-partenaires' includes force delete
    }
}