<?php

namespace App\Policies;

use App\Models\Accident;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AccidentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('voir-accidents');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Accident $accident): bool
    {
        return $user->can('voir-accidents');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('creer-accidents');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Accident $accident): bool
    {
        return $user->can('modifier-accidents');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Accident $accident): bool
    {
        return $user->can('supprimer-accidents');
    }
}
