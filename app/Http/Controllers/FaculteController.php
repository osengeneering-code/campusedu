<?php

namespace App\Http\Controllers;

use App\Models\Faculte;
use Illuminate\Http\Request;

class FaculteController extends Controller
{
    

    public function index()
    {
        $facultes = Faculte::latest()->paginate(10);
        return view('academique.facultes.index', compact('facultes'));
    }

    public function create()
    {
        return view('academique.facultes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255|unique:facultes,nom',
            'description' => 'nullable|string',
        ]);

        Faculte::create($request->all());

        return redirect()->route('academique.facultes.index')->with('success', 'Faculté créée avec succès.');
    }
    
    public function edit(Faculte $faculte)
    {
        return view('academique.facultes.edit', compact('faculte'));
    }

    public function update(Request $request, Faculte $faculte)
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255', \Illuminate\Validation\Rule::unique('facultes')->ignore($faculte->id)],
            'description' => 'nullable|string',
        ]);

        $faculte->update($request->all());

        return redirect()->route('academique.facultes.index')->with('success', 'Faculté mise à jour avec succès.');
    }

    public function destroy(Faculte $faculte)
    {
        if ($faculte->departements()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette faculté, des départements y sont rattachés.');
        }

        $faculte->delete();
        return redirect()->route('academique.facultes.index')->with('success', 'Faculté supprimée avec succès.');
    }
}

