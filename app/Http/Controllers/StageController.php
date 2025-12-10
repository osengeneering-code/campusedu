<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\InscriptionAdmin;
use App\Models\Entreprise;
use App\Models\Enseignant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StageController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $query = Stage::with('inscriptionAdmin.etudiant', 'entreprise', 'enseignant');

        if (auth()->user()->hasRole('enseignant')) {
            $query->where('id_enseignant_tuteur', auth()->user()->enseignant->id);
        }
        if (auth()->user()->hasRole('etudiant')) {
            $etudiantId = auth()->user()->etudiant->id;
            $query->whereHas('inscriptionAdmin', function ($q) use ($etudiantId) {
                $q->where('id_etudiant', $etudiantId);
            });
        }
        
        $stages = $query->latest()->paginate(10);
        return view('stages.stages.index', compact('stages'));
    }

    public function create()
    {
        $this->authorize('create', Stage::class);
        $inscriptions = InscriptionAdmin::with('etudiant')->doesntHave('stages')->get();
        $entreprises = Entreprise::orderBy('nom_entreprise')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        return view('stages.stages.create', compact('inscriptions', 'entreprises', 'enseignants'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Stage::class);
        $request->validate([
            'id_inscription_admin' => 'required|exists:inscription_admins,id|unique:stages,id_inscription_admin',
            'id_entreprise' => 'required|exists:entreprises,id',
            'id_enseignant_tuteur' => 'required|exists:enseignants,id',
            'sujet_stage' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'nom_tuteur_entreprise' => 'nullable|string|max:255',
        ]);

        Stage::create($request->all());

        return redirect()->route('stages.stages.index')->with('success', 'Stage créé avec succès.');
    }

    public function show(Stage $stage)
    {
        $this->authorize('view', $stage);
        $stage->load('inscriptionAdmin.etudiant', 'entreprise', 'enseignant', 'convention', 'soutenance');
        return view('stages.stages.show', compact('stage'));
    }

    public function edit(Stage $stage)
    {
        $this->authorize('update', $stage);
        $inscriptions = InscriptionAdmin::with('etudiant')->get();
        $entreprises = Entreprise::orderBy('nom_entreprise')->get();
        $enseignants = Enseignant::orderBy('nom')->get();
        return view('stages.stages.edit', compact('stage', 'inscriptions', 'entreprises', 'enseignants'));
    }

    public function update(Request $request, Stage $stage)
    {
        $this->authorize('update', $stage);
        $request->validate([
            'id_inscription_admin' => ['required','exists:inscription_admins,id', Rule::unique('stages')->ignore($stage->id)],
            'id_entreprise' => 'required|exists:entreprises,id',
            'id_enseignant_tuteur' => 'required|exists:enseignants,id',
            'sujet_stage' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after_or_equal:date_debut',
            'statut_validation' => ['required', Rule::in(['En attente', 'Validé par tuteur', 'Validé par admin', 'Refusé'])],
        ]);

        $stage->update($request->all());

        return redirect()->route('stages.stages.index')->with('success', 'Stage mis à jour avec succès.');
    }
    
    public function destroy(Stage $stage)
    {
        $this->authorize('delete', $stage);
        $stage->convention()->delete();
        $stage->soutenance()->delete();
        $stage->delete();

        return redirect()->route('stages.stages.index')->with('success', 'Stage supprimé avec succès.');
    }

    public function submitReport(Request $request, Stage $stage)
    {
        $request->validate([
            'rapport' => 'required|file|mimes:pdf|max:10240', // Max 10MB PDF
        ]);

        // Authorization: Ensure the logged-in user is the student associated with this stage
        $this->authorize('view', $stage);

        // Store the file
        $path = $request->file('rapport')->store('rapports', 'public');

        // Update the stage record
        $stage->update([
            'rapport_path' => $path,
            'statut_rapport' => 'soumis',
        ]);

        return back()->with('success', 'Votre rapport a été soumis avec succès.');
    }
}

