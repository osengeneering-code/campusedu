<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Filiere;
use App\Models\Parcours;
use App\Models\Departement;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Routes API pour le chargement dynamique des filtres de bulletins
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/filieres-by-departement/{departement}', function (Departement $departement) {
        return response()->json($departement->filieres);
    });

    Route::get('/parcours-by-filiere/{filiere}', function (Filiere $filiere) {
        return response()->json($filiere->parcours);
    });
});
