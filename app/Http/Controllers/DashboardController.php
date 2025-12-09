<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $roleRoutes = [
            'admin' => 'dashboards.admin.dashboard',
            // 'etudiant' => 'dashboards.etudiant.dashboard',
            'enseignant' => 'dashboards.enseignant.dashboard',
            'secretaire' => 'dashboards.secretaire.dashboard',
            'responsable-stage' => 'dashboards.responsable_stage.dashboard',
            'responsable-etude' => 'dashboards.responsable_etude.dashboard',
            'comptable' => 'dashboards.comptable.dashboard',
            'directeur-general' => 'dashboards.directeur_general.dashboard',
        ];

        foreach ($roleRoutes as $role => $routeName) {
            if ($user->hasRole($role)) {
                return redirect()->route($routeName);
            }
        }

        // Fallback if no specific role is matched
        // This should ideally not be reached if all roles are covered
        // or a default dashboard exists for unhandled roles.
        // For now, redirect to a generic home or login
        return redirect()->route('login_form');
    }
}