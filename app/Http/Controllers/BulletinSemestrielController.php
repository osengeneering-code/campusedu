<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AcademicAverageService;
use App\Models\Semestre;
use App\Models\Etudiant;
use App\Models\InscriptionAdmin; // Pour récupérer les étudiants inscrits

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
    public function index()
    {
        $semestres = Semestre::with('ues')->get(); // Récupérer tous les semestres avec leurs UEs
        $anneeAcademique = date('Y') . '-' . (date('Y') + 1); // Année académique actuelle par défaut

        return view('academique.bulletins.semestriel.index', compact('semestres', 'anneeAcademique'));
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
