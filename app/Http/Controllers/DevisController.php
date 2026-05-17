<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\DevisLigne;
use App\Models\Client;
use App\Models\Article;
use App\Models\Mouvement;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class DevisController extends Controller
{
    public function index()
    {
        $devis = Devis::with('client')->get();
        return view('devis.index', compact('devis'));
    }

    public function create()
    {
        $clients = Client::all();
        $articles = Article::all();
        return view('devis.create', compact('clients', 'articles'));
    }

   public function store(Request $request)
{
    $data = $request->validate([
        'numero' => 'required|string|unique:devis',
        'client_id' => 'required|exists:clients,id',
        'date_creation' => 'required|date',
        'date_validite' => 'required|date',
        'remise_globale' => 'nullable|numeric',
        'tva' => 'nullable|numeric',
        'notes' => 'nullable|string',
        'lignes' => 'required|array|min:1',
        'lignes.*.article_id' => 'required|exists:articles,id',
        'lignes.*.designation' => 'required|string',
        'lignes.*.quantite' => 'required|numeric|min:0.01',
        'lignes.*.prix_unitaire' => 'required|numeric',
        'lignes.*.remise_ligne' => 'nullable|numeric',
        'machines' => 'nullable|array',
        'machines.*.machine_id' => 'required_with:machines|exists:machines,id',
        'machines.*.nb_heures' => 'required_with:machines|integer|min:1',
    ]);

    $devis = DB::transaction(function () use ($data, $request) {
        // 1. Calcul des lignes produits
        $montant_ht = 0;
        foreach ($data['lignes'] as $ligne) {
            $qte = $ligne['quantite'];
            $pu = $ligne['prix_unitaire'];
            $remise = $ligne['remise_ligne'] ?? 0;
            $total_ligne = ($qte * $pu) * (1 - $remise / 100);
            $montant_ht += $total_ligne;
        }

        // 2. Ajouter le coût des machines
        $coutMachines = 0;
        if (!empty($data['machines'])) {
            foreach ($data['machines'] as $machineData) {
                $machine = Machine::find($machineData['machine_id']);
                $nbHeures = $machineData['nb_heures'];
                $coutTotal = $nbHeures * $machine->cout_heure;
                $coutMachines += $coutTotal;
            }
        }
        $montant_ht += $coutMachines;

        // 3. Appliquer remise globale et TVA
        $remise_globale = $data['remise_globale'] ?? 0;
        $montant_ht -= $montant_ht * ($remise_globale / 100);
        $tva = $data['tva'] ?? 20;
        $montant_ttc = $montant_ht * (1 + $tva / 100);

        // 4. Créer le devis
        $devis = Devis::create([
            'numero' => $data['numero'],
            'client_id' => $data['client_id'],
            'user_id' => $request->user()->id,
            'statut' => 'brouillon',
            'date_creation' => $data['date_creation'],
            'date_validite' => $data['date_validite'],
            'remise_globale' => $remise_globale,
            'montant_ht' => round($montant_ht, 2),
            'tva' => $tva,
            'montant_ttc' => round($montant_ttc, 2),
            'notes' => $data['notes'] ?? null,
        ]);

        // 5. Créer les lignes produits
        foreach ($data['lignes'] as $ligne) {
            $qte = $ligne['quantite'];
            $pu = $ligne['prix_unitaire'];
            $remise = $ligne['remise_ligne'] ?? 0;
            $total_ligne = ($qte * $pu) * (1 - $remise / 100);

            DevisLigne::create([
                'devis_id' => $devis->id,
                'article_id' => $ligne['article_id'],
                'designation' => $ligne['designation'],
                'quantite' => $qte,
                'prix_unitaire' => $pu,
                'remise_ligne' => $remise,
                'total_ligne' => round($total_ligne, 2),
            ]);
        }

        // 6. Attacher les machines (DANS la transaction)
        if (!empty($data['machines'])) {
            foreach ($data['machines'] as $machineData) {
                $machine = Machine::find($machineData['machine_id']);
                $nbHeures = $machineData['nb_heures'];
                $coutTotal = $nbHeures * $machine->cout_heure;

                $devis->machines()->attach($machine->id, [
                    'nb_heures' => $nbHeures,
                    'cout_total' => $coutTotal,
                ]);
            }
        }

        return $devis;
    });

    return redirect()->route('devis.index')->with('success', 'Devis créé avec succès.');
}

    public function show(Devis $devi)
    {
        $devi->load(['client', 'lignes.article', 'user']);
        return view('devis.show', compact('devi'));
    }

    public function edit(Devis $devi)
    {
        if ($devi->statut !== 'brouillon') {
            return redirect()->route('devis.index')->with('error', 'Modification impossible.');
        }

        $clients = Client::all();
        $articles = Article::all();
        $devi->load('lignes');
        return view('devis.edit', compact('devi', 'clients', 'articles'));
    }

   public function update(Request $request, Devis $devi)
{
    if ($devi->statut !== 'brouillon') {
        return redirect()->route('devis.index')->with('error', 'Modification impossible.');
    }

    $data = $request->validate([
        'client_id' => 'sometimes|required|exists:clients,id',
        'date_validite' => 'sometimes|required|date',
        'remise_globale' => 'nullable|numeric',
        'tva' => 'nullable|numeric',
        'notes' => 'nullable|string',
        'lignes' => 'sometimes|required|array|min:1',
        'lignes.*.article_id' => 'required_with:lignes|exists:articles,id',
        'lignes.*.designation' => 'required_with:lignes|string',
        'lignes.*.quantite' => 'required_with:lignes|numeric|min:0.01',
        'lignes.*.prix_unitaire' => 'required_with:lignes|numeric',
        'lignes.*.remise_ligne' => 'nullable|numeric',
        'machines' => 'nullable|array',
        'machines.*.machine_id' => 'required_with:machines|exists:machines,id',
        'machines.*.nb_heures' => 'required_with:machines|integer|min:1',
    ]);

    DB::transaction(function () use ($data, $devi) {
        // Supprimer anciennes lignes et machines
        if (isset($data['lignes'])) {
            DevisLigne::where('devis_id', $devi->id)->delete();
        }
        $devi->machines()->detach();

        $montant_ht = 0;

        // Recalcul lignes
        if (isset($data['lignes'])) {
            foreach ($data['lignes'] as $ligne) {
                $qte = $ligne['quantite'];
                $pu = $ligne['prix_unitaire'];
                $remise = $ligne['remise_ligne'] ?? 0;
                $total_ligne = ($qte * $pu) * (1 - $remise / 100);
                $montant_ht += $total_ligne;

                DevisLigne::create([
                    'devis_id' => $devi->id,
                    'article_id' => $ligne['article_id'],
                    'designation' => $ligne['designation'],
                    'quantite' => $qte,
                    'prix_unitaire' => $pu,
                    'remise_ligne' => $remise,
                    'total_ligne' => round($total_ligne, 2),
                ]);
            }
        } else {
            $montant_ht = $devi->lignes->sum('total_ligne');
        }

        // Ajouter coût machines
        if (!empty($data['machines'])) {
            foreach ($data['machines'] as $machineData) {
                $machine = Machine::find($machineData['machine_id']);
                $nbHeures = $machineData['nb_heures'];
                $coutTotal = $nbHeures * $machine->cout_heure;
                $montant_ht += $coutTotal;

                $devi->machines()->attach($machine->id, [
                    'nb_heures' => $nbHeures,
                    'cout_total' => $coutTotal,
                ]);
            }
        }

        $remise_globale = $data['remise_globale'] ?? $devi->remise_globale;
        $montant_ht -= $montant_ht * ($remise_globale / 100);
        $tva = $data['tva'] ?? $devi->tva;
        $montant_ttc = $montant_ht * (1 + $tva / 100);

        $devi->update([
            'client_id' => $data['client_id'] ?? $devi->client_id,
            'date_validite' => $data['date_validite'] ?? $devi->date_validite,
            'remise_globale' => $remise_globale,
            'montant_ht' => round($montant_ht, 2),
            'tva' => $tva,
            'montant_ttc' => round($montant_ttc, 2),
            'notes' => $data['notes'] ?? $devi->notes,
        ]);
    });

    return redirect()->route('devis.index')->with('success', 'Devis modifié.');
}

    public function destroy(Devis $devi)
    {
        if ($devi->statut === 'accepte') {
            return redirect()->route('devis.index')->with('error', 'Suppression impossible.');
        }

        $devi->delete();
        return redirect()->route('devis.index')->with('success', 'Devis supprimé.');
    }

    public function changeStatut(Request $request, Devis $devi)
    {
        $data = $request->validate([
            'statut' => 'required|in:brouillon,envoye,accepte,refuse',
        ]);

        $nouveau = $data['statut'];
        $ancien = $devi->statut;

        $transitions = [
            'brouillon' => ['envoye'],
            'envoye' => ['accepte', 'refuse'],
            'accepte' => [],
            'refuse' => [],
        ];

        if ($ancien !== $nouveau && !in_array($nouveau, $transitions[$ancien] ?? [])) {
            return redirect()->back()->with('error', 'Transition non autorisée.');
        }

        if ($nouveau === 'accepte' && $ancien !== 'accepte') {
            DB::transaction(function () use ($devi) {
                foreach ($devi->lignes as $ligne) {
                    $article = Article::find($ligne->article_id);

                    if ($article->quantite_stock < $ligne->quantite) {
                        throw new \Exception('Stock insuffisant : ' . $article->designation);
                    }

                    $article->decrement('quantite_stock', $ligne->quantite);

                    Mouvement::create([
                        'article_id' => $article->id,
                        'type' => 'sortie',
                        'quantite' => $ligne->quantite,
                        'prix_unitaire' => $ligne->prix_unitaire,
                        'devis_id' => $devi->id,
                        'user_id' => auth()->id(),
                        'motif' => 'Devis accepté : ' . $devi->numero,
                        'date_mouvement' => now(),
                    ]);
                }
            });
        }

        $devi->update(['statut' => $nouveau]);
        return redirect()->route('devis.index')->with('success', 'Statut mis à jour.');
    }
    public function duplicate(Devis $devi)
{
    $nouveau = $devi->replicate();
    $nouveau->numero = 'DEV-' . date('Ymd') . '-' . rand(100,999);
    $nouveau->statut = 'brouillon';
    $nouveau->date_creation = now();
    $nouveau->save();

    foreach ($devi->lignes as $ligne) {
        $ligne->replicate()->fill(['devis_id' => $nouveau->id])->save();
    }

    return redirect()->route('devis.edit', $nouveau)->with('success', 'Devis dupliqué.');
}


// ... autres méthodes ...

public function exportPDF(Devis $devi)
{
    $devi->load(['client', 'lignes.article', 'user']);
    
    $pdf = Pdf::loadView('devis.pdf', compact('devi'));
    
    return $pdf->download('devis-' . $devi->numero . '.pdf');
}
}