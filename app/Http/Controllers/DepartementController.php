<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Faculte;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    

    public function index()
    {
        $departements = Departement::with('faculte')->latest()->paginate(10);
        return view('academique.departements.index', compact('departements'));
    }

    public function create()
    {
        $facultes = Faculte::orderBy('nom')->get();
        return view('academique.departements.create', compact('facultes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'id_faculte' => 'required|exists:facultes,id',
            'description' => 'nullable|string',
        ]);

        Departement::create($request->all());

        return redirect()->route('academique.departements.index')->with('success', 'Département créé avec succès.');
    }

    public function edit(Departement $departement)
    {
        $facultes = Faculte::orderBy('nom')->get();
        return view('academique.departements.edit', compact('departement', 'facultes'));
    }

    public function update(Request $request, Departement $departement)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'id_faculte' => 'required|exists:facultes,id',
            'description' => 'nullable|string',
        ]);

        $departement->update($request->all());

        return redirect()->route('academique.departements.index')->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Departement $departement)
    {
        if ($departement->filieres()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce département, des filières y sont rattachées.');
        }

        $departement->delete();
        return redirect()->route('academique.departements.index')->with('success', 'Département supprimé avec succès.');
    }
}

