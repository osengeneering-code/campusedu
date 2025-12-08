<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        $this->logActivity('création', $model);
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        $this->logActivity('modification', $model);
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->logActivity('suppression', $model);
    }

    /**
     * Log the activity.
     */
    protected function logActivity(string $action, Model $model): void
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $ipAddress = Request::ip();
            // $entrepriseId = $model->entreprise_id ?? (Auth::user()->entreprise_id ?? null); // Supprimé

            ActivityLog::create([
                // 'entreprise_id' => $entrepriseId, // Supprimé
                'user_id' => $userId,
                'action' => $action,
                'table_cible' => $model->getTable(),
                'element_id' => $model->id,
                'description' => $this->getDescription($action, $model),
                'ip_address' => $ipAddress,
            ]);
        }
    }

    /**
     * Get the description for the activity log.
     */
    protected function getDescription(string $action, Model $model): string
    {
        $description = "{$action} de {$model->getTable()} (ID: {$model->id})";

        if ($action === 'modification') {
            $changes = $model->getChanges();
            $original = $model->getOriginal(); // Get original attributes
            unset($changes['updated_at']); // Ignore updated_at changes

            if (!empty($changes)) {
                $formattedChanges = [];
                foreach ($changes as $attribute => $newValue) {
                    $oldValue = $original[$attribute] ?? 'N/A';

                    if (is_object($newValue) && method_exists($newValue, 'getValue')) {
                        $newValue = $newValue->getValue();
                    } elseif (is_object($newValue) && isset($newValue->value)) {
                        $newValue = $newValue->value;
                    }

                    if (is_object($oldValue) && method_exists($oldValue, 'getValue')) {
                        $oldValue = $oldValue->getValue();
                    } elseif (is_object($oldValue) && isset($oldValue->value)) {
                        $oldValue = $oldValue->value;
                    }

                    $formattedChanges[] = "{$attribute}: '{$oldValue}' -> '{$newValue}'";
                }
                $description .= " (Changements: " . implode(', ', $formattedChanges) . ")";
            }
        } elseif ($action === 'création') {
            // Optionally add some details for creation
            $description .= " (Nom: " . ($model->name ?? $model->nom ?? $model->title ?? $model->id) . ")";
        } elseif ($action === 'suppression') {
            // Optionally add some details for deletion
            $description .= " (Nom: " . ($model->name ?? $model->nom ?? $model->title ?? $model->id) . ")";
        }

        return $description;
    }
}
