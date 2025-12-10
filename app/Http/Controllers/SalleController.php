<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Salle; // Add this line

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salles = Salle::all(); // Fetch all salles
        return view('academique.salles.index', compact('salles')); // Pass salles to the view
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('academique.salles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nom_salle' => 'required|string|max:255|unique:salles,nom_salle',
            'capacite' => 'required|integer|min:1',
            'type_salle' => 'nullable|string|max:255',
        ]);

        Salle::create($validatedData);

        return redirect()->route('academique.salles.index')->with('success', 'Salle créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salle $salle) // Use route model binding
    {
        return view('academique.salles.edit', compact('salle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salle $salle)
    {
        $validatedData = $request->validate([
            'nom_salle' => 'required|string|max:255|unique:salles,nom_salle,' . $salle->id,
            'capacite' => 'required|integer|min:1',
            'type_salle' => 'nullable|string|max:255',
        ]);

        $salle->update($validatedData);

        return redirect()->route('academique.salles.index')->with('success', 'Salle mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salle $salle)
    {
        $salle->delete();

        return redirect()->route('academique.salles.index')->with('success', 'Salle supprimée avec succès.');
    }
}

