<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AcademicAverageService;
use App\Models\Semestre;
use App->Models\Etudiant;
use App\Models\InscriptionAdmin;
use App\Models\Departement; // NOUVEAU
use App->Models\Filiere;    // NOUVEAU
use App\Models\Parcours;   // NOUVEAU

class BulletinSemestrielController extends Controller
{
    protected $academicAverageService;

    public function __construct(AcademicAverageService $academicAverageService)
    {
        $this->academicAverageService = $academicAverageService;
    }

    /**
     * Affiche la liste des semestres pour la sélection des bulletins.
     */
    public function index(Request $request)
    {
        $anneeAcademique = $request->input('annee_academique', date('Y') . '-' . (date('Y') + 1));
        $semestreId = $request->input('semestre_id');
        $departementId = $request->input('departement_id');
        $filiereId = $request->input('filiere_id');
        $parcoursId = $request->input('parcours_id');

        $semestres = Semestre::all();
        $departements = Departement::all();
        $filieres = collect(); // Initialiser comme collection vide
        $parcours = collect(); // Initialiser comme collection vide

        if ($departementId) {
            $filieres = Filiere::where('id_departement', $departementId)->get();
        }
        if ($filiereId) {
            $parcours = Parcours::where('id_filiere', $filiereId)->get();
        }
        
        $etudiants = collect();
        if ($semestreId && $anneeAcademique && $parcoursId) {
            $etudiants = Etudiant::whereHas('inscriptionAdmins', function ($query) use ($semestreId, $anneeAcademique, $parcoursId) {
                $query->where('annee_academique', $anneeAcademique)
                      ->where('id_parcours', $parcoursId)
                      ->whereHas('parcours.semestres', function ($q) use ($semestreId) {
                          $q->where('semestres.id', $semestreId);
                      });
            })->with('inscriptionAdmins')->get(); // Charger la relation pour l'affichage
        }
        
        return view('academique.bulletins.semestriel.index', compact(
            'semestres',
            'departements',
            'filieres',
            'parcours',
            'etudiants',
            'anneeAcademique',
            'semestreId',
            'departementId',
            'filiereId',
            'parcoursId'
        ));
    }

    /**
     * Affiche le bulletin semestriel détaillé pour un étudiant spécifique.
     *
     * @param string $anneeAcademique
     * @param \App\Models\Semestre $semestre
     * @param \App\Models\Etudiant $etudiant
     * @return \Illuminate\View\View
     */
    public function show(string $anneeAcademique, Semestre $semestre, Etudiant $etudiant)
    {
        // Vérifier si l'étudiant est inscrit à ce semestre pour cette année académique
        $inscriptionAdmin = InscriptionAdmin::where('id_etudiant', $etudiant->id)
                                            ->where('annee_academique', $anneeAcademique)
                                            ->whereHas('parcours.semestres', function($query) use ($semestre) {
                                                $query->where('semestres.id', $semestre->id);
                                            })
                                            ->first();

        if (!$inscriptionAdmin) {
            return back()->with('error', 'L\'étudiant n\'est pas inscrit à ce semestre pour l\'année académique spécifiée.');
        }

        // Utiliser le service pour obtenir les résultats du semestre
        $results = $this->academicAverageService->getGeneralSemesterAverageAndValidation(
            $semestre,
            $etudiant,
            $anneeAcademique
        );

        // Récupérer les moyennes détaillées par UE
        $ueAverages = [];
        foreach ($semestre->ues as $ue) {
            $ueAverages[] = [
                'ue' => $ue,
                'moyenne' => $this->academicAverageService->getMoyenneUE($ue, $etudiant, $anneeAcademique)
            ];
        }
        
        // Charger les modules de chaque UE pour les détails dans le bulletin
        $semestre->load(['ues.modules' => function($query) use ($etudiant, $anneeAcademique) {
            $query->with(['evaluations' => function($query) use ($etudiant, $anneeAcademique) {
                $query->where('annee_academique', $anneeAcademique)
                      ->with(['evaluationType', 'notes' => function($query) use ($etudiant) {
                          $query->whereHas('inscriptionAdmin', function ($q) use ($etudiant) {
                              $q->where('id_etudiant', $etudiant->id);
                          });
                      }]);
            }]);
        }]);


        return view('academique.bulletins.semestriel.show', compact(
            'anneeAcademique',
            'semestre',
            'etudiant',
            'results',
            'ueAverages'
        ));
    }
}
