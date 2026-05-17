@extends('layouts.app')

@section('title', $machine->designation . ' - Texoffice')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">{{ $machine->designation }}</h2>
            <p class="text-muted mb-0">Réf: {{ $machine->reference }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('machines.edit', $machine) }}" class="btn btn-warning text-white"><i class="bi bi-pencil me-2"></i> Modifier</a>
            <form action="{{ route('machines.destroy', $machine) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger"><i class="bi bi-trash me-2"></i> Supprimer</button>
            </form>
            <a href="{{ route('machines.index') }}" class="btn btn-outline-secondary">Retour</a>
        </div>
    </div>
</div>

<div class="content-card">
    <div class="card-header-custom"><h5><i class="bi bi-gear text-primary"></i> Fiche technique</h5></div>
    <div class="p-4">
        <div class="row g-3">
            <div class="col-md-4"><strong>Marque:</strong> {{ $machine->marque ?? '-' }}</div>
            <div class="col-md-4"><strong>Modèle:</strong> {{ $machine->modele ?? '-' }}</div>
            <div class="col-md-4"><strong>État:</strong> <span class="badge-custom bg-{{ $machine->etat === 'disponible' ? 'success' : ($machine->etat === 'en_maintenance' || $machine->etat === 'hors_service' ? 'warning' : 'primary') }} bg-opacity-10 text-{{ $machine->etat === 'disponible' ? 'success' : ($machine->etat === 'en_maintenance' || $machine->etat === 'hors_service' ? 'warning' : 'primary') }}">{{ ucfirst(str_replace('_', ' ', $machine->etat)) }}</span></div>
            <div class="col-md-6"><strong>Date acquisition:</strong> {{ $machine->date_acquisition?->format('d/m/Y') ?? '-' }}</div>
            <div class="col-md-6"><strong>Coût/heure:</strong> {{ number_format($machine->cout_heure, 2, ',', ' ') }} DH</div>
            <div class="col-12"><strong>Notes:</strong> {{ $machine->notes ?? '-' }}</div>
        </div>
    </div>
</div>
<div class="content-card mt-4">
    <div class="card-header-custom">
        <h5><i class="bi bi-wrench text-warning"></i> Historique des interventions ({{ $machine->interventions->count() }})</h5>
    </div>
    <div class="p-0">
        <table class="table custom-table mb-0">
            <thead>
                <tr><th>Date</th><th>Type</th><th>Description</th><th class="text-end">Coût</th></tr>
            </thead>
            <tbody>
                @forelse($machine->interventions as $intervention)
                <tr>
                    <td>{{ $intervention->date_intervention->format('d/m/Y') }}</td>
                    <td><span class="badge-custom bg-warning bg-opacity-10 text-warning">{{ ucfirst($intervention->type) }}</span></td>
                    <td>{{ Str::limit($intervention->description, 40) }}</td>
                    <td class="text-end">{{ number_format($intervention->cout, 2, ',', ' ') }} DH</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-3">Aucune intervention</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection