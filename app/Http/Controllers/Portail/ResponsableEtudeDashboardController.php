<?php

namespace App\Http\Controllers\Portail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ResponsableEtudeDashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return view('portails.responsable-etude.dashboard');
    }
}
