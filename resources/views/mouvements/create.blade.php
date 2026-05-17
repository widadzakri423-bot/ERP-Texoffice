@extends('layouts.app')

@section('title', 'Nouveau mouvement - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Nouveau mouvement</h2>
    <p class="text-muted mb-0">Entrée ou sortie de stock</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('mouvements.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Article *</label>
                    <select name="article_id" class="form-select @error('article_id') is-invalid @enderror" required>
                        <option value="">Choisir...</option>
                        @foreach($articles as $article)
                        <option value="{{ $article->id }}" {{ old('article_id') == $article->id ? 'selected' : '' }}>
                            {{ $article->reference }} - {{ $article->designation }} (Stock: {{ $article->quantite_stock }})
                        </option>
                        @endforeach
                    </select>
                    @error('article_id')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Type *</label>
                    <select name="type" class="form-select" required>
                        <option value="entree" {{ old('type') == 'entree' ? 'selected' : '' }}>Entrée</option>
                        <option value="sortie" {{ old('type') == 'sortie' ? 'selected' : '' }}>Sortie</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Quantité *</label>
                    <input type="number" name="quantite" class="form-control @error('quantite') is-invalid @enderror" value="{{ old('quantite', 1) }}" min="0.01" step="0.01" required>
                    @error('quantite')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Prix unitaire (DH)</label>
                    <input type="number" name="prix_unitaire" class="form-control" value="{{ old('prix_unitaire') }}" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date du mouvement *</label>
                    <input type="date" name="date_mouvement" class="form-control" value="{{ old('date_mouvement', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Motif</label>
                    <input type="text" name="motif" class="form-control" value="{{ old('motif') }}">
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-2"></i> Enregistrer</button>
                <a href="{{ route('mouvements.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection