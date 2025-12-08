<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Enseignant;
use App\Models\Ue;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ModuleController extends Controller
{
    

    public function index()
    {
        $modules = Module::with('ue.semestre.parcours')->latest()->paginate(15);
        return view('academique.modules.index', compact('modules'));
    }

    public function create()
    {
        $ues = Ue::with('semestre.parcours')->get();
        $enseignants = Enseignant::all();
        return view('academique.modules.create', compact('ues', 'enseignants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'code_module' => 'required|string|max:20|unique:modules,code_module',
            'id_ue' => 'required|exists:ues,id',
            'volume_horaire' => 'required|numeric|min:0',
            'coefficient' => 'required|numeric|min:0',
            'enseignant_ids' => 'nullable|array',
            'enseignant_ids.*' => 'exists:enseignants,id',
        ]);

        $module = Module::create($request->all());

        if ($request->has('enseignant_ids')) {
            $module->enseignants()->sync($request->input('enseignant_ids', []));
        }

        return redirect()->route('academique.modules.index')->with('success', 'Module créé avec succès.');
    }

    public function show(Module $module)
    {
        $module->load('ue.semestre.parcours.filiere.departement', 'enseignants');
        return view('academique.modules.show', compact('module'));
    }

    public function edit(Module $module)
    {
        $ues = Ue::with('semestre.parcours')->get();
        $enseignants = Enseignant::all();
        $module->load('enseignants');
        return view('academique.modules.edit', compact('module', 'ues', 'enseignants'));
    }

    public function update(Request $request, Module $module)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
            'code_module' => ['required', 'string', 'max:20', Rule::unique('modules')->ignore($module->id)],
            'id_ue' => 'required|exists:ues,id',
            'volume_horaire' => 'required|numeric|min:0',
            'coefficient' => 'required|numeric|min:0',
            'enseignant_ids' => 'nullable|array',
            'enseignant_ids.*' => 'exists:enseignants,id',
        ]);

        $module->update($request->all());

        if ($request->has('enseignant_ids')) {
            $module->enseignants()->sync($request->enseignant_ids);
        } else {
            $module->enseignants()->detach();
        }

        return redirect()->route('academique.modules.index')->with('success', 'Module mis à jour avec succès.');
    }

    public function destroy(Module $module)
    {
        if ($module->cours()->exists() || $module->evaluations()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce module, des cours ou des évaluations y sont rattachés.');
        }

        $module->delete();
        return redirect()->route('academique.modules.index')->with('success', 'Module supprimé avec succès.');
    }
}

