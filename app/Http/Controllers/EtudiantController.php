<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDF; // Pour l'export PDF
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EtudiantController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        // Logique de filtres (à implémenter avec une query scope dans le modèle par ex.)
        $etudiants = Etudiant::with('user')->latest()->paginate(15);
        return view('personnes.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('personnes.etudiants.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email_perso' => 'required|email|unique:etudiants,email_perso',
            'date_naissance' => 'required|date',
            'sexe' => 'required|in:M,F,Autre',
            // Valider les champs pour le user
            'user_email' => 'required|email|unique:users,email',
            'user_password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->user_email,
            'password' => Hash::make($request->user_password),
            'statut' => 'actif',
        ]);
        $user->assignRole('etudiant');

        $matricule = 'ETD-' . date('Y') . strtoupper(Str::random(4));
        Etudiant::create($request->except(['user_email', 'user_password']) + [
            'id_user' => $user->id,
            'matricule' => $matricule,
        ]);

        return redirect()->route('personnes.etudiants.index')->with('success', 'Étudiant créé avec succès.');
    }

    public function show(Etudiant $etudiant)
    {
        if (auth()->user()->hasRole('etudiant') && auth()->user()->id !== $etudiant->id_user) {
            abort(403, 'Accès non autorisé.');
        }
        $etudiant->load('user', 'inscriptionAdmins.parcours.filiere', 'documents');
        return view('personnes.etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        return view('personnes.etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'nom' => 'required|string|max:100',
            'prenom' => 'required|string|max:100',
            'email_perso' => ['required', 'email', \Illuminate\Validation\Rule::unique('etudiants')->ignore($etudiant->id)],
            'date_naissance' => 'required|date',
        ]);

        $etudiant->update($request->all());

        return redirect()->route('personnes.etudiants.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        if ($etudiant->inscriptionAdmins()->exists()) {
            return back()->with('error', 'Impossible de supprimer cet étudiant, des inscriptions sont liées.');
        }
        $etudiant->user()->delete(); // Supprime le compte utilisateur associé
        $etudiant->delete();
        
        return redirect()->route('personnes.etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }

    public function exportProfil(Etudiant $etudiant)
    {
        $pdf = PDF::loadView('personnes.etudiants.profil-pdf', compact('etudiant'));
        return $pdf->download('profil-'.$etudiant->matricule.'.pdf');
    }
}

