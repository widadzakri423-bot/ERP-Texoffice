@extends('layouts.app')

@section('title', 'Modifier devis - Texoffice')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Modifier devis</h2>
    <p class="text-muted mb-0">{{ $devi->numero }} — {{ $devi->client->raison_sociale }}</p>
</div>

<div class="content-card">
    <div class="p-4">
        <form action="{{ route('devis.update', $devi) }}" method="POST" id="devisForm">
            @csrf @method('PUT')
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">N° Devis</label>
                    <input type="text" class="form-control" value="{{ $devi->numero }}" disabled>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Client *</label>
                    <select name="client_id" class="form-select" required>
                        @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $devi->client_id) == $client->id ? 'selected' : '' }}>
                            {{ $client->raison_sociale }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Date validité *</label>
                    <input type="date" name="date_validite" class="form-control" value="{{ old('date_validite', $devi->date_validite->format('Y-m-d')) }}" required>
                </div>
            </div>

            <h5 class="fw-bold mb-3 border-bottom pb-2">Lignes de devis</h5>
            <div id="lignesContainer">
                @foreach($devi->lignes as $index => $ligne)
                <div class="row g-2 align-items-end mb-3 ligne-devis">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Article</label>
                        <select name="lignes[{{ $index }}][article_id]" class="form-select article-select" onchange="updatePrix(this)" required>
                            @foreach($articles as $article)
                            <option value="{{ $article->id }}" data-prix="{{ $article->prix_unitaire }}" data-designation="{{ $article->designation }}"
                                {{ $ligne->article_id == $article->id ? 'selected' : '' }}>
                                {{ $article->reference }} - {{ $article->designation }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Désignation</label>
                        <input type="text" name="lignes[{{ $index }}][designation]" class="form-control designation-input" value="{{ $ligne->designation }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">Qté</label>
                        <input type="number" name="lignes[{{ $index }}][quantite]" class="form-control quantite-input" value="{{ $ligne->quantite }}" min="0.01" step="0.01" onchange="calculerTotal()" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small text-muted">P.U (DH)</label>
                        <input type="number" name="lignes[{{ $index }}][prix_unitaire]" class="form-control prix-input" value="{{ $ligne->prix_unitaire }}" min="0" step="0.01" onchange="calculerTotal()" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label small text-muted">Remise %</label>
                        <input type="number" name="lignes[{{ $index }}][remise_ligne]" class="form-control remise-input" value="{{ $ligne->remise_ligne }}" min="0" max="100" step="0.01" onchange="calculerTotal()">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="this.closest('.ligne-devis').remove(); calculerTotal();">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-outline-primary btn-sm mb-4" onclick="ajouterLigne()">
                <i class="bi bi-plus-lg me-1"></i> Ajouter une ligne
            </button>

            <div class="row g-3 mb-4 bg-light p-3 rounded-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Remise globale (%)</label>
                    <input type="number" name="remise_globale" id="remiseGlobale" class="form-control" value="{{ old('remise_globale', $devi->remise_globale) }}" min="0" max="100" step="0.01" onchange="calculerTotal()">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">TVA (%)</label>
                    <input type="number" name="tva" id="tva" class="form-control" value="{{ old('tva', $devi->tva) }}" min="0" max="100" step="0.01" onchange="calculerTotal()">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Notes</label>
                    <textarea name="notes" class="form-control" rows="1">{{ old('notes', $devi->notes) }}</textarea>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center bg-dark text-white p-3 rounded-3 mb-4">
                <span class="fw-semibold">TOTAL TTC</span>
                <span class="fs-4 fw-bold" id="totalTtcDisplay">{{ number_format($devi->montant_ttc, 2, ',', ' ') }} DH</span>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom text-white">
                    <i class="bi bi-check-lg me-2"></i> Mettre à jour
                </button>
                <a href="{{ route('devis.index') }}" class="btn btn-outline-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
const articles = @json($articles);

function ajouterLigne() {
    const container = document.getElementById('lignesContainer');
    const index = container.children.length;
    
    let options = '<option value="">Choisir article...</option>';
    articles.forEach(a => {
        options += `<option value="${a.id}" data-prix="${a.prix_unitaire}" data-designation="${a.designation}">${a.reference} - ${a.designation} (Stock: ${a.quantite_stock})</option>`;
    });

    const ligne = document.createElement('div');
    ligne.className = 'row g-2 align-items-end mb-3 ligne-devis';
    ligne.innerHTML = `
        <div class="col-md-4">
            <label class="form-label small text-muted">Article</label>
            <select name="lignes[${index}][article_id]" class="form-select article-select" onchange="updatePrix(this)" required>
                ${options}
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted">Désignation</label>
            <input type="text" name="lignes[${index}][designation]" class="form-control designation-input" required>
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted">Qté</label>
            <input type="number" name="lignes[${index}][quantite]" class="form-control quantite-input" value="1" min="0.01" step="0.01" onchange="calculerTotal()" required>
        </div>
        <div class="col-md-2">
            <label class="form-label small text-muted">P.U (DH)</label>
            <input type="number" name="lignes[${index}][prix_unitaire]" class="form-control prix-input" value="0" min="0" step="0.01" onchange="calculerTotal()" required>
        </div>
        <div class="col-md-1">
            <label class="form-label small text-muted">Remise %</label>
            <input type="number" name="lignes[${index}][remise_ligne]" class="form-control remise-input" value="0" min="0" max="100" step="0.01" onchange="calculerTotal()">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="this.closest('.ligne-devis').remove(); calculerTotal();">
                <i class="bi bi-trash"></i>
            </button>
        </div>
    `;
    container.appendChild(ligne);
}

function updatePrix(select) {
    const option = select.options[select.selectedIndex];
    const ligne = select.closest('.ligne-devis');
    ligne.querySelector('.prix-input').value = option.dataset.prix || 0;
    ligne.querySelector('.designation-input').value = option.dataset.designation || '';
    calculerTotal();
}

function calculerTotal() {
    let totalHt = 0;
    document.querySelectorAll('.ligne-devis').forEach(ligne => {
        const qte = parseFloat(ligne.querySelector('.quantite-input').value) || 0;
        const pu = parseFloat(ligne.querySelector('.prix-input').value) || 0;
        const remise = parseFloat(ligne.querySelector('.remise-input').value) || 0;
        totalHt += (qte * pu) * (1 - remise / 100);
    });

    const remiseGlobale = parseFloat(document.getElementById('remiseGlobale').value) || 0;
    totalHt -= totalHt * (remiseGlobale / 100);

    const tva = parseFloat(document.getElementById('tva').value) || 0;
    const ttc = totalHt * (1 + tva / 100);

    document.getElementById('totalTtcDisplay').textContent = ttc.toLocaleString('fr-FR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' DH';
}
</script>
@endsection