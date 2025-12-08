<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use App\Models\Module;
use App\Models\Salle;
use App\Models\Filiere;
use App\Models\Parcours;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Barryvdh\DomPDF\Facade\Pdf;


class CoursController extends Controller
{
    /**
     * Affiche l'emploi du temps (tableau par jour).
     */
public function index(Request $request)
{
    // Récupération des cours avec toutes les relations nécessaires
    $query = Cours::with(['module', 'salle', 'filiere', 'parcours', 'semestre']);

    // Filtrage si sélectionné
    if ($request->filled('id_filiere')) {
        $query->where('id_filiere', $request->id_filiere);
    }

    if ($request->filled('id_parcour')) {
        $query->where('id_parcours', $request->id_parcour);
    }

    if ($request->filled('id_semestre')) {
        $query->where('id_semestre', $request->id_semestre);
    }

    // Récupérer tous les cours et les grouper par jour
    $cours = $query->get()->groupBy('jour');

    // Liste complète des jours pour le tableau
    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    // Récupération des listes pour le formulaire de filtrage
    $filieres  = \App\Models\Filiere::all();
    $parcours  = \App\Models\Parcours::all();
    $semestres = \App\Models\Semestre::all();

    return view('emplois_du_temps.index', compact(
        'cours', 'jours', 'filieres', 'parcours', 'semestres'
    ));
}


public function downloadPdf(Request $request)
{
    $filieres = Filiere::all();
    $parcours = Parcours::all();
    $semestres = Semestre::all();

    $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

    $cours = Cours::with('module', 'salle')->get()->groupBy('jour');

    $pdf = Pdf::loadView('emplois_du_temps.pdf', compact('cours','filieres','parcours','semestres','jours'))
              ->setPaper('a4', 'landscape');

    return $pdf->download('emploi_du_temps.pdf');
}

    /**
     * Formulaire de création d'un cours (emploi du temps).
     */
    public function create()
    {
        $filieres = Filiere::all();
        $parcours = Parcours::all();
        $semestres = Semestre::all();

        $modules = Module::all();
        $salles   = Salle::all();

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        $types = ['CM', 'TD', 'TP'];

        return view('emplois_du_temps.create', compact(
            'filieres', 'parcours', 'semestres', 'modules', 'salles', 'jours', 'types'
        ));
    }

    /**
     * Enregistrement d'un nouveau créneau de cours.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_filiere'  => 'required|exists:filieres,id',
            'id_parcours' => 'required|exists:parcours,id',
            'id_semestre' => 'required|exists:semestres,id',

            'id_module' => 'required|exists:modules,id',

            'id_salle'  => [
                'required',
                'exists:salles,id',
                Rule::unique('cours')->where(function ($q) use ($request) {
                    return $q->where('annee_academique', $request->annee_academique)
                             ->where('jour', $request->jour)
                             ->where(fn($sub) => 
                                 $sub->where('heure_debut', '<', $request->heure_fin)
                                     ->where('heure_fin', '>', $request->heure_debut)
                             );
                }),
            ],

            'annee_academique' => 'required|string',
            'jour' => ['required', Rule::in(['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'])],
            'heure_debut' => 'required|date_format:H:i',
            'heure_fin'   => 'required|date_format:H:i|after:heure_debut',
            'type_cours'  => ['required', Rule::in(['CM','TD','TP'])],
        ], [
            'id_salle.unique' => 'Cette salle est déjà occupée sur ce créneau.',
        ]);

        // Enregistrement
        Cours::create($request->all());

        return redirect()
            ->route('gestion-cours.cours.index')
            ->with('success', 'Cours ajouté à l’emploi du temps.');
    }
}
