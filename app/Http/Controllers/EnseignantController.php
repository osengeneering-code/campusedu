<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Departement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EnseignantController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $enseignants = Enseignant::with('departement', 'user')->latest()->paginate(10);
        return view('personnes.enseignants.index', compact('enseignants'));
    }

    public function create()
    {
        $departements = Departement::orderBy('nom')->get();
        $usersSansEnseignant = User::doesntHave('enseignant')->get(); 
        return view('personnes.enseignants.create', compact('departements', 'usersSansEnseignant'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email_pro' => 'required|email|unique:enseignants,email_pro',
            'telephone_pro' => 'nullable|string|max:20',
            'statut' => ['required', Rule::in(['Permanent', 'Vacataire', 'Chercheur'])],
            'bureau' => 'nullable|string|max:50',
            'id_departement_rattachement' => 'nullable|exists:departements,id',
            'id_user' => 'nullable|exists:users,id|unique:enseignants,id_user',
            'user_email' => 'required_without:id_user|email|unique:users,email',
            'user_password' => 'required_without:id_user|string|min:8',
        ]);

        if ($request->filled('id_user')) {
            $user = User::find($request->id_user);
        } else {
            $user = User::create([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'email' => $request->user_email,
                'password' => Hash::make($request->user_password),
                'statut' => 'actif',
            ]);
            $user->assignRole('enseignant');
        }

        Enseignant::create($request->except(['user_email', 'user_password']) + ['id_user' => $user->id]);

        return redirect()->route('personnes.enseignants.index')->with('success', 'Enseignant créé avec succès.');
    }

    public function show(Enseignant $enseignant)
    {
        if (auth()->user()->hasRole('enseignant') && auth()->user()->id !== $enseignant->id_user) {
            abort(403, 'Accès non autorisé.');
        }
        $enseignant->load('departement', 'user', 'cours.module', 'stages.inscriptionAdmin.etudiant');
        return view('personnes.enseignants.show', compact('enseignant'));
    }

    public function edit(Enseignant $enseignant)
    {
        $departements = Departement::orderBy('nom')->get();
        $usersSansEnseignant = User::doesntHave('enseignant')->orWhere('id', $enseignant->id_user)->get();
        return view('personnes.enseignants.edit', compact('enseignant', 'departements', 'usersSansEnseignant'));
    }

    public function update(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email_pro' => ['required', 'email', Rule::unique('enseignants', 'email_pro')->ignore($enseignant->id)],
            'telephone_pro' => 'nullable|string|max:20',
            'statut' => ['required', Rule::in(['Permanent', 'Vacataire', 'Chercheur'])],
            'bureau' => 'nullable|string|max:50',
            'id_departement_rattachement' => 'nullable|exists:departements,id',
            'id_user' => ['nullable', 'exists:users,id', Rule::unique('enseignants', 'id_user')->ignore($enseignant->id)],
        ]);
        
        if ($enseignant->user && $request->filled('id_user') && $enseignant->user->id == $request->id_user) {
            $enseignant->user->update([
                'nom' => $request->nom,
                'prenom' => $request->prenom,
            ]);
        }

        $enseignant->update($request->all());

        return redirect()->route('personnes.enseignants.index')->with('success', 'Enseignant mis à jour avec succès.');
    }

    public function destroy(Enseignant $enseignant)
    {
        if ($enseignant->cours()->exists() || $enseignant->stages()->exists()) {
            return back()->with('error', 'Impossible de supprimer cet enseignant, des cours ou stages y sont rattachés.');
        }
        
        $enseignant->delete();
        return redirect()->route('personnes.enseignants.index')->with('success', 'Enseignant supprimé avec succès.');
    }
}

