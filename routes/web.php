<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\FaculteController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\FiliereController;
use App\Http\Controllers\ParcoursController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\UeController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\EnseignantController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\InscriptionAdminController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\ConventionStageController;
use App\Http\Controllers\SoutenanceController;
use App\Http\Controllers\DocumentEtudiantController;
use App\Http\Controllers\EnseignantModuleController;
use App\Http\Controllers\EvaluationTypeController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use Spatie\Permission\Middleware\PermissionMiddleware;
use App\Models\Etudiant;
use App\Models\Enseignant;
use App\Models\Cours;
use App\Http\Controllers\PortailController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

// --- Routes de Candidature Publiques (accessibles aux non-authentifiés) ---
Route::prefix('inscriptions')->name('inscriptions.')->group(function () {
    Route::get('candidatures/create', [CandidatureController::class, 'create'])->name('candidatures.create');
    Route::post('candidatures', [CandidatureController::class, 'store'])->name('candidatures.store');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/profil', [UserController::class, 'profil'])->name('profil.show');

    // --- Messagerie ---
    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/create/{recipient_id?}', [ConversationController::class, 'create'])->name('conversations.create');
    Route::post('/conversations', [ConversationController::class, 'store'])->name('conversations.store');
    Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])->name('conversations.show');
    Route::post('conversations/{conversation}/messages', [MessageController::class, 'store'])->name('messages.store');

    Route::get('/dashboard', [PortailController::class, 'index'])->name('dashboard');

    // Routes portail avec middleware role pour sécuriser
    Route::prefix('portail')->name('portail.')->middleware('auth')->group(function () {
        Route::get('/enseignant/mes-modules', [PortailController::class, 'mesModules'])
            ->name('enseignant.mes-modules')->middleware('role:enseignant');
        Route::get('/enseignant/{enseignant}/etudiant/{etudiant}/bilan', [PortailController::class, 'showEtudiantBilan'])
            ->name('enseignant.etudiant-bilan')->middleware('role:enseignant');
    });

    // --- Administration & Sécurité (protégé par le rôle admin) ---
    Route::middleware('role:admin')->group(function() {
        Route::resource('settings', SettingController::class);
        Route::resource('users', UserController::class);
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::put('users/{user}/update-password', [UserController::class, 'updatePassword'])->name('users.updatePassword');
        Route::resource('roles', RoleController::class);
        Route::resource('activitylogs', ActivityLogController::class)->only(['index', 'show']);
        Route::get('/parametre', [HomeController::class, 'parametre'])->name('parametre');
    });

    // --- Structure Pédagogique ---
    Route::prefix('academique')->name('academique.')->middleware(PermissionMiddleware::class . ':gerer_structure_pedagogique')->group(function () {
        Route::resource('facultes', FaculteController::class);
        Route::resource('departements', DepartementController::class);
        Route::resource('filieres', FiliereController::class);
        Route::resource('parcours', ParcoursController::class);
        Route::resource('semestres', SemestreController::class);
        Route::resource('ues', UeController::class);
        Route::resource('modules', ModuleController::class);
        Route::resource('salles', SalleController::class);
        Route::resource('evaluation-types', EvaluationTypeController::class);
    });

    // --- Personnes ---
    Route::prefix('personnes')->name('personnes.')->group(function () {
        Route::resource('enseignants', EnseignantController::class)->middleware(PermissionMiddleware::class . ':gerer_enseignants');
        Route::get('enseignants/{enseignant}/modules', [EnseignantModuleController::class, 'index'])->name('enseignants.modules.index')->middleware(PermissionMiddleware::class . ':gerer_enseignants');
        Route::post('enseignants/{enseignant}/modules', [EnseignantModuleController::class, 'store'])->name('enseignants.modules.store')->middleware(PermissionMiddleware::class . ':gerer_enseignants');
        Route::resource('etudiants', EtudiantController::class)->middleware(PermissionMiddleware::class . ':lister_etudiants|creer_etudiant|modifier_etudiant');
        Route::post('etudiants/{etudiant}/initier-inscription', [EtudiantController::class, 'initierInscription'])->name('etudiants.initierInscription')->middleware(PermissionMiddleware::class . ':gerer_inscriptions');
        Route::get('etudiants/{etudiant}/export-pdf', [EtudiantController::class, 'exportPdf'])->name('etudiants.exportPdf')->middleware(PermissionMiddleware::class . ':lister_etudiants');
        Route::resource('etudiants.documents', DocumentEtudiantController::class)->shallow()->middleware(PermissionMiddleware::class . ':gerer_etudiants');
    });

    // --- Admissions & Inscriptions (reste des routes protégées) ---
    Route::prefix('inscriptions')->name('inscriptions.')->middleware(PermissionMiddleware::class . ':gerer_inscriptions|gerer_candidatures')->group(function () {
        Route::get('candidatures', [CandidatureController::class, 'index'])->name('candidatures.index');
        Route::get('candidatures/{candidature}', [CandidatureController::class, 'show'])->name('candidatures.show');
        Route::get('candidatures/{candidature}/edit', [CandidatureController::class, 'edit'])->name('candidatures.edit');
        Route::put('candidatures/{candidature}', [CandidatureController::class, 'update'])->name('candidatures.update');
        Route::delete('candidatures/{candidature}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
        Route::post('candidatures/{candidature}/validate', [CandidatureController::class, 'validateCandidature'])->name('candidatures.validate');
        Route::post('candidatures/{candidature}/reject', [CandidatureController::class, 'rejectCandidature'])->name('candidatures.reject');
        Route::resource('inscription-admins', InscriptionAdminController::class);
    });

    // --- Gestion des Cours & Evaluations ---
    Route::prefix('gestion-cours')->name('gestion-cours.')->group(function () {
        Route::resource('cours', CoursController::class)->middleware(PermissionMiddleware::class . ':gerer_emplois_du_temps');
        Route::get('emplois-du-temps', [CoursController::class, 'index'])->name('emplois-du-temps')->middleware(PermissionMiddleware::class . ':consulter_son_emploi_du_temps');
        Route::get('evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::post('evaluations', [EvaluationController::class, 'store'])->name('evaluations.store')->middleware('permission:creer_evaluations');
        Route::get('evaluations/create', [EvaluationController::class, 'create'])->name('evaluations.create')->middleware('permission:creer_evaluations');
        Route::get('evaluations/{evaluation}', [EvaluationController::class, 'show'])->name('evaluations.show');
        Route::get('evaluations/{evaluation}/edit', [EvaluationController::class, 'edit'])->name('evaluations.edit');
        Route::put('evaluations/{evaluation}', [EvaluationController::class, 'update'])->name('evaluations.update');
        Route::patch('evaluations/{evaluation}', [EvaluationController::class, 'update']);
        Route::delete('evaluations/{evaluation}', [EvaluationController::class, 'destroy'])->name('evaluations.destroy')->middleware(PermissionMiddleware::class . ':gerer_structure_pedagogique');
        Route::get('evaluations/{evaluation}/notes/fill', [NoteController::class, 'fill'])->name('evaluations.notes.fill')->middleware('permission:saisir_notes');
        Route::put('evaluations/{evaluation}/notes', [NoteController::class, 'update'])->name('evaluations.notes.store')->middleware('permission:saisir_notes');
    });

    // --- Stages & Entreprises ---
    Route::prefix('stages')->name('stages.')->group(function () {
        Route::middleware(PermissionMiddleware::class . ':gerer_stages')->group(function () {
            Route::resource('entreprises', EntrepriseController::class);
            Route::resource('conventions', ConventionStageController::class);
            Route::resource('soutenances', SoutenanceController::class);
            Route::get('stages/create', [StageController::class, 'create'])->name('stages.create');
            Route::post('stages', [StageController::class, 'store'])->name('stages.store');
            Route::get('stages/{stage}/edit', [StageController::class, 'edit'])->name('stages.edit');
            Route::put('stages/{stage}', [StageController::class, 'update'])->name('stages.update');
            Route::patch('stages/{stage}', [StageController::class, 'update']);
            Route::delete('stages/{stage}', [StageController::class, 'destroy'])->name('stages.destroy');
        });

        Route::get('stages', [StageController::class, 'index'])->name('stages.index')->middleware(PermissionMiddleware::class . ':suivre_stages_tuteur');
        Route::get('stages/{stage}', [StageController::class, 'show'])->name('stages.show')->middleware(PermissionMiddleware::class . ':suivre_stages_tuteur');
    });
    
    // --- Gestion Financière ---
    Route::resource('paiements', PaiementController::class)->middleware(PermissionMiddleware::class . ':gerer_paiements');
    Route::get('paiements/{paiement}/receipt', [PaiementController::class, 'receipt'])->name('paiements.receipt')->middleware(PermissionMiddleware::class . ':consulter_ses_paiements');

    // --- Gestion des Bulletins ---
    Route::prefix('bulletins')->name('bulletins.')->middleware(PermissionMiddleware::class . ':gerer_bulletins')->group(function () {
        Route::get('trimestriel', function () {
            return 'Page des Bulletins Trimestriels';
        })->name('trimestriel.index');
        Route::get('semestriel', function () {
            return 'Page des Bulletins Semestriels';
        })->name('semestriel.index');
        Route::get('annuel', function () {
            return 'Page des Bulletins Annuels';
        })->name('annuel.index');
    });

    Route::get('gestion-cours/emploi-du-temps/pdf', [CoursController::class, 'downloadPdf'])->name('emplois-du-temps.pdf');

});

Route::group(['middleware' => ['auth', 'role:etudiant'], 'prefix' => 'etudiant', 'as' => 'etudiant.'], function () {
    Route::get('dossier', [\App\Http\Controllers\EtudiantPortailController::class, 'dossier'])->name('dossier');
    Route::get('notes', [\App\Http\Controllers\EtudiantPortailController::class, 'notes'])->name('notes');
    Route::get('stage', [\App\Http\Controllers\EtudiantPortailController::class, 'stage'])->name('stage');
    Route::get('mon-parcours', [\App\Http\Controllers\EtudiantPortailController::class, 'monParcours'])->name('mon-parcours');
    Route::post('stage/{stage}/submit-report', [\App\Http\Controllers\StageController::class, 'submitReport'])->name('stage.submit_report');
    Route::get('emploi-du-temps', [\App\Http\Controllers\EtudiantPortailController::class, 'emploi_du_temps'])->name('emploi_du_temps');
    Route::get('paiements', [\App\Http\Controllers\PaiementController::class, 'index'])->name('paiements');
    Route::get('semestres/{anneeAcademique}/{semestreId}/resultats', [\App\Http\Controllers\EtudiantPortailController::class, 'semestreResultats'])->name('semestre-resultats');
});
