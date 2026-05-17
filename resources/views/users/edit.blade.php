@extends('layouts.app')

@section('title', 'Modifier utilisateur - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Modifier utilisateur</h2>
    <p class="text-muted mb-0">{{ $user->name }}</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom complet *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nouveau mot de passe (laisser vide = inchangé)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rôle *</label>
                    <select name="role" class="form-select" required>
                        @foreach(['commercial', 'magasinier', 'administrateur'] as $role)
                        <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                            {{ ucfirst($role) }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn text-white text-decoration-none" style="background: var(--success); border: none; padding: 10px 20px; border-radius: 10px; font-weight: 500;">
                    <i class="bi bi-check-lg me-2"></i> Mettre à jour
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection