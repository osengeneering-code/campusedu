<?php

namespace App\Http\Controllers;

use App\Models\Ue;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Departement;

class UeController extends Controller
{
    

    public function index()
    {
        // Charger tous les départements avec leurs filières, parcours, semestres et UE
        $departements = Departement::with([
            'filieres.parcours.semestres.ues'
        ])->get();

        $ues = Ue::with('semestre.parcours')->latest()->paginate(10);
        return view('academique.ues.index', compact('ues','departements'));
    }

    public function create()
    {
        $semestres = Semestre::with('parcours.filiere')->get();
        return view('academique.ues.create', compact('semestres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'code_ue' => 'required|string|max:20|unique:ues,code_ue',
            'id_semestre' => 'required|exists:semestres,id',
            'credits_ects' => 'required|integer|min:0',
        ]);

        Ue::create($request->all());

        return redirect()->route('academique.ues.index')->with('success', 'UE créée avec succès.');
    }

    public function show(Ue $ue)
    {
        $ue->load('semestre.parcours.filiere.departement', 'modules');
        return view('academique.ues.show', compact('ue'));
    }

    public function edit(Ue $ue)
    {
        $semestres = Semestre::with('parcours.filiere')->get();
        return view('academique.ues.edit', compact('ue', 'semestres'));
    }

    public function update(Request $request, Ue $ue)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'code_ue' => ['required', 'string', 'max:20', Rule::unique('ues')->ignore($ue->id)],
            'id_semestre' => 'required|exists:semestres,id',
            'credits_ects' => 'required|integer|min:0',
        ]);

        $ue->update($request->all());

        return redirect()->route('academique.ues.index')->with('success', 'UE mise à jour avec succès.');
    }

    public function destroy(Ue $ue)
    {
        if ($ue->modules()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette UE, des modules y sont rattachés.');
        }

        $ue->delete();
        return redirect()->route('academique.ues.index')->with('success', 'UE supprimée avec succès.');
    }
}

