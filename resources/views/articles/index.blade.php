@extends('layouts.app')

@section('title', 'Articles - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Stock & Articles</h2>
        <p class="text-muted mb-0">Gestion du magasin</p>
    </div>
    <a href="{{ route('articles.create') }}" class="btn btn-primary text-white text-decoration-none">
        <i class="bi bi-plus-lg me-2"></i> Nouvel article
    </a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Catégorie</th>
                    <th class="text-end">Stock</th>
                    <th class="text-end">Seuil min</th>
                    <th class="text-end">P.U</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr class="{{ $article->quantite_stock <= $article->seuil_minimum && $article->seuil_minimum > 0 ? 'table-danger' : '' }}">
                    <td class="fw-semibold">{{ $article->reference }}</td>
                    <td>{{ $article->designation }}</td>
                    <td>{{ $article->categorie ?? '-' }}</td>
                    <td class="text-end fw-bold {{ $article->quantite_stock <= $article->seuil_minimum && $article->seuil_minimum > 0 ? 'text-danger' : '' }}">
                        {{ $article->quantite_stock }} {{ $article->unite }}
                    </td>
                    <td class="text-end">{{ $article->seuil_minimum }}</td>
                    <td class="text-end">{{ number_format($article->prix_unitaire, 2, ',', ' ') }} DH</td>
                    <td class="text-end">
                        <a href="{{ route('articles.edit', $article) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucun article</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection