<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\AcademicAverageService; // Add this line
use App\Models\Semestre; // Add this line

class EtudiantPortailController extends Controller
{
    protected $academicAverageService;

    public function __construct(AcademicAverageService $academicAverageService)
    {
        $this->academicAverageService = $academicAverageService;
    }

    public function dossier()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant()->with(['inscriptionAdmins.parcours'])->first();

        if (!$etudiant) {
            abort(404, 'Dossier étudiant non trouvé.');
        }

        return view('etudiant.dossier', compact('etudiant'));
    }

    public function notes()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            abort(404, 'Dossier étudiant non trouvé.');
        }

        $inscriptions = $etudiant->inscriptionAdmins()->with([
            'parcours.semestres.ues.modules.evaluations.notes' => function ($query) use ($etudiant) {
                $query->whereHas('inscriptionAdmin', function ($q) use ($etudiant) {
                    $q->where('id_etudiant', $etudiant->id);
                });
            }
        ])->get();

        return view('etudiant.notes', compact('etudiant', 'inscriptions'));
    }

    public function stage()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            abort(404, 'Dossier étudiant non trouvé.');
        }

        $inscription = $etudiant->inscriptionAdmins()->latest()->first();

        if (!$inscription) {
            return view('etudiant.stage')->with('stage', null);
        }

        $stage = $inscription->stages()->with('enseignant')->first();

        return view('etudiant.stage', compact('stage'));
    }

    public function monParcours()
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            abort(404, 'Dossier étudiant non trouvé.');
        }

        $inscription = $etudiant->inscriptionAdmins()->latest()->first();

        if (!$inscription) {
            return view('etudiant.mon-parcours')->with('parcours', null);
        }

        $parcours = $inscription->parcours()->with('semestres.ues.modules.enseignants')->first();

        return view('etudiant.mon-parcours', compact('parcours'));
    }

    public function emploi_du_temps()
    {
        return view('etudiant.emploi_du_temps');
    }

    public function paiements()
    {
        return view('etudiant.paiements');
    }

    /**
     * Display semester results for the authenticated student.
     *
     * @param string $anneeAcademique The academic year (e.g., '2023-2024').
     * @param int $semestreId The ID of the semester.
     * @return \Illuminate\View\View
     */
    public function semestreResultats(string $anneeAcademique, int $semestreId)
    {
        $user = Auth::user();
        $etudiant = $user->etudiant;

        if (!$etudiant) {
            abort(404, 'Dossier étudiant non trouvé.');
        }

        $semestre = Semestre::with('ues.modules.evaluations.evaluationType')->find($semestreId);

        if (!$semestre) {
            abort(404, 'Semestre non trouvé.');
        }

        $results = $this->academicAverageService->getGeneralSemesterAverageAndValidation(
            $semestre,
            $etudiant,
            $anneeAcademique
        );
        
        // You might also want to retrieve detailed UE and Module averages here
        $ueAverages = [];
        foreach ($semestre->ues as $ue) {
            $ueAverages[] = [
                'ue' => $ue,
                'moyenne' => $this->academicAverageService->getMoyenneUE($ue, $etudiant, $anneeAcademique)
            ];
        }


        return view('etudiant.semestre_resultats', compact('etudiant', 'semestre', 'results', 'ueAverages'));
    }
}
