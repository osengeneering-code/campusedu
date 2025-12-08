<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user->hasRole('etudiant')) {
            $home = route('portail.etudiant.dashboard');
        } elseif ($user->hasRole('enseignant')) {
            $home = route('portail.enseignant.dashboard');
        } elseif ($user->hasRole('secretaire')) {
            $home = route('portail.secretaire.dashboard');
        } elseif ($user->hasRole('responsable_stage')) {
            $home = route('portail.responsable_stage.dashboard');
        } elseif ($user->hasRole('responsable_etude')) {
            $home = route('portail.responsable_etude.dashboard');
        } elseif ($user->hasRole('comptable')) {
            $home = route('portail.comptable.dashboard');
        } elseif ($user->hasRole('directeur_general')) {
            $home = route('portail.directeur_general.dashboard');
        } elseif ($user->hasRole('admin')) {
            $home = route('portail.admin.dashboard');
        } else {
            $home = route('dashboard'); // Fallback pour les rôles inconnus
        }

        return $request->wantsJson()
                    ? new JsonResponse(['two_factor' => false], 200)
                    : redirect()->intended($home);
    }
}
