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
        .field { position: absolute; font-size: 18pt; color: #000; }

        /* تعريف الخلفيات */
         .page_1 { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/BNF1.jpg') }}"); background-size: cover; } 
        .page_2 { width: 210mm; height: 297mm; background-image: url("{{ public_path('images/BNF2.jpg') }}"); background-size: cover; }
    </style> 
</head>
<body>


    <div class="page_1"></div>
    @if ($beneficiary->demande == 'طلب قيد') <div class="field" style="top: 6.2cm; right: 1.8cm; font-weight: bold;">x</div> @endif
    @if ($beneficiary->demande == 'طلب تعديل') <div class="field" style="top: 6.2cm; right: 10cm; font-weight: bold;">x</div> @endif
    <div style="top: 8.2cm; right: 6.2cm;" class="field">{{ $beneficiary->social_label }}</div>
    <div style="top: 8.9cm; right: 6.2cm;width: 600px;" class="field">{{ $beneficiary->authorized_person_identity }}</div>
    <div style="top: 10.2cm; right: 6cm;font-size: 16pt;" class="field">{{ $beneficiary->number_of_register }}</div>
    @if ($beneficiary->mentioned == 'non') <div class="field" style="top: 11.65cm; right: 4.8cm; font-weight: bold;">x</div>@endif  
    @if ($beneficiary->mentioned == 'oui') <div class="field" style="top: 11.65cm; right: 2.9cm; font-weight: bold;">x</div>
    <div style="top: 14.6cm; right: 7.6cm;font-size: 16pt;" class="field">{{ $beneficiary->full_identity }}</div>
    <div style="top: 15.9cm; right: 6.6cm;font-size: 16pt;" class="field">{{ $beneficiary->nationalities }}</div>
    <div class="field" style="top: 17.6cm; right: 2.56cm; font-weight: bold;">x</div>
    <div class="field" style="top: 18.4cm; right: 2.56cm; font-weight: bold;">x</div>
    <div style="top: 18.5cm; right: 16.6cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 19.3cm; right: 16.6cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 24.4cm; right: 14cm;font-size: 16pt;" class="field">{{ $beneficiary->date_of_this }}</div>
     @endif
     <pagebreak  />
     <div class="page_2"></div>
 @if ($beneficiary->mentioned == 'non')  
     <div style="top: 2.6cm; right: 7cm;font-size: 16pt;" class="field">{{ $beneficiary->full_name }}</div>
    <div style="top: 3.5cm; right: 8cm;font-size: 16pt;" class="field">{{ $beneficiary->nationalities }}</div>
    <div style="top: 4.35cm; right: 4.6cm;font-size: 16pt;" class="field">{{ $beneficiary->date_of_birth }}</div>
    <div style="top: 4.35cm; right: 12cm;font-size: 16pt;" class="field">{{ $beneficiary->place_of_birth }}</div>
    <div style="top: 5.2cm; right: 3.6cm;font-size: 16pt;" class="field">{{ $beneficiary->address }}</div>
    <div style="top: 6.9cm; right: 7cm;font-size: 16pt;" class="field">{{ $beneficiary->number_card }}</div>
    <div style="top: 6.9cm; right: 15cm;font-size: 16pt;" class="field">{{ $beneficiary->date1_card }}</div>
    <div style="top: 7.7cm; right: 13.8cm;font-size: 16pt;" class="field">{{ $beneficiary->date2_card }}</div>
    <div style="top: 7.7cm; right: 4.5cm;font-size: 16pt;" class="field">{{ $beneficiary->place_card }}</div>
    <div style="top: 8.6cm; right: 12.6cm;font-size: 16pt;" class="field">{{ $beneficiary->number_of_passport }}</div>
    <div style="top: 8.6cm; right: 17.2cm;font-size: 16pt;" class="field">{{ $beneficiary->date1_passport }}</div>
    <div style="top: 9.4cm; right: 14cm;font-size: 16pt;" class="field">{{ $beneficiary->date2_passport }}</div>
    <div style="top: 9.4cm; right: 4.2cm;font-size: 16pt;" class="field">{{ $beneficiary->place_passport }}</div>
    <div style="top: 10.3cm; right: 8.6cm;font-size: 16pt;" class="field">{{ $beneficiary->other_document }}</div>
    <div class="field" style="top: 12.2cm; right: 2.5cm; font-weight: bold;">x</div>
    <div class="field" style="top: 13cm; right: 2.5cm; font-weight: bold;">x</div>
    <div style="top: 13cm; right: 16.6cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 13.9cm; right: 16.6cm;font-size: 16pt;" class="field">%{{ number_format($beneficiary->percentage, 0) }} </div>
    <div style="top: 20cm; right: 4cm;font-size: 16pt;" class="field">{{ $beneficiary->date_of_this }}</div>
    <div style="top: 24.9cm; right: 14cm;font-size: 16pt;" class="field">{{ $beneficiary->declaration_date }}</div>
     @if ($beneficiary->found == 'oui') <div class="field" style="top: 20.92cm; right: 12.91cm; font-weight: bold;">x</div>@endif
     @if ($beneficiary->found == 'non') <div class="field" style="top: 20.92cm; right: 14.81cm; font-weight: bold;">x</div>@endif
@endif

</body>
</html>