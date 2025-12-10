<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Enums\UserStatusEnum;
use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', User::class);

        $query = User::with('roles', 'entreprise');

        // Appliquer les filtres
        if ($request->filled('filter_role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->filter_role);
            });
        }

        if ($request->filled('filter_statut')) {
            $query->where('statut', $request->filter_statut);
        }

        if ($request->filled('filter_entreprise')) {
            $query->where('entreprise_id', $request->filter_entreprise);
        }

        $users = $query->latest()->paginate();
        $entreprises = Entreprise::all();
        $roles = Role::all();
        $userStatuses = UserStatusEnum::cases();

        // Statistiques pour le mini dashboard
        $totalUsers = User::count();
        $activeUsers = User::where('statut', UserStatusEnum::ACTIF->value)->count();
        $blockedUsers = User::where('statut', UserStatusEnum::SUSPENDU->value)->count();

        return view('users.index', compact('users', 'entreprises', 'roles', 'userStatuses', 'totalUsers', 'activeUsers', 'blockedUsers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $entreprises = \App\Models\Entreprise::all();
        $roles = Role::all();
        $userStatuses = UserStatusEnum::cases();
        $partenaires = \App\Models\Partenaire::all(); // Added

        return view('users.create', compact('entreprises', 'roles', 'userStatuses', 'partenaires')); // Added partenaires
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'entreprise_id' => 'required|exists:entreprises,id',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'telephone' => 'required|string|max:255',
            'adresse' => 'nullable|string',
            'statut' => ['required', Rule::in(array_column(UserStatusEnum::cases(), 'value'))],
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
            'partenaire_id' => 'nullable|exists:partenaires,id', // Added
        ]);

        $user = User::create(array_merge($validated, [
            'password' => Hash::make($validated['password']),
        ]));

        $user->assignRole($validated['roles']);

        return redirect()->route('users.index')->with('toastr_success', 'Utilisateur créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->load('roles', 'entreprise', 'partenaire'); // Added partenaire
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $entreprises = Entreprise::all();
        $roles = Role::all();
        $userStatuses = UserStatusEnum::cases();
        $partenaires = \App\Models\Partenaire::all(); // Added

        return view('users.edit', compact('user', 'entreprises', 'roles', 'userStatuses', 'partenaires')); // Added partenaires
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'entreprise_id' => 'sometimes|required|exists:entreprises,id',
            'nom' => 'sometimes|required|string|max:255',
            'prenom' => 'sometimes|required|string|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'telephone' => 'sometimes|required|string|max:255',
            'adresse' => 'nullable|string',
            'statut' => ['sometimes', 'required', Rule::in(array_column(UserStatusEnum::cases(), 'value'))],
            'roles' => 'sometimes|required|array',
            'roles.*' => 'exists:roles,name',
            'profile_photo' => 'nullable|image|max:2048',
            'partenaire_id' => 'nullable|exists:partenaires,id', // Added
        ]);



        $user->update(array_merge($validated, [
            'password' => isset($validated['password']) ? Hash::make($validated['password']) : $user->password,
        ]));

        // Gérer l'upload de la photo de profil via Jetstream
        if ($request->hasFile('profile_photo')) {
            try {
                $user->updateProfilePhoto($request->file('profile_photo'));
            } catch (\Exception $e) {
                return redirect()->back()->with('toastr_warning', 'Erreur lors de l\'upload de la photo : ' . $e->getMessage());
            }

        }

        if (isset($validated['roles'])) {
            $user->syncRoles($validated['roles']);
        }

        return redirect()->route('users.show', $user->id)->with('toastr_success', 'Profil utilisateur mis à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès !');
    }

    /**
     * Toggle the status of the specified user.
     */
    public function toggleStatus(User $user)
    {
        $this->authorize('update', $user); // Assurez-vous que l'utilisateur a la permission de modifier

        $user->statut = $user->statut === UserStatusEnum::ACTIF->value ? UserStatusEnum::SUSPENDU->value : UserStatusEnum::ACTIF->value;
        $user->save();

        return redirect()->back()->with('toastr_success', 'Le statut de l\'utilisateur a été mis à jour.');
    }

    /**
     * Update the specified user's password.
     */
    public function updatePassword(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('toastr_success', 'Mot de passe mis à jour avec succès !');
    }

    public function profil()
    {
        $user = auth()->user();
        $user->load('etudiant', 'enseignant', 'roles');
        return view('profil.show', compact('user'));
    }
}
