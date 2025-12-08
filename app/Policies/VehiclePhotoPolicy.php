<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VehiclePhoto;

class VehiclePhotoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('voir-vehicules');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, VehiclePhoto $vehiclePhoto): bool
    {
        return $user->can('voir-vehicules');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('modifier-vehicules');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, VehiclePhoto $vehiclePhoto): bool
    {
        return $user->can('modifier-vehicules');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, VehiclePhoto $vehiclePhoto): bool
    {
        return $user->can('modifier-vehicules');
    }
}
