<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Evaluation;
use App\Services\AcademicService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;

    protected $academicService;

    public function __construct(AcademicService $academicService)
    {
        $this->academicService = $academicService;
    }

    /**
     * Affiche le formulaire pour saisir ou éditer les notes d'une évaluation spécifique.
     * @param Evaluation $evaluation
     * @return \Illuminate\View\View
     */
    public function fill(Evaluation $evaluation)
    {
        $this->authorize('fillNotes', $evaluation);

        $etudiantsInscrits = $this->academicService->getEnrolledStudentsForEvaluation($evaluation);

        if ($etudiantsInscrits->isEmpty()) {
            // Optionnel : retourner une information si aucun étudiant n'est trouvé
            // pour éviter une vue vide sans explication.
            // return back()->with('info', 'Aucun étudiant inscrit à ce parcours pour cette année académique.');
        }

        $notesExistantes = Note::where('id_evaluation', $evaluation->id)
                                ->pluck('note_obtenue', 'id_inscription_admin');
        
        $notesAppreciationsExistantes = Note::where('id_evaluation', $evaluation->id)
                                             ->pluck('appreciation', 'id_inscription_admin');

        $absentsExistants = Note::where('id_evaluation', $evaluation->id)
                                ->where('est_absent', true)
                                ->pluck('est_absent', 'id_inscription_admin');

        return view('academique.notes.fill', compact('evaluation', 'etudiantsInscrits', 'notesExistantes', 'notesAppreciationsExistantes', 'absentsExistants'));
    }

    /**
     * Met à jour les notes d'une évaluation spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Evaluation  $evaluation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        $this->authorize('fillNotes', $evaluation); // Utiliser la même autorisation pour l'accès

        // Validation des données soumises
        $request->validate([
            'notes' => 'required|array',
            'notes.*.id_inscription_admin' => 'required|exists:inscription_admins,id',
            'notes.*.note_obtenue' => 'nullable|numeric|min:0|max:' . ($evaluation->evaluationType->max_score ?? 20),
            'notes.*.appreciation' => 'nullable|string|max:255',
            'notes.*.est_absent' => 'boolean',
        ]);

        foreach ($request->notes as $noteData) {
            $idInscriptionAdmin = $noteData['id_inscription_admin'];
            $existingNote = Note::firstOrNew([
                'id_evaluation' => $evaluation->id,
                'id_inscription_admin' => $idInscriptionAdmin
            ]);

            // Logique "enseignant ne peut pas modifier un relevé de note"
            if (Auth::user()->hasRole('enseignant')) {
                if ($existingNote->exists && $existingNote->note_obtenue !== null && $existingNote->note_obtenue !== $noteData['note_obtenue']) {
                    return back()->with('error', 'Vous n\'êtes pas autorisé à modifier une note déjà remplie.')->withInput();
                }
                if ($existingNote->exists && !$existingNote->est_absent && ($noteData['est_absent'] ?? false)) {
                     return back()->with('error', 'Vous n\'êtes pas autorisé à marquer absent un étudiant déjà noté.')->withInput();
                }
            }

            $existingNote->note_obtenue = $noteData['note_obtenue'];
            $existingNote->appreciation = $noteData['appreciation'] ?? null;
            $existingNote->est_absent = $noteData['est_absent'] ?? false;
            $existingNote->save();
        }

        return redirect()->route('academique.evaluations.show', $evaluation)->with('success', 'Notes enregistrées avec succès !');
    }
}
