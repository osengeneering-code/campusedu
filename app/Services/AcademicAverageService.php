<?php

namespace App\Services;

use App\Models\Etudiant;
use App\Models\Evaluation;
use App\Models\Module;
use App\Models\Ue;
use App\Models\Semestre;
use App\Models\Note;

class AcademicAverageService
{
    /**
     * Normalizes a given note to a scale of 20 based on the evaluation type's bareme.
     *
     * @param float $note The obtained note.
     * @param float $bareme_evaluation_type The maximum score of the evaluation type.
     * @return float The normalized note on 20.
     */
    private function normalizeNoteTo20(float $note, float $bareme_evaluation_type): float
    {
        if ($bareme_evaluation_type == 0) {
            return 0.0; // Avoid division by zero
        }
        return ($note / $bareme_evaluation_type) * 20;
    }

    /**
     * Calculates the normalized score for a specific note within an evaluation.
     *
     * @param \App\Models\Note $note The student's note object.
     * @param \App\Models\Evaluation $evaluation The evaluation object.
     * @return float The normalized note on 20, or 0.0 if not calculable (absent, no note, etc.).
     */
    private function calculateEvaluationAverage(Note $note, Evaluation $evaluation): float
    {
        if ($note->est_absent || is_null($note->note_obtenue)) {
            return 0.0;
        }

        $evaluationType = $evaluation->evaluationType;

        if (!$evaluationType || $evaluationType->max_score === null) {
            // Log an error or throw an exception if the evaluation type or its bareme is missing
            // For now, return 0.0 as it's an uncalculable score.
            return 0.0;
        }

        return $this->normalizeNoteTo20($note->note_obtenue, $evaluationType->max_score);
    }

    /**
     * Calculates the average score for a specific module, student, and academic year.
     * The average is a simple average of normalized (on 20) notes from all evaluations within the module.
     *
     * @param \App\Models\Module $module
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @return float The average score for the module, or 0.0 if no valid notes are found.
     */
    public function getMoyenneModule(Module $module, Etudiant $etudiant, string $anneeAcademique): float
    {
        $normalizedNotesSum = 0.0;
        $notesCount = 0;

        // Eager load relationships for efficiency
        $evaluations = $module->evaluations()
                              ->where('annee_academique', $anneeAcademique)
                              ->with(['evaluationType', 'notes' => function ($query) use ($etudiant) {
                                  // Ensure we only get notes for the specific student via inscription_admin
                                  $query->whereHas('inscriptionAdmin', function ($q) use ($etudiant) {
                                      $q->where('id_etudiant', $etudiant->id);
                                  });
                              }])
                              ->get();

        foreach ($evaluations as $evaluation) {
            foreach ($evaluation->notes as $note) {
                // Ensure the note belongs to the correct inscriptionAdmin for the etudiant
                // (This check is implicitly handled by the whereHas above, but good for clarity)
                if ($note->inscriptionAdmin->id_etudiant === $etudiant->id) {
                    $normalizedNote = $this->calculateEvaluationAverage($note, $evaluation);
                    if ($normalizedNote > 0 || ($normalizedNote === 0.0 && !$note->est_absent && !is_null($note->note_obtenue))) {
                        $normalizedNotesSum += $normalizedNote;
                        $notesCount++;
                    }
                }
            }
        }

        if ($notesCount === 0) {
            return 0.0;
        }

        return round($normalizedNotesSum / $notesCount, 2);
    }


    /**
     * Calculates the weighted average score for a specific UE, student, and academic year.
     * Formula: sum(module.moyenne × module.coefficient) / sum(coefficients)
     *
     * @param \App\Models\Ue $ue
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @return float The weighted average score for the UE, or 0.0 if no valid modules or notes are found.
     */
    public function getMoyenneUE(Ue $ue, Etudiant $etudiant, string $anneeAcademique): float
    {
        $sumWeightedModuleAverages = 0.0;
        $sumCoefficients = 0;

        $modules = $ue->modules; // Get all modules for this UE

        foreach ($modules as $module) {
            $moduleAverage = $this->getMoyenneModule($module, $etudiant, $anneeAcademique);
            $moduleCoefficient = $module->coefficient ?? 1; // Default coefficient to 1 if not set

            // Only include modules with a valid average in the calculation
            if ($moduleAverage > 0 || ($moduleAverage === 0.0 && $this->moduleHasNotes($module, $etudiant, $anneeAcademique))) {
                 $sumWeightedModuleAverages += ($moduleAverage * $moduleCoefficient);
                 $sumCoefficients += $moduleCoefficient;
            }
        }

        if ($sumCoefficients === 0) {
            return 0.0;
        }

        return round($sumWeightedModuleAverages / $sumCoefficients, 2);
    }
    
    /**
     * Helper to check if a module has any valid notes for a given student and academic year.
     *
     * @param \App\Models\Module $module
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @return bool
     */
    private function moduleHasNotes(Module $module, Etudiant $etudiant, string $anneeAcademique): bool
    {
        return $module->evaluations()
                      ->where('annee_academique', $anneeAcademique)
                      ->whereHas('notes', function ($query) use ($etudiant) {
                          $query->where('note_obtenue', '!=', null)
                                ->where('est_absent', false)
                                ->whereHas('inscriptionAdmin', function ($q) use ($etudiant) {
                                    $q->where('id_etudiant', $etudiant->id);
                                });
                      })
                      ->exists();
    }

    /**
     * Calculates the weighted average score for a specific Semester, student, and academic year.
     * Formula: sum(moyenne_ue × coefficient_ue) / sum(coefficients_ue)
     *
     * @param \App\Models\Semestre $semestre
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @return float The weighted average score for the Semester, or 0.0 if no valid UEs or notes are found.
     */
    public function getMoyenneSemestre(Semestre $semestre, Etudiant $etudiant, string $anneeAcademique): float
    {
        $sumWeightedUeAverages = 0.0;
        $sumCoefficients = 0;

        $ues = $semestre->ues; // Get all UEs for this Semester

        foreach ($ues as $ue) {
            $ueAverage = $this->getMoyenneUE($ue, $etudiant, $anneeAcademique);
            $ueCoefficient = $ue->coefficient ?? 1; // Default coefficient to 1 if not set

            // Only include UEs with a valid average in the calculation
            if ($ueAverage > 0 || ($ueAverage === 0.0 && $this->ueHasNotes($ue, $etudiant, $anneeAcademique))) {
                $sumWeightedUeAverages += ($ueAverage * $ueCoefficient);
                $sumCoefficients += $ueCoefficient;
            }
        }

        if ($sumCoefficients === 0) {
            return 0.0;
        }

        return round($sumWeightedUeAverages / $sumCoefficients, 2);
    }
    
    /**
     * Helper to check if a UE has any valid notes for a given student and academic year.
     *
     * @param \App\Models\Ue $ue
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @return bool
     */
    /**
     * Helper to check if a UE has any valid notes for a given student and academic year.
     *
     * @param \App\Models\Ue $ue
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @return bool
     */
    private function ueHasNotes(Ue $ue, Etudiant $etudiant, string $anneeAcademique): bool
    {
        foreach ($ue->modules as $module) {
            if ($this->moduleHasNotes($module, $etudiant, $anneeAcademique)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Calculates the general average for a semester, determines validation status and assigns a mention.
     *
     * @param \App\Models\Semestre $semestre
     * @param \App\Models\Etudiant $etudiant
     * @param string $anneeAcademique
     * @param float $seuilValidation The minimum average required to validate the semester (e.g., 10.0).
     * @return array Contains 'moyenne_generale', 'validation', and 'mention'.
     */
    public function getGeneralSemesterAverageAndValidation(Semestre $semestre, Etudiant $etudiant, string $anneeAcademique, float $seuilValidation = 10.0): array
    {
        $moyenneGenerale = $this->getMoyenneSemestre($semestre, $etudiant, $anneeAcademique);

        $validation = ($moyenneGenerale >= $seuilValidation) ? 'Validé' : 'Non Validé';

        $mention = 'N/A';
        if ($moyenneGenerale >= 16) {
            $mention = 'Très Bien';
        } elseif ($moyenneGenerale >= 14) {
            $mention = 'Bien';
        } elseif ($moyenneGenerale >= 12) {
            $mention = 'Assez Bien';
        } elseif ($moyenneGenerale >= 10) {
            $mention = 'Passable';
        }

        return [
            'moyenne_generale' => $moyenneGenerale,
            'validation' => $validation,
            'mention' => $mention,
        ];
    }
}
