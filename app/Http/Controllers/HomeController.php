<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class HomeController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $role = $user->getRoleNames()->first();

            return match($role) {
                'admin' => view('dashboards.admin'),
                'enseignant' => view('dashboards.enseignant'),
                'etudiant' => view('dashboards.etudiant'),
                
                default => view('dashboards.default'), // Fallback view
            };
        }

        return redirect('/login'); // Rediriger vers la page de connexion si non authentifié
    }

    public function parametre()
    {
        $this->authorize('voir-parametres-generaux');
        return view('parametre');
    }
}
