<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Trader PDF</title>
    <style>
        @font-face { 
            font-family: 'arabictypesetting'; 
            src: url('{{ public_path('fonts/ARABTYPE.TTF') }}') format('truetype'); 
        }
        body { font-family: 'arabictypesetting'; direction: rtl; text-align: right; margin: 0; }
        .field { position: absolute; font-size: 16pt; color: #000; }

        /* تعريف الخلفيات */
        .page-g12r{ width: 210mm; height: 297mm; background-image: url("{{ public_path('images/G12R.jpg') }}"); background-size: cover; } 
        .page-g12v { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/G12V.jpg') }}"); background-size: cover; }
        .page-g08r { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/G08.jpg') }}"); background-size: cover; }
        
        .page-g12bisr { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/G12BisR1.jpg') }}"); background-size: cover; }
        .page-g12bisv { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/G12BisV1.jpg') }}"); background-size: cover; }

</style> 
<body>

@if($type == 'full')
    <div class="page-g12r"></div>
<div class="field" style="top: 1cm; right: 19.2cm; font-size: 10pt; font-weight: bold;width: 30px ;">:BP</div>
    <div class="field" style="top: 1cm; right: 16.7cm; font-size: 10pt; font-weight: bold; ">{{ $trader_tax->BP }}</div>


    <div class="field" style="top: 1.75cm; right: 13cm; font-size: 14pt; font-weight: bold; ">SETIF</div>
<div class="field" style="top: 2.2cm; right: 12cm; font-size: 14pt;font-weight: bold;">CPI AIN OULMENE</div>
 <div class="field" style="top: 3cm; right: 12cm; font-size: 14pt;font-weight: bold;">AIN OULMENE</div>
<div class="field" style="top: 4.1cm; right: 13.5cm; font-size: 14pt;">{{ $trader_tax->tax_year }}</div>
<div class="field" style="top: 5.2cm; right: 1.2cm; font-size: 14pt;">{{ $trader_tax->tax_year }}</div>
 <div class="field" style="top: 8.05cm; right: 9cm; font-size: 14pt;">{{ $trader_tax->trader->last_nameFR }} {{ $trader_tax->trader->first_nameFR }}</div>
 <div class="field" style="top: 9.2cm; right: 8.5cm; font-size: 14pt;">{{ $trader_tax->date_start }}</div>
 @if ($trader_tax->adrress_activity == 'تاجر متنقل') <div class="field" style="top: 11.9cm; right: 8.5cm; font-weight: bold; font-size: 14pt;">AMBULANT</div> 
 @elseif ($trader_tax->adrress_activity == 'نقل عمومي للبضائع') <div class="field" style="top: 11.9cm; right: 8.5cm; font-weight: bold; font-size: 14pt;">TRANSPORTEUR</div> 
 @else <div class="field" style="top: 11.9cm; right: 5.5cm; font-weight: bold; font-size: 10pt;">{{ $trader_tax->adrress_activity }}</div> @endif 
 <div class="field" style="top: 12.5cm; right: 7cm; font-size: 12pt;">{{ $trader_tax->trader->address_fr }}</div>
 <div class="field" style="top: 13.1cm; right: 7cm; font-size: 14pt;">{{ $trader_tax->Nif }}</div>
 <div class="field" style="top: 13.7cm; right: 7cm; font-size: 14pt;">{{ $trader_tax->trader->NIN }}</div> 
 <div class="field" style="top: 14.3cm; right: 7cm; font-size: 14pt;">{{ $trader_tax->numero_matiere }}</div>

 @if ($trader_tax->tax_value == '5')
 <div class="field" style="top: 17cm; right: 10.4cm; font-weight: bold; font-size: 14pt;">000 600</div> 
 <div class="field" style="top: 17cm; right: 2.5cm; font-weight: bold; font-size: 14pt;">000 30</div> 
 @elseif ($trader_tax->tax_value == '12')
    <div class="field" style="top: 17.8cm; right: 10.4cm; font-weight: bold; font-size: 14pt;">000 250</div>
    <div class="field" style="top: 17.8cm; right: 2.5cm; font-weight: bold; font-size: 14pt;">000 30</div>
    @endif
    <div class="field" style="top: 19.4cm; right: 2.5cm; font-weight: bold; font-size: 14pt;">000 30</div>
    <div class="field" style="top: 26.44cm; right: 14.5cm; font-weight: bold; font-size: 12pt;">A / O</div>
    <div class="field" style="top: 26.44cm; right: 10.5cm; font-weight: bold; font-size: 12pt;">{{ date('d/m/Y') }}</div>
@php
    $trader = $trader_tax->trader;

    $activity = $trader->mainActivityFr
        ?? $trader->activitiesFr->first();
@endphp

@if($activity)

<div class="field" style="top:8.7cm; right:4.7cm; width:12cm;font-size: 12pt;">
    {{ $activity->activity }}
</div>

@endif 
 
    <div class="page-g12v"></div>

     <div class="field" style="top: 2cm; right: 6cm; font-size: 12pt;">{{ $trader_tax->Nif }}</div>
    <div class="field" style="top: 5.4cm; right: 16cm; font-weight: bold; font-size: 13pt;">000 30</div>
    <div class="field" style="top: 5.8cm; right: 14cm; font-weight: bold; font-size: 12pt;">TRENT MILLE-DA</div>

@elseif($type == 'g12bis')

<div class="page-g12bisr"></div>
<div class="field" style="top: 0.4cm; right: 18cm; font-size: 10pt; font-weight: bold;width: 80px ; ">:matricule</div>
<div class="field" style="top: 1cm; right: 19.2cm; font-size: 10pt; font-weight: bold;width: 30px ;">:BP</div>
<div class="field" style="top: 0.4cm; right: 14.7cm; font-size: 11pt; font-weight: bold; ">{{ $trader_tax->matricule }}</div>
<div class="field" style="top: 1cm; right: 17cm; font-size: 11pt; font-weight: bold; ">{{ $trader_tax->BP }}</div>

<div class="field" style="top: 1.75cm; right: 13cm; font-size: 14pt; font-weight: bold; ">SETIF</div>
<div class="field" style="top: 2.2cm; right: 12cm; font-size: 14pt;font-weight: bold;">CPI AIN OULMENE</div>
 <div class="field" style="top: 3cm; right: 12cm; font-size: 14pt;font-weight: bold;">AIN OULMENE</div>
<div class="field" style="top: 4.3cm; right: 14.2cm; font-size: 14pt;font-weight: bold;">{{ $trader_tax->tax_year }}</div>
<div class="field" style="top: 5.7cm; right: 1.45cm; font-size: 14pt;font-weight: bold;">{{ $trader_tax->tax_year }}</div>
 <div class="field" style="top: 10.23cm; right: 9cm; font-size: 14pt;">{{ $trader_tax->trader->last_nameFR }} {{ $trader_tax->trader->first_nameFR }}</div>
 <div class="field" style="top: 11.5cm; right: 8.5cm; font-size: 14pt;">{{ $trader_tax->date_start }}</div>
@php
    $trader = $trader_tax->trader;

    $activity = $trader->mainActivityFr
        ?? $trader->activitiesFr->first();
@endphp

@if($activity)

<div class="field" style="top:11cm; right:5cm; width:12cm;font-size: 12pt;">
    {{ $activity->activity }}
</div>

@endif 


 @if ($trader_tax->adrress_activity == 'تاجر متنقل') <div class="field" style="top: 14.4cm; right: 8.5cm; font-weight: bold; font-size: 14pt;">AMBULANT</div> 
 @elseif ($trader_tax->adrress_activity == 'نقل عمومي للبضائع') <div class="field" style="top: 14.4cm; right: 8cm; font-weight: bold; font-size: 14pt;">TRANSPORTEUR</div>
 @else <div class="field" style="top: 14.4cm; right: 5.5cm; font-weight: bold; font-size: 10pt;">{{ $trader_tax->adrress_activity }}</div> @endif 
 <div class="field" style="top: 15cm; right: 7cm; font-size: 12pt;">{{ $trader_tax->trader->address_fr }}</div>
 <div class="field" style="top: 15.6cm; right: 7cm; font-size: 14pt;">{{ $trader_tax->Nif }}</div>
 <div class="field" style="top: 16.2cm; right: 7cm; font-size: 14pt;">{{ $trader_tax->trader->NIN }}</div> 
 <div class="field" style="top: 16.8cm; right: 7cm; font-size: 14pt;">{{ $trader_tax->numero_matiere }}</div>
 <div class="field" style="top: 17.42cm; right: 7cm;  font-size: 14pt;">{{ $trader_tax->trader->phone }}</div>


<div class="page-g12bisv"></div>

 @if ($trader_tax->tax_value == '5')
 <div class="field" style="top: 16.2cm; right: 10cm; font-weight: bold; font-size: 14pt;">000 150</div> 
 
 <div class="field" style="top: 4cm; right: 14.8cm; font-weight: bold; font-size: 10pt;">000 600</div>
 <div class="field" style="top: 4cm; right: 11cm; font-weight: bold; font-size: 10pt;">000 600</div>
 <div class="field" style="top: 4cm; right: 9cm; font-weight: bold; font-size: 10pt;">000 600</div>
 <div class="field" style="top: 4cm; right: 5.1cm; font-weight: bold; font-size: 10pt;">000 600</div>
 <div class="field" style="top: 4cm; right: 3.8cm; font-weight: bold; font-size: 12pt;">0,00</div>
 
 <div class="field" style="top: 4cm; right: 1cm; font-weight: bold; font-size: 12pt;">Neant</div> 
 <div class="field" style="top: 8.5cm; right: 1cm; font-weight: bold; font-size: 12pt;">Neant</div> 
 
 @elseif ($trader_tax->tax_value == '12')
 <div class="field" style="top: 16.2cm; right: 10cm; font-weight: bold; font-size: 14pt;">000 150</div> 
 
 <div class="field" style="top: 5.55cm; right: 14.8cm; font-weight: bold; font-size: 10pt;">000 250</div>
 <div class="field" style="top: 5.55cm; right: 11cm; font-weight: bold; font-size: 10pt;">000 250</div>
 <div class="field" style="top: 5.55cm; right: 9cm; font-weight: bold; font-size: 10pt;">000 250</div>
 <div class="field" style="top: 5.55cm; right: 5.1cm; font-weight: bold; font-size: 10pt;">000 250</div>
 <div class="field" style="top: 5.55cm; right: 3.8cm; font-weight: bold; font-size: 12pt;">0,00</div>
 
 <div class="field" style="top: 5.5cm; right: 1cm; font-weight: bold; font-size: 12pt;">Neant</div> 
 <div class="field" style="top: 8.5cm; right: 1cm; font-weight: bold; font-size: 12pt;">Neant</div> 
    @endif
    @endif

</body>