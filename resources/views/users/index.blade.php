@extends('layouts.app')

@section('title', 'Utilisateurs - Texoffice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Gestion des utilisateurs</h2>
        <p class="text-muted mb-0">Comptes et rôles</p>
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary-custom text-white text-decoration-none">
        <i class="bi bi-plus-lg me-2"></i> Nouvel utilisateur
    </a>
</div>

<div class="content-card">
    <div class="card-body-custom p-0">
        <table class="table custom-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="fw-semibold">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge-custom bg-{{ $user->role === 'administrateur' ? 'danger' : ($user->role === 'commercial' ? 'primary' : 'warning') }} bg-opacity-10 text-{{ $user->role === 'administrateur' ? 'danger' : ($user->role === 'commercial' ? 'primary' : 'warning') }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-outline-warning me-1"><i class="bi bi-pencil"></i></a>
                        @if($user->id !== auth()->id())
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">Aucun utilisateur</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection