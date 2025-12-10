<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entreprises = Entreprise::latest()->paginate(10);
        return view('stages.entreprises.index', compact('entreprises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stages.entreprises.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email_contact' => 'nullable|email|max:255',
        ]);

        Entreprise::create($request->all());

        return redirect()->route('stages.entreprises.index')->with('success', 'Entreprise créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Entreprise $entreprise)
    {
        return view('stages.entreprises.show', compact('entreprise'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entreprise $entreprise)
    {
        return view('stages.entreprises.edit', compact('entreprise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entreprise $entreprise)
    {
        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'secteur_activite' => 'nullable|string|max:255',
            'adresse' => 'nullable|string|max:255',
            'code_postal' => 'nullable|string|max:20',
            'ville' => 'nullable|string|max:255',
            'pays' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email_contact' => 'nullable|email|max:255',
        ]);

        $entreprise->update($request->all());

        return redirect()->route('stages.entreprises.index')->with('success', 'Entreprise mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entreprise $entreprise)
    {
        $entreprise->delete();

        return redirect()->route('stages.entreprises.index')->with('success', 'Entreprise supprimée avec succès.');
    }
}
