<?php

namespace App\Http\Controllers;

use App\Models\InscriptionAdmin;
use App\Models\Etudiant;
use App\Models\Parcours;
use App\Models\User; // Importez le modèle User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Pour hasher le mot de passe
use Illuminate\Support\Str; // Pour générer un mot de passe aléatoire
use Spatie\Permission\Models\Role; // Pour attribuer le rôle
use Illuminate\Support\Facades\Mail; // Pour l'envoi d'e-mail
use App\Mail\EtudiantCredentialsMail; // Nous allons créer ce Mailable
use Illuminate\Validation\Rule; // Pour les règles de validation

class InscriptionAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inscriptions = InscriptionAdmin::with('etudiant.user', 'parcours.filiere')->paginate(10);
        return view('inscriptions.inscription-admins.index', compact('inscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $etudiants = Etudiant::doesntHave('user')->get(); // N'affiche que les étudiants sans compte user
        $parcours = Parcours::all();
        return view('inscriptions.inscription-admins.create', compact('etudiants', 'parcours'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Règles de validation de base pour l'inscription administrative
        $rules = [
            'id_etudiant' => ['required', 'exists:etudiants,id', Rule::unique('inscription_admins')->where(function ($query) use ($request) {
                return $query->where('id_etudiant', $request->id_etudiant)
                             ->where('annee_academique', $request->annee_academique);
            })],
            'id_parcours' => 'required|exists:parcours,id',
            'annee_academique' => 'required|string|max:255',
            'date_inscription' => 'required|date',
            'statut' => 'required|string|max:255',
        ];

        // Si la checkbox est cochée, ajouter les règles pour le compte utilisateur
        if ($request->has('creer_compte_utilisateur')) {
            $rules['email_compte_user'] = 'required|string|email|max:255|unique:users,email';
        }

        $validatedData = $request->validate($rules);

        // Créer l'inscription administrative
        $inscriptionAdmin = InscriptionAdmin::create([
            'id_etudiant' => $validatedData['id_etudiant'],
            'id_parcours' => $validatedData['id_parcours'],
            'annee_academique' => $validatedData['annee_academique'],
            'date_inscription' => $validatedData['date_inscription'],
            'statut' => $validatedData['statut'],
        ]);

        // Gérer la création du compte utilisateur si la checkbox est cochée
        if ($request->has('creer_compte_utilisateur')) {
            $randomPassword = Str::random(10); // Générer un mot de passe aléatoire
            
            $user = User::create([
                'nom' => $inscriptionAdmin->etudiant->nom,
                'prenom' => $inscriptionAdmin->etudiant->prenom,
                'email' => $validatedData['email_compte_user'],
                'password' => Hash::make($randomPassword),
                'statut' => 'actif', // Par défaut
                // Autres champs User si nécessaire
            ]);

            // Attribuer le rôle 'etudiant'
            $role = Role::where('name', 'etudiant')->first();
            if ($role) {
                $user->assignRole($role);
            }

            // Lier l'étudiant à l'utilisateur
            $etudiant = Etudiant::find($validatedData['id_etudiant']);
            $etudiant->id_user = $user->id;
            $etudiant->save();

            // Envoyer l'e-mail avec les identifiants
            Mail::to($user->email)->send(new EtudiantCredentialsMail($user, $randomPassword));
        }

        return redirect()->route('inscriptions.inscription-admins.index')->with('success', 'Inscription administrative enregistrée avec succès. ' . ($request->has('creer_compte_utilisateur') ? 'Un compte utilisateur a été créé pour l\'étudiant.' : ''));
    }

    /**
     * Display the specified resource.
     */
    public function show(InscriptionAdmin $inscriptionAdmin)
    {
        $inscriptionAdmin->load('parcours'); // Charge la relation 'parcours'
        return view('inscriptions.inscription-admins.show', compact('inscriptionAdmin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InscriptionAdmin $inscriptionAdmin)
    {
        $etudiants = Etudiant::all(); // Ou filtrer ceux qui n'ont pas encore de compte si on veut leur en créer un
        $parcours = Parcours::all();
        return view('inscriptions.inscription-admins.edit', compact('inscriptionAdmin', 'etudiants', 'parcours'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InscriptionAdmin $inscriptionAdmin)
    {
        // Règles de validation de base pour l'inscription administrative
        $rules = [
            'id_etudiant' => ['required', 'exists:etudiants,id', Rule::unique('inscription_admins')->ignore($inscriptionAdmin->id)->where(function ($query) use ($request) {
                return $query->where('id_etudiant', $request->id_etudiant)
                             ->where('annee_academique', $request->annee_academique);
            })],
            'id_parcours' => 'required|exists:parcours,id',
            'annee_academique' => 'required|string|max:255',
            'date_inscription' => 'required|date',
            'statut' => 'required|string|max:255',
        ];

        // Pour la mise à jour, si l'étudiant n'a pas encore de compte et que la checkbox est cochée
        if ($request->has('creer_compte_utilisateur') && !($inscriptionAdmin->etudiant->user ?? false)) {
            $rules['email_compte_user'] = 'required|string|email|max:255|unique:users,email';
        }

        $validatedData = $request->validate($rules);

        $inscriptionAdmin->update([
            'id_etudiant' => $validatedData['id_etudiant'],
            'id_parcours' => $validatedData['id_parcours'],
            'annee_academique' => $validatedData['annee_academique'],
            'date_inscription' => $validatedData['date_inscription'],
            'statut' => $validatedData['statut'],
        ]);

        // Gérer la création du compte utilisateur en mode update si la checkbox est cochée et que l'étudiant n'a pas de compte
        if ($request->has('creer_compte_utilisateur') && !($inscriptionAdmin->etudiant->user ?? false)) {
            $randomPassword = Str::random(10);
            
            $user = User::create([
                'nom' => $inscriptionAdmin->etudiant->nom,
                'prenom' => $inscriptionAdmin->etudiant->prenom,
                'email' => $validatedData['email_compte_user'],
                'password' => Hash::make($randomPassword),
                'statut' => 'actif',
            ]);

            $role = Role::where('name', 'etudiant')->first();
            if ($role) {
                $user->assignRole($role);
            }

            $etudiant = Etudiant::find($validatedData['id_etudiant']);
            $etudiant->id_user = $user->id;
            $etudiant->save();

            Mail::to($user->email)->send(new EtudiantCredentialsMail($user, $randomPassword));
        }


        return redirect()->route('inscriptions.inscription-admins.index')->with('success', 'Inscription administrative mise à jour avec succès. ' . ($request->has('creer_compte_utilisateur') && !($inscriptionAdmin->etudiant->user ?? false) ? 'Un compte utilisateur a été créé pour l\'étudiant.' : ''));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InscriptionAdmin $inscriptionAdmin)
    {
        $inscriptionAdmin->delete();
        return redirect()->route('inscriptions.inscription-admins.index')->with('success', 'Inscription administrative supprimée avec succès.');
    }
}