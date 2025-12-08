<?php

namespace App\Http\Controllers;

use App\Models\Parcours;
use App\Models\Departement;
use App\Models\Filiere;
use Illuminate\Http\Request;
use Spatie\Permission\Middleware\PermissionMiddleware;

class ParcoursController extends Controller
{
    public function __construct()
    {
        // Retiré le middleware de permission pour gérer les frais
        $this->middleware(PermissionMiddleware::class . ':gerer_frais')->only(['store', 'update']);
    }

    public function index()
    {
        $parcours = Parcours::with('filiere.departement')->latest()->paginate(10);
        $departements = Departement::with(['filieres.parcours'])->get();

        return view('academique.parcours.index', compact('parcours', 'departements'));
    }

    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();
        return view('academique.parcours.create', compact('filieres'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'id_filiere' => 'required|exists:filieres,id',
            'description' => 'nullable|string',
            'frais_inscription' => 'required|numeric|min:0',
            'frais_formation' => 'required|numeric|min:0',
        ]);

        Parcours::create($request->all());

        return redirect()->route('academique.parcours.index')->with('success', 'Parcours créé avec succès.');
    }

    public function show(Parcours $parcour)
    {
        $parcour->load('filiere.departement', 'semestres');
        return view('academique.parcours.show', ['parcours' => $parcour]);
    }

    public function edit(Parcours $parcour)
    {
        $filieres = Filiere::orderBy('nom')->get();
        return view('academique.parcours.edit', ['parcours' => $parcour, 'filieres' => $filieres]);
    }

    public function update(Request $request, Parcours $parcour)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'id_filiere' => 'required|exists:filieres,id',
            'description' => 'nullable|string',
            'frais_inscription' => 'required|numeric|min:0',
            'frais_formation' => 'required|numeric|min:0',
        ]);

        $parcour->update($request->all());

        return redirect()->route('academique.parcours.index')->with('success', 'Parcours mis à jour avec succès.');
    }

    public function destroy(Parcours $parcour)
    {
        if ($parcour->inscriptionAdmins()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce parcours, des inscriptions y sont liées.');
        }

        $parcour->delete();
        return redirect()->route('academique.parcours.index')->with('success', 'Parcours supprimé avec succès.');
    }
}
