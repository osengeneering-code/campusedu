<?php

namespace App\Policies;

use App\Models\MaintenanceRecord;
use App\Models\User;

class MaintenanceRecordPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('voir-maintenance');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceRecord $maintenanceRecord): bool
    {
        return $user->can('voir-maintenance');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('creer-maintenance');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MaintenanceRecord $maintenanceRecord): bool
    {
        return $user->can('modifier-maintenance');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceRecord $maintenanceRecord): bool
    {
        return $user->can('supprimer-maintenance');
    }
}
