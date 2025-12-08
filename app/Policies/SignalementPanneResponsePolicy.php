<?php

namespace App\Policies;

use App\Models\SignalementPanneResponse;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SignalementPanneResponsePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('voir-reponses-signalement');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SignalementPanneResponse $signalementPanneResponse): bool
    {
        return $user->can('voir-reponses-signalement');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('creer-reponses-signalement');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SignalementPanneResponse $signalementPanneResponse): bool
    {
        return $user->can('modifier-reponses-signalement');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SignalementPanneResponse $signalementPanneResponse): bool
    {
        return $user->can('supprimer-reponses-signalement');
    }
}
