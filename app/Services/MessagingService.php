<?php

namespace App\Services;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class MessagingService
{
    /**
     * Finds or creates a private conversation between two users.
     *
     * @param User $userA
     * @param User $userB
     * @return Conversation
     */
    public function getOrCreatePrivateConversation(User $userA, User $userB): Conversation
    {
        // Look for an existing private conversation with exactly these two users.
        $conversation = $userA->conversations()
            ->where('type', 'private')
            ->whereHas('users', function ($query) use ($userB) {
                $query->where('user_id', $userB->id);
            }, '=', 1)
            ->whereDoesntHave('users', function ($query) use ($userA, $userB) {
                $query->whereNotIn('user_id', [$userA->id, $userB->id]);
            })
            ->first();

        if ($conversation) {
            return $conversation;
        }

        // If no conversation exists, create a new one.
        return DB::transaction(function () use ($userA, $userB) {
            $conversation = Conversation::create([
                'type' => 'private',
                'name' => null // Name can be generated dynamically on the frontend if needed
            ]);

            $conversation->users()->attach([$userA->id, $userB->id]);

            return $conversation;
        });
    }

    /**
     * Creates a new group conversation.
     *
     * @param User $creator
     * @param array $userIds
     * @param string $groupName
     * @return Conversation
     */
    public function createGroupConversation(User $creator, array $userIds, string $groupName): Conversation
    {
        return DB::transaction(function () use ($creator, $userIds, $groupName) {
            $conversation = Conversation::create([
                'type' => 'group',
                'name' => $groupName
            ]);

            // Ensure the creator is also in the group
            $allUserIds = collect($userIds)->push($creator->id)->unique()->all();

            $conversation->participants()->attach($allUserIds);

            return $conversation;
        });
    }

    /**
     * Get a list of users the given user is allowed to communicate with.
     *
     * @param User $user
     * @return Collection
     */
    public function getPotentialRecipients(User $user): Collection
    {
        $recipients = new Collection();

        // All users can contact 'Responsable des Études'
        $responsableEtudesRole = Role::where('name', 'Responsable des Études')->first();
        if ($responsableEtudesRole) {
            $recipients = $recipients->merge($responsableEtudesRole->users);
        }

        // --- Student's permissions ---
        if ($user->hasRole('etudiant') && $user->etudiant) {
            // Get modules student is enrolled in...
            // This is a complex query and depends on the final data structure.
            // Assuming an etudiant has a direct or indirect relationship to their modules.
            // For now, let's assume we can get the teachers from the student's filiere's modules.
            $filiere = $user->etudiant->inscriptionAdmins()->latest()->first()->parcours->filiere ?? null;
            if ($filiere) {
                // Get teachers of modules in that filiere
                // This is still a simplification
                $enseignants = User::whereHas('enseignant.modules.ue.semestre.parcours.filiere', function ($query) use ($filiere) {
                    $query->where('id', $filiere->id);
                })->get();
                $recipients = $recipients->merge($enseignants);
            }
        }

        // --- Teacher's permissions ---
        if ($user->hasRole('enseignant') && $user->enseignant) {
            // Get students from the teacher's modules
            $modules = $user->enseignant->modules;
            foreach ($modules as $module) {
                // Again, this is a complex relationship.
                // We're finding users who are students and are enrolled in this module's parcours.
                $parcours = $module->ue->semestre->parcours;
                $etudiants = User::whereHas('etudiant.inscriptionAdmins', function ($query) use ($parcours) {
                    $query->where('id_parcours', $parcours->id);
                })->get();
                $recipients = $recipients->merge($etudiants);
            }
        }
        
        // --- Admin permissions ---
        if ($user->hasRole('admin')) {
             // Admins can talk to anyone
            $recipients = $recipients->merge(User::all());
        }


        // Return a unique, sorted list, excluding the user themselves.
        return $recipients->unique('id')->where('id', '!=', $user->id)->sortBy('name');
    }
}
