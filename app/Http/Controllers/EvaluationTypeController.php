<?php

namespace App\Http\Controllers;

use App\Models\EvaluationType;
use Illuminate\Http\Request;

class EvaluationTypeController extends Controller
{
    public function index()
    {
        $evaluationTypes = EvaluationType::latest()->paginate(10);
        return view('academique.evaluation_types.index', compact('evaluationTypes'));
    }

    public function create()
    {
        return view('academique.evaluation_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:evaluation_types,name',
            'max_score' => 'required|integer|min:1',
        ]);

        EvaluationType::create($request->all());

        return redirect()->route('academique.evaluation-types.index')->with('success', 'Type d\'évaluation créé avec succès.');
    }

    public function edit(EvaluationType $evaluationType)
    {
        return view('academique.evaluation_types.edit', compact('evaluationType'));
    }

    public function update(Request $request, EvaluationType $evaluationType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:evaluation_types,name,' . $evaluationType->id,
            'max_score' => 'required|integer|min:1',
        ]);

        $evaluationType->update($request->all());

        return redirect()->route('academique.evaluation-types.index')->with('success', 'Type d\'évaluation mis à jour avec succès.');
    }

    public function destroy(EvaluationType $evaluationType)
    {
        if ($evaluationType->evaluations()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce type, il est déjà utilisé par des évaluations.');
        }

        $evaluationType->delete();
        return redirect()->route('academique.evaluation-types.index')->with('success', 'Type d\'évaluation supprimé avec succès.');
    }
}