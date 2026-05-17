@extends('layouts.app')

@section('title', 'Nouveau client - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Nouveau client</h2>
    <p class="text-muted mb-0">Créer une fiche client</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('clients.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Raison sociale *</label>
                    <input type="text" name="raison_sociale" class="form-control @error('raison_sociale') is-invalid @enderror" value="{{ old('raison_sociale') }}" required>
                    @error('raison_sociale')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                    @error('email')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Téléphone</label>
                    <input type="text" name="telephone" class="form-control" value="{{ old('telephone') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Ville</label>
                    <input type="text" name="ville" class="form-control" value="{{ old('ville') }}">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Adresse</label>
                    <textarea name="adresse" class="form-control" rows="2">{{ old('adresse') }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success" >
                    <i class="bi bi-check-lg me-2"></i> Enregistrer
                </button>
                <a href="{{ route('clients.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection