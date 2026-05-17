@extends('layouts.app')

@section('title', 'Modifier client - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Modifier client</h2>
    <p class="text-muted mb-0">{{ $client->raison_sociale }}</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('clients.update', $client) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Raison sociale *</label>
                    <input type="text" name="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ old('raison_sociale', $client->raison_sociale) }}" required>
                    @error('raison_sociale')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $client->email) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $client->telephone) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ville</label>
                    <input type="text" name="ville" class="form-control" value="{{ old('ville', $client->ville) }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Adresse</label>
                    <textarea name="adresse" class="form-control" rows="2">{{ old('adresse', $client->adresse) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white">
                    <i class="bi bi-check-lg me-2"></i> Mettre à jour
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection