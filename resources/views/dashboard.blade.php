@extends('layouts.app')

@section('title', 'Tableau de bord - Texoffice')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center animate-fade-in">
    <div>
        <h2 class="fw-bold mb-1">Tableau de bord</h2>
        <p class="text-muted mb-0" style="font-size:0.9rem;">Vue d'ensemble de votre activité commerciale</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-calendar3 me-2"></i> {{ now()->format('d F Y') }}
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6 animate-fade-in delay-1">
        <div class="stat-card border-brouillon">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label mb-1">Devis en brouillon</div>
                    <div class="stat-value" style="color: #6c757d;">{{ $statsDevis['brouillon'] }}</div>
                </div>
                <div class="icon-circle bg-icon-brouillon">
                    <i class="bi bi-file-earmark"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in delay-2">
        <div class="stat-card border-envoye">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label mb-1">Devis envoyés</div>
                    <div class="stat-value" style="color: #0d6efd;">{{ $statsDevis['envoye'] }}</div>
                </div>
                <div class="icon-circle bg-icon-envoye">
                    <i class="bi bi-send-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in delay-3">
        <div class="stat-card border-accepte">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label mb-1">Devis acceptés</div>
                    <div class="stat-value" style="color: #198754;">{{ $statsDevis['accepte'] }}</div>
                </div>
                <div class="icon-circle bg-icon-accepte">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 animate-fade-in delay-4">
        <div class="stat-card border-refuse">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-label mb-1">Devis refusés</div>
                    <div class="stat-value" style="color: #dc3545;">{{ $statsDevis['refuse'] }}</div>
                </div>
                <div class="icon-circle bg-icon-refuse">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ... garde le reste du fichier inchangé ... -->

<div class="row g-4">
    <!-- Graphique Evolution -->
    <div class="col-lg-8">
        <div class="card stat-card h-100">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-graph-up"></i> Évolution des devis (12 derniers mois)</h5>
            </div>
            <div class="card-body">
                <canvas id="evolutionChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Valeur Stock + Alertes -->
    <div class="col-lg-4">
        <div class="card stat-card mb-3">
            <div class="card-body text-center">
                <h6 class="text-muted">Valeur totale du stock</h6>
                <h3 class="fw-bold text-primary">{{ number_format($valeurStock, 2, ',', ' ') }} DH</h3>
            </div>
        </div>
        <div class="card stat-card">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-triangle"></i> Stock bas ({{ $stockAlerte->count() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($stockAlerte->count())
                    <ul class="list-group list-group-flush">
                        @foreach($stockAlerte as $article)
                        <li class="list-group-item alert-stock d-flex justify-content-between">
                            <span>{{ $article->designation }}</span>
                            <span class="badge bg-danger">{{ $article->quantite_stock }} / {{ $article->seuil_minimum }}</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-3 text-muted text-center">Aucune alerte stock</div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mt-1">
    <!-- Machines en panne -->
    <div class="col-lg-6">
        <div class="card stat-card">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0 text-warning"><i class="bi bi-gear-wide-connected"></i> Machines en panne / maintenance ({{ $machinesPanne->count() }})</h5>
            </div>
            <div class="card-body p-0">
                @if($machinesPanne->count())
                    <ul class="list-group list-group-flush">
                        @foreach($machinesPanne as $machine)
                        <li class="list-group-item machine-panne d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $machine->designation }}</strong>
                                <div class="small text-muted">{{ $machine->reference }} — {{ $machine->marque }}</div>
                            </div>
                            <span class="badge bg-warning text-dark text-uppercase">{{ $machine->etat }}</span>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="p-3 text-muted text-center">Toutes les machines sont opérationnelles</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Derniers mouvements -->
    <div class="col-lg-6">
        <div class="card stat-card">
            <div class="card-header bg-white border-0 pt-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-clock-history"></i> Dernières activités</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($derniersMouvements as $mouvement)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge {{ $mouvement->type === 'entree' ? 'bg-success' : 'bg-danger' }}">
                                {{ $mouvement->type }}
                            </span>
                            <strong>{{ $mouvement->article->designation }}</strong>
                            <div class="small text-muted">par {{ $mouvement->user->name }} — {{ $mouvement->date_mouvement->format('d/m/Y') }}</div>
                        </div>
                        <span class="fw-bold">{{ $mouvement->quantite }} {{ $mouvement->article->unite }}</span>
                    </li>
                    @empty
                    <li class="list-group-item text-muted text-center">Aucun mouvement récent</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Derniers devis -->
<div class="card stat-card mt-4">
    <div class="card-header bg-white border-0 pt-3 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0"><i class="bi bi-file-earmark-text"></i> Derniers devis</h5>
        <a href="{{ route('devis.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Montant TTC</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                @forelse($derniersDevis as $devis)
                <tr>
                    <td><a href="{{ route('devis.show', $devis) }}" class="fw-bold text-decoration-none">{{ $devis->numero }}</a></td>
                    <td>{{ $devis->client->raison_sociale }}</td>
                    <td>{{ $devis->date_creation->format('d/m/Y') }}</td>
                    <td class="fw-bold">{{ number_format($devis->montant_ttc, 2, ',', ' ') }} DH</td>
                    <td>
                        <span class="badge bg-{{ $devis->statut === 'brouillon' ? 'secondary' : ($devis->statut === 'envoye' ? 'primary' : ($devis->statut === 'accepte' ? 'success' : 'danger')) }}">
                            {{ ucfirst($devis->statut) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted">Aucun devis</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('evolutionChart').getContext('2d');
    const evolutionChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($evolutionDevis->pluck('mois')) !!},
            datasets: [{
                label: 'Nombre de devis',
                data: {!! json_encode($evolutionDevis->pluck('total')) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
@endsection