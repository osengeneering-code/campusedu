<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Departement;
use App\Models\Niveau; // Import du modèle Niveau
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Middleware\PermissionMiddleware; // Import du middleware de permission
use Illuminate\Support\Facades\DB; // Pour les transactions

class FiliereController extends Controller
{
    public function __construct()
    {
        // $this->middleware(PermissionMiddleware::class . ':gerer_frais')->only(['create', 'edit', 'store', 'update']);
    }

    public function index()
    {
        $filieres = Filiere::with('departement')->latest()->get();
        return view('academique.filieres.index', compact('filieres'));
    }

    public function create()
    {
        $departements = Departement::orderBy('nom')->get();
        return view('academique.filieres.create', compact('departements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'id_departement' => 'required|exists:departements,id',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['nom', 'id_departement', 'description']);

            if ($request->hasFile('image_path')) {
                $path = $request->file('image_path')->store('public/filiere_banners');
                $data['image_path'] = Storage::url($path);
            }

            Filiere::create($data);

            DB::commit();
            return redirect()->route('academique.filieres.index')->with('success', 'Filière créée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création de la filière : ' . $e->getMessage())->withInput();
        }
    }

    public function show(Filiere $filiere)
    {
        $filiere->load('departement', 'parcours'); // Charger les relations
        return view('academique.filieres.show', compact('filiere'));
    }

    public function edit(Filiere $filiere)
    {
        $departements = Departement::orderBy('nom')->get();
        return view('academique.filieres.edit', compact('filiere', 'departements'));
    }

    public function update(Request $request, Filiere $filiere)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'id_departement' => 'required|exists:departements,id',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $data = $request->only(['nom', 'id_departement', 'description']);

            if ($request->hasFile('image_path')) {
                // Supprimer l'ancienne image si elle existe
                if ($filiere->image_path) {
                    Storage::delete(str_replace('/storage', 'public', $filiere->image_path));
                }

                $path = $request->file('image_path')->store('public/filiere_banners');
                $data['image_path'] = Storage::url($path);
            }

            $filiere->update($data);

            DB::commit();
            return redirect()->route('academique.filieres.index')->with('success', 'Filière mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour de la filière : ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Filiere $filiere)
    {
        if ($filiere->parcours()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette filière, des parcours y sont liés.');
        }

        // Supprimer l'image associée
        if ($filiere->image_path) {
            Storage::delete(str_replace('/storage', 'public', $filiere->image_path));
        }

        $filiere->delete();
        return redirect()->route('academique.filieres.index')->with('success', 'Filière supprimée avec succès.');
    }
}
