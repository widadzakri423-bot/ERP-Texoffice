@extends('layouts.app')

@section('title', 'Machines - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Parc Machines</h2>
        <p class="text-muted mb-0">Suivi des équipements</p>
    </div>
    <a href="{{ route('machines.create') }}" class="btn btn-primary text-white text-decoration-none">
        <i class="bi bi-plus-lg me-2"></i> Nouvelle machine
    </a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Référence</th>
                    <th>Désignation</th>
                    <th>Marque</th>
                    <th>État</th>
                    <th class="text-end">Coût/heure</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($machines as $machine)
                <tr>
                    <td class="fw-semibold">{{ $machine->reference }}</td>
                    <td>{{ $machine->designation }}</td>
                    <td>{{ $machine->marque ?? '-' }}</td>
                    <td>
                        @php
                            $etatColors = [
                                'disponible' => 'bg-success bg-opacity-10 text-success',
                                'en_maintenance' => 'bg-warning bg-opacity-10 text-warning',
                                'hors_service' => 'bg-danger bg-opacity-10 text-danger',
                                'occupe' => 'bg-primary bg-opacity-10 text-primary'
                            ];
                        @endphp
                        <span class="badge-custom {{ $etatColors[$machine->etat] ?? '' }}">
                            {{ ucfirst(str_replace('_', ' ', $machine->etat)) }}
                        </span>
                    </td>
                    <td class="text-end">{{ number_format($machine->cout_heure, 2, ',', ' ') }} DH</td>
                    <td class="text-end">
                        <a href="{{ route('machines.edit', $machine) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('machines.destroy', $machine) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune machine</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection