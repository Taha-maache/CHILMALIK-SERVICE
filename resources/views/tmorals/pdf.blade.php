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
        .field { position: absolute; font-size: 20pt;
        @if($color == 'black')
              color: #000;
        @else
                color: blue;
        @endif }

        /* تعريف الخلفيات */
             .page_1 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/TM1.jpg') }}"); background-size: cover; } 
        .page_2 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/TM2.jpg') }}"); background-size: cover; }
        .page_3 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/TM3.jpg') }}"); background-size: cover; }
        .page_4 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/TM4.jpg') }}"); background-size: cover; } 
    </style> 
</head>
<body>


    <div class="page_1"></div>
    <div style="top: 27.3cm; right: 22.1cm; width: 300px;font-size: 14pt;" class="field">NIN:{{ $tmoral->NIN }}</div>
    <div style="top: 28.55cm; right: 5.8cm; width: 300px;" class="field">{{ $tmoral->first_name }}</div>
    <div style="top: 28.55cm; right: 17.5cm; width: 300px;" class="field">{{ $tmoral->last_name }}</div>
    <div style="top: 29.5cm; right: 7.7cm; background-color: ghostwhite" class="field">{{ $tmoral->date_of_birth }}</div>
    <div style="top: 29.51cm; right: 16.6cm;" class="field">{{ $tmoral->place_of_birth }}</div>
    <div style="top: 30.5cm; right: 5.2cm;width: 300px;" class="field">{{ $tmoral->father_name }}</div>
    <div style="top: 30.5cm; right: 17.6cm;width: 300px;" class="field">{{ $tmoral->mother_name }}</div>
    <div style="top: 31.6cm; right: 4.35cm;" class="field">{{ $tmoral->nationality }}</div>
    <div style="top: 32.53cm; right: 6cm;" class="field">{{ $tmoral->address }}</div>
    <div style="top: 33.5cm; right: 17.2cm; background-color: ghostwhite" class="field">{{ $tmoral->county_code }}</div>
    <div style="top: 33.5cm; right: 22.6cm;width: 300px;" class="field">{{ $tmoral->state }}</div>
    <div style="top: 34.5cm; right: 7cm; background-color: ghostwhite;" class="field">{{ $tmoral->phone }}</div>
    <div style="top: 35.5cm; right: 7.6cm;" class="field">{{ $tmoral->email }}</div> 
    @if ($tmoral->nature_RC == 'قيد جديد') <div class="field" style="top: 15.65cm; right: 6.1cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->nature_RC == 'تعديل') <div class="field" style="top: 17.6cm; right: 6.12cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->nature_local == 'رئيسي') <div class="field" style="top: 15.6cm; right: 26.2cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->nature_local == 'ثانوي') <div class="field" style="top: 17.65cm; right: 26.2cm; font-weight: bold;">x</div> @endif
     <div style="top: 19.2cm; right: 7.2cm;" class="field">{{ $tmoral->Social_label_ar }}</div>
     <div style="top: 37.8cm; right: 4cm;" class="field">{{ $tmoral->Social_label_fr }}</div>
     <div style="top: 21.2cm; right: 10.2cm;" class="field">{{ $tmoral->Trade_name_ar }}</div>
     <div style="top: 22.15cm; right: 7.8cm; width: 300px;" class="field">{{ $tmoral->Legal_form_of_company_ar }}</div>
     <div style="top: 22.15cm; right: 14.8cm; width: 300px;" class="field">99 سنة</div>
     <div style="top: 23.2cm; right: 7.8cm;" class="field">{{ $tmoral->Social_address }}</div>
     <div style="top: 25.1cm; right: 5.8cm; background-color: ghostwhite" class="field">{{ $tmoral->phone }}</div>
     <div style="top: 24.2cm; right: 17cm; background-color: ghostwhite" class="field">{{ $tmoral->Municipal_code_social_headquarters }}</div>
     <div style="top: 24.2cm; right: 22.2cm; width: 300px;" class="field">{{ $tmoral->Social_state }}</div>
     <div style="top: 26.14cm; right: 6.6cm;" class="field">{{ $tmoral->email }}</div>
     <div style="top: 31.53cm; right: 15.8cm; width: 300px;" class="field">{{ $tmoral->adjectif }}</div>
     <div style="top: 22.15cm; right: 22.8cm; width: 300px;" class="field">{{ number_format($tmoral->Social_capital, 0) }}</div>

   


    <pagebreak  />
    <div class="page_2"></div>
    <div style="top: 3.9cm; right: 7cm;" class="field">{{ $tmoral->Social_label_institution }}</div>
    <div style="top: 5cm; right: 10.6cm;" class="field">{{ $tmoral->Business_address }}</div>
    <div style="top: 6.1cm; right: 17cm; background-color: ghostwhite" class="field">{{ $tmoral->Municipality_code_Business }}</div>
    <div style="top: 6.1cm; right: 22.2cm;" class="field">{{ $tmoral->state_Business }}</div>
    <div style="top: 7.2cm; right: 8.2cm; background-color: ghostwhite" class="field">{{ $tmoral->Activity_start_date }}</div>
    <div style="top: 8.35cm; right: 5.8cm;" class="field">{{ $tmoral->Rental_period }}</div>
    <div style="top: 8.35cm; right: 13cm; background-color: ghostwhite" class="field">{{ $tmoral->date1 }}</div>
    <div style="top: 8.35cm; right: 20cm; background-color: ghostwhite" class="field">{{ $tmoral->date2 }}</div>
    <div style="top: 9.5cm; right: 10cm;width: 300px;" class="field">{{ $tmoral->Name_surname_landlord }}</div>
    <div style="top: 11.6cm; right: 8cm;width: 300px;" class="field">{{ $tmoral->Subordination_CP }}</div>
    <div style="top: 12.8cm; right: 8cm;width: 300px;" class="field">{{ $tmoral->Commercial_base_dependency }}</div>
   
    @foreach($tmoral->representatives as $i => $rep)

<div class="field" style="top: {{ 17.9 + ($i*3.4) }}cm; right: 1.6cm; font-size: 18pt;width: 150px">
    {{ $rep->full_name }}
</div>


<div class="field" style="top: {{ 17.9 + ($i*3.4) }}cm; right: 8.8cm;font-size: 18pt;width: 150px">
    {{ $rep->date_of_birth }} - {{ $rep->place_of_birth }}
</div>

<div
    class="field"
    style="
        top: 16cm;
        right: 12.43cm;
        width: 3.6cm;
        height: 1.7cm;
        background-color: #fff;
        text-align: center;
        line-height: 1cm;
        font-size: 20pt;
        
    ">
    رقم التعريف الوطني
</div>

<div class="field" style="top: {{ 18.05 + ($i*3.4) }}cm; right: 12.45cm;font-size: 14pt;font-weight: bold;width: 150px;line-height: 1.55;">
  {{ $rep->NIN }}
</div>

<div class="field" style="top: {{ 17.9 + ($i*3.4) }}cm; right: 16.6cm;font-size: 18pt;width: 100px">
    {{ $rep->adjectif }}
</div>

<div class="field" style="top: {{ 17.9 + ($i*3.4) }}cm; right: 20cm;font-size: 18pt;width: 150px">
    {{ $rep->address }}
</div>

<div class="field" style="top: {{ 17.9 + ($i*3.4) }}cm; right: 25cm;font-size: 18pt;width: 150px">
    {{ $rep->nationality }}
</div>

@endforeach


<pagebreak  />
    <div class="page_3"></div>
    <div style="top: 3.75cm; right: 2.6cm;width: 900px; line-height: 1.45;" class="field">{{ $tmoral->Modification }}</div> 
    @if ($tmoral->production_of_goods == '1') <div class="field" style="top: 8.5cm; right: 14.1cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->Craft_production == '1') <div class="field" style="top: 9.6cm; right: 14.1cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->Wholesale_distribution == '1') <div class="field" style="top: 10.8cm; right: 14.1cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->Import_for_resale_asis == '1') <div class="field" style="top: 8.3cm; right: 25.8cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->Retail_distribution == '1') <div class="field" style="top: 9.2cm; right: 25.8cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->Services == '1') <div class="field" style="top: 10cm; right: 25.8cm; font-weight: bold;">x</div> @endif
    @if ($tmoral->Export == '1') <div class="field" style="top: 10.9cm; right: 25.8cm; font-weight: bold;">x</div> @endif
   
    @foreach($tmoral->activities as $index => $activity)

@php
    $digits = str_split($activity->code);
    $top = 14 + ($index * 2.22);
@endphp

{{-- التسمية --}}
<div class="field"
     style="top:{{ $top }}cm; right:2.3cm; width:20cm; font-weight: bold;line-height: 1.5;">
    {{ $activity->activity }}
</div>

{{-- الأرقام --}}
@foreach($digits as $i => $digit)

<div class="field"
     style="
        top:{{ $top }}cm;
        right:{{ 26.8 - ($i * 0.81) }}cm;
        width:5mm;
        text-align:center;
        font-weight:bold;
        font-size: 14pt;
     ">
    {{ $digit }}
</div>

@endforeach

@endforeach


    <pagebreak  />
    <div class="page_4"></div>
    <div style="top: 30cm; right: 1.8cm; font-size: 22px; font-weight: bolder" class="field" >الوكيل:{{ $tmoral->name_agence }}</div> 
    <div style="top: 31cm; right: 1.8cm; font-size: 22px; font-weight: bolder" class="field">ب ت و: رقم {{ $tmoral->number_card_agence }}</div> 
    <div style="top: 32cm; right: 1.8cm; font-size: 22px; font-weight: bolder" class="field">صادرة بتاريخ : {{ $tmoral->date_card_agence }}  ببلدية {{ $tmoral->municipality_agence }}</div> 

</body>
</html>