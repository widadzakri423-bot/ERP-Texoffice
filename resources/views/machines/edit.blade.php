@extends('layouts.app')

@section('title', 'Modifier machine - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Modifier machine</h2>
    <p class="text-muted mb-0">{{ $machine->designation }}</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('machines.update', $machine) }}" method="POST">
            @csrf @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Référence *</label>
                    <input type="text" name="reference" class="form-control" value="{{ old('reference', $machine->reference) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Désignation *</label>
                    <input type="text" name="designation" class="form-control" value="{{ old('designation', $machine->designation) }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Marque</label>
                    <input type="text" name="marque" class="form-control" value="{{ old('marque', $machine->marque) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Modèle</label>
                    <input type="text" name="modele" class="form-control" value="{{ old('modele', $machine->modele) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">État</label>
                    <select name="etat" class="form-select">
                        @foreach(['disponible', 'en_maintenance', 'hors_service', 'occupe'] as $etat)
                        <option value="{{ $etat }}" {{ old('etat', $machine->etat) == $etat ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $etat)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Date d'acquisition</label>
                    <input type="date" name="date_acquisition" class="form-control" value="{{ old('date_acquisition', $machine->date_acquisition?->format('Y-m-d')) }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Coût/heure (DH)</label>
                    <input type="number" name="cout_heure" class="form-control" value="{{ old('cout_heure', $machine->cout_heure) }}" min="0" step="0.01">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="2">{{ old('notes', $machine->notes) }}</textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white"><i class="bi bi-check-lg me-2"></i> Mettre à jour</button>
                <a href="{{ route('machines.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection