<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tmoral PDF</title>
    <style>
        @font-face { 
            font-family: 'amiri'; 
            src: url('{{ public_path('fonts/ARABTYPE.TTF') }}') format('truetype'); 
        }
        body { font-family: 'amiri'; direction: rtl; text-align: right; margin: 0; }
        .field { position: absolute; font-size: 16pt; color: #000; }

        /* تعريف الخلفيات */
         .page_1 { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/BNF3.jpg') }}"); background-size: cover; } 
        .page_2 { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/BNF4.jpg') }}"); background-size: cover; }
    </style> 
</head>
<body>


    <div class="page_1"></div>
    @if ($beneficiary->demande == 'طلب قيد') <div class="field" style="top: 5.4cm; right: 18.83cm; font-weight: bold;font-size: 12pt;">x</div> @endif
    @if ($beneficiary->demande == 'طلب تعديل') <div class="field" style="top: 5.4cm; right: 9.8cm; font-weight: bold;font-size: 12pt;">x</div> @endif
    <div style="top: 7.7cm; right: 5cm;" class="field">{{ $beneficiary->social_label_fr }}</div>
    <div style="top: 8.58cm; right: 5cm;width: 600px;" class="field">{{ $beneficiary->authorized_person_identity_fr }}</div>
    <div style="top: 9.74cm; right: 6cm;font-size: 16pt;" class="field">{{ $beneficiary->number_of_register }}</div>
    @if ($beneficiary->mentioned == 'non') <div class="field" style="top: 11.15cm; right: 10cm; font-weight: bold;font-size: 12pt;">x</div>@endif
    @if ($beneficiary->mentioned == 'oui') <div class="field" style="top: 11.15cm; right: 12.68cm; font-weight: bold;font-size: 12pt;">x</div>
    <div style="top: 13.9cm; right: 2cm;font-size: 14pt;" class="field">{{ $beneficiary->full_identity_fr }}</div>
    <div style="top: 15.1cm; right: 6cm;font-size: 14pt;" class="field">{{ $beneficiary->nationalities_fr }}</div>
    <div class="field" style="top: 16.86cm; right: 18.04cm; font-weight: bold;font-size: 12pt;">x</div>
    <div class="field" style="top: 17.66cm; right: 18.04cm; font-weight: bold;font-size: 12pt;">x</div>
    <div style="top: 17.5cm; right: 2.56cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 18.3cm; right: 2.56cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 22.8cm; right: 4cm;font-size: 16pt; "class="field">{{ $beneficiary->date_of_this }}</div>
     @endif
     <pagebreak  />
     <div class="page_2"></div>
 @if ($beneficiary->mentioned == 'non')  
     <div style="top: 2.8cm; right: 3cm;font-size: 16pt;" class="field">{{ $beneficiary->full_name_fr }}</div>
    <div style="top: 3.6cm; right: 3cm;font-size: 16pt;" class="field">{{ $beneficiary->nationalities_fr }}</div>
    <div style="top: 4.4cm; right: 12cm;font-size: 16pt;" class="field">{{ $beneficiary->date_of_birth }}</div>
    <div style="top: 4.4cm; right: 4.6cm;font-size: 16pt;" class="field">{{ $beneficiary->place_of_birth_fr }}</div>
    <div style="top: 5.2cm; right: 3.6cm;font-size: 16pt;" class="field">{{ $beneficiary->address_fr }}</div>
    <div style="top: 6.9cm; right: 9.8cm;font-size: 16pt;" class="field">{{ $beneficiary->number_card }}</div>
    <div style="top: 6.9cm; right: 3cm;font-size: 16pt;" class="field">{{ $beneficiary->date1_card }}</div>
    <div style="top: 7.7cm; right: 3cm;font-size: 16pt;" class="field">{{ $beneficiary->date2_card }}</div>
    <div style="top: 7.7cm; right: 10.5cm;font-size: 16pt;" class="field">{{ $beneficiary->place_card_fr }}</div>
    <div style="top: 8.5cm; right: 6.9cm;font-size: 16pt;" class="field">{{ $beneficiary->number_of_passport }}</div>
    <div style="top: 8.5cm; right: 1cm;font-size: 16pt;" class="field">{{ $beneficiary->date1_passport }}</div>
    <div style="top: 9.35cm; right: 3cm;font-size: 16pt;" class="field">{{ $beneficiary->date2_passport }}</div>
    <div style="top: 9.35cm; right: 12cm;font-size: 16pt;" class="field">{{ $beneficiary->place_passport_fr }}</div>
    <div style="top: 10.2cm; right: 4cm;font-size: 16pt;" class="field">{{ $beneficiary->other_document_fr }}</div>
    <div class="field" style="top: 12cm; right: 18.25cm; font-weight: bold;font-size: 12pt;">x</div>
    <div class="field" style="top: 12.8cm; right: 18.25cm; font-weight: bold;font-size: 12pt;">x</div>
    <div style="top: 12.6cm; right: 2.5cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 13.5cm; right: 2.5cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 18.1cm; right: 7cm;font-size: 16pt;" class="field">{{ $beneficiary->date_of_this }}</div>
    <div style="top: 24.15cm; right: 6cm;font-size: 16pt;" class="field">{{ $beneficiary->declaration_date }}</div>
     @if ($beneficiary->found == 'oui') <div class="field" style="top: 19cm; right: 8cm; font-weight: bold;font-size: 12pt;">x</div>@endif
     @if ($beneficiary->found == 'non') <div class="field" style="top: 19cm; right: 5.82cm; font-weight: bold;font-size: 12pt;">x</div>@endif
@endif

</body>
</html>