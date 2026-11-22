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
        @endif 
     }

        /* تعريف الخلفيات */
             .page_1 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/CNRC1.jpg') }}"); background-size: cover; } 
        .page_2 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/CNRC2.jpg') }}"); background-size: cover; }
        .page_3 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/CNRC3.jpg') }}"); background-size: cover; }
        .page_4 { width: 297mm; height: 420mm; background-image: url("{{ public_path('images/CNRC4.jpg') }}"); background-size: cover; } 
        .page_5 { size: A4 portrait; width: 210mm; height: 297mm; background-image: url("{{ public_path('images/RN.jpg') }}"); background-size: cover;  }
    </style> 
</head>
<body>


    <div class="page_1"></div>
    <div style="top: 23.1cm; right: 19.5cm; " class="field">NIN:{{ $trader->NIN }}</div>
    <div style="top: 24.7cm; right: 5.8cm; width: 300px;" class="field">{{ $trader->first_name }}</div>
    <div style="top: 24.7cm; right: 17.5cm; width: 300px;" class="field">{{ $trader->last_name }}</div>
    <div style="top: 38.5cm; right: 10.4cm;" class="field">{{ $trader->first_nameFR }}</div>
    <div style="top: 38.5cm; right: 6.4cm;" class="field">{{ $trader->last_nameFR }}</div>
    <div style="top: 25.8cm; right: 7.7cm; background-color: ghostwhite" class="field">{{ $trader->date_of_birth }}</div>
    <div style="top: 25.9cm; right: 17cm;" class="field">{{ $trader->place_of_birth }}</div>
    <div style="top: 27.1cm; right: 5.2cm;width: 300px;" class="field">{{ $trader->father_name }}</div>
    <div style="top: 27.1cm; right: 14cm;width: 300px;" class="field">{{ $trader->mother_name }}</div>
    <div style="top: 27.1cm; right: 22.3cm;" class="field">{{ $trader->nationality }}</div>
    <div style="top: 28.3cm; right: 6.6cm;" class="field">{{ $trader->address }}</div>
    <div style="top: 29.35cm; right: 17.2cm; background-color: ghostwhite" class="field">{{ $trader->county_code }}</div>
    <div style="top: 29.5cm; right: 22.4cm;width: 300px;" class="field">{{ $trader->state }}</div>
    <div style="top: 30.7cm; right: 7.1cm; background-color: ghostwhite;" class="field">{{ $trader->phone }}</div>
    <div style="top: 31.7cm; right: 7.7cm;" class="field">{{ $trader->email }}</div> 
    <div style="top: 35.5cm; right: 8.8cm; width: 300px;" class="field">{{ $trader->Rationalization_contract_number }}</div>
    @if ($trader->nature_RC == 'قيد جديد') <div class="field" style="top: 19.53cm; right: 5.41cm; font-weight: bold;">x</div> @endif
    @if ($trader->nature_RC == 'تعديل') <div class="field" style="top: 21.95cm; right: 5.42cm; font-weight: bold;">x</div> @endif
    @if ($trader->form_BA == 'تجارة قارة') <div class="field" style="top: 21.62cm; right: 11.8cm; font-weight: bold;">x</div> @endif
    @if ($trader->form_BA == 'تجارة غير قارة') <div class="field" style="top: 21.6cm; right: 16.15cm; font-weight: bold;">x</div> @endif
    @if ($trader->nature_local == 'رئيسي') <div class="field" style="top: 19.69cm; right: 27cm; font-weight: bold;">x</div> @endif
    @if ($trader->nature_local == 'ثانوي') <div class="field" style="top: 22cm; right: 27cm; font-weight: bold;">x</div> @endif
    <div style="top: 40.5cm; right: 24.8cm; width: 300px;font-size: 12pt;" class="field">{{ $total  }}</div>

    <pagebreak  />
    <div class="page_2"></div>
    <div style="top: 4.9cm; right: 8cm;" class="field">{{ $trader->Business_address }}</div>
    <div style="top: 6.6cm; right: 17cm; background-color: ghostwhite" class="field">{{ $trader->Municipality_code_Business }}</div>
    <div style="top: 6.6cm; right: 22.2cm;" class="field">{{ $trader->state_Business }}</div>
    <div style="top: 8.4cm; right: 8.2cm; background-color: ghostwhite" class="field">{{ $trader->Activity_start_date }}</div>
    <div style="top: 10.2cm; right: 6.6cm;" class="field">{{ $trader->Rental_period }}</div>
    <div style="top: 10.1cm; right: 13cm; background-color: ghostwhite" class="field">{{ $trader->date1 }}</div>
    <div style="top: 10.1cm; right: 20cm; background-color: ghostwhite" class="field">{{ $trader->date2 }}</div>
    <div style="top: 11.9cm; right: 10cm;width: 300px;" class="field">{{ $trader->Name_surname_landlord }}</div>
    @if ($trader->legal_nature_CP == 'ملكية') <div class="field" style="top: 13.7cm; right: 11.9cm; font-weight: bold;">x</div> @endif
    @if ($trader->legal_nature_CP == 'ايجار') <div class="field" style="top: 13.7cm; right: 15.8cm; font-weight: bold;">x</div> @endif
    <div style="top: 15.46cm; right: 8.2cm;" class="field">{{ $trader->Subordination_CP }}</div>
    <div style="top: 17.2cm; right: 8.3cm;" class="field">{{ $trader->Commercial_base_dependency }}</div>
    <div style="top: 21.52cm; right: 8.2cm;" class="field">{{ $trader->place_activity_Non_permanent_trade }}</div> 
    <div style="top: 23.88cm; right: 6.2cm; background-color: ghostwhite" class="field">{{ $trader->Municipality_code_Business_Non_permanent_trade }}</div> 
    <div style="top: 24cm; right: 20cm;" class="field">{{ $trader->state_Non_permanent_trade }}</div>
<pagebreak  />
    <div class="page_3"></div>
    <div style="top: 3.7cm; right: 2.75cm;width: 900px;line-height: 1.5;" class="field">{{ $trader->Modification }}</div> 
    @if ($trader->production_of_goods == 'oui') <div class="field" style="top: 8.58cm; right: 13.1cm; font-weight: bold;">x</div> @endif
    @if ($trader->Wholesale_distribution == 'oui') <div class="field" style="top: 10.3cm; right: 13.1cm; font-weight: bold;">x</div> @endif
    @if ($trader->Retail_distribution == 'oui') <div class="field" style="top: 8.4cm; right: 25.8cm; font-weight: bold;">x</div> @endif
    @if ($trader->Services == 'oui') <div class="field" style="top: 9.5cm; right: 25.8cm; font-weight: bold;">x</div> @endif
    @if ($trader->Export == 'oui') <div class="field" style="top: 10.6cm; right: 25.8cm; font-weight: bold;">x</div> @endif
@foreach($trader->activities as $index => $activity)

@php
    $digits = str_split($activity->code);
    $top = 14.02 + ($index * 2.22);
@endphp

{{-- التسمية --}}
<div class="field"
     style="top:{{ $top }}cm; right:2.3cm; width:20cm; font-weight: bold; line-height: 1.5;">
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
        <div style="top: 30cm; right: 1.8cm; font-size: 22px; font-weight: bolder" class="field" >الوكيل:{{ $trader->name_agence }}</div> 
    <div style="top: 31cm; right: 1.8cm; font-size: 22px; font-weight: bolder" class="field">ب ت و: رقم {{ $trader->number_card_agence }}</div> 
    <div style="top: 32cm; right: 1.8cm; font-size: 22px; font-weight: bolder" class="field">صادرة بتاريخ : {{ $trader->date_card_agence }}  ببلدية {{ $trader->municipality_agence }}</div> 

</body>
</html>