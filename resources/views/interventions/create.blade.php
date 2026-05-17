@extends('layouts.app')

@section('title', 'Nouvelle intervention - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Nouvelle intervention</h2>
    <p class="text-muted mb-0">Maintenance machine</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('interventions.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Machine *</label>
                    <select name="machine_id" class="form-select" required>
                        <option value="">Choisir...</option>
                        @foreach($machines as $machine)
                        <option value="{{ $machine->id }}">{{ $machine->reference }} - {{ $machine->designation }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date *</label>
                    <input type="date" name="date_intervention" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Type *</label>
                    <select name="type" class="form-select" required>
                        <option value="preventive">Préventive</option>
                        <option value="corrective">Corrective</option>
                        <option value="revision">Révision</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Coût (DH)</label>
                    <input type="number" name="cout" class="form-control" value="0" min="0" step="0.01">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Technicien</label>
                    <input type="text" name="technicien" class="form-control">
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Description *</label>
                    <textarea name="description" class="form-control" rows="2" required></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold">Pièces remplacées</label>
                    <textarea name="pieces_remplacees" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn text-white text-decoration-none" style="background: var(--success); border: none; padding: 10px 20px; border-radius: 10px; font-weight: 500;">
                    <i class="bi bi-check-lg me-2"></i> Enregistrer
                </button>
                <a href="{{ route('interventions.index') }}" class="btn btn-danger">Annuler</a>
            </div>
        </form>
    </div>
</div>
@endsection