@extends('layouts.app')

@section('title', 'Nouvel article - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Nouvel article</h2>
    <p class="text-muted mb-0">Ajouter au stock</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('articles.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Référence *</label>
                    <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" required>
                    @error('reference')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Désignation *</label>
                    <input type="text" name="designation" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Catégorie</label>
                    <input type="text" name="categorie" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Unité</label>
                    <input type="text" name="unite" class="form-control" value="unité">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Emplacement</label>
                    <input type="text" name="emplacement" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Quantité stock</label>
                    <input type="number" name="quantite_stock" class="form-control" value="0" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Seuil minimum (alerte)</label>
                    <input type="number" name="seuil_minimum" class="form-control" value="0" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Prix unitaire (DH)</label>
                    <input type="number" name="prix_unitaire" class="form-control" value="0" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-2"></i> Enregistrer</button>
                <a href="{{ route('articles.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection