<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Parcours;
use App\Models\User;
use App\Models\Etudiant;
use App\Models\InscriptionAdmin; // Assurez-vous d\'importer ce modèle
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\CandidatureConfirmationMail;
use App\Mail\EtudiantCredentialsMail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB; // Pour les transactions
use Illuminate\Support\Facades\Auth; // Ajouté pour Auth::check() et Auth::user()
use Illuminate\Support\Facades\Storage; // Pour gérer les uploads de fichiers

class CandidatureController extends Controller
{
    public function __construct()
    {
        // Les admins/directeurs doivent avoir 'gerer_candidatures' pour l\'index, show, edit, update, destroy
        // Les non-authentifiés peuvent create et store
        $this->middleware('can:gerer_candidatures')->except(['create', 'store']);
        // Seuls ceux qui ont la permission peuvent valider ou rejeter
        $this->middleware('can:valider_candidatures')->only(['validateCandidature', 'rejectCandidature']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidatures = Candidature::with('parcours')->paginate(10); // Charger la relation parcours
        return view('candidatures.index', compact('candidatures'));
    }

    /**
     * Show the form for creating a new resource (pre-inscription form).
     */
    public function create()
    {
        $parcours = Parcours::all();
        // Les niveaux fixes pour le select
        $niveaux = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2', 'DUT', 'BTS', 'Autre'];
        return view('candidatures.create', compact('parcours', 'niveaux'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules());

        // Gérer les uploads de fichiers
        $paths = $this->handleFileUploads($request);
        $candidature = Candidature::create(array_merge($validatedData, $paths, ['statut' => 'En attente'])); // Statut par défaut

        Mail::to($candidature->email)->send(new CandidatureConfirmationMail($candidature));

        return redirect()->route('inscriptions.candidatures.create')->with('success', 'Votre candidature a été soumise avec succès. Un e-mail de confirmation vous a été envoyé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidature $candidature)
    {
        $candidature->load('parcours'); // Charger la relation parcours pour la vue
        return view('candidatures.show', compact('candidature'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidature $candidature)
    {
        $parcours = Parcours::all();
        $niveaux = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2', 'DUT', 'BTS', 'Autre'];
        return view('candidatures.edit', compact('candidature', 'parcours', 'niveaux'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidature $candidature)
    {
        $validatedData = $request->validate($this->validationRules($candidature->id));
        $paths = $this->handleFileUploads($request, $candidature);
        $candidature->update(array_merge($validatedData, $paths));

        return redirect()->route('inscriptions.candidatures.index')->with('success', 'Candidature mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidature $candidature)
    {
        $this->deleteAssociatedFiles($candidature);
        $candidature->delete();
        return redirect()->route('inscriptions.candidatures.index')->with('success', 'Candidature supprimée avec succès.');
    }

    /**
     * Valide une candidature et crée le compte utilisateur, l\'étudiant et l\'inscription administrative.
     */
    public function validateCandidature(Request $request, Candidature $candidature)
    {
        $this->authorize('valider_candidatures'); // Vérifier la permission

        // Assurez-vous que la candidature est bien "En attente" avant de la valider
        if ($candidature->statut !== 'En attente') {
            return back()->with('error', 'Cette candidature ne peut pas être validée car son statut n\'est pas "En attente".');
        }

        // Utiliser une transaction pour s\'assurer que toutes les opérations réussissent ou échouent ensemble
        try {
            DB::beginTransaction();

            // 1. Création du compte utilisateur (users)
            $randomPassword = Str::random(10);
            $user = User::create([
                'nom' => $candidature->nom,
                'prenom' => $candidature->prenom,
                'email' => $candidature->email, // Utiliser l\'email de la candidature comme email de connexion
                'password' => Hash::make($randomPassword),
                'statut' => 'actif',
            ]);

            $role = Role::where('name', 'etudiant')->first();
            if ($role) {
                $user->assignRole($role);
            }

            // 2. Création du profil étudiant (etudiants)
            // Générer un matricule (exemple simple, peut être amélioré)
            $matricule = 'ETU' . date('Y') . str_pad($user->id, 4, '0', STR_PAD_LEFT);

            $etudiant = Etudiant::create([
                'id_user' => $user->id,
                'matricule' => $matricule,
                'nom' => $candidature->nom,
                'prenom' => $candidature->prenom,
                'date_naissance' => $candidature->date_naissance,
                'lieu_naissance' => $candidature->lieu_naissance,
                'sexe' => $candidature->sexe,
                'adresse_postale' => $candidature->adresse_complete,
                'email_perso' => $candidature->email,
                'telephone_perso' => $candidature->telephone,

                // Transfert des informations personnelles détaillées
                'nom_pere' => $candidature->nom_pere,
                'prenom_pere' => $candidature->prenom_pere,
                'nom_mere' => $candidature->nom_mere,
                'prenom_mere' => $candidature->prenom_mere,
                'ville' => $candidature->ville,
                'pays' => $candidature->pays,
                'telephone_secondaire' => $candidature->telephone_secondaire,
                'email_secondaire' => $candidature->email_secondaire,
                'nationalite' => $candidature->nationalite,
                'situation_matrimoniale' => $candidature->situation_matrimoniale,
                // Tuteur
                'nom_tuteur' => $candidature->nom_tuteur,
                'prenom_tuteur' => $candidature->prenom_tuteur,
                'profession_tuteur' => $candidature->profession_tuteur,
                'adresse_tuteur' => $candidature->adresse_tuteur,
                'telephone_tuteur' => $candidature->telephone_tuteur,
                'email_tuteur' => $candidature->email_tuteur,
                'lien_parente_tuteur' => $candidature->lien_parente_tuteur,
                // Parcours académique antérieur
                'dernier_etablissement' => $candidature->dernier_etablissement,
                'serie_bac' => $candidature->serie_bac,
                'annee_obtention_bac' => $candidature->annee_obtention_bac,
                'mention_bac' => $candidature->mention_bac,
                'numero_diplome_bac' => $candidature->numero_diplome_bac,
                'dernier_diplome_obtenu' => $candidature->dernier_diplome_obtenu,
                'etablissement_origine' => $candidature->etablissement_origine,
                'specialite_souhaitee' => $candidature->specialite_souhaitee,
                'option_souhaitee' => $candidature->option_souhaitee,
                // Liens vers les documents (transfert des chemins)
                'photo_identite_path' => $candidature->photo_identite_path,
                'scan_diplome_bac_path' => $candidature->scan_diplome_bac_path,
                'releves_notes_path' => $candidature->releves_notes_path,
                'attestation_reussite_path' => $candidature->attestation_reussite_path,
                'piece_identite_path' => $candidature->piece_identite_path,
                'certificat_naissance_path' => $candidature->certificat_naissance_path,
                'certificat_medical_path' => $candidature->certificat_medical_path,
                'cv_path' => $candidature->cv_path,

                // Assurez-vous que tous les champs requis pour Etudiant sont présents
            ]);

            // 3. Création de l\'inscription administrative (inscriptions_admin)
            $inscriptionAdmin = InscriptionAdmin::create([
                'id_etudiant' => $etudiant->id,
                'id_parcours' => $candidature->parcours_id,
                'annee_academique' => $candidature->annee_admission ?? (date('Y').'-'.(date('Y')+1)),
                'date_inscription' => now(),
                'statut' => 'En attente de paiement',
                // Transfert d\'autres informations administratives
                'type_bourse' => $candidature->type_bourse,
                'est_premiere_inscription' => $candidature->est_premiere_inscription,
                'mode_paiement_prevu' => $candidature->mode_paiement_prevu,
                'declaration_engagement_acceptee' => $candidature->declaration_engagement_acceptee,
                'paiement_modalite' => $candidature->paiement_modalite,
                'acceptation_conditions_inscription' => $candidature->acceptation_conditions_inscription,
            ]);

            // Mettre à jour le statut de la candidature
            $candidature->statut = 'Validée';
            $candidature->save();

            DB::commit();

            // Envoyer l\'e-mail avec les identifiants
            Mail::to($user->email)->send(new EtudiantCredentialsMail($user, $randomPassword));

            return redirect()->route('inscriptions.candidatures.index')->with('success', 'Candidature validée avec succès. Un compte utilisateur, un profil étudiant et une inscription administrative ont été créés.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Erreur lors de la validation de la candidature ID: {$candidature->id} - " . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de la validation de la candidature : ' . $e->getMessage());
        }
    }

    /**
     * Rejette une candidature.
     */
    public function rejectCandidature(Request $request, Candidature $candidature)
    {
        $this->authorize('valider_candidatures'); // Vérifier la permission

        if ($candidature->statut !== 'En attente') {
            return back()->with('error', 'Cette candidature ne peut pas être rejetée car son statut n\'est pas "En attente".');
        }

        $candidature->statut = 'Rejetée';
        $candidature->save();

        // Optionnel : Envoyer un e-mail à l\'étudiant pour l\'informer du rejet
        // Mail::to($candidature->email)->send(new CandidatureRejeteeMail($candidature));

        return redirect()->route('inscriptions.candidatures.index')->with('success', 'Candidature rejetée avec succès.');
    }


    /**
     * Define validation rules for candidature.
     */
    protected function validationRules(?int $candidatureId = null): array
    {
        return [
            // 1. Informations personnelles
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'nom_pere' => 'nullable|string|max:255',
            'prenom_pere' => 'nullable|string|max:255',
            'nom_mere' => 'nullable|string|max:255',
            'prenom_mere' => 'nullable|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:255',
            'sexe' => 'nullable|in:M,F,Autre',
            'situation_matrimoniale' => 'nullable|in:Célibataire,Marié(e),Divorcé(e),Veuf(ve)',
            'photo_identite' => 'nullable|image|max:2048', // max 2MB

            // 2. Coordonnées de l’étudiant
            'email' => 'required|email|max:255|unique:candidatures,email,' . ($candidatureId ?? 'NULL'),
            'email_secondaire' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:20',
            'telephone_secondaire' => 'nullable|string|max:20',
            'adresse_complete' => 'nullable|string',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',

            // 3. Informations sur le tuteur / parent
            'nom_tuteur' => 'nullable|string|max:255',
            'prenom_tuteur' => 'nullable|string|max:255',
            'profession_tuteur' => 'nullable|string|max:255',
            'lien_parente_tuteur' => 'nullable|string|max:255',
            'adresse_tuteur' => 'nullable|string',
            'telephone_tuteur' => 'nullable|string|max:20',
            'email_tuteur' => 'nullable|email|max:255',

            // 4. Niveau d’entrée / Formation souhaitée
            'annee_admission' => 'nullable|string|max:255',
            'type_niveau' => 'nullable|in:Licence 1,Licence 2,Licence 3,Master 1,Master 2,DUT,BTS,Autre',
            'parcours_id' => 'required|exists:parcours,id', // Le parcours doit exister
            'specialite_souhaitee' => 'nullable|string|max:255',
            'option_souhaitee' => 'nullable|string|max:255',
            'type_inscription' => 'nullable|in:Nouveau,Réinscription,Transfert',

            // 5. Parcours académique antérieur
            'dernier_etablissement' => 'nullable|string|max:255',
            'serie_bac' => 'nullable|string|max:255',
            'annee_obtention_bac' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'mention_bac' => 'nullable|string|max:255',
            'numero_diplome_bac' => 'nullable|string|max:255',
            'scan_diplome_bac' => 'nullable|file|mimes:pdf|max:5120', // max 5MB
            'dernier_diplome_obtenu' => 'nullable|string|max:255',
            'etablissement_origine' => 'nullable|string|max:255',
            'releves_notes' => 'nullable|array', // Pour permettre plusieurs fichiers
            'releves_notes.*' => 'file|mimes:pdf|max:5120', // Validation pour chaque fichier
            'attestation_reussite' => 'nullable|file|mimes:pdf|max:5120',

            // 6. Documents à téléverser
            'piece_identite' => 'nullable|file|mimes:pdf|max:5120',
            'certificat_naissance' => 'nullable|file|mimes:pdf|max:5120',
            'certificat_medical' => 'nullable|file|mimes:pdf|max:5120',
            'cv' => 'nullable|file|mimes:pdf|max:5120',

            // 7. Informations administratives
            'type_bourse' => 'nullable|string|max:255',
            'est_premiere_inscription' => 'boolean',
            'mode_paiement_prevu' => 'nullable|in:Mobile Money,Banque,Cash',
            'declaration_engagement_acceptee' => 'accepted', // Doit être coché
            
            // 8. Choix des modalités de paiement
            'paiement_modalite' => 'nullable|in:Total,Échelonné',
            'acceptation_conditions_inscription' => 'accepted', // Doit être coché
        ];
    }

    /**
     * Handle file uploads and return paths.
     */
    protected function handleFileUploads(Request $request, ?Candidature $candidature = null): array
    {
        $paths = [];
        $fileFields = [
            'photo_identite' => 'photo_identite_path',
            'scan_diplome_bac' => 'scan_diplome_bac_path',
            'attestation_reussite' => 'attestation_reussite_path',
            'piece_identite' => 'piece_identite_path',
            'certificat_naissance' => 'certificat_naissance_path',
            'certificat_medical' => 'certificat_medical_path',
            'cv' => 'cv_path',
        ];

        foreach ($fileFields as $requestField => $dbField) {
            if ($request->hasFile($requestField)) {
                // Supprimer l\'ancien fichier si existant
                if ($candidature && $candidature->$dbField) {
                    Storage::delete($candidature->$dbField);
                }
                $paths[$dbField] = $request->file($requestField)->store('candidatures/documents');
            } elseif ($candidature && $candidature->$dbField) {
                // Conserver l\'ancien chemin si aucun nouveau fichier n\'est uploadé et qu\'un fichier existait
                $paths[$dbField] = $candidature->$dbField;
            }
        }
        
        // Cas spécial pour releves_notes (peut être multiple)
        if ($request->hasFile('releves_notes')) {
            $uploadedPaths = [];
            foreach ($request->file('releves_notes') as $file) {
                $uploadedPaths[] = $file->store('candidatures/documents/releves');
            }
            // Supprimer les anciens fichiers si la candidature existe et a des relevés
            if ($candidature && $candidature->releves_notes_path) {
                $oldPaths = json_decode($candidature->releves_notes_path, true);
                foreach ($oldPaths as $oldPath) {
                    Storage::delete($oldPath);
                }
            }
            $paths['releves_notes_path'] = json_encode($uploadedPaths);
        } elseif ($candidature && $candidature->releves_notes_path) {
             // Conserver l\'ancien chemin si aucun nouveau fichier n\'est uploadé et qu\'un fichier existait
            $paths['releves_notes_path'] = $candidature->releves_notes_path;
        }

        return $paths;
    }

    /**
     * Delete associated files when a candidature is deleted.
     */
    protected function deleteAssociatedFiles(Candidature $candidature): void
    {
        $fileFields = [
            'photo_identite_path', 'scan_diplome_bac_path', 'releves_notes_path',
            'attestation_reussite_path', 'piece_identite_path', 'certificat_naissance_path',
            'certificat_medical_path', 'cv_path'
        ];

        foreach ($fileFields as $field) {
            if ($candidature->$field) {
                if ($field === 'releves_notes_path') {
                    $paths = json_decode($candidature->$field, true);
                    foreach ($paths as $path) {
                        Storage::delete($path);
                    }
                } else {
                    Storage::delete($candidature->$field);
                }
            }
        }
    }
}
