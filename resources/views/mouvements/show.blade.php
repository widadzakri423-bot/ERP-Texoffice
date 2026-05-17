@extends('layouts.app')

@section('title', 'Mouvement #' . $mouvement->id . ' - Texoffice')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Mouvement #{{ $mouvement->id }}</h2>
            <p class="text-muted mb-0">{{ $mouvement->date_mouvement->format('d/m/Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <form action="{{ route('mouvements.destroy', $mouvement) }}" method="POST" onsubmit="return confirm('Supprimer ce mouvement ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash me-2"></i> Supprimer</button>
            </form>
            <a href="{{ route('mouvements.index') }}" class="btn btn-outline-secondary">Retour</a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="p-4">
        <div class="row g-3">
            <div class="col-md-4"><strong>Type:</strong> <span class="badge-custom {{ $mouvement->type === 'entree' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">{{ ucfirst($mouvement->type) }}</span></div>
            <div class="col-md-4"><strong>Article:</strong> {{ $mouvement->article->designation }}</div>
            <div class="col-md-4"><strong>Quantité:</strong> {{ $mouvement->quantite }} {{ $mouvement->article->unite }}</div>
            <div class="col-md-4"><strong>Prix unitaire:</strong> {{ $mouvement->prix_unitaire ? number_format($mouvement->prix_unitaire, 2, ',', ' ') . ' DH' : '-' }}</div>
            <div class="col-md-4"><strong>Par:</strong> {{ $mouvement->user->name }}</div>
            <div class="col-md-4"><strong>Motif:</strong> {{ $mouvement->motif ?? '-' }}</div>
            @if($mouvement->devis)
            <div class="col-12"><strong>Lié au devis:</strong> <a href="{{ route('devis.show', $mouvement->devis) }}">{{ $mouvement->devis->numero }}</a></div>
            @endif
        </div>
    </div>
</div>
@endsection