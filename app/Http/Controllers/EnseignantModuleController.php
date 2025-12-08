<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Module;
use Illuminate\Http\Request;

class EnseignantModuleController extends Controller
{
    public function index(Enseignant $enseignant)
    {
        $modules = Module::with('ue.semestre.parcours')->get();
        $enseignant->load('modules');
        $assignedModuleIds = $enseignant->modules->pluck('id')->toArray();

        return view('personnes.enseignants.modules', compact('enseignant', 'modules', 'assignedModuleIds'));
    }

    public function store(Request $request, Enseignant $enseignant)
    {
        $request->validate([
            'module_ids' => 'nullable|array',
            'module_ids.*' => 'exists:modules,id',
        ]);

        $enseignant->modules()->sync($request->module_ids ?? []);

        return redirect()->route('personnes.enseignants.show', $enseignant)->with('success', 'Modules assignés avec succès.');
    }
}