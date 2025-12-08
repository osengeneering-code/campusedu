<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'matricule',
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'adresse_postale',
        'email_perso',
        'telephone_perso',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function inscriptionAdmins()
    {
        return $this->hasMany(InscriptionAdmin::class, 'id_etudiant');
    }

    public function documents()
    {
        return $this->hasMany(DocumentEtudiant::class, 'id_etudiant');
    }

    /**
     * Calcule la moyenne de l'étudiant pour un module spécifique sur une année académique donnée.
     * Prend en compte les coefficients des évaluations.
     *
     * @param Module $module
     * @param string $anneeAcademique Ex: "2023-2024"
     * @return float|null La moyenne arrondie à 2 décimales, ou null si aucune note valide.
     */
    public function getMoyenneModule(Module $module, $anneeAcademique)
    {
        // 1. Trouver l'inscription administrative de l'étudiant pour l'année académique et le parcours du module
        // S'assurer que le module a bien les relations UE -> Semestre -> Parcours chargées
        $parcoursId = optional(optional(optional($module->ue)->semestre)->parcours)->id;
        if (!$parcoursId) {
            return null; // Impossible de déterminer le parcours du module
        }

        $inscriptionAdmin = $this->inscriptionAdmins()
                                 ->where('annee_academique', $anneeAcademique)
                                 ->where('id_parcours', $parcoursId)
                                 ->first();

        if (!$inscriptionAdmin) {
            return null; // L'étudiant n'est pas inscrit à ce parcours pour cette année
        }

        // 2. Charger les évaluations du module et les notes de l'étudiant pour ces évaluations
        // Assurez-vous que le modèle Module a une relation 'evaluations'
        $evaluations = $module->evaluations()
                               ->with(['notes' => function ($query) use ($inscriptionAdmin) {
                                   $query->where('id_inscription_admin', $inscriptionAdmin->id);
                               }])
                               ->get();

        $sommeNotesCoeff = 0;
        $sommeCoefficients = 0;

        foreach ($evaluations as $evaluation) {
            $noteEtudiant = $evaluation->notes->first(); // Il ne devrait y avoir qu'une seule note par étudiant par évaluation

            // S'assurer que la note existe, que l'étudiant n'est pas absent et que la note est numérique
            if ($noteEtudiant && !$noteEtudiant->est_absent && is_numeric($noteEtudiant->note_obtenue)) {
                // Utiliser le coefficient de l'évaluation si défini, sinon un par défaut (ex: 1)
                // Pourrait aussi être le coefficient défini sur le type d'évaluation
                $coefficientEvaluation = $evaluation->coefficient ?? optional($evaluation->evaluationType)->coefficient ?? 1;
                $sommeNotesCoeff += $noteEtudiant->note_obtenue * $coefficientEvaluation;
                $sommeCoefficients += $coefficientEvaluation;
            }
        }

        if ($sommeCoefficients > 0) {
            return round($sommeNotesCoeff / $sommeCoefficients, 2);
        }

        return null; // Pas de notes valides trouvées pour ce module et cet étudiant
    }

    /**
     * Calcule la moyenne de l'étudiant pour un conteneur (Semestre/UE/Filière/Parcours) donné
     * sur une année académique spécifique, en tenant compte des coefficients des modules.
     *
     * @param string $typeConteneur 'semestre', 'ue', 'filiere', 'parcours'
     * @param int $idConteneur L'ID du conteneur (Semestre, UE, Filière ou Parcours)
     * @param string $anneeAcademique Ex: "2023-2024"
     * @return float|null La moyenne arrondie à 2 décimales, ou null si aucune note valide.
     */
    public function getMoyenneConteneur(string $typeConteneur, int $idConteneur, string $anneeAcademique)
    {
        // 1. Trouver l'InscriptionAdmin de l'étudiant pour l'année académique donnée
        $inscriptionAdmin = $this->inscriptionAdmins()
                                 ->where('annee_academique', $anneeAcademique)
                                 ->first();

        if (!$inscriptionAdmin) {
            return null; // L'étudiant n'est pas inscrit pour cette année académique
        }

        $modules = collect(); // Collection des modules à inclure dans le calcul

        // Déterminer les modules pertinents selon le type de conteneur
        switch ($typeConteneur) {
            case 'semestre':
                $semestre = Semestre::find($idConteneur);
                if ($semestre) {
                    $semestre->loadMissing('ues.modules'); // Charger les relations nécessaires
                    $modules = $semestre->ues->flatMap(fn($ue) => $ue->modules);
                }
                break;
            case 'ue':
                $ue = Ue::find($idConteneur);
                if ($ue) {
                    $ue->loadMissing('modules'); // Charger les relations nécessaires
                    $modules = $ue->modules;
                }
                break;
            case 'filiere':
                $filiere = Filiere::find($idConteneur);
                if ($filiere) {
                    $filiere->loadMissing('parcours.semestres.ues.modules'); // Charger les relations nécessaires
                    $modules = $filiere->parcours->flatMap(fn($parcours) => $parcours->semestres)
                                       ->flatMap(fn($semestre) => $semestre->ues)
                                       ->flatMap(fn($ue) => $ue->modules);
                }
                break;
            case 'parcours':
                $parcours = Parcours::find($idConteneur);
                if ($parcours) {
                    $parcours->loadMissing('semestres.ues.modules'); // Charger les relations nécessaires
                    $modules = $parcours->semestres->flatMap(fn($semestre) => $semestre->ues)
                                       ->flatMap(fn($ue) => $ue->modules);
                }
                break;
            default:
                return null; // Type de conteneur non reconnu
        }
        
        if ($modules->isEmpty()) {
            return null; // Aucun module trouvé pour ce conteneur
        }

        $sommeMoyennesModulesCoeff = 0;
        $sommeCoefficientsModules = 0;

        foreach ($modules as $module) {
            // S'assurer que le module a la relation ue.semestre.parcours chargée pour la méthode getMoyenneModule
            $module->loadMissing('ue.semestre.parcours');
            $moyenneModuleEtudiant = $this->getMoyenneModule($module, $anneeAcademique);

            if (is_numeric($moyenneModuleEtudiant)) {
                $coefficientModule = $module->coefficient ?? 1; // Coefficient du module, ou 1 par défaut
                $sommeMoyennesModulesCoeff += $moyenneModuleEtudiant * $coefficientModule;
                $sommeCoefficientsModules += $coefficientModule;
            }
        }

        if ($sommeCoefficientsModules > 0) {
            return round($sommeMoyennesModulesCoeff / $sommeCoefficientsModules, 2);
        }

        return null; // Pas de moyenne valide trouvée pour ce conteneur
    }
}
