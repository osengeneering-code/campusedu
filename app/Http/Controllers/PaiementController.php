<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\InscriptionAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PDF;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PaiementController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // Construction de la requête de base
        $query = Paiement::with('inscriptionAdmin.etudiant');

        // Filtrage pour les étudiants
        if (auth()->user()->hasRole('etudiant')) {
            $etudiantId = auth()->user()->etudiant->id;
            $query->whereHas('inscriptionAdmin', function ($q) use ($etudiantId) {
                $q->where('id_etudiant', $etudiantId);
            });
        }
        
        // Récupération des paiements paginés
        $paiements = $query->latest()->paginate(10);
        
        // Statistiques
        $baseQuery = auth()->user()->hasRole('etudiant') 
            ? Paiement::whereHas('inscriptionAdmin', function ($q) use ($etudiantId) {
                $q->where('id_etudiant', $etudiantId);
            })
            : Paiement::query();
        
        $stats = [
            'total_paiements' => $baseQuery->sum('montant'),
            'paiements_payes' => (clone $baseQuery)->where('statut_paiement', 'Payé')->count(),
            'paiements_en_attente' => (clone $baseQuery)->where('statut_paiement', '!=', 'Payé')->count(),
            'taux_recouvrement' => $baseQuery->count() > 0 
                ? ((clone $baseQuery)->where('statut_paiement', 'Payé')->count() / $baseQuery->count() * 100)
                : 0
        ];
        
        // Données pour graphiques - Évolution mensuelle (CORRIGÉ)
        $evolutionData = (clone $baseQuery)
            ->selectRaw('MONTH(date_paiement) as mois_num, DATE_FORMAT(date_paiement, "%b") as mois, SUM(montant) as total')
            ->whereYear('date_paiement', date('Y'))
            ->groupBy('mois_num', 'mois')
            ->orderBy('mois_num')
            ->get();
        
        // Répartition par type de frais
        $typesData = (clone $baseQuery)
            ->selectRaw('type_frais, COUNT(*) as nombre')
            ->groupBy('type_frais')
            ->get();
        
        // Top 10 étudiants (uniquement pour admin)
        $topEtudiants = [];
        if (!auth()->user()->hasRole('etudiant')) {
            $topEtudiants = Paiement::with('inscriptionAdmin.etudiant')
                ->selectRaw('inscription_admins.id_etudiant, SUM(paiements.montant) as total')
                ->join('inscription_admins', 'paiements.id_inscription_admin', '=', 'inscription_admins.id')
                ->groupBy('inscription_admins.id_etudiant')
                ->orderByDesc('total')
                ->limit(10)
                ->get()
                ->map(function($item) {
                    $etudiant = \App\Models\Etudiant::find($item->id_etudiant);
                    return [
                        'nom' => $etudiant ? $etudiant->nom . ' ' . $etudiant->prenom : 'N/A',
                        'total' => $item->total
                    ];
                });
        }
        
        // Répartition par statut
        $statutsData = (clone $baseQuery)
            ->selectRaw('statut_paiement, COUNT(*) as nombre')
            ->groupBy('statut_paiement')
            ->get();
        
        // Préparation des données pour les graphiques
        $chartData = [
            'evolution' => [
                'labels' => $evolutionData->pluck('mois')->toArray(),
                'data' => $evolutionData->pluck('total')->toArray()
            ],
            'types' => [
                'labels' => $typesData->pluck('type_frais')->toArray(),
                'data' => $typesData->pluck('nombre')->toArray()
            ],
            'topEtudiants' => [
                'labels' => $topEtudiants ? collect($topEtudiants)->pluck('nom')->toArray() : [],
                'data' => $topEtudiants ? collect($topEtudiants)->pluck('total')->toArray() : []
            ],
            'statuts' => [
                'labels' => $statutsData->pluck('statut_paiement')->toArray(),
                'data' => $statutsData->pluck('nombre')->toArray()
            ]
        ];
        
        return view('financier.paiements.index', compact('paiements', 'stats', 'chartData'));
    }

    public function create()
    {
        $inscriptions = InscriptionAdmin::with('etudiant')->get();
        $typesFrais = ['Inscription', 'Scolarité', 'Autre'];
        $methodesPaiement = ['Carte bancaire', 'Virement', 'Chèque', 'Espèces'];
        return view('financier.paiements.create', compact('inscriptions', 'typesFrais', 'methodesPaiement'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_inscription_admin' => 'required|exists:inscription_admins,id',
            'montant' => 'required|numeric|min:0.01',
            'type_frais' => ['required', Rule::in(['Inscription', 'Scolarité', 'Autre'])],
            'date_paiement' => 'required|date',
            'methode_paiement' => ['required', Rule::in(['Carte bancaire', 'Virement', 'Chèque', 'Espèces'])],
        ]);

        $reference = 'PAI-' . strtoupper(Str::random(10));
        Paiement::create($request->all() + ['reference_paiement' => $reference, 'statut_paiement' => 'Payé']);

        return redirect()->route('paiements.index')->with('success', 'Paiement enregistré avec succès.');
    }



    public function show(Paiement $paiement)
    {
        $this->authorize('view', $paiement);
        return view('financier.paiements.show', compact('paiement'));
    }

    public function edit(Paiement $paiement)
    {
        $inscriptions = InscriptionAdmin::with('etudiant')->get();
        $typesFrais = ['Inscription', 'Scolarité', 'Autre'];
        $methodesPaiement = ['Carte bancaire', 'Virement', 'Chèque', 'Espèces'];
        $statutsPaiement = ['Payé', 'En attente', 'Annulé', 'Impayé'];
        return view('financier.paiements.edit', compact('paiement', 'inscriptions', 'typesFrais', 'methodesPaiement', 'statutsPaiement'));
    }

    public function update(Request $request, Paiement $paiement)
    {
        $request->validate([
            'id_inscription_admin' => 'required|exists:inscription_admins,id',
            'montant' => 'required|numeric|min:0.01',
            'type_frais' => ['required', Rule::in(['Inscription', 'Scolarité', 'Autre'])],
            'date_paiement' => 'required|date',
            'methode_paiement' => ['required', Rule::in(['Carte bancaire', 'Virement', 'Chèque', 'Espèces'])],
            'statut_paiement' => ['required', Rule::in(['Payé', 'En attente', 'Annulé', 'Impayé'])],
        ]);

        $paiement->update($request->all());

        return redirect()->route('paiements.index')->with('success', 'Paiement mis à jour avec succès.');
    }

    public function destroy(Paiement $paiement)
    {
        $paiement->delete();
        return redirect()->route('paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }

    public function receipt(Paiement $paiement)
    {
        $this->authorize('view', $paiement);
        $pdf = PDF::loadView('financier.paiements.receipt-pdf', compact('paiement'));
        return $pdf->download('recu-paiement-'.$paiement->reference_paiement.'.pdf');
    }
}

