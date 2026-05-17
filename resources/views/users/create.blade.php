@extends('layouts.app')

@section('title', 'Nouvel utilisateur - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Nouvel utilisateur</h2>
    <p class="text-muted mb-0">Créer un compte</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nom complet *</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Mot de passe *</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Rôle *</label>
                    <select name="role" class="form-select" required>
                        <option value="commercial">Commercial</option>
                        <option value="magasinier">Magasinier</option>
                        <option value="administrateur">Administrateur</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn text-white text-decoration-none" style="background: var(--success); border: none; padding: 10px 20px; border-radius: 10px; font-weight: 500;">
                    <i class="bi bi-check-lg me-2"></i> Enregistrer
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection