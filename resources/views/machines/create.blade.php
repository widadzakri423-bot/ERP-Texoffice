@extends('layouts.app')

@section('title', 'Nouvelle machine - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Nouvelle machine</h2>
    <p class="text-muted mb-0">Ajouter un équipement au parc</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('machines.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Référence *</label>
                    <input type="text" name="reference" class="form-control @error('reference') is-invalid @enderror" required>
                    @error('reference')<<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Désignation *</label>
                    <input type="text" name="designation" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Marque</label>
                    <input type="text" name="marque" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Modèle</label>
                    <input type="text" name="modele" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">État</label>
                    <select name="etat" class="form-select">
                        <option value="disponible">Disponible</option>
                        <option value="en_maintenance">En maintenance</option>
                        <option value="hors_service">Hors service</option>
                        <option value="occupe">Occupé</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date d'acquisition</label>
                    <input type="date" name="date_acquisition" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Coût/heure (DH)</label>
                    <input type="number" name="cout_heure" class="form-control" value="0" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success"><i class="bi bi-check-lg me-2"></i> Enregistrer</button>
                <a href="{{ route('machines.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection