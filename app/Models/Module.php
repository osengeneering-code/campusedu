<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ue',
        'code_module',
        'libelle',
        'volume_horaire',
        'coefficient',
    ];

    public function ue()
    {
        return $this->belongsTo(Ue::class, 'id_ue');
    }

    public function cours()
    {
        return $this->hasMany(Cours::class, 'id_module');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'id_module');
    }

    public function inscriptionAdmins()
    {
        return $this->belongsToMany(InscriptionAdmin::class, 'inscription_pedagogique_module', 'id_module', 'id_inscription_admin');
    }

    public function enseignants()
    {
        return $this->belongsToMany(Enseignant::class, 'enseignant_module', 'module_id', 'enseignant_id');
    }

    /**
     * Calcule la moyenne générale de toutes les notes pour ce module sur une année académique donnée.
     * Prend en compte les coefficients des évaluations.
     *
     * @param string $anneeAcademique Ex: "2023-2024"
     * @return float|null La moyenne arrondie à 2 décimales, ou null si aucune note valide.
     */
    public function getMoyenneGenerale($anneeAcademique)
    {
        // Charger toutes les évaluations du module avec leurs notes et types d'évaluation
        $evaluations = $this->evaluations()
                            ->where('annee_academique', $anneeAcademique)
                            ->with('notes', 'evaluationType')
                            ->get();

        $sommeNotesCoeff = 0;
        $sommeCoefficients = 0;

        foreach ($evaluations as $evaluation) {
            // Coefficient de l'évaluation, en prenant en compte le type d'évaluation ou un défaut
            $coefficientEvaluation = $evaluation->coefficient ?? optional($evaluation->evaluationType)->coefficient ?? 1;

            foreach ($evaluation->notes as $note) {
                // S'assurer que la note existe, que l'étudiant n'est pas absent et que la note est numérique
                if (!$note->est_absent && is_numeric($note->note_obtenue)) {
                    $sommeNotesCoeff += $note->note_obtenue * $coefficientEvaluation;
                    $sommeCoefficients += $coefficientEvaluation;
                }
            }
        }

        if ($sommeCoefficients > 0) {
            return round($sommeNotesCoeff / $sommeCoefficients, 2);
        }

        return null; // Pas de notes valides trouvées pour ce module
    }
 }