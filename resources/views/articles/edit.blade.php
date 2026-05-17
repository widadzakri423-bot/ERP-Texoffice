@extends('layouts.app')

@section('title', 'Modifier article - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Modifier article</h2>
    <p class="text-muted mb-0">{{ $article->reference }} — {{ $article->designation }}</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('articles.update', $article) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Référence *</label>
                    <input type="text" name="reference" class="form-control" value="{{ old('reference', $article->reference) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Désignation *</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation', $article->designation) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <input type="text" name="categorie" class="form-control" value="{{ old('categorie', $article->categorie) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Unité</label>
                    <input type="text" name="unite" class="form-control" value="{{ old('unite', $article->unite) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Emplacement</label>
                    <input type="text" name="emplacement" class="form-control" value="{{ old('emplacement', $article->emplacement) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Quantité stock</label>
                    <input type="number" name="quantite_stock" class="form-control" value="{{ old('quantite_stock', $article->quantite_stock) }}" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Seuil minimum</label>
                    <input type="number" name="seuil_minimum" class="form-control" value="{{ old('seuil_minimum', $article->seuil_minimum) }}" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Prix unitaire (DH)</label>
                    <input type="number" name="prix_unitaire" class="form-control" value="{{ old('prix_unitaire', $article->prix_unitaire) }}" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $article->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white"><i class="bi bi-check-lg me-2"></i> Mettre à jour</button>
                <a href="{{ route('articles.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection