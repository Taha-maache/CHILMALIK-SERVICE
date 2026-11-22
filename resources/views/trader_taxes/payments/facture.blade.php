<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Facture Paiement Tax</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #222222;
            margin: 30px;
        }

        /* ===== TOP BAND ===== */
        .top-band {
            border-bottom: 2px solid #333333;
            padding-bottom: 14px;
            margin-bottom: 24px;
        }

        .top-band table {
            width: 100%;
            border-collapse: collapse;
        }

        .top-band td {
            border: none;
            padding: 0;
            vertical-align: top;
        }

        .brand-title {
            font-size: 19px;
            font-weight: bold;
            color: #111111;
            margin: 0 0 4px 0;
        }

        .brand-sub {
            font-size: 11px;
            color: #666666;
        }

        .doc-tag {
            display: inline-block;
            border: 1px solid #999999;
            padding: 4px 12px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
            color: #333333;
        }

        .doc-meta {
            text-align: right;
            font-size: 11px;
            color: #666666;
            margin-top: 6px;
        }

        /* ===== SECTION BOX ===== */
        .section {
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #333333;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #cccccc;
            padding-bottom: 6px;
            margin-bottom: 10px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            border: none;
            padding: 4px 6px;
            font-size: 12px;
        }

        .info-table .label {
            color: #666666;
            width: 110px;
        }

        .info-table .value {
            font-weight: bold;
            color: #111111;
        }

        /* ===== DATA TABLE ===== */
        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px;
        }

        table.data th {
            background: #f2f2f2;
            color: #222222;
            border: 1px solid #cccccc;
            padding: 8px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            text-align: center;
        }

        table.data td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: center;
            font-size: 12px;
        }

        table.data tr:nth-child(even) td {
            background: #fafafa;
        }

        .amount-cell {
            font-weight: bold;
        }

        /* ===== SUMMARY BOX ===== */
        .summary-box {
            width: 55%;
            margin-left: auto;
            margin-top: 6px;
            border: 1px solid #cccccc;
            border-radius: 3px;
            overflow: hidden;
        }

        .summary-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-box td {
            padding: 9px 14px;
            font-size: 12px;
            border-bottom: 1px solid #e6e6e6;
        }

        .summary-box tr:last-child td {
            border-bottom: none;
        }

        .summary-box .s-label {
            color: #444444;
        }

        .summary-box .s-value {
            text-align: right;
            font-weight: bold;
            color: #111111;
        }

        .row-remaining {
            background: #f5f5f5;
        }

        .row-remaining .s-label,
        .row-remaining .s-value {
            font-weight: bold;
        }

        /* ===== SIGNATURE ===== */
        .signature {
            margin-top: 50px;
            text-align: right;
            font-size: 12px;
        }

        .signature-line {
            display: inline-block;
            margin-top: 34px;
            border-top: 1px solid #999999;
            width: 180px;
        }

        .footer-note {
            margin-top: 40px;
            font-size: 9px;
            color: #999999;
            text-align: center;
            border-top: 1px solid #dddddd;
            padding-top: 10px;
        }
    </style>
</head>

<body>

    {{-- TOP BAND --}}
    <div class="top-band">
        <table>
            <tr>
                <td style="width:60%">
                    <div class="brand-title">Facture de Paiement</div>
                    <div class="brand-sub">Taxe / Commerçant</div>
                </td>
                <td style="width:40%">
                    <div class="doc-meta">
                        <span class="doc-tag">TAX / TRADER</span><br>
                        Paiement N° {{ $payment->id }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- CLIENT --}}
    <div class="section">
        <div class="section-title">Informations du client</div>
        <table class="info-table">
            <tr>
                <td class="label">Nom :</td>
                <td class="value">{{ $traderTax->trader->first_name ?? '' }} {{ $traderTax->trader->last_name ?? '' }}</td>
                <td class="label">NIN :</td>
                <td class="value">{{ $traderTax->trader->NIN ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Année :</td>
                <td class="value">{{ $traderTax->tax_year }}</td>
                <td class="label">Date paiement :</td>
                <td class="value">{{ $payment->payment_date?->format('d/m/Y') }}</td>
            </tr>
        </table>
    </div>

    {{-- PAYMENT --}}
    <div class="section">
        <div class="section-title">Paiement actuel</div>
        <table class="data">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Référence</th>
                    <th>Description</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $payment->payment_date?->format('d/m/Y') }}</td>
                    <td>{{ $payment->reference ?? '-' }}</td>
                    <td>{{ $payment->description ?? '-' }}</td>
                    <td class="amount-cell">{{ number_format($payment->amount, 2, ',', ' ') }} DA</td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- SITUATION --}}
    <div class="section">
        <div class="section-title">Situation du compte</div>
        <div class="summary-box">
            <table>
                <tr>
                    <td class="s-label">Montant dû</td>
                    <td class="s-value">{{ number_format($totalDue, 2, ',', ' ') }} DA</td>
                </tr>
                <tr>
                    <td class="s-label">Total payé</td>
                    <td class="s-value">{{ number_format($totalPaid, 2, ',', ' ') }} DA</td>
                </tr>
                <tr class="row-remaining">
                    <td class="s-label">Reste à payer</td>
                    <td class="s-value">{{ number_format($remaining, 2, ',', ' ') }} DA</td>
                </tr>
                @if($overpaid > 0)
                <tr>
                    <td class="s-label">Surplus</td>
                    <td class="s-value">{{ number_format($overpaid, 2, ',', ' ') }} DA</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    {{-- HISTORIQUE --}}
    <div class="section">
        <div class="section-title">Historique des paiements</div>
        <table class="data">
            <thead>
                <tr>
                    <th style="width:8%">#</th>
                    <th>Date</th>
                    <th>Référence</th>
                    <th>Montant</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->payment_date?->format('d/m/Y') }}</td>
                    <td>{{ $p->reference ?? '-' }}</td>
                    <td>{{ number_format($p->amount, 2, ',', ' ') }} DA</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- SIGNATURE --}}
    <div class="signature">
        Signature :
        <div class="signature-line"></div>
    </div>

    <div class="footer-note">
        Document généré automatiquement — Facture de paiement Tax / Trader
    </div>

</body>
</html>