<?php

namespace App\Policies;

use App\Models\SignalementPanne;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SignalementPannePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('voir-signalement-pannes');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SignalementPanne $signalementPanne): bool
    {
        return $user->can('voir-signalement-pannes');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('creer-signalement-pannes');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SignalementPanne $signalementPanne): bool
    {
        return $user->can('modifier-signalement-pannes');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SignalementPanne $signalementPanne): bool
    {
        return $user->can('supprimer-signalement-pannes');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SignalementPanne $signalementPanne): bool
    {
        return $user->can('gerer-signalement-pannes');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SignalementPanne $signalementPanne): bool
    {
        return $user->can('gerer-signalement-pannes');
    }
}