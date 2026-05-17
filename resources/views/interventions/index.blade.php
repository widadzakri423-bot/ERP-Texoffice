@extends('layouts.app')

@section('title', 'Interventions - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Interventions de maintenance</h2>
        <p class="text-muted mb-0">Suivi technique</p>
    </div>
    <a href="{{ route('interventions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i> Nouvelle intervention
    </a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Machine</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th class="text-end">Coût</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($interventions as $intervention)
                <tr>
                    <td>{{ $intervention->date_intervention->format('d/m/Y') }}</td>
                    <td class="fw-semibold">{{ $intervention->machine->designation }}</td>
                    <td>
                        <span class="badge-custom bg-{{ $intervention->type === 'preventive' ? 'info' : ($intervention->type === 'corrective' ? 'warning' : 'secondary') }} bg-opacity-10 text-{{ $intervention->type === 'preventive' ? 'info' : ($intervention->type === 'corrective' ? 'warning' : 'secondary') }}">
                            {{ ucfirst($intervention->type) }}
                        </span>
                    </td>
                    <td>{{ Str::limit($intervention->description, 50) }}</td>
                    <td class="text-end">{{ number_format($intervention->cout, 2, ',', ' ') }} DH</td>
                    <td class="text-end">
                        <a href="{{ route('interventions.edit', $intervention) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('interventions.destroy', $intervention) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Aucune intervention</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection