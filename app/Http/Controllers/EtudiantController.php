<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\User;
use App\Models\Paiement;
use App\Models\Candidature;
use App\Models\InscriptionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PDF;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage; // Ajouté pour les fichiers
use Illuminate\Support\Facades\Mail; // Ajouté pour l'email
use App\Mail\EtudiantCredentialsMail; // Ajouté pour l'email
use Illuminate\Validation\Rule;


class EtudiantController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $etudiants = Etudiant::with('user')->latest()->paginate(15);
        return view('personnes.etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('personnes.etudiants.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules());

        // Gérer les uploads de fichiers
        $paths = $this->handleFileUploads($request);

        // 1. Création du compte utilisateur (users)
        $randomPassword = Str::random(10);
        $user = User::create([
            'nom' => $validatedData['nom'],
            'prenom' => $validatedData['prenom'],
            'email' => $validatedData['user_email'],
            'password' => Hash::make($randomPassword),
            'statut' => 'actif',
        ]);
        $user->assignRole('etudiant'); // Assigner le rôle etudiant

        // 2. Création du profil étudiant (etudiants)
        $matricule = 'ETD-' . date('Y') . str_pad($user->id, 4, '0', STR_PAD_LEFT);

        $etudiantData = array_merge($validatedData, $paths, [
            'id_user' => $user->id,
            'matricule' => $matricule,
            // S'assurer que les champs email/tel perso sont pris de validatedData
            'email_perso' => $validatedData['email_perso'],
            'telephone_perso' => $validatedData['telephone_perso'] ?? null,
            'adresse_postale' => $validatedData['adresse_postale'] ?? null,
            'sexe' => $validatedData['sexe'],
            'date_naissance' => $validatedData['date_naissance'],
        ]);
        // Nettoyer les champs qui ne sont pas directement pour l'étudiant ou qui sont des fichiers
        unset($etudiantData['user_email']);
        unset($etudiantData['photo_identite']);
        unset($etudiantData['scan_diplome_bac']);
        unset($etudiantData['releves_notes']);
        unset($etudiantData['attestation_reussite']);
        unset($etudiantData['piece_identite']);
        unset($etudiantData['certificat_naissance']);
        unset($etudiantData['certificat_medical']);
        unset($etudiantData['cv']);

        $etudiant = Etudiant::create($etudiantData);

        // Envoyer l'e-mail avec les identifiants
        Mail::to($user->email)->send(new EtudiantCredentialsMail($user, $randomPassword));

        return redirect()->route('personnes.etudiants.index')->with('success', 'Étudiant créé avec succès. Les identifiants ont été envoyés par email.');
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
        $validatedData = $request->validate($this->validationRules($etudiant->id));
        $paths = $this->handleFileUploads($request, $etudiant);

        $etudiantData = array_merge($validatedData, $paths);
        unset($etudiantData['photo_identite']);
        unset($etudiantData['scan_diplome_bac']);
        unset($etudiantData['releves_notes']);
        unset($etudiantData['attestation_reussite']);
        unset($etudiantData['piece_identite']);
        unset($etudiantData['certificat_naissance']);
        unset($etudiantData['certificat_medical']);
        unset($etudiantData['cv']);

        $etudiant->update($etudiantData);
        // Mise à jour de l'utilisateur associé si nécessaire
        if ($etudiant->user) {
            $etudiant->user->update([
                'nom' => $validatedData['nom'],
                'prenom' => $validatedData['prenom'],
            ]);
        }


        return redirect()->route('personnes.etudiants.show', $etudiant->id)->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        if ($etudiant->inscriptionAdmins()->exists()) {
            return back()->with('error', 'Impossible de supprimer cet étudiant, des inscriptions sont liées.');
        }
        // Supprimer les fichiers associés avant de supprimer l'étudiant
        $this->deleteAssociatedFiles($etudiant);
        $etudiant->user()->delete();
        $etudiant->delete();
        
        return redirect()->route('personnes.etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }
    
    public function initierInscription(Etudiant $etudiant)
    {
        $this->authorize('create', InscriptionAdmin::class);

        $currentYear = date('Y') . '-' . (date('Y') + 1);

        $existingInscription = $etudiant->inscriptionAdmins()
            ->where('annee_academique', $currentYear)
            ->first();

        if ($existingInscription) {
            return redirect()->route('paiements.index')->with('info', 'Cet étudiant a déjà une inscription ou un paiement initié pour cette année.');
        }

        $candidature = Candidature::where('email', $etudiant->email_perso)->latest()->first();
        if (!$candidature || !$candidature->parcours_id) {
            return back()->with('error', 'Impossible de trouver le parcours de cet étudiant depuis sa candidature.');
        }
        
        $parcours = $candidature->parcours;

        $inscription = InscriptionAdmin::create([
            'id_etudiant' => $etudiant->id,
            'id_parcours' => $parcours->id,
            'annee_academique' => $currentYear,
            'date_inscription' => now(),
            'statut' => 'En attente de paiement',
        ]);

        $fraisInscription = $parcours->frais_inscription ?? 0;
        $fraisFormation = $parcours->frais_formation ?? 0;

        if ($fraisInscription > 0) {
            Paiement::create([
                'id_inscription_admin' => $inscription->id,
                'montant' => $fraisInscription,
                'type_frais' => 'Inscription',
                'date_paiement' => now(),
                'methode_paiement' => null, // Correction: Utiliser null car la méthode n'est pas encore connue
                'statut_paiement' => 'Payé', // Marquer comme payé directement
                'reference_paiement' => 'PAI-' . strtoupper(Str::random(10)),
            ]);
        }
        if ($fraisFormation > 0) {
            Paiement::create([
                'id_inscription_admin' => $inscription->id,
                'montant' => $fraisFormation,
                'type_frais' => 'Scolarité',
                'date_paiement' => now(),
                'methode_paiement' => null, // Reste null car en attente
                'statut_paiement' => 'En attente', // Reste en attente
                'reference_paiement' => 'PAI-' . strtoupper(Str::random(10)),
            ]);
        }

        // Mettre à jour le statut de l'InscriptionAdmin à 'Inscrit'
        $inscription->statut = 'Inscrit';
        $inscription->save();

        return redirect()->route('paiements.index')->with('success', 'L\'inscription de l\'étudiant ' . $etudiant->nom . ' a été effectuée et le paiement des frais d\'inscription enregistré.');
    }

    public function exportPdf(Etudiant $etudiant)
    {
        $pdf = PDF::loadView('personnes.etudiants.profil-pdf', compact('etudiant'));
        return $pdf->download('profil-'.$etudiant->matricule.'.pdf');
    }

    /**
     * Define validation rules for etudiant.
     */
    protected function validationRules(?int $etudiantId = null): array
    {
        return [
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'nom_pere' => 'nullable|string|max:255',
            'prenom_pere' => 'nullable|string|max:255',
            'nom_mere' => 'nullable|string|max:255',
            'prenom_mere' => 'nullable|string|max:255',
            'date_naissance' => 'required|date',
            'lieu_naissance' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:255',
            'sexe' => 'required|in:M,F,Autre',
            'situation_matrimoniale' => 'nullable|in:Célibataire,Marié(e),Divorcé(e),Veuf(ve)',
            'photo_identite' => 'nullable|image|max:2048',

            'email_perso' => 'required|email|max:255|unique:etudiants,email_perso,' . ($etudiantId ?? 'NULL'),
            'email_secondaire' => 'nullable|email|max:255',
            'telephone_perso' => 'nullable|string|max:20',
            'telephone_secondaire' => 'nullable|string|max:20',
            'adresse_postale' => 'nullable|string',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',

            'nom_tuteur' => 'nullable|string|max:255',
            'prenom_tuteur' => 'nullable|string|max:255',
            'profession_tuteur' => 'nullable|string|max:255',
            'lien_parente_tuteur' => 'nullable|string|max:255',
            'adresse_tuteur' => 'nullable|string',
            'telephone_tuteur' => 'nullable|string|max:20',
            'email_tuteur' => 'nullable|email|max:255',

            'dernier_etablissement' => 'nullable|string|max:255',
            'serie_bac' => 'nullable|string|max:255',
            'annee_obtention_bac' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'mention_bac' => 'nullable|string|max:255',
            'numero_diplome_bac' => 'nullable|string|max:255',
            'dernier_diplome_obtenu' => 'nullable|string|max:255',
            'etablissement_origine' => 'nullable|string|max:255',
            
            'scan_diplome_bac' => 'nullable|file|mimes:pdf|max:5120',
            'releves_notes' => 'nullable|array',
            'releves_notes.*' => 'file|mimes:pdf|max:5120',
            'attestation_reussite' => 'nullable|file|mimes:pdf|max:5120',
            'piece_identite' => 'nullable|file|mimes:pdf|max:5120',
            'certificat_naissance' => 'nullable|file|mimes:pdf|max:5120',
            'certificat_medical' => 'nullable|file|mimes:pdf|max:5120',
            'cv' => 'nullable|file|mimes:pdf|max:5120',


        ];
    }

    /**
     * Handle file uploads and return paths.
     */
    protected function handleFileUploads(Request $request, ?Etudiant $etudiant = null): array
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
                if ($etudiant && $etudiant->$dbField) {
                    Storage::delete($etudiant->$dbField);
                }
                $paths[$dbField] = $request->file($requestField)->store('etudiants/documents');
            } elseif ($etudiant && $etudiant->$dbField) {
                $paths[$dbField] = $etudiant->$dbField;
            }
        }
        
        // Cas spécial pour releves_notes (peut être multiple)
        if ($request->hasFile('releves_notes')) {
            $uploadedPaths = [];
            foreach ($request->file('releves_notes') as $file) {
                $uploadedPaths[] = $file->store('etudiants/documents/releves');
            }
            if ($etudiant && $etudiant->releves_notes_path) {
                $oldPaths = json_decode($etudiant->releves_notes_path, true);
                foreach ($oldPaths as $oldPath) {
                    Storage::delete($oldPath);
                }
            }
            $paths['releves_notes_path'] = json_encode($uploadedPaths);
        } elseif ($etudiant && $etudiant->releves_notes_path) {
             $paths['releves_notes_path'] = $etudiant->releves_notes_path;
        }

        return $paths;
    }

    /**
     * Delete associated files when an etudiant is deleted.
     */
    protected function deleteAssociatedFiles(Etudiant $etudiant): void
    {
        $fileFields = [
            'photo_identite_path', 'scan_diplome_bac_path', 'releves_notes_path',
            'attestation_reussite_path', 'piece_identite_path', 'certificat_naissance_path',
            'certificat_medical_path', 'cv_path'
        ];

        foreach ($fileFields as $field) {
            if ($etudiant->$field) {
                if ($field === 'releves_notes_path') {
                    $paths = json_decode($etudiant->$field, true);
                    foreach ($paths as $path) {
                        Storage::delete($path);
                    }
                } else {
                    Storage::delete($etudiant->$field);
                }
            }
        }
    }
}


