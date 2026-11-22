<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 10mm;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif; 
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            line-height: 1.6;
        }
        .page {
            width: 100%;
            padding: 5mm;
            box-sizing: border-box;
            page-break-after: always;
        }
        .page:last-child {
            page-break-after: avoid;
        }

        /* الجزء العلوي (المعلومات الشخصية) */
        .header-section {
            width: 100%;
            margin-bottom: 40px;
        }
        .sender-info {
            float: right;
            text-align: right;
            font-size: 14pt;
        }

        /* العنوان الرئيسي */
        .main-recipient {
            text-align: center;
            font-size: 24pt;
            font-weight: bold;
            margin: 50px 0;
            line-height: 1.5;
        }

        /* الغرض */
        .subject-box {
            font-size: 18pt;
            font-weight: bold;
            margin-bottom: 30px;
        }

        /* الجداول والتنسيقات الخاصة بالاستمارة */
        .full-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .full-table td, .full-table th {
            border: 1px solid #000;
            padding: 10px;
            font-size: 13pt;
            vertical-align: middle;
        }
        .bg-gray {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: center;
            width: 30%;
        }
        .center-text {
            text-align: center;
        }

        /* المربعات (Checkboxes) */
        .check-item {
            display: inline-block;
            margin-left: 15px;
        }
        .box {
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 1px solid #000;
            margin-left: 5px;
            vertical-align: middle;
        }

        .signature-area {
            margin-top: 40px;
            font-weight: bold;
            font-size: 16pt;
        }
        .float-right { float: right; }
        .clear { clear: both; }

        /* تنسيق قائمة المواصفات للصفحة الأولى */
        .specs-group {
            margin-right: 40px;
            font-size: 18pt;
            font-weight: bold;
        }
        .date-top {
            text-align: left;
            font-size: 12pt;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    

    <div class="page">
    <div class="date-top">{{ date('d/m/Y') }}</div>
    <div class="header-section">
            <div class="sender-info">
                السيد: {{ $transporter->last_name }} {{ $transporter->first_name }}<br>
                العنوان: {{ $transporter->address }}<br>
                الهاتف/ {{ $transporter->phone }}
            </div>
            <div class="clear"></div>
        </div>

        <div class="main-recipient">
            الي السيد :مدير النقل<br>
            لولاية سطيف
        </div>

        <div class="subject-box">الغرض : {{ $transporter->object }}</div>

        <p style="font-size: 16pt;">لي الشرف العظيم أن أتقدم إلى سيادتكم الموقرة بطلبي هذا و المتمثل في {{ $transporter->object }} ذات المواصفات التالية:</p>

        <div class="specs-group">
            <p>رقم التسجيل: &lrm;{{ $transporter->number_of_registration }}&lrm;</p>
            <p>النوع: {{ $transporter->type_of_vehicle }}</p>
            <p>الصنف: {{ $transporter->category_of_vehicle }}</p>
            <p>جملة الحمولة: {{ $transporter->load_total }} طن</p>
            <p>أول سنة استعمال: {{ $transporter->first_year_of_using }}</p>
        </div>

        <div style="margin-top: 10px; font-size: 16pt;">وفي انتظار ردكم تقبلوا مني فائق التقدير والاحترام</div>
        <div class="signature-area" style="text-align: center; margin-right: 400px;">امضاء الناقل</div>
    </div>

    <div class="page">
        <div class="date-top">{{ date('d/m/Y') }}</div>
        <div class="header-section">
            <div class="sender-info">
                السيد: {{ $transporter->last_name }} {{ $transporter->first_name }}<br>
                العنوان: {{ $transporter->address }}<br>
                الهاتف/ {{ $transporter->phone }}<br>
                رقم القيد في سجل  الناقلين : {{ $transporter->carriers_registry_number }}
            </div>
            <div class="clear"></div>
        </div>

        <div class="main-recipient" style="font-size: 22pt;">الي السيد :مدير النقل<br>لولاية سطيف</div>

        <div class="subject-box" style="text-align: right;">الغرض :تصريح بالمستخدمين</div>

        <p style="font-size: 15pt;">أنا الممضي اسفله السيد <strong>{{ $transporter->last_name }} {{ $transporter->first_name }}</strong> متعامل النقل للحساب الخاص/ النقل العمومي للبضائع أصرح أني أستخدم السيد:</p>

        <table class="full-table center-text">
            <tr class="bg-gray">
                <th>الاسم و اللقب</th>
                <th>تاريخ و مكان الازدياد</th>
                <th>عنوان الإقامة</th>
                <th>رقم الهاتف</th>
                <th>الصفة / سائق /مواكب ..</th>
                <th>رقم التسجيل</th>
            </tr>
            <tr>
                <td>{{ $transporter->first_last_name_of_driver }}</td>
                <td>{{ $transporter->date_of_birth_of_driver }} بـ {{ $transporter->place_of_birth_of_driver }}</td>
                <td>{{ $transporter->address_of_driver }}</td>
                <td>{{ $transporter->phone_of_driver }}</td>
                <td>سائق</td>
                <td>&lrm;{{ $transporter->number_of_registration }}&lrm;</td>
            </tr>
            <tr>
                <td>/</td><td>/</td><td>/</td><td>/</td><td>/</td><td>/</td>
            </tr>
        </table>

        <div style="margin-top: 30px; font-size: 15pt;">وذلك ابتداءا من يومنا هذا</div>
        
        <div class="signature-area"  style="margin-top: 50px; margin-right: 500px;">إمضاء و ختم الناقل</div>
        <div style="margin-top: 80px; font-size: 12pt; font-weight: bold;">ملاحظة يرفق هذا التصريح بالرخصة السياقة للسائق</div>
    </div>

    <div class="page">
        <div style="text-align: center; font-weight: bold; font-size: 16pt;">الجمهورية الجزائرية الديمقراطية الشعبية</div>
        <div style="float: right; font-weight: bold; font-size: 14pt;">ولاية سطيف<br>مديرية النقل</div>
        <div class="clear"></div>

        <div style="text-align: center; border: 2px solid #000; padding: 10px; margin: 10px auto; width: 85%; font-size: 20pt; font-weight: bold;">
            بطاقـة معلومـات - نشاط نقل البضائع -
        </div>

        <table class="full-table">
            <tr>
                <td class="bg-gray">اللقب والاسم أو التسمية التجارية بالنسبة للشركات</td>
                <td class="center-text">{{ $transporter->last_name }} {{ $transporter->first_name }}</td>
            </tr>
            <tr>
                <td class="bg-gray">Nom et Prénom ou Raison sociale</td>
                <td class="center-text" style="text-transform: uppercase;">{{ $transporter->last_namefr }} {{ $transporter->first_namefr }}</td>
            </tr>
            <tr>
                <td class="bg-gray">تاريخ و بلدية الميلاد للمتعامل أو لمسير الشركة</td>
                <td class="center-text">{{ $transporter->date_of_birth }} بـ {{ $transporter->place_of_birth }}</td>
            </tr>
            <tr>
                <td class="bg-gray">النشاط (اشطب الخانة المناسبة)</td>
                <td>
                    <div class="check-item"><span class="box"></span> النقل العمومي للبضائع</div><br>
                    <div style="margin-right: 10px;">نقل البضائع للحساب الخاص:</div>
                    <div style="margin-right: 20px; margin-top: 5px;">
                        <span class="check-item"><span class="box"></span> فلاح</span>
                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <span class="check-item"><span class="box"></span> حرفي</span>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        <span class="check-item"><span class="box"></span> نشاط آخر</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td class="bg-gray">رقم  القيد في سجل المتعاملين</td>
                <td class="center-text" style="letter-spacing: 3px; font-weight: bold;">{{ $transporter->carriers_registry_number }}</td>
            </tr>
            <tr>
                <td class="bg-gray">رقم التعريف الوطني</td>
                <td class="center-text" style="letter-spacing: 3px; font-weight: bold;">{{ implode(' ', str_split($transporter->number_of_identity_card)) }}</td>
            </tr>
            <tr>
                <td class="bg-gray">العنوان الكامل بدقة</td>
                <td class="center-text">{{ $transporter->address }}</td>
            </tr>
            <tr>
                <td class="bg-gray">رقم الهاتف</td>
                <td class="center-text">{{ $transporter->phone }}</td>
            </tr>
            <tr>
                <td class="bg-gray">البريد الالكتروني</td>
                <td class="center-text">{{ $transporter->email }}</td>
            </tr>
            <tr>
                <td class="bg-gray">أرقام تسجيل جميع الشاحنات المملوكة حاليا من طرف المتعامل</td>
                <td class="center-text">&lrm;{{ $transporter->number_of_registration }}&lrm;</td>
            </tr>
        </table>

        <div class="signature-area" style="margin-top: 10px;">الإمضاء و الختم</div>

        <div style="margin-top: 40px; font-size: 10pt; border-top: 1px solid #ccc; padding-top: 10px;">
            <strong>ملاحظة:</strong><br>
            1- يجب استكمال المعلومات المطلوبة بخط واضح مع تجنب الشطب وحشو الكلمات.<br>
            2- ضرورة استعمال البريد الإلكتروني الشخصي والذي سيتم استعماله مستقبلا في جميع التعاملات مع مديرية النقل <br>
            3- يجب ارفاق  هذه الاستمارة بنسخة عن بطاقة التعريف الوطنية او رخصة السياقة البيومتريين.<br>
            4-يجب ارفاق هذه الاستمارة بنسخة عن السجل التجاري بطاقة فلاح/بطاقة حرفي حسب الحالة.<br>
            5- يجب إمضاء وختم هذه الاستمارة بختم التعامل اوالمصادقة عليها لدى مصالح الحالة المدنية.<br>
        </div>
</div>
</body>
</html>