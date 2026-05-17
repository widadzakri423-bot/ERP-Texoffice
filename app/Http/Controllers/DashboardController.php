<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Article;
use App\Models\Machine;
use App\Models\Mouvement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques devis par statut
        $statsDevis = [
            'brouillon' => Devis::where('statut', 'brouillon')->count(),
            'envoye' => Devis::where('statut', 'envoye')->count(),
            'accepte' => Devis::where('statut', 'accepte')->count(),
            'refuse' => Devis::where('statut', 'refuse')->count(),
        ];

        // Évolution mensuelle des devis (12 derniers mois)
        $evolutionDevis = Devis::select(
                DB::raw('DATE_FORMAT(date_creation, "%Y-%m") as mois'),
                DB::raw('COUNT(*) as total')
            )
            ->where('date_creation', '>=', now()->subMonths(12))
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        // Articles sous seuil minimum
        $stockAlerte = Article::whereColumn('quantite_stock', '<=', 'seuil_minimum')
            ->where('seuil_minimum', '>', 0)
            ->get();

        // Machines en panne / hors service
        $machinesPanne = Machine::whereIn('etat', ['en_maintenance', 'hors_service'])->get();

        // Derniers mouvements de stock
        $derniersMouvements = Mouvement::with(['article', 'user'])
            ->latest()
            ->take(10)
            ->get();

        // Derniers devis créés
        $derniersDevis = Devis::with('client')
            ->latest()
            ->take(5)
            ->get();

        // Valeur totale du stock
        $valeurStock = Article::select(
                DB::raw('SUM(quantite_stock * prix_unitaire) as total')
            )->first()->total ?? 0;

        return view('dashboard', compact(
            'statsDevis',
            'evolutionDevis',
            'stockAlerte',
            'machinesPanne',
            'derniersMouvements',
            'derniersDevis',
            'valeurStock'
        ));
    }
}