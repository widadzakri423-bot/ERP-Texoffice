@extends('layouts.app')

@section('title', 'Devis - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Devis clients</h2>
        <p class="text-muted mb-0">Gestion commerciale</p>
    </div>
    <a href="{{ route('devis.create') }}" class="btn btn-primary text-white text-decoration-none">
        <i class="bi bi-plus-lg me-2"></i> Nouveau devis
    </a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th class="text-end">Montant TTC</th>
                    <th class="text-center">Statut</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($devis as $d)
                <tr>
                    <td class="fw-bold">{{ $d->numero }}</td>
                    <td>{{ $d->client->raison_sociale }}</td>
                    <td>{{ $d->date_creation->format('d/m/Y') }}</td>
                    <td class="text-end fw-bold">{{ number_format($d->montant_ttc, 2, ',', ' ') }} DH</td>
                    <td class="text-center">
                        @php
                            $badge = match($d->statut) {
                                'brouillon' => 'badge-brouillon',
                                'envoye' => 'badge-envoye',
                                'accepte' => 'badge-accepte',
                                'refuse' => 'badge-refuse',
                                default => 'badge-brouillon'
                            };
                        @endphp
                        <span class="badge-custom {{ $badge }}">{{ ucfirst($d->statut) }}</span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('devis.show', $d) }}" class="btn btn-sm btn-outline-primary me-1"><i class="bi bi-eye"></i></a>
                        @if($d->statut === 'brouillon')
                        <a href="{{ route('devis.edit', $d) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                        @endif
                        <form action="{{ route('devis.destroy', $d) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucun devis</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection