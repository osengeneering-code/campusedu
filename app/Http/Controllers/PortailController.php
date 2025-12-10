<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Cours;
use App\Models\Semestre; // Ajouté pour la dynamisation du dashboard enseignant
use App\Models\Module; // Ajouté pour la dynamisation du dashboard enseignant
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth; // Ajouté

class PortailController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Affiche le tableau de bord pour l'utilisateur connecté en fonction de son rôle.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('etudiant')) {
            return $this->etudiantDashboard($user);
        }

        if ($user->hasRole('enseignant')) {
            return $this->enseignantDashboard($user);
        }

        if ($user->hasRole('secretaire')) {
            return $this->secretaireDashboard($user);
        }

        if ($user->hasRole('responsable-stage')) {
            return $this->responsableStageDashboard($user);
        }

        if ($user->hasRole('responsable-etude')) {
            return $this->responsableEtudeDashboard($user);
        }

        if ($user->hasRole('comptable')) {
            return $this->comptableDashboard($user);
        }

        if ($user->hasRole('directeur-general')) {
            return $this->directeurGeneralDashboard($user);
        }

        if ($user->hasRole('admin')) {
            return $this->adminDashboard($user);
        }

        // Fallback for any other role or no role
        return view('dashboards.admin');
    }

    /**
     * Tableau de bord spécifique à l'étudiant.
     */
  public function etudiantDashboard($user)
{
    // Charger la relation etudiant avec vérification
    $etudiant = $user->load('etudiant')->etudiant;
    
    if (!$etudiant) {
        return redirect()->route('home')->with('error', 'Vous n\'avez pas de profil étudiant associé.');
    }
    // Année académique actuelle
    $anneeAcademique = now()->year . '-' . (now()->year + 1);
    
    // Charger toutes les relations nécessaires en une seule requête optimisée
    $etudiant->load([
        'documents',
        'inscriptionAdmins' => function ($query) use ($anneeAcademique) {
            $query->where('annee_academique', $anneeAcademique)
                  ->with([
                      'parcours.filiere',
                      'paiements',
                      'notes.evaluation' => function ($q) {
                          $q->with([
                              'evaluationType',
                              'module.ue.semestre.parcours.filiere'
                          ]);
                      },
                      'stages.entreprise',
                      'modules.ue.semestre.parcours', // Pour getMoyenneModule
                      'modules.enseignants'
                  ]);
        }
    ]);

    $inscriptionAdmin = $etudiant->inscriptionAdmins->first();
    
    // Initialiser les collections vides par défaut
    $edt = collect();
    $moyennesModules = collect();

    if ($inscriptionAdmin && $inscriptionAdmin->modules->isNotEmpty()) {
        // Récupérer l'emploi du temps avec une seule requête
        $modulesIds = $inscriptionAdmin->modules->pluck('id')->toArray();
        
        $edt = Cours::whereIn('id_module', $modulesIds)
            ->where('annee_academique', $anneeAcademique)
            ->with(['module.enseignants', 'salle'])
            ->orderBy('jour')
            ->orderBy('heure_debut')
            ->get()
            ->groupBy('jour');

        // Calculer les moyennes par module de manière optimisée
        $moyennesModules = $inscriptionAdmin->modules->mapWithKeys(function ($module) use ($etudiant, $anneeAcademique) {
            $moyenne = $etudiant->getMoyenneModule($module, $anneeAcademique);
            return [$module->id => [
                'moyenne' => $moyenne,
                'nom_module' => $module->nom ?? $module->libelle,
                'credit' => $module->credit ?? 0
            ]];
        });
    }

    return view('dashboards.etudiant', compact(
        'etudiant',
        'edt',
        'moyennesModules',
        'inscriptionAdmin',
        'anneeAcademique'
    ));
}
 

    /**
     * Tableau de bord spécifique au responsable de stage.
     */
    public function responsableStageDashboard($user)
    {
        return view('portails.responsable-stage.dashboard');
    }

    /**
     * Tableau de bord spécifique au responsable des études.
     */
    public function responsableEtudeDashboard($user)
    {
        return view('portails.responsable-etude.dashboard');
    }

    /**
     * Tableau de bord spécifique au comptable.
     */
    public function comptableDashboard($user)
    {
        return view('portails.comptable.dashboard');
    }

    /**
     * Tableau de bord spécifique au directeur general.
     */
    public function directeurGeneralDashboard($user)
    {
        return view('portails.directeur-general.dashboard');
    }

    /**
     * Tableau de bord spécifique à l'administrateur.
     */
    public function adminDashboard($user)
    {
        return view('Dashboards.admin');
    }
     
    /**
     * Tableau de bord spécifique à l'enseignant.
     */
    public function enseignantDashboard($user)
    {
        $enseignant = $user->enseignant()->with('departement')->first(); 
        if (!$enseignant) {
            return redirect()->route('dashboard')->with('error', 'Profil enseignant non trouvé.');
        }

        // Fetch courses for the current enseignant and organize them into EDT
        $moduleIds = $enseignant->modules->pluck('id');
        $courses = Cours::whereIn('id_module', $moduleIds)
                         ->where('annee_academique', date('Y').'-'.(date('Y')+1)) 
                         ->with(['module', 'salle'])
                         ->get();

        $edt = collect();
        foreach ($courses as $course) {
            $jour = $course->jour;
            if (!isset($edt[$jour])) {
                $edt[$jour] = collect();
            }
            $edt[$jour]->push($course);
        }

        foreach ($edt as $jour => $dailyCourses) {
            $edt[$jour] = collect($dailyCourses)->sortBy('heure_debut')->values();
        }

        // 1. Data for "Relevé des évaluations par module"
        $modulesTaught = $enseignant->modules()->with(['evaluations.notes', 'evaluations.evaluationType'])->get();
        $releves_evaluations_par_module = collect();

        foreach ($modulesTaught as $module) {
            foreach ($module->evaluations as $evaluation) {
                $totalNotes = $evaluation->notes->count();
                $moyenne = $totalNotes > 0 ? $evaluation->notes->avg('note') : 0;

                $releves_evaluations_par_module->push([
                    'module_libelle' => $module->libelle,
                    'evaluation_libelle' => $evaluation->libelle,
                    'evaluation_type' => $evaluation->evaluationType->libelle ?? 'N/A',
                    'date_evaluation' => $evaluation->date_evaluation->format('d/m/Y'),
                    'total_notes' => $totalNotes,
                    'moyenne_notes' => round($moyenne, 2),
                ]);
            }
        }
        
        // 2. Data for "Évaluations" (Upcoming/Recent Evaluations created by or linked to enseignant's modules)
        $evaluations_enseignant = $modulesTaught->flatMap(function ($module) {
            return $module->evaluations->map(function ($evaluation) {
                return [
                    'id' => $evaluation->id,
                    'libelle' => $evaluation->libelle,
                    'module' => $evaluation->module->libelle ?? 'N/A',
                    'type' => $evaluation->evaluationType->libelle ?? 'N/A',
                    'date' => $evaluation->date_evaluation->format('d/m/Y'),
                    'total_notes_saisies' => $evaluation->notes->count(),
                ];
            });
        })->sortByDesc('date')->take(5); 

        // 3. Data for "Étudiants inscrits aux modules"
        $etudiants_par_module = collect();
        foreach ($modulesTaught as $module) {
            $studentsInModule = $module->inscriptionAdmins()->with('etudiant')->get()->map(function ($inscriptionAdmin) {
                return $inscriptionAdmin->etudiant;
            })->filter()->unique('id')->values(); 

            if ($studentsInModule->isNotEmpty()) {
                $etudiants_par_module->put($module->libelle, $studentsInModule);
            }
        }


        $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $jourAujourdhui = $jours[date('w')];
        $coursAujourdhui = $edt->get($jourAujourdhui, collect());

        // --- Données pour le graphique d'évolution des notes par module ---
        $donneesGraphiqueEvolution = collect();
        $anneeAcademiqueActuelle = date('Y').'-'.(date('Y')+1); 

        foreach ($modulesTaught as $module) {
            $evaluationsModule = $module->evaluations()
                                        ->where('annee_academique', $anneeAcademiqueActuelle)
                                        ->with('notes')
                                        ->orderBy('date_evaluation')
                                        ->get();

            $evolutionMoyennes = collect();
            foreach ($evaluationsModule as $evaluation) {
                $moyenneEvaluation = null;
                $notesValides = $evaluation->notes->filter(fn($note) => !$note->est_absent && is_numeric($note->note_obtenue));
                
                if ($notesValides->isNotEmpty()) {
                    $moyenneEvaluation = round($notesValides->avg('note_obtenue'), 2);
                }

                $evolutionMoyennes->push([
                    'date_evaluation' => $evaluation->date_evaluation->format('d/m/Y'),
                    'moyenne' => $moyenneEvaluation,
                ]);
            }
            if ($evolutionMoyennes->isNotEmpty()) {
                $donneesGraphiqueEvolution->put($module->libelle, $evolutionMoyennes);
            }
        }

        // --- Données pour le graphique de répartition des étudiants par filière/parcours ---
        $donneesGraphiqueRepartitionNiveaux = ['labels' => [], 'data' => []];
        $repartitionEtudiants = collect();

        foreach ($modulesTaught as $module) {
            $studentsInModule = $module->inscriptionAdmins()->with('etudiant.inscriptionAdmins.parcours.filiere')->get()
                                       ->map(fn($ia) => optional(optional(optional($ia->etudiant)->inscriptionAdmins->where('annee_academique', $anneeAcademiqueActuelle)->first())->parcours)->filiere)
                                       ->filter(); 
            
            foreach ($studentsInModule as $filiere) {
                if ($filiere) {
                    $repartitionEtudiants->put($filiere->nom, ($repartitionEtudiants->get($filiere->nom, 0) + 1));
                }
            }
        }
        
        $donneesGraphiqueRepartitionNiveaux['labels'] = $repartitionEtudiants->keys()->all();
        $donneesGraphiqueRepartitionNiveaux['data'] = $repartitionEtudiants->values()->all();

        // --- Données pour les cartes statistiques ---
        $totalEtudiants = 0;
        $etudiantsUniques = collect();
        foreach ($etudiants_par_module as $moduleLibelle => $etudiants) {
            $etudiantsUniques = $etudiantsUniques->merge($etudiants);
        }
        $totalEtudiants = $etudiantsUniques->unique('id')->count();

        $totalEvaluationsSaisies = 0;
        foreach ($modulesTaught as $module) {
            foreach ($module->evaluations as $evaluation) {
                // Compte uniquement les notes qui ne sont pas "absent" et qui ont une valeur numérique
                $totalEvaluationsSaisies += $evaluation->notes->filter(fn($note) => !$note->est_absent && is_numeric($note->note_obtenue))->count();
            }
        }

        // --- Données pour "Bilan Semestres en cours" ---
        $semestres_enseignant = collect();
        // $anneeAcademiqueActuelle est déjà définie

        // Charger les relations nécessaires pour les modules enseignés
        $enseignant->load(['modules.ue.semestre']);
        $semestresIds = $enseignant->modules->pluck('ue.semestre.id')->unique();
        $semestres = Semestre::whereIn('id', $semestresIds)
                                         ->with(['ues.modules' => fn($q) => $q->whereIn('id', $moduleIds)->withCount('evaluations')])
                                         ->get();

        foreach ($semestres as $semestre) {
            $modulesDuSemestre = $semestre->ues->flatMap(fn($ue) => $ue->modules)->whereIn('id', $moduleIds);
            
            $totalEvaluationsPourSemestre = 0;
            $evaluationsSaisiesPourSemestre = 0;

            foreach ($modulesDuSemestre as $module) {
                $totalEvaluationsPourSemestre += $module->evaluations_count; // Compte des évaluations sur le module
                // Compter les évaluations de ce module qui ont au moins une note saisie
                $evaluationsSaisiesPourSemestre += \App\Models\Evaluation::where('id_module', $module->id)
                                                                       ->whereHas('notes', fn($q) => $q->whereNotNull('note_obtenue')->orWhere('est_absent', true))
                                                                       ->count();
            }

            $progression = ($totalEvaluationsPourSemestre > 0) ? round(($evaluationsSaisiesPourSemestre / $totalEvaluationsPourSemestre) * 100) : 0;

            $semestres_enseignant->push([
                'libelle' => $semestre->libelle,
                'niveau' => $semestre->niveau,
                'modules_count' => $modulesDuSemestre->count(),
                'progression' => $progression,
                'statut' => ($progression == 100) ? 'Terminé' : 'En cours',
                'date_debut' => $semestre->date_debut ? $semestre->date_debut->format('d/m/Y') : 'N/A',
                'date_fin' => $semestre->date_fin ? $semestre->date_fin->format('d/m/Y') : 'N/A',
                'db_status' => $semestre->status, // Le statut de la base de données
            ]);
        }

        // --- Données pour "Meilleur performance du module" ---
        $meilleurs_etudiants_module = collect();
        $modulePourPalmares = $modulesTaught->first(); // Prend le premier module pour l'exemple
        if ($modulePourPalmares) {
            $etudiantsDuModule = \App\Models\InscriptionAdmin::whereHas('modules', fn($q) => $q->where('modules.id', $modulePourPalmares->id))
                                                              ->where('annee_academique', $anneeAcademiqueActuelle)
                                                              ->with('etudiant.user')
                                                              ->get()
                                                              ->map(function ($inscriptionAdmin) use ($anneeAcademiqueActuelle, $modulePourPalmares) {
                                                                    $currentEtudiant = $inscriptionAdmin->etudiant;
                                                                    $moyenne = $currentEtudiant->getMoyenneModule($modulePourPalmares, $anneeAcademiqueActuelle);
                                                                    return [
                                                                        'etudiant' => $currentEtudiant,
                                                                        'moyenne' => $moyenne,
                                                                    ];
                                                              })
                                                              ->filter(fn($data) => is_numeric($data['moyenne'])) // Ne garder que ceux avec une moyenne calculable
                                                              ->sortByDesc('moyenne')
                                                              ->take(5);
            $meilleurs_etudiants_module->put('module_libelle', $modulePourPalmares->libelle);
            $meilleurs_etudiants_module->put('etudiants', $etudiantsDuModule);
        }

        // --- Données pour le graphique "Évolution" (inscriptionsChart) ---
        $evolutionEtudiantsParMois = ['labels' => [], 'data' => []];
        $etudiantsUniquesTousModules = collect();
        foreach ($modulesTaught as $module) {
            $etudiantsUniquesTousModules = $etudiantsUniquesTousModules->merge(
                $module->inscriptionAdmins()->where('annee_academique', $anneeAcademiqueActuelle)->with('etudiant')->get()->pluck('etudiant')
            );
        }
        $etudiantsUniquesTousModules = $etudiantsUniquesTousModules->unique('id');

        $etudiantsParMois = [];
        $periode = now()->subMonths(6); // Exemple: les 6 derniers mois
        while ($periode->lessThanOrEqualTo(now())) {
            $mois = $periode->format('M Y');
            $count = $etudiantsUniquesTousModules->filter(fn($etudiant) => 
                $etudiant->created_at && $etudiant->created_at->format('M Y') == $mois
            )->count();
            $etudiantsParMois[$mois] = $count;
            $periode->addMonth();
        }

        $evolutionEtudiantsParMois['labels'] = array_keys($etudiantsParMois);
        $evolutionEtudiantsParMois['data'] = array_values($etudiantsParMois);


        return view('dashboards.enseignant', compact(
            'enseignant',
            'edt',
            'releves_evaluations_par_module',
            'evaluations_enseignant',
            'etudiants_par_module',
            'modulesTaught',
            'coursAujourdhui',
            'donneesGraphiqueEvolution',
            'donneesGraphiqueRepartitionNiveaux',
            'totalEtudiants',
            'totalEvaluationsSaisies',
            'semestres_enseignant',
            'meilleurs_etudiants_module',
            'evolutionEtudiantsParMois',
            'anneeAcademiqueActuelle'
        ));
    }

    /**
     * Affiche les modules de l'enseignant connecté.
     */
    public function mesModules()
    {
        $user = auth()->user();
        if (!$user->enseignant) {
            abort(403, 'Accès non autorisé.');
        }

        $modules = $user->enseignant->modules()
            ->with('ue.semestre.parcours.filiere', 'inscriptionAdmins.etudiant.user')
            ->get();

        return view('portails.mes-modules', compact('modules'));
    }

    /**
     * Affiche le bilan détaillé d'un étudiant pour l'enseignant.
     */
    public function showEtudiantBilan(Enseignant $enseignant, Etudiant $etudiant)
    {
        // Autorisation: S'assurer que l'enseignant peut voir ce bilan
        // Par exemple, l'enseignant doit être affecté à au moins un module de cet étudiant.
        // Ou que l'enseignant est le tuteur de stage de l'étudiant, etc.
        // Pour l'instant, on suppose que s'il peut y accéder via son dashboard, c'est autorisé.

        $anneeAcademique = date('Y').'-'.(date('Y')+1); // Année académique actuelle

        // Charger les inscriptions de l'étudiant avec les relations nécessaires
        $etudiant->load([
            'inscriptionAdmins' => function ($query) use ($anneeAcademique) {
                $query->where('annee_academique', $anneeAcademique)
                      ->with([
                          'parcours.semestres.ues.modules.evaluations.notes' => function ($query) use ($etudiant) {
                              $query->whereHas('inscriptionAdmin', function ($q) use ($etudiant) {
                                  $q->where('id_etudiant', $etudiant->id);
                              });
                          },
                          'notes.evaluation.evaluationType', 
                          'modules', 
                      ]);
            },
            'user'
        ]);

        $inscriptionAdminActuelle = $etudiant->inscriptionAdmins->first();

        if (!$inscriptionAdminActuelle) {
            return back()->with('error', 'Aucune inscription trouvée pour cet étudiant cette année.');
        }

        $moyennesModules = collect();
        $moyennesSemestres = collect();
        $donneesGraphiqueMoyennesModules = ['labels' => [], 'datasets' => []]; 
        $donneesGraphiqueEvolutionSemestre = ['labels' => [], 'datasets' => []]; 


        if ($inscriptionAdminActuelle) {
            // Calcul des moyennes par module
            foreach ($inscriptionAdminActuelle->modules as $module) {
                $module->loadMissing('ue.semestre.parcours.filiere'); 
                $moyenne = $etudiant->getMoyenneModule($module, $anneeAcademique);
                if (is_numeric($moyenne)) {
                    $moyennesModules->put($module->id, $moyenne);
                    $donneesGraphiqueMoyennesModules['labels'][] = $module->code_module;
                    $donneesGraphiqueMoyennesModules['datasets'][0]['data'][] = $moyenne;
                    $donneesGraphiqueMoyennesModules['datasets'][0]['backgroundColor'][] = $moyenne >= 10 ? '#4CAF50' : '#F44336'; // Vert si >= 10, Rouge sinon
                }
            }
            if(isset($donneesGraphiqueMoyennesModules['datasets'][0]['data'])) {
                $donneesGraphiqueMoyennesModules['datasets'][0]['label'] = 'Moyennes par Module';
            }


            // Calcul des moyennes par semestre et pour l'évolution
            $semestresUniques = $inscriptionAdminActuelle->parcours->semestres->sortBy('libelle'); 
            $evolutionSemestreLabels = [];
            $evolutionSemestreData = [];

            foreach ($semestresUniques as $semestre) {
                $moyenneSemestre = $etudiant->getMoyenneConteneur('semestre', $semestre->id, $anneeAcademique);
                if (is_numeric($moyenneSemestre)) {
                    $moyennesSemestres->put($semestre->id, $moyenneSemestre);
                    $evolutionSemestreLabels[] = $semestre->libelle;
                    $evolutionSemestreData[] = $moyenneSemestre;
                }
            }
            if(!empty($evolutionSemestreLabels)) {
                $donneesGraphiqueEvolutionSemestre['labels'] = $evolutionSemestreLabels;
                $donneesGraphiqueEvolutionSemestre['datasets'][] = [
                    'label' => 'Moyenne par Semestre',
                    'data' => $evolutionSemestreData,
                    'borderColor' => 'rgb(75, 192, 192)',
                    'tension' => 0.1,
                    'fill' => false
                ];
            }
        }
        
        return view('portails.enseignant.bilan-etudiant', compact(
            'enseignant',
            'etudiant',
            'anneeAcademique',
            'inscriptionAdminActuelle',
            'moyennesModules',
            'moyennesSemestres',
            'donneesGraphiqueMoyennesModules',
            'donneesGraphiqueEvolutionSemestre'
        ));
    }
}