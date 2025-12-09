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
        // The intended URL is the one the user was trying to access before being
        // forced to login. If it doesn't exist, we redirect to the main dashboard route.
        // The PortailController, which is robust, will then handle the final role-based redirection.
        $home = route('dashboard');

        return $request->wantsJson()
                    ? new JsonResponse(['two_factor' => false], 200)
                    : redirect($home);
    }
}
