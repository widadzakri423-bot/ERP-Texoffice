@extends('layouts.app')

@section('title', 'Devis ' . $devi->numero . ' - Texoffice')

@section('content')
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="fw-bold mb-1">Devis {{ $devi->numero }}</h2>
            <p class="text-muted mb-0">{{ $devi->client->raison_sociale }}</p>
        </div>
        <div class="d-flex gap-2">
            @if($devi->statut === 'brouillon')
            <form action="{{ route('devis.statut', $devi) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="statut" value="envoye">
                <button class="btn btn-primary"><i class="bi bi-send me-2"></i> Envoyer</button>
            </form>
            <a href="{{ route('devis.edit', $devi) }}" class="btn btn-warning text-white"><i class="bi bi-pencil me-2"></i> Modifier</a>
 <a href="{{ route('devis.duplicate', $devi) }}" class="btn btn-info text-white">
                <i class="bi bi-copy me-2"></i> Dupliquer
            </a>
            <a href="{{ route('devis.pdf', $devi) }}" class="btn btn-secondary text-white" target="_blank">
    <i class="bi bi-file-earmark-pdf me-2"></i> PDF
</a>

            @elseif($devi->statut === 'envoye')
            <form action="{{ route('devis.statut', $devi) }}" method="POST" class="d-inline">
                @csrf @method('PATCH')
                <input type="hidden" name="statut" value="accepte">
                <button class="btn btn-success"><i class="bi bi-check-lg me-2"></i> Accepter</button>
            </form>
            <form action="{{ route('devis.statut', $devi) }}" method="POST" class="d-inline">
                @csrf @method('PATCH')
                <input type="hidden" name="statut" value="refuse">
                <button class="btn btn-danger"><i class="bi bi-x-lg me-2"></i> Refuser</button>
            </form>
            @endif
            <a href="{{ route('devis.index') }}" class="btn btn-outline-secondary">Retour</a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="content-card mb-4">
            <div class="card-header-custom">
                <h5><i class="bi bi-file-earmark-text text-primary"></i> Détails du devis</h5>
            </div>
            <div class="p-4">
                <div class="row g-3 mb-4">
                    <div class="col-md-4"><strong>Date création :</strong> {{ $devi->date_creation->format('d/m/Y') }}</div>
                    <div class="col-md-4"><strong>Validité :</strong> {{ $devi->date_validite->format('d/m/Y') }}</div>
                    <div class="col-md-4"><strong>Par :</strong> {{ $devi->user->name }}</div>
                </div>
                  <!-- ⬇️ MACHINES MOBILISÉES ⬇️ -->
    @if($devi->machines->count())
    <div class="content-card mb-4" style="border-left: 4px solid #0d6efd;">
        <div class="card-header-custom bg-white border-0 pt-3">
            <h6 class="fw-bold mb-0 text-primary"><i class="bi bi-gear-wide-connected me-2"></i> Machines mobilisées</h6>
        </div>
        <div class="p-0">
            <table class="table custom-table mb-0">
                <thead>
                    <tr>
                        <th>Machine</th>
                        <th>Référence</th>
                        <th class="text-center">Heures</th>
                        <th class="text-end">Coût total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($devi->machines as $machine)
                    <tr>
                        <td class="fw-semibold">{{ $machine->designation }}</td>
                        <td class="text-muted">{{ $machine->reference }}</td>
                        <td class="text-center">{{ $machine->pivot->nb_heures }} h</td>
                        <td class="text-end fw-bold">{{ number_format($machine->pivot->cout_total, 2, ',', ' ') }} DH</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th>Article</th>
                            <th class="text-end">Qté</th>
                            <th class="text-end">P.U</th>
                            <th class="text-end">Remise</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($devi->lignes as $ligne)
                        <tr>
                            <td>{{ $ligne->designation }}</td>
                            <td class="text-end">{{ $ligne->quantite }}</td>
                            <td class="text-end">{{ number_format($ligne->prix_unitaire, 2, ',', ' ') }} DH</td>
                            <td class="text-end">{{ $ligne->remise_ligne }}%</td>
                            <td class="text-end fw-bold">{{ number_format($ligne->total_ligne, 2, ',', ' ') }} DH</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="content-card mb-4">
            <div class="p-4">
                <div class="d-flex justify-content-between mb-2"><span>Total HT</span><span class="fw-bold">{{ number_format($devi->montant_ht, 2, ',', ' ') }} DH</span></div>
                <div class="d-flex justify-content-between mb-2"><span>TVA ({{ $devi->tva }}%)</span><span>{{ number_format($devi->montant_ttc - $devi->montant_ht, 2, ',', ' ') }} DH</span></div>
                <hr>
                <div class="d-flex justify-content-between"><span class="fs-5 fw-bold">TOTAL TTC</span><span class="fs-5 fw-bold text-primary">{{ number_format($devi->montant_ttc, 2, ',', ' ') }} DH</span></div>
            </div>
        </div>

        <div class="content-card">
            <div class="card-header-custom">
                <h5><i class="bi bi-info-circle"></i> Informations</h5>
            </div>
            <div class="p-4">
                <p><strong>Statut :</strong> 
                    <span class="badge-custom {{ match($devi->statut) {
                        'brouillon' => 'badge-brouillon',
                        'envoye' => 'badge-envoye',
                        'accepte' => 'badge-accepte',
                        'refuse' => 'badge-refuse',
                        default => 'badge-brouillon'
                    } }}">{{ ucfirst($devi->statut) }}</span>
                </p>
                @if($devi->notes)
                <p><strong>Notes :</strong> {{ $devi->notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection