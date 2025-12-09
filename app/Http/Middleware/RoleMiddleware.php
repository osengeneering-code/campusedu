<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Utilisateur non connecté
        if (!Auth::check()) {
            return redirect()->route('login_form');
        }

        $user = Auth::user();

        // Vérifie si l'utilisateur possède au moins un des rôles demandés
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        // Si aucun rôle ne correspond → accès interdit
        abort(403, "Accès non autorisé.");
    }
}
