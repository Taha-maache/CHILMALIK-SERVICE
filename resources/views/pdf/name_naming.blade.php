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
        .field { position: absolute; font-size: 20pt; color: #000; }

               .page_5 {  width: 210mm; height: 297mm; background-image: url("{{ public_path('images/RN.jpg') }}"); background-size: cover;  }
    </style> 
</head>
<body>
    @if($name->type=='physique')
    <div class="page_5"></div>
    <div style="top: 8.65cm; right: 6cm;font-weight:bold; width: 300px; font-size: 24px;"  class="field">{{ $name->full_name }}</div>
    <div style="top: 9.65cm; right: 6.4cm;font-weight: bold;font-size: 24px;"  class="field">{{ $name->address }}</div>
    <div class="field" style="top: 11.8cm; right: 6.8cm; font-weight: bold;">x</div>
    <div style="top: 4.65cm; right: 4.2cm; font-size: 24px; font-weight: bold;"  class="field">سطيف</div>
    <div style="top: 21.6cm; right: 10.2cm; font-size: 18px;"font-weight: bold;  class="field">الوكيل: </div>
    <div style="top: 22.4cm; right: 8.2cm; font-size: 18px;"font-weight: bold;  class="field">0555710848</div>  
   
    <div style="top: 15.2cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_1 }}</div>
    <div style="top: 16.5cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_2 }}</div>
    <div style="top: 17.8cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_3 }}</div>
    <div style="top: 19.1cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_4 }}</div>

    <div style="top: 15.2cm; right: 11cm;  font-size: 18px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_1}}</div>
    <div style="top: 16.5cm; right: 11cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_2}}</div>
    <div style="top: 17.8cm; right: 11cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_3}}</div>
    <div style="top: 19.1cm; right: 11cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_4}}</div>
    @endif
    @if($name->type=='moral')
  <div class="page_5"></div>
    <div style="top: 8.65cm; right: 6cm;font-weight:bold; width: 300px; font-size: 24px;"  class="field">{{ $name->full_name }}</div>
    <div style="top: 9.65cm; right: 6.4cm;font-weight: bold;font-size: 24px;"  class="field">{{ $name->address }}</div>
    <div style="top: 10.6cm; right: 12.6cm;font-weight: bold;font-size: 24px;"  class="field">{{ $name->form_juridique}}</div>  
    <div class="field" style="top: 10.8cm; right: 6.8cm; font-weight: bold;">x</div>
    <div style="top: 4.65cm; right: 4.2cm; font-size: 24px; font-weight: bold;"  class="field">سطيف</div>
    <div style="top: 21.6cm; right: 10.2cm; font-size: 18px;"font-weight: bold;  class="field">الوكيل: </div>
    <div style="top: 22.4cm; right: 8.2cm; font-size: 18px;"font-weight: bold;  class="field">0555710848</div>  
   
    <div style="top: 15.2cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_1 }}</div>
    <div style="top: 16.5cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_2 }}</div>
    <div style="top: 17.8cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_3 }}</div>
    <div style="top: 19.1cm; right: 2.8cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_ar_4 }}</div>

    <div style="top: 15.2cm; right: 11cm;  font-size: 18px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_1}}</div>
    <div style="top: 16.5cm; right: 11cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_2}}</div>
    <div style="top: 17.8cm; right: 11cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_3}}</div>
    <div style="top: 19.1cm; right: 11cm;  font-size: 19px; font-weight: bold"; class="field">{{ $name->nom_commercial_fr_4}}</div>
   @endif
</body>
</html>