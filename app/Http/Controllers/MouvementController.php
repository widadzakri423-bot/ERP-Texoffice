<?php

namespace App\Http\Controllers;

use App\Models\Mouvement;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MouvementController extends Controller
{
    public function index()
    {
        $mouvements = Mouvement::with(['article', 'devis', 'user'])->get();
        return view('mouvements.index', compact('mouvements'));
    }

    public function create()
    {
        $articles = Article::all();
        return view('mouvements.create', compact('articles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'article_id' => 'required|exists:articles,id',
            'type' => 'required|in:entree,sortie',
            'quantite' => 'required|numeric|min:0.01',
            'prix_unitaire' => 'nullable|numeric',
            'motif' => 'nullable|string',
            'date_mouvement' => 'required|date',
        ]);

        DB::transaction(function () use ($data, $request) {
            $article = Article::find($data['article_id']);

            if ($data['type'] === 'sortie' && $article->quantite_stock < $data['quantite']) {
                return redirect()->back()->with('error', 'Stock insuffisant.');
            }

            if ($data['type'] === 'entree') {
                $article->increment('quantite_stock', $data['quantite']);
            } else {
                $article->decrement('quantite_stock', $data['quantite']);
            }

            Mouvement::create([
                'article_id' => $data['article_id'],
                'type' => $data['type'],
                'quantite' => $data['quantite'],
                'prix_unitaire' => $data['prix_unitaire'] ?? null,
                'devis_id' => null,
                'user_id' => $request->user()->id,
                'motif' => $data['motif'] ?? null,
                'date_mouvement' => $data['date_mouvement'],
            ]);
        });

        return redirect()->route('mouvements.index')->with('success', 'Mouvement enregistré.');
    }

    public function show(Mouvement $mouvement)
    {
        return view('mouvements.show', compact('mouvement'));
    }

    public function destroy(Mouvement $mouvement)
    {
        $mouvement->delete();
        return redirect()->route('mouvements.index')->with('success', 'Mouvement supprimé.');
    }
}