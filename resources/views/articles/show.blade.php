@extends('layouts.app')

@section('title', $article->designation . ' - Texoffice')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">{{ $article->designation }}</h2>
            <p class="text-muted mb-0">Réf: {{ $article->reference }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('articles.edit', $article) }}" class="btn btn-warning text-white"><i class="bi bi-pencil me-2"></i> Modifier</a>
            <form action="{{ route('articles.destroy', $article) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash me-2"></i> Supprimer</button>
            </form>
            <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">Retour</a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-6">
        <div class="content-card">
            <div class="card-header-custom"><h5><i class="bi bi-box-seam text-primary"></i> Informations</h5></div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-6"><strong>Catégorie:</strong> {{ $article->categorie ?? '-' }}</div>
                    <div class="col-6"><strong>Unité:</strong> {{ $article->unite }}</div>
                    <div class="col-6"><strong>Emplacement:</strong> {{ $article->emplacement ?? '-' }}</div>
                    <div class="col-6"><strong>Prix unitaire:</strong> {{ number_format($article->prix_unitaire, 2, ',', ' ') }} DH</div>
                    <div class="col-6"><strong>Stock:</strong> <span class="fw-bold {{ $article->quantite_stock <= $article->seuil_minimum && $article->seuil_minimum > 0 ? 'text-danger' : '' }}">{{ $article->quantite_stock }}</span></div>
                    <div class="col-6"><strong>Seuil min:</strong> {{ $article->seuil_minimum }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection