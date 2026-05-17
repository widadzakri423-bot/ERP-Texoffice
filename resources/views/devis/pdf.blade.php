<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Devis {{ $devi->numero }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e3a5f; padding-bottom: 20px; }
        .header h1 { color: #1e3a5f; margin: 0; font-size: 24px; }
        .header p { color: #666; margin: 5px 0; }
        .info-box { margin-bottom: 20px; }
        .info-box table { width: 100%; }
        .info-box td { padding: 5px 0; }
        .info-box .label { font-weight: bold; color: #1e3a5f; width: 30%; }
        table.items { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table.items th { background: #1e3a5f; color: white; padding: 10px; text-align: left; }
        table.items td { padding: 10px; border-bottom: 1px solid #ddd; }
        table.items .text-right { text-align: right; }
        .totals { margin-top: 20px; text-align: right; }
        .totals table { width: 300px; margin-left: auto; }
        .totals td { padding: 5px; }
        .totals .total-row { font-size: 16px; font-weight: bold; color: #1e3a5f; border-top: 2px solid #1e3a5f; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #ddd; padding-top: 20px; }
    </style>
</head>
<body>

<div class="header">
    <h1>DEVIS</h1>
    <p>N° {{ $devi->numero }}</p>
    <p>Texoffice ERP - Système de Gestion Commerciale</p>
</div>

<div class="info-box">
    <table>
        <tr>
            <td class="label">Date de création :</td>
            <td>{{ $devi->date_creation->format('d/m/Y') }}</td>
            <td class="label">Date de validité :</td>
            <td>{{ $devi->date_validite->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Client :</td>
            <td colspan="3">{{ $devi->client->raison_sociale }}</td>
        </tr>
        <tr>
            <td class="label">Adresse :</td>
            <td colspan="3">{{ $devi->client->adresse ?? '-' }}, {{ $devi->client->ville ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Téléphone :</td>
            <td>{{ $devi->client->telephone ?? '-' }}</td>
            <td class="label">Email :</td>
            <td>{{ $devi->client->email ?? '-' }}</td>
        </tr>
    </table>
</div>

<table class="items">
    <thead>
        <tr>
            <th>N°</th>
            <th>Désignation</th>
            <th class="text-right">Qté</th>
            <th class="text-right">P.U (DH)</th>
            <th class="text-right">Remise %</th>
            <th class="text-right">Total (DH)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($devi->lignes as $index => $ligne)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $ligne->designation }}</td>
            <td class="text-right">{{ $ligne->quantite }}</td>
            <td class="text-right">{{ number_format($ligne->prix_unitaire, 2, ',', ' ') }}</td>
            <td class="text-right">{{ $ligne->remise_ligne }}%</td>
            <td class="text-right">{{ number_format($ligne->total_ligne, 2, ',', ' ') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="totals">
    <table>
        <tr>
            <td>Total HT :</td>
            <td class="text-right">{{ number_format($devi->montant_ht, 2, ',', ' ') }} DH</td>
        </tr>
        <tr>
            <td>TVA ({{ $devi->tva }}%) :</td>
            <td class="text-right">{{ number_format($devi->montant_ttc - $devi->montant_ht, 2, ',', ' ') }} DH</td>
        </tr>
        <tr class="total-row">
            <td>TOTAL TTC :</td>
            <td class="text-right">{{ number_format($devi->montant_ttc, 2, ',', ' ') }} DH</td>
        </tr>
    </table>
</div>

@if($devi->notes)
<div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
    <strong>Notes :</strong><br>
    {{ $devi->notes }}
</div>
@endif

<div class="footer">
    <p>Document généré par Texoffice ERP - OFPPT ISTA</p>
    <p>Page 1/1</p>
</div>

</body>
</html>