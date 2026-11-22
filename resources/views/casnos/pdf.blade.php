<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>طلب إلغاء غرامات وزيادات التأخير</title>
    <style>
        /*
            ملاحظة مهمة بخصوص الخط العربي مع dompdf:
            الخطوط الافتراضية (DejaVu Sans...) ما تدعمش العربية مليح.
            لازم تحط خط عربي (مثلا Amiri أو NotoNaskhArabic) فـ storage/fonts
            وتسجلو فـ config/dompdf.php تحت "font_dir" و "font_cache"،
            أو تستعمل مكتبة تدعم @font-face مباشرة كيما تحت.
        */
        @font-face {
font-family: 'DejaVu Sans', sans-serif; 
            font-weight: normal;
            font-style: normal;
        }
        @font-face {
font-family: 'DejaVu Sans', sans-serif; 
            font-weight: bold;
            font-style: normal;
        }

        * {
            box-sizing: border-box;
        }
        .field { position: absolute; font-size: 18pt; color: #000; }

        body {
            font-family: 'Amiri', 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            font-size: 13px;
            line-height: 1.9;
            color: #111;
            margin: 30px 40px;
        }

        /* ===== رأس الوثيقة: معلومات الزبون (فارغة، تتعمر بـ variables) ===== */
        .header-info {
            width: 45%;
            margin-bottom: 25px;
        }
        .header-info td {
            padding: 4px 0;
            font-size: 18px;
        }
        .label {
            font-weight: bold;
            
            
        }
        .dotted-value {
            border-bottom: 1px dotted #000;
            display: inline-block;
            min-width: 220px;
            padding-bottom: 2px;
        }

        /* ===== المرسل إليه ===== */
        .recipient {
            margin: 20px 0;
            font-size: 20px;
            text-align: left;
            }
        .recipient .to-label {
            font-weight: bold;
        }
        .org-name {
            font-weight: bold;
            font-size: 20px;
            letter-spacing: 1px;
            margin: 6px 0;
          
        }

        /* ===== الموضوع ===== */
        .subject {
            margin: 25px 0;
            font-weight: bold;
            text-decoration: underline;
        }

        /* ===== نص الطلب ===== */
        .body-text {
            text-align: justify;
            margin: 20px 0 40px 0;
        }

        /* ===== أسفل الوثيقة: التاريخ والإمضاء ===== */
        .footer-table {
            width: 100%;
            margin-top: 60px;
        }
        .footer-table td {
            vertical-align: top;
            font-size: 13px;
        }
        .signature-box {
            text-align: left;
        }
        .signature-line {
            margin-top: 10px;
            border-bottom: 1px solid #000;
            width: 180px;
            height: 60px;
        }
        .container{
    position:relative;
    width:350px;
    height:25px;
}

.bg{
    position:absolute;
    top:0;
    right:0;
    color:#777;
    white-space:nowrap;
}

.txt{
    position:absolute;
    top:0;
    right:0;
    background:transparent;
}
    </style>
</head>
<body>

    {{-- =========================================================
         معلومات الزبون - كلها variables، فارغة إذا ماجاتش القيمة
         =========================================================      --}}
         
    <table class="header-info">
        <tr>
            <td class="label" style="text-decoration: underline;">الاســم والـلقـب : </td>
            
         
     <div style="top: 1.1cm; right: 4.2cm;font-size: 12pt;" class="field">......................................</div>
    <div style="top: 0.9cm; right: 4.2cm;font-size: 16pt;font-weight: bold;" class="field">{{ $clients->nom }}</div>
    <div style="top: 0.9cm; right: 6.2cm;font-size: 16pt;font-weight: bold;" class="field">{{ $clients->prenom }}</div>
  
       
        </tr>
        <tr>
            <td class="label" style="text-decoration: underline;">رقم التسجيل :</td>
    <div style="top: 2cm; right: 4.2cm;font-size: 12pt;" class="field">......................................</div>
    <div style="top: 1.8cm; right: 4.4cm;font-size: 16pt;font-weight: bold;" class="field">{{ $clients->matricule }}</div>
         </tr>
        <tr>
            <td class="label" style="text-decoration: underline;">الــعنــوان :</td>
    <div style="top: 2.7cm; right: 4cm;font-size: 12pt;" class="field">......................................</div>
    <div style="top: 2.5cm; right: 4.2cm;font-size: 16pt;font-weight: bold;" class="field">{{ $clients->address }}</div>
         </tr>
        <tr>
            <td class="label" style="text-decoration: underline;">الــهــاتــف :</td>
        <div style="top: 3.6cm; right: 3.9cm;font-size: 12pt;" class="field">......................................</div>
    <div style="top: 3.4cm; right: 4.1cm;font-size: 16pt;font-weight: bold;" class="field">{{ $clients->phone }}</div>
     </tr>
    </table>
<div style="top: 5cm; right: 9cm; font-size: 20px;font-weight: bold;text-decoration: underline;" class="field">الى السيد:</div>
 <div style="top: 5cm; right: 11.2cm; font-size: 20px;font-weight: bold;" class="field">رئيس اللجنة المحلية المؤهلة للطعن المسبق</div>
 <div style="top: 6cm; right: 14cm; font-size: 22px;font-weight: bold;text-shadow:1px 0 0 #000;" class="field">C A S N O S</div>
 <div style="top: 7cm; right: 13cm; font-size: 20px;font-weight: bold;" class="field">الوكالة الولائية-سطيف-</div>
 <div style="top: 7.8cm; right: 12cm; font-size: 20px;font-weight: bold;" class="field">الحي المالي 600 مسكن-سطيف-</div>
 <div style="top: 13cm; right: 1cm; font-size: 22px;font-weight: bold;text-decoration: underline;" class="field">الغرض:</div>
 <div style="top: 13cm; right: 3cm; font-size: 22px;font-weight: bold;" class="field">طلب إلغاء غرامات وزيادات التأخير.</div>        
 <div style="top: 15.6cm; right: 1cm; font-size: 18px;font-weight: bold;" class="field"> يشرفني سيدي أن أتقدم إليكم بهذا الطلب، والذي ألتمس من خلاله إعادة النظر في زيادات وغرامات التأخير</div>
 <div style="top: 16.4cm; right: 0.5cm; font-size: 18px;font-weight: bold;" class="field">المحتسبة خلال فترات التكليف، والمترتبة عن عدم التصريح بالنشاط وعدم تسديد المستحقات في آجالها القانونية.</div>
 <div style="top: 17.2cm; right: 5cm; font-size: 18px;font-weight: bold;" class="field">في انتظار ردكم، تقبلوا مني سيادتكم اسمى عبارات الاحترام والتقدير.</div>
 <div style="top: 22.2cm; right: 17.4cm; font-size: 18px;" class="field">......................</div>
 <div style="top: 22.2cm; right: 15cm; font-size: 18px;font-weight: bold;text-decoration: underline;" class="field">سطيف في :</div>
 <div style="top: 23.2cm; right: 15cm; font-size: 18px;font-weight: bold;text-decoration: underline;" class="field">امضاء المعني :</div>
<div style="top: 22.2cm; right: 18cm; font-size: 18px;font-weight: bold;" class="field">{{ date('d/m/Y') }}</div>
 

</body>
</html>