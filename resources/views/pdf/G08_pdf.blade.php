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
        .page-g08r { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/G08.jpg') }}"); background-size: cover; }

</style> 
<body>
<div class="page-g08r"></div>
<div class="field" style="top: 2.5cm; right: 2cm; font-size: 13pt; background-color: aliceblue;">{{ $trader->nif }}</div>
<div class="field" style="top: 3.25cm; right: 17.2cm; font-size: 11pt; font-weight: bolder; ">SETIF</div>
<div class="field" style="top: 3.65cm; right: 14.5cm; font-size: 12pt; font-weight: bolder; ">{{  $trader->cpi }}</div>
<div class="field" style="top: 10cm; right: 9cm; font-size: 12pt;">{{ $trader->last_nameFR }} {{ $trader->first_nameFR }}</div>
<div class="field" style="top: 10.6cm; right: 7cm; font-size: 12pt; background-color: aliceblue;font-weight: bolder; ">{{ $trader->NIN }}</div>
<div class="field" style="top: 11.1cm; right: 12cm; font-size: 11pt; font-weight: bold; ">personne physique</div> 
@php
    
    $activity = $trader->mainActivityFr
        ?? $trader->activitiesFr->first();
@endphp

@if($activity)

<div class="field" style="top:11.8cm; right:1cm; width:16cm; font-size: 12pt; font-weight: bold;">
    {{ $activity->activity }}
</div>

@endif 

@if ($trader->activity_address_g08 == 'تاجر متنقل' || $trader->activity_address_g08 == 'نقل عمومي للبضائع') 
<div class="field" style="top: 17.4cm; right: 9cm; font-size: 14pt; font-weight: bold; ">TRANSPORTEUR</div> 
@else 
<div class="field" style="top: 17cm; right: 10cm; font-size: 11pt; font-weight: bold; ">{{ $trader->activity_address_g08 }}</div>
@endif
<div class="field" style="top: 21cm; right: 14cm; font-size: 11pt; font-weight: bold; ">{{ $trader->address_fr }}</div>
<div class="field" style="top: 21.68cm; right: 13.8cm; font-size: 11pt; font-weight: bold; ">{{ $trader->phone }}</div>
<div class="field" style="top: 21.68cm; right: 1.4cm; font-size: 10pt; font-weight: bold; ">{{ $trader->email }}</div>
<div class="field" style="top: 22.3cm; right: 7cm; font-size: 11pt; font-weight: bold; ">{{ $trader->number_of_register }}</div>
<div class="field" style="top: 23.9cm; right: 7cm; font-size: 11pt; font-weight: bold; ">{{ $trader->starting_date }}</div>
<div class="field" style="top: 25.68cm; right: 1cm; font-weight: bold; font-size: 13pt;">{{ date('d/m/Y') }}</div>
<div class="field" style="top: 25.72cm; right: 5cm; font-weight: bold; font-size: 12pt;">{{ $trader->place_g08 }}</div>

</body>