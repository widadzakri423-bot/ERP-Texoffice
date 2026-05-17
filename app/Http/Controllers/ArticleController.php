<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return view('articles.index', ['articles' => Article::all()]);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference' => 'required|string|unique:articles',
            'designation' => 'required|string',
            'categorie' => 'nullable|string',
            'unite' => 'nullable|string',
            'quantite_stock' => 'nullable|numeric',
            'seuil_minimum' => 'nullable|numeric',
            'prix_unitaire' => 'nullable|numeric',
            'emplacement' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Article::create($data);
        return redirect()->route('articles.index')->with('success', 'Article créé.');
    }

    public function show(Article $article)
    {
        return view('articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $data = $request->validate([
            'reference' => 'sometimes|required|string|unique:articles,reference,' . $article->id,
            'designation' => 'sometimes|required|string',
            'categorie' => 'nullable|string',
            'unite' => 'nullable|string',
            'quantite_stock' => 'nullable|numeric',
            'seuil_minimum' => 'nullable|numeric',
            'prix_unitaire' => 'nullable|numeric',
            'emplacement' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $article->update($data);
        return redirect()->route('articles.index')->with('success', 'Article modifié.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article supprimé.');
    }
}