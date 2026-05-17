@extends('layouts.app')

@section('title', 'Clients - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Clients</h2>
        <p class="text-muted mb-0">Gestion de la clientèle</p>
    </div>
   <a href="{{ route('clients.create') }}" class="btn btn-primary text-white text-decoration-none">
    <i class="bi bi-plus-lg me-2"></i> Nouveau client
</a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Raison sociale</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Ville</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clients as $client)
                <tr>
                    <td class="fw-semibold">{{ $client->raison_sociale }}</td>
                    <td>{{ $client->email ?? '-' }}</td>
                    <td>{{ $client->telephone ?? '-' }}</td>
                    <td>{{ $client->ville ?? '-' }}</td>
                    <td class="text-end">
                        <a href="{{ route('clients.show', $client) }}" class="btn btn-sm btn-outline-primary me-1">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('clients.edit', $client) }}" class="btn btn-sm btn-outline-warning me-1">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ce client ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Aucun client</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection