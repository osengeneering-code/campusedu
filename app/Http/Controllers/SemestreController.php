<?php

namespace App\Http\Controllers;

use App\Models\Semestre;
use App\Models\Parcours;
use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SemestreController extends Controller
{
    

    public function index()
    {
        $semestres = Semestre::with('parcours.filiere')->latest()->paginate(10);
        // Charger hiérarchie complète pour la vue imbriquée
        $departements = Departement::with(['filieres.parcours.semestres'])->get();

        return view('academique.semestres.index', compact('semestres','departements'));
    }

    public function create()
    {
        $parcours = Parcours::orderBy('nom')->get();
        $niveaux = ['L1', 'L2', 'L3', 'M1', 'M2']; 
        return view('academique.semestres.create', compact('parcours', 'niveaux'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
            'id_parcours' => 'required|exists:parcours,id',
            'niveau' => ['required', Rule::in(['L1', 'L2', 'L3', 'M1', 'M2'])],
        ]);

        Semestre::create($request->all());

        return redirect()->route('academique.semestres.index')->with('success', 'Semestre créé avec succès.');
    }

    public function show(Semestre $semestre)
    {
        $semestre->load('parcours.filiere.departement', 'ues');
        return view('academique.semestres.show', compact('semestre'));
    }

    public function edit(Semestre $semestre)
    {
        $parcours = Parcours::orderBy('nom')->get();
        $niveaux = ['L1', 'L2', 'L3', 'M1', 'M2'];
        return view('academique.semestres.edit', compact('semestre', 'parcours', 'niveaux'));
    }

    public function update(Request $request, Semestre $semestre)
    {
        $request->validate([
            'libelle' => 'required|string|max:50',
            'id_parcours' => 'required|exists:parcours,id',
            'niveau' => ['required', Rule::in(['L1', 'L2', 'L3', 'M1', 'M2'])],
        ]);

        $semestre->update($request->all());

        return redirect()->route('academique.semestres.index')->with('success', 'Semestre mis à jour avec succès.');
    }

    public function destroy(Semestre $semestre)
    {
        if ($semestre->ues()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce semestre, des UE y sont rattachées.');
        }

        $semestre->delete();
        return redirect()->route('academique.semestres.index')->with('success', 'Semestre supprimé avec succès.');
    }
}

