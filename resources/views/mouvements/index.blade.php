@extends('layouts.app')

@section('title', 'Mouvements - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Mouvements de stock</h2>
        <p class="text-muted mb-0">Historique entrées/sorties</p>
    </div>
    <a href="{{ route('mouvements.create') }}" class="btn btn-primary text-white text-decoration-none">
        <i class="bi bi-plus-lg me-2"></i> Nouveau mouvement
    </a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Type</th>
                    <th>Article</th>
                    <th class="text-end">Quantité</th>
                    <th>Par</th>
                    <th>Motif</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mouvements as $mouvement)
                <tr>
                    <td>{{ $mouvement->date_mouvement->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge-custom {{ $mouvement->type === 'entree' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger' }}">
                            <i class="bi bi-arrow-{{ $mouvement->type === 'entree' ? 'down-left' : 'up-right' }}"></i>
                            {{ ucfirst($mouvement->type) }}
                        </span>
                    </td>
                    <td class="fw-semibold">{{ $mouvement->article->designation }}</td>
                    <td class="text-end fw-bold">{{ $mouvement->quantite }} {{ $mouvement->article->unite }}</td>
                    <td>{{ $mouvement->user->name }}</td>
                    <td class="text-muted">{{ $mouvement->motif ?? '-' }}</td>
                    <td class="text-end">
                        <form action="{{ route('mouvements.destroy', $mouvement) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Aucun mouvement</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection