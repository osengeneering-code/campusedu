<?php

namespace App\Providers;

use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\Damage;
use App\Models\Entreprise;
use App\Models\Invoice;
use App\Models\MaintenanceRecord;
use App\Models\Payment;
use App\Models\Partenaire;
use App\Models\Contrat;
use App\Models\SignalementPanneResponse; // Added
use App\Models\Accident; // Added
use App\Models\Stage; // Added
use App\Policies\ActivityLogPolicy;
use App\Policies\ClientPolicy;
use App\Policies\DamagePolicy;
use App\Policies\EntreprisePolicy;
use App\Policies\InvoicePolicy;
use App\Policies\MaintenanceRecordPolicy;
use App\Policies\PaymentPolicy;
use App\Policies\PartenairePolicy;
use App\Policies\ContratPolicy;
use App\Policies\SignalementPanneResponsePolicy; // Added
use App\Policies\AccidentPolicy; // Added
use App\Policies\StagePolicy; // Added
use App\Models\Reservation;
use App\Policies\ReservationPolicy;

use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\SignalementPannePolicy; // Import SignalementPannePolicy
use App\Policies\UserPolicy;
use App\Policies\VehiclePhotoPolicy;
use App\Policies\VehiclePolicy;
use App\Policies\VehicleTypePolicy;
use App\Models\Evaluation; // Added
use App\Policies\EvaluationPolicy; // Added
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate; // Added

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Vehicle::class => VehiclePolicy::class,
        Client::class => ClientPolicy::class,
        Accident::class => AccidentPolicy::class,
        SignalementPanneResponse::class => SignalementPanneResponsePolicy::class,
        Reservation::class => ReservationPolicy::class,

        Contrat::class => ContratPolicy::class,
        Invoice::class => InvoicePolicy::class,
        Role::class => RolePolicy::class,
        // User::class => User::class, // Removed
        Entreprise::class => EntreprisePolicy::class,
        ActivityLog::class => ActivityLogPolicy::class,
        Setting::class => SettingPolicy::class,
        Damage::class => DamagePolicy::class,
        MaintenanceRecord::class => MaintenanceRecordPolicy::class,
        Payment::class => PaymentPolicy::class,
        VehicleType::class => VehicleTypePolicy::class,
        VehiclePhoto::class => VehiclePhotoPolicy::class,
        Partenaire::class => PartenairePolicy::class,
        SignalementPanne::class => SignalementPannePolicy::class, // Register SignalementPannePolicy
        Evaluation::class => EvaluationPolicy::class, // Added
        Stage::class => StagePolicy::class, // Added
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Implicitly grant "Super Admin" role all permissions
        // This works in the all permission-related gates and directives
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });
    }
}
