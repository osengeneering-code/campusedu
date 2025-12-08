<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Module;
use App\Models\EvaluationType;
use App\Models\InscriptionAdmin; // Added
use App\Models\Note; // Added
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Exemple: Récupérer toutes les évaluations paginées
        $evaluations = Evaluation::paginate(10);
        return view('academique.evaluations.index', compact('evaluations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $evaluation = new Evaluation();
        
        // Filter modules based on user role
        $modulesQuery = Module::with('ue.semestre.parcours')->orderBy('libelle');
        if (Auth::check() && Auth::user()->hasRole('enseignant')) {
            $modulesQuery->whereHas('enseignants', function ($query) {
                $query->where('enseignant_id', Auth::user()->enseignant->id);
            });
        }
        $modules = $modulesQuery->get();

        $evaluationTypes = EvaluationType::orderBy('name')->get();
        return view('academique.evaluations.create', compact('evaluation', 'modules', 'evaluationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:255',
            'date_evaluation' => 'required|date',
            'id_module' => 'required|exists:modules,id',
            'evaluation_type_id' => 'required|exists:evaluation_types,id',
            'annee_academique' => 'required|string|max:9', // Ex: 2023-2024
        ]);

        // Authorization check
        if (Auth::check() && Auth::user()->hasRole('enseignant')) {
            $teacherModules = Auth::user()->enseignant->modules->pluck('id')->toArray();
            if (!in_array($validatedData['id_module'], $teacherModules)) {
                return back()->with('error', 'Vous n\'êtes pas autorisé à créer une évaluation pour ce module.')->withInput();
            }
        }


        // Créer une nouvelle évaluation
        $evaluation = Evaluation::create($validatedData);

        // Générer automatiquement les entrées de notes pour tous les étudiants inscrits au module
        $module = Module::find($validatedData['id_module']);
        $anneeAcademique = $validatedData['annee_academique'];

        // Trouver tous les InscriptionAdmin liés au même parcours que le module, pour l'année académique
        $inscriptionAdmins = InscriptionAdmin::where('id_parcours', $module->ue->semestre->parcours->id)
            ->where('annee_academique', $anneeAcademique)
            ->get();

        foreach ($inscriptionAdmins as $inscriptionAdmin) {
            Note::create([
                'id_evaluation' => $evaluation->id,
                'id_inscription_admin' => $inscriptionAdmin->id,
                'note_obtenue' => null, // Initialiser la note à null
                'est_absent' => false, // Initialiser comme non absent
            ]);
        }

        return redirect()->route('academique.evaluations.index')->with('success', 'Évaluation créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Evaluation $evaluation)
    {
        // Retourne la vue avec les détails de l'évaluation
        return view('academique.evaluations.show', compact('evaluation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Evaluation $evaluation)
    {
        // Filter modules based on user role for edit view also
        $modulesQuery = Module::with('ue.semestre.parcours')->orderBy('libelle');
        if (Auth::check() && Auth::user()->hasRole('enseignant')) {
            $modulesQuery->whereHas('enseignants', function ($query) {
                $query->where('enseignant_id', Auth::user()->enseignant->id);
            });
        }
        $modules = $modulesQuery->get();
        
        $evaluationTypes = EvaluationType::orderBy('name')->get();

        // Retourne la vue pour le formulaire d'édition
        return view('academique.evaluations.edit', compact('evaluation', 'modules', 'evaluationTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        // Valider les données
        $validatedData = $request->validate([
            'libelle' => 'required|string|max:255',
            'date_evaluation' => 'required|date',
            'id_module' => 'required|exists:modules,id',
            'evaluation_type_id' => 'required|exists:evaluation_types,id',
            'annee_academique' => 'required|string|max:9', // Ex: 2023-2024
        ]);
        
        // Authorization check for update
        if (Auth::check() && Auth::user()->hasRole('enseignant')) {
            $teacherModules = Auth::user()->enseignant->modules->pluck('id')->toArray();
            if (!in_array($validatedData['id_module'], $teacherModules)) {
                return back()->with('error', 'Vous n\'êtes pas autorisé à modifier une évaluation pour ce module.')->withInput();
            }
        }


        // Mettre à jour l'évaluation
        $evaluation->update($validatedData);

        return redirect()->route('academique.evaluations.index')->with('success', 'Évaluation mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Evaluation $evaluation)
    {
        // Supprimer l'évaluation
        $evaluation->delete();

        return redirect()->route('academique.evaluations.index')->with('success', 'Évaluation supprimée avec succès.');
    }
}