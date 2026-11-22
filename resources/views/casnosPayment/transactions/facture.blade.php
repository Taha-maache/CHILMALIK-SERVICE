<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">

    <title>Facture CASNOS</title>

    <style>
        @page {
            margin: 20mm 15mm 18mm 15mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        .invoice {
            width: 100%;
        }

        /* HEADER */

        .header {
            width: 100%;
            border-bottom: 2px solid #111827;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header-table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-table td {
            vertical-align: top;
            border: none;
            padding: 0;
        }

        .company {
            width: 60%;
        }

        .invoice-info {
            width: 40%;
            text-align: right;
        }

        .company-name {
            font-size: 23px;
            font-weight: bold;
            letter-spacing: .5px;
            color: #111827;
            margin-bottom: 5px;
        }

        .company-subtitle {
            font-size: 11px;
            color: #6b7280;
            margin-bottom: 9px;
        }

        .company-line {
            font-size: 10px;
            line-height: 1.7;
            color: #374151;
        }

        .invoice-title {
            font-size: 25px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 8px;
        }

        .invoice-number {
            font-size: 11px;
            color: #4b5563;
            line-height: 1.8;
        }

        /* SECTION */

        .section-title {
            color: #111827;
            border-bottom: 1px solid #111827;
            padding: 6px 0;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 16px;
            margin-bottom: 0;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d1d5db;
        }

        .info-table td {
            border: 1px solid #d1d5db;
            padding: 8px 10px;
        }

        .label {
            width: 22%;
            background: #f9fafb;
            font-weight: bold;
            color: #374151;
        }

        /* SITUATION */

        .situation-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .situation-table td {
            width: 33.33%;
            border: 1px solid #d1d5db;
            text-align: center;
            padding: 12px 8px;
        }

        .situation-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .situation-value {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
        }

        .reste-box {
            background: #f9fafb;
        }

        /* PAYMENT TABLE */

        .payments-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 0;
        }

        .payments-table th {
            background: #f3f4f6;
            color: #111827;
            border: 1px solid #d1d5db;
            padding: 8px 6px;
            font-size: 10px;
            text-align: center;
        }

        .payments-table td {
            border: 1px solid #d1d5db;
            padding: 8px 6px;
            font-size: 10px;
        }

        .payments-table tbody tr:nth-child(even) {
            background: #f9fafb;
        }

        .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .amount {
            font-weight: bold;
            white-space: nowrap;
        }

        /* TOTALS */

        .totals-wrapper {
            width: 100%;
            margin-top: 15px;
        }

        .totals-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
        }

        .totals-table td {
            border: 1px solid #d1d5db;
            padding: 9px 10px;
        }

        .totals-label {
            background: #f9fafb;
            font-weight: bold;
        }

        .total-paid {
            font-size: 14px;
            font-weight: bold;
            color: #15803d;
        }

        .total-rest {
            font-size: 15px;
            font-weight: bold;
            color: #dc2626;
        }

        .paid-value {
            color: #15803d;
        }

        .rest-value {
            color: #dc2626;
        }

        .due-breakdown {
            margin-top: 8px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            background: #f9fafb;
            font-size: 10px;
            line-height: 1.8;
        }

        .due-breakdown strong {
            color: #111827;
        }

        .penalty-value {
            color: #b45309;
            font-weight: bold;
        }

        /* FOOTER */

        .footer {
            margin-top: 35px;
            border-top: 1px solid #d1d5db;
            padding-top: 12px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            width: 50%;
            vertical-align: top;
            border: none;
        }

        .signature {
            text-align: right;
        }

        .signature-title {
            font-weight: bold;
            margin-bottom: 40px;
        }

        .signature-line {
            border-top: 1px solid #6b7280;
            width: 170px;
            margin-left: auto;
            padding-top: 5px;
            font-size: 9px;
            color: #6b7280;
        }

        .footer-note {
            font-size: 9px;
            color: #6b7280;
            line-height: 1.6;
        }

        .status {
            display: inline-block;
            padding: 4px 9px;
            border: 1px solid #9ca3af;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            padding: 15px !important;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

<div class="invoice">

@php
    // أصل الدين
    $montantOriginal = (float) $montantOriginal;

    // مجموع الدفعات
    $montantPaye = (float) $montantPaye;

    // الباقي قبل الزيادة
    $resteInitial = (float) $resteInitial;

    // التأخير
    $nombreMois = (int) $nombreMois;

    // نسبة الزيادة
    $tauxAugmentation = (float) $tauxAugmentation;

    // قيمة الزيادة على الباقي فقط
    $augmentation = (float) $augmentation;

    // الباقي النهائي بعد الزيادة
    $resteAPayer = (float) $resteAPayer;

    // إجمالي المستحقات مع المدفوع
    $montantDu = (float) $montantDu;
@endphp

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="header">

        <table class="header-table">

            <tr>

                <td class="company">

                    <div class="company-name">
                        CHILLCOM SERVICE
                    </div>

                    <div class="company-subtitle">
                        Services & Accompagnement Administratif
                    </div>

                    <div class="company-line">
                        Adresse : 📍 حي الاخوة تامر خلف بلدية عين ولمان
                    </div>

                    <div class="company-line">
                        Téléphone : 📞 0555710848
                                        
                    </div>
                    <div class="company-line">
                        WhatsApp: ✉️+213 555710848
                    </div>

                </td>


                <td class="invoice-info">

                    <div class="invoice-title">
                        FACTURE
                    </div>

                    <div class="invoice-number">
                        <strong>FACTURE CASNOS</strong>
                    </div>

                    <div class="invoice-number">
                        N° : CASNOS-{{ str_pad($casnosPayment->id, 6, '0', STR_PAD_LEFT) }}
                    </div>

                    <div class="invoice-number">
                        Date :
                        {{ optional($casnosPayment->date_paiement)->format('d/m/Y') }}
                    </div>

                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
         CLIENT
    ========================================================== --}}

    <div class="section-title">
        Informations du client
    </div>

    <table class="info-table">

        <tr>

            <td class="label">
                Client
            </td>

            <td>
                {{ $casnosPayment->trader?->first_name ?? '' }}
                {{ $casnosPayment->trader?->last_name ?? '' }}
            </td>

            <td class="label">
                Matricule CASNOS
            </td>

            <td>
                {{ $casnosPayment->matricule }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Téléphone
            </td>

            <td>
                {{ $casnosPayment->trader?->phone ?? '-' }}
            </td>

            <td class="label">
                Date de paiement
            </td>

            <td>
                {{ optional($casnosPayment->date_paiement)->format('d/m/Y') }}
            </td>

        </tr>


        <tr>

            <td class="label">
                Situation
            </td>

            <td colspan="3">
                <span class="status">
                    {{ $status }}
                </span>
            </td>

        </tr>

    </table>


    {{-- =========================================================
         SITUATION CASNOS
    ========================================================== --}}

    <div class="section-title">
        Situation CASNOS
    </div>

    <table class="situation-table">

        <tr>

            <td>

                <div class="situation-label">
                    Montant dû
                </div>

                <div class="situation-value">
                    {{ number_format($montantDu, 2, ',', ' ') }} DA
                </div> 
                <div class="due-breakdown">
                    <div>Montant initial : <strong>{{ number_format($montantOriginal, 2, ',', ' ') }} DA</strong></div>
                    <div>Retard constaté : <strong>{{ (int) $nombreMois }} mois</strong></div>
                    <div>Taux de majoration : <strong>{{ number_format((float) $tauxAugmentation, 2, ',', ' ') }} %</strong></div>
                    <div>Majoration calculée : <strong class="penalty-value">+ {{ number_format((float) $augmentation, 2, ',', ' ') }} DA</strong></div>
                    <div>Total dû après majoration : <strong>{{ number_format($montantDu, 2, ',', ' ') }} DA</strong></div>
                </div>

            </td>


            <td>

                <div class="situation-label">
                    Montant payé
                </div>

                <div class="situation-value paid-value">
                    {{ number_format($montantPaye, 2, ',', ' ') }} DA
                </div>

            </td>


            <td class="reste-box">

                <div class="situation-label">
                    Reste à payer
                </div>

                <div class="situation-value rest-value" style="color: #dc2626" >
                    {{ number_format($resteAPayer, 2, ',', ' ') }} DA
                </div>

            </td>

        </tr>

    </table>


    {{-- =========================================================
         HISTORIQUE DES PAIEMENTS
    ========================================================== --}}

    <div class="section-title">
        Historique des paiements
    </div>

    <table class="payments-table">

        <thead>

            <tr>

                <th style="width: 7%;">
                    #
                </th>

                <th style="width: 16%;">
                    Date
                </th>

                <th style="width: 20%;">
                    Référence
                </th>

                <th>
                    Description
                </th>

                <th style="width: 18%;">
                    Montant
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($transactions as $index => $transaction)

                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td class="center">
                        {{ optional($transaction->payment_date)->format('d/m/Y') }}
                    </td>

                    <td class="center">
                        {{ $transaction->reference ?? '-' }}
                    </td>

                    <td>
                        {{ $transaction->description ?? 'Paiement CASNOS' }}
                    </td>

                    <td class="right amount">
                        {{ number_format((float) $transaction->amount, 2, ',', ' ') }}
                        DA
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="empty">
                        Aucun paiement enregistré.
                    </td>

                </tr>

            @endforelse

        </tbody>


        @if($transactions->count() > 0)

            <tfoot>

                <tr>

                    <td colspan="4" class="right">
                        <strong>TOTAL DES PAIEMENTS</strong>
                    </td>

                    <td class="right amount" style="color: #15803d;">
                        {{ number_format((float) $totalTransactions, 2, ',', ' ') }}
                        DA
                    </td>

                </tr>

            </tfoot>

        @endif

    </table>


    {{-- =========================================================
         RÉCAPITULATIF
    ========================================================== --}}

    <div class="totals-wrapper">

        <table class="totals-table">

            <tr>

                <td class="totals-label">
                    Montant dû
                </td>

                <td class="right">
                    {{ number_format($montantOriginal, 2, ',', ' ') }} DA
                    <br>
                    <span class="penalty-value">Majoration : + {{ number_format((float) $augmentation, 2, ',', ' ') }} DA</span>
                    <br>
                    <strong>Total : {{ number_format($montantDu, 2, ',', ' ') }} DA</strong>
                </td>

            </tr>


            <tr>

                <td class="totals-label">
                    Total payé
                </td>

                <td class="right total-paid">
                    {{ number_format($montantPaye, 2, ',', ' ') }} DA
                </td>

            </tr>


            <tr>

                <td class="totals-label">
                    Reste à payer
                </td>

                <td class="right total-rest">
                    {{ number_format($resteAPayer, 2, ',', ' ') }} DA
                </td>

            </tr>

        </table>

    </div>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}

    <div class="footer">

        <table class="footer-table">

            <tr>

                <td>

                    <div class="footer-note">

                        <strong>Observation :</strong><br>

                        Cette facture récapitule les paiements enregistrés
                        pour le dossier CASNOS du client mentionné ci-dessus.

                        <br><br>

                        Document généré le
                        {{ now()->format('d/m/Y à H:i') }}.

                    </div>

                </td>


                <td class="signature">

                    <div class="signature-title">
                        Signature & Cachet
                    </div>

                    <div class="signature-line">
                        Signature / Cachet
                    </div>

                </td>

            </tr>

        </table>

    </div>

</div>

</body>

</html>