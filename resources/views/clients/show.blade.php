@extends('layouts.app')

@section('title', $client->raison_sociale . ' - Texoffice')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">{{ $client->raison_sociale }}</h2>
            <p class="text-muted mb-0">Fiche client</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-warning text-white">
                <i class="bi bi-pencil me-2"></i> Modifier
            </a>
            <form action="{{ route('clients.destroy', $client) }}" method="POST" onsubmit="return confirm('Supprimer ce client ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash me-2"></i> Supprimer</button>
            </form>
            <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Retour</a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="content-card">
            <div class="card-header-custom">
                <h5><i class="bi bi-person text-primary"></i> Informations</h5>
            </div>
            <div class="p-4">
                <div class="row g-3">
                    <div class="col-md-6"><strong>Email :</strong> {{ $client->email ?? '-' }}</div>
                    <div class="col-md-6"><strong>Téléphone :</strong> {{ $client->telephone ?? '-' }}</div>
                    <div class="col-md-6"><strong>Ville :</strong> {{ $client->ville ?? '-' }}</div>
                    <div class="col-12"><strong>Adresse :</strong> {{ $client->adresse ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="content-card mt-4">
            <div class="card-header-custom">
                <h5><i class="bi bi-file-earmark-text text-primary"></i> Devis associés ({{ $client->devis->count() }})</h5>
            </div>
            <div class="p-0">
                <table class="table custom-table mb-0">
                    <thead>
                        <tr><th>N°</th><th>Date</th><th class="text-end">Montant</th><th>Statut</th></tr>
                    </thead>
                    <tbody>
                        @forelse($client->devis as $devis)
                        <tr>
                            <td><a href="{{ route('devis.show', $devis) }}">{{ $devis->numero }}</a></td>
                            <td>{{ $devis->date_creation->format('d/m/Y') }}</td>
                            <td class="text-end">{{ number_format($devis->montant_ttc, 2, ',', ' ') }} DH</td>
                            <td><span class="badge-custom badge-{{ $devis->statut }}">{{ ucfirst($devis->statut) }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-3">Aucun devis</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection