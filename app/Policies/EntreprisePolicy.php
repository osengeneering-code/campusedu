<?php

namespace App\Policies;

use App\Models\Entreprise;
use App\Models\User;

class EntreprisePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('gerer-parametres');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Entreprise $entreprise): bool
    {
        return $user->can('gerer-parametres');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('gerer-parametres');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Entreprise $entreprise): bool
    {
        return $user->can('gerer-parametres');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Entreprise $entreprise): bool
    {
        return $user->can('gerer-parametres');
    }
}
