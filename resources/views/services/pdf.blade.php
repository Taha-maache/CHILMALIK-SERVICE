<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    
<meta charset="UTF-8">
<title>فاتورة الخدمة</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{margin:0;padding:0;box-sizing:border-box}
:root{--ink:#1f2937;--muted:#6b7280;--line:#e5e7eb;--bg-soft:#f9fafb;--accent:#0f766e;--accent-soft:#ecfdf5;--danger:#dc2626;--danger-soft:#fef2f2}
body{font-family:'Segoe UI',Tahoma,Arial,sans-serif;background:#f3f4f6;padding:40px 15px;color:var(--ink)}
.invoice-wrapper{max-width:760px;margin:auto}
.box{background:#fff;border-radius:10px;border:1px solid var(--line);overflow:hidden}
.header{display:flex;align-items:center;justify-content:space-between;gap:20px;padding:28px 36px;border-bottom:3px solid var(--accent)}
.header-logo img{height:48px;border-radius:6px}
.header-title h1{font-size:20px;font-weight:700;color:var(--ink)}
.header-title span{display:block;margin-top:2px;font-size:11px;letter-spacing:2px;color:var(--muted)}
.header-badge{font-size:12.5px;color:var(--muted);white-space:nowrap}
.header-badge b{color:var(--ink)}
.company-bar{background:var(--bg-soft);padding:14px 36px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;border-bottom:1px solid var(--line);font-size:12.5px;color:var(--muted)}
.company-bar .company-name{font-weight:700;color:var(--ink);font-size:13.5px}
.company-bar .company-details{display:flex;gap:16px;flex-wrap:wrap}
.client-info{display:grid;grid-template-columns:repeat(4,1fr);gap:1px;background:var(--line);margin:28px 36px 0;border:1px solid var(--line);border-radius:8px;overflow:hidden}
.info-card{background:#fff;padding:14px 16px}
.info-card .label{display:block;font-size:11px;color:var(--muted);margin-bottom:4px}
.info-card .value{font-size:14px;font-weight:600;color:var(--ink)}
.status-pill{display:inline-block;padding:2px 10px;border-radius:20px;font-size:12px;font-weight:600}
.status-pill.subscriber{background:var(--accent-soft);color:var(--accent)}
.status-pill.non-subscriber{background:var(--danger-soft);color:var(--danger)}
.table-container{padding:24px 36px 0}
.section-label{font-size:12px;font-weight:700;color:var(--muted);letter-spacing:.5px;margin-bottom:8px}
table{width:100%;border-collapse:collapse;border:1px solid var(--line);border-radius:8px;overflow:hidden}
thead th{background:var(--bg-soft);color:var(--ink);padding:11px 16px;font-size:13px;font-weight:700;text-align:right;border-bottom:1px solid var(--line)}
thead th:last-child{text-align:left}
tbody tr:not(:last-child) td{border-bottom:1px solid var(--line)}
tbody td{padding:11px 16px;font-size:14px;color:var(--ink)}
tbody td:last-child{text-align:left;direction:ltr;font-weight:600;font-variant-numeric:tabular-nums}
.total-section{margin:22px 36px 0;border:1px solid var(--line);border-radius:8px;overflow:hidden;display:flex}
.total-section .cell{flex:1;padding:16px 18px;text-align:center;border-inline-start:1px solid var(--line)}
.total-section .cell:first-child{border-inline-start:none}
.total-section .label{font-size:12px;color:var(--muted);margin-bottom:6px}
.total-section .amount{font-size:19px;font-weight:700;direction:ltr}
.total-section .amount.total{color:var(--ink)}
.total-section .amount.paid{color:var(--accent)}
.total-section .amount.remaining{color:var(--danger)}
.payments-header{margin:22px 36px 8px;display:flex;align-items:center;justify-content:space-between}
.payments-header .title{font-size:13px;font-weight:700;color:var(--ink)}
.payments-header .count{font-size:12.5px;color:var(--muted)}
.payments-table{margin:0 36px}
.footer-note{text-align:center;color:var(--muted);font-size:12px;padding:26px 36px 8px}
.no-print{text-align:center;padding:10px 36px 30px}
button{padding:10px 26px;background:var(--accent);border:none;color:#fff;border-radius:6px;font-size:14px;font-weight:600;cursor:pointer}
button:hover{opacity:.9}
@media print{body{background:#fff;padding:0}.box{border:none;border-radius:0}.no-print{display:none}}
@media(max-width:600px){
.header{padding:22px 20px;flex-direction:column;text-align:center}
.company-bar{padding:12px 20px;flex-direction:column;text-align:center}
.company-bar .company-details{justify-content:center}
.client-info{grid-template-columns:1fr 1fr;margin:20px 16px 0}
.table-container{padding:18px 16px 0}
.total-section{margin:18px 16px 0;flex-direction:column}
.total-section .cell{border-inline-start:none;border-top:1px solid var(--line)}
.total-section .cell:first-child{border-top:none}
.payments-header,.payments-table{margin-inline:16px}
.footer-note,.no-print{padding-inline:16px}
}
.sub-box{margin:22px 36px 0;border:2px solid var(--accent);border-radius:8px;overflow:hidden;font-family:'Cairo','Segoe UI',Tahoma,Arial,sans-serif;font-weight:700;font-size:17px;line-height:2;break-inside:avoid}
.sub-box .sub-title{background:var(--accent-soft);color:var(--accent);padding:14px 20px;font-size:21px;font-weight:800;border-bottom:1px solid var(--line)}
.sub-box .sub-body{padding:16px 20px;text-align:justify}
.sub-box .slogan{margin-top:12px;padding:10px 14px;background:var(--bg-soft);border-inline-start:4px solid var(--accent);border-radius:6px;color:var(--accent);text-align:right}
@media(max-width:600px){.sub-box{margin:18px 16px 0}}
@media print{
  .sub-box{break-before:page;page-break-before:always;margin:20px 20px 0}
}
</style>
</head>
<body>

@php
    $price = fn ($key, $default = 0) => \App\Models\ServicePrice::getPrice($key, $default);

    $galization = (int) ($service->number_of_galization ?? 1);
    $ramzCount = (int) ($service->sijil_ramz_count ?? 0);
    $anneeDebut = (int) ($service->anne_de_modification ?? 0);
    $anneeActuelle = now()->year;

    $montantTa3dilCA = $price('ta3dil_CA_base', 11000);

    if ($anneeDebut > 0) {
        for ($annee = $anneeDebut; $annee <= $anneeActuelle; $annee++) {
            $montantTa3dilCA += $annee <= 2024
                ? $price('ta3dil_CA_before_2025', 300)
                : $price('ta3dil_CA_from_2025', 1000);
        }
    }
@endphp

<div class="invoice-wrapper">
<div class="box">

    <div class="header">
        <div class="header-logo">
            <img src="{{ asset('images/logo1.jpg') }}" alt="Logo">
        </div>
        <div class="header-title">
            <h1>فاتورة الخدمة</h1>
            <span>INVOICE</span>
        </div>
        <div class="header-badge">
            رقم الخدمة <b>#{{ $service->id ?? '---' }}</b>
        </div>
    </div>

    <div class="company-bar">
        <div class="company-name">CHILLCOM SERVICE</div>
        <div class="company-details">
            <span>📍 حي الاخوة تامر خلف بلدية عين ولمان</span>
            <span>📞 0555710848</span>
            <span>✉️ WhatsApp: +213 555710848</span>
        </div>
    </div>

    <div class="client-info">
        <div class="info-card">
            <span class="label">الاسم و اللقب</span>
            <span class="value">{{ $service->full_name }}</span>
        </div>
        <div class="info-card">
            <span class="label">الهاتف</span>
            <span class="value">{{ $service->phone }}</span>
        </div>
        <div class="info-card">
            <span class="label">الحالة</span>
            <span class="value">
                @if($service->is_subscriber)
                    <span class="status-pill subscriber">مشترك</span>
                @else
                    <span class="status-pill non-subscriber">غير مشترك</span>
                @endif
            </span>
        </div>
        <div class="info-card">
            <span class="label">تاريخ الخدمة</span>
            <span class="value">{{ \Carbon\Carbon::parse($service->service_date)->format('Y-m-d') }}</span>
        </div>
    </div>

    <div class="table-container">
        <div class="section-label">تفاصيل الخدمات</div>
        <table>
            <thead>
                <tr><th>الخدمة</th><th>السعر (دج)</th></tr>
            </thead>
            <tbody>

                @if($service->cnas_type == 1)
                <tr><td>CNAS Abattement</td><td>{{ $price('cnas_abattement', 15000) }}</td></tr>
                @endif

                @if($service->cnas_type == 2)
                <tr><td>CNAS Sans Abattement</td><td>{{ $price('cnas_sans_abattement', 12000) }}</td></tr>
                @endif

                @if($service->sijil_moutanaiqil)
                <tr><td>سجل تجاري متنقل</td><td>{{ $price('sijil_moutanaiqil', 11000) }}</td></tr>
                @endif

                @if($service->naql_badaie)
                <tr><td>نقل بضائع</td><td>{{ $price('naql_badaie', 14000) }}</td></tr>
                @endif

                @if($service->hanout)
                <tr><td>حانوت</td><td>{{ $price('hanout', 15000) }}</td></tr>
                @endif

                @if($service->sina3a)
                <tr><td>صناعة</td><td>{{ $price('sina3a', 16000) }}</td></tr>
                @endif

                @if($service->eljemla)
                <tr><td>الجملة</td><td>{{ $price('eljemla', 16000) }}</td></tr>
                @endif

                @if($service->wakala)
                <tr><td>وكالة</td><td>{{ $price('wakala', 2000) }}</td></tr>
                @endif

                @if($service->tamdid_salahya)
                <tr><td>تمديد الصلاحية</td><td>{{ $price('tamdid_salahya', 18000) }}</td></tr>
                @endif

                @if($service->istirad)
                <tr><td>استيراد</td><td>{{ $price('istirad', 45000) }}</td></tr>
                @endif

                @if($service->mosada9a == 1)
                <tr><td>مصادقة</td><td>{{ $price('mosada9a_one', 1500) }}</td></tr>
                @endif

                @if($service->mosada9a > 1)
                <tr><td>مصادقة {{ $service->mosada9a }}</td><td>{{ $price('mosada9a_multiple', 1200) * $service->mosada9a }}</td></tr>
                @endif

                @if($service->ta3dil)
                <tr><td>تعديل سجل تجاري</td><td>{{ $price('ta3dil', 13000) }}</td></tr>
                @endif

                @if($service->creation_CA)
                <tr><td>إنشاء بطاقة الحرفي</td><td>{{ $price('creation_CA', 11000) }}</td></tr>
                @endif

                @if($service->creation_dplm_CA)
                <tr><td>إنشاء ديبلوم بطاقة الحرفي</td><td>{{ $price('creation_dplm_CA', 11000) }}</td></tr>
                @endif

                @if($service->annulation_CA)
                <tr><td>شطب بطاقة الحرفي</td><td>{{ $price('annulation_CA', 11000) }}</td></tr>
                @endif

                @if($service->efficacite)
                <tr><td>الكفاءة</td><td>{{ $price('efficacite', 30000) }}</td></tr>
                @endif

                @if($service->khidma_ijer_mahal)
                <tr><td>خدمة إيجار محل</td><td>{{ $price('khidma_ijer_mahal', 3000) }}</td></tr>
                @endif

                @if($service->ta3dil_CA)
                <tr>
                    <td>تعديل CA @if($service->anne_de_modification) - سنة التعديل {{ $service->anne_de_modification }} @endif</td>
                    <td>{{ $montantTa3dilCA }}</td>
                </tr>
                @endif

                @if($ramzCount > 0)
                <tr><td>عدد الرموز {{ $ramzCount }}</td><td>{{ $ramzCount * $price('sijil_ramz_unit', 240) }}</td></tr>
                @endif

                @if($service->nis)
                <tr><td>NIS</td><td>{{ $price('nis', 4800) }}</td></tr>
                @endif

                @if($service->inapi)
                <tr><td>INAPI</td><td>{{ $price('inapi', 11000) }}</td></tr>
                @endif

                @if(($service->logo_price ?? 0) > 0)
                <tr><td>Logo</td><td>{{ $service->logo_price }}</td></tr>
                @endif

                @if($service->coderbar)
                <tr><td>Codebar</td><td>{{ $price('coderbar_base', 11000) + (($service->coderbar_products_count ?? 0) * $price('coderbar_product', 500)) }}</td></tr>
                @endif

                @if($service->moudirya_naql)
                <tr><td>permis circulaire</td><td>{{ $price('moudirya_naql', 5000) }}</td></tr>
                @endif

                @php
                    $khatmPrices = [
                        '11' => ['khatm_11', 1400],
                        '12' => ['khatm_12', 1700],
                        '13' => ['khatm_13', 2100],
                        '14' => ['khatm_14', 2900],
                        '15' => ['khatm_15', 3500],
                        '42' => ['khatm_42', 3200],
                    ];
                    $khatmType = (string) $service->khatm_type;
                @endphp

                @if(isset($khatmPrices[$khatmType]))
                <tr>
                    <td>ختم {{ $khatmType }} @if($galization == 2) × 2 @endif</td>
                    <td>{{ $price($khatmPrices[$khatmType][0], $khatmPrices[$khatmType][1]) * $galization }}</td>
                </tr>
                @endif

                @if($service->tarjama_register == 1)
                <tr><td>ترجمة السجل التجاري</td><td>{{ $price('tarjama_register_1', 1800) }}</td></tr>
                @endif

                @if($service->tarjama_register == 2)
                <tr><td>ترجمة السجلات التجارية</td><td>{{ $price('tarjama_register_2', 2400) }}</td></tr>
                @endif

                @if($service->tarjamat_sawabi9)
                <tr><td>ترجمة السوابق العدلية</td><td>{{ $price('tarjamat_sawabi9', 1400) }}</td></tr>
                @endif

                @if($service->talab_c20)
                <tr><td>طلب C20</td><td>{{ $price('talab_c20', 4000) }}</td></tr>
                @endif

                @if($service->kachf_hisseb)
                <tr><td>كشف الحساب</td><td>{{ $price('kachf_hisseb', 3000) }}</td></tr>
                @endif

                @if($service->tasmya)
                <tr><td>تسمية</td><td>{{ $price('tasmya', 1500) }}</td></tr>
                @endif

                @if($service->tarjamat_boal)
                <tr><td>ترجمة Boal</td><td>{{ $price('tarjamat_boal', 3000) }}</td></tr>
                @endif

                @if($service->ichhar_boal)
                <tr><td>إشهار Boal</td><td>{{ $price('ichhar_boal', 10000) }}</td></tr>
                @endif

                @if($service->creation_entreprise)
                <tr>
                    <td>
                        تأسيس شركة:
                        <ul>
                            <li>تسمية</li>
                            <li>البحث عن رموز النشاط التجاري</li>
                            <li>Boal (ترجمة + إشهار + فاتورة)</li>
                            <li>دفع واستلام السجل</li>
                            <li>NIF</li>
                            <li>fiche de navete</li>
                            <li>G08 + BP + mot de passe</li>
                        </ul>
                    </td>
                    <td>{{ $price('creation_entreprise', 45000) }}</td>
                </tr>
                @endif

                @if($service->chahedat_ihtiram)
                <tr><td>شهادة احترام</td><td>{{ $price('chahedat_ihtiram', 10000) }}</td></tr>
                @endif

                @if($service->nif_alces)
                <tr><td>NIF ALCES</td><td>{{ $price('nif_alces', 10000) }}</td></tr>
                @endif

                @if($service->nif_dowan)
                <tr><td>NIF الديوان</td><td>{{ $price('nif_dowan', 3000) }}</td></tr>
                @endif

                @if($service->g50)
                <tr><td>G50</td><td>{{ $price('g50', 1000) }}</td></tr>
                @endif

                @if($service->irg_salaire)
                <tr><td>IRG الأجر</td><td>{{ $price('irg_salaire', 1000) }}</td></tr>
                @endif

                @if($service->tva)
                <tr><td>TVA</td><td>{{ $price('tva', 1000) }}</td></tr>
                @endif

                @if(!$service->is_subscriber)
                    @if(($service->g12_price ?? 0) > 0)
                    <tr><td>G12</td><td>{{ $price('g12_price', 1200) }}</td></tr>
                    @endif

                    @if(($service->g12bis_price ?? 0) > 0)
                    <tr><td>G12 BIS</td><td>{{ $price('g12bis_price', 1200) }}</td></tr>
                    @endif

                    @if($service->casnos)
                    <tr><td>CASNOS</td><td>{{ $price('casnos', 1500) }}</td></tr>
                    @endif

                    @if($service->carte_chifa)
                    <tr><td>Carte Chifa</td><td>{{ $price('carte_chifa', 500) }}</td></tr>
                    @endif

                    @if($service->nif)
                    <tr><td>NIF</td><td>{{ $price('nif', 800) }}</td></tr>
                    @endif

                    @if($service->nif_plus_g08)
                    <tr><td>NIF + G08</td><td>{{ $price('nif_plus_g08', 1000) }}</td></tr>
                    @endif
                @endif

            </tbody>
        </table>
    </div>

    @php
        $credit = $service->credit;
    @endphp

    @if($credit)
        <div class="total-section">
            <div class="cell">
                <div class="label">المبلغ الإجمالي</div>
                <div class="amount total">{{ number_format($service->total_price) }} دج</div>
            </div>
            <div class="cell">
                <div class="label">المدفوع</div>
                <div class="amount paid">{{ number_format($credit->amount_paid) }} دج</div>
            </div>
            <div class="cell">
                <div class="label">المتبقي</div>
                <div class="amount remaining">{{ number_format($credit->remaining_amount) }} دج</div>
            </div>
        </div>

        <div class="payments-header">
            <span class="title">سجل الدفعات</span>
            <span class="count">عدد الدفعات: {{ $credit->payments()->count() }}</span>
        </div>

        <div class="payments-table">
            <table>
                <thead>
                    <tr><th>#</th><th>التاريخ</th><th>الوقت</th><th>المبلغ</th></tr>
                </thead>
                <tbody>
                    @foreach($credit->payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $payment->payment_date }}</td>
                        <td>{{ $payment->created_at ? $payment->created_at->format('H:i') : '--:--' }}</td>
                        <td>{{ number_format($payment->amount) }} دج</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="total-section">
            <div class="cell">
                <div class="label">المبلغ الإجمالي</div>
                <div class="amount total">{{ number_format($service->total_price) }} دج</div>
            </div>
        </div>
    @endif

<div class="sub-box">
    <div class="sub-title">الاشتراك السنوي — Chillcom Service</div>
    <div class="sub-body">
        <p>مبروك عليك السجل التجاري! بعد استخراجه، يتكفّل بك مكتبنا ويغنيك عن التنقّل إلى مصلحة الضرائب و CASNOS.</p>
        <p><b>واش هو الاشتراك؟</b> لمدة سنة كاملة، نتكفّلو بجميع العمليات المحاسبية والتصريحات الجبائية وشبه الجبائية لدى الضرائب و CASNOS، بما في ذلك طلب بطاقة الشفاء أو تفعيلها.</p>

        <h4>واش نديرو لك؟</h4>
        <ul>
            <li>استخراج NIF وتفعيله بلا تنقّل.</li>
            <li>استخراج رقم المادة (ART).</li>
            <li>التصريح G12 والتخليص قبل 30 جوان من كل سنة.</li>
            <li>التصريح G12 bis قبل 20 جانفي (نحتاجوه في التصريح لدى CASNOS).</li>
            <li>التسجيل في CASNOS وتفعيل بطاقة الشفاء في الآجال المحددة، لتفادي الغرامات.</li>
        </ul>

        <h4>علاش تخلّيها علينا؟</h4>
        <ul>
            <li>بروحك: تضيّع وقتك في التنقّل والانتظار، وتنسى المواعيد فتدفع غرامات كبيرة.</li>
            <li>بروحك: ما تعرفش الوثائق اللازمة، فتروح وتجي عدة مرات بلا ما تنجز شيء.</li>
            <li>معانا: نعرفو الوثائق والآجال، ونتكفّلو بكل شيء، وأنت تتفرّغ لنشاطك.</li>
        </ul>

        <div class="slogan">«الوكيل شيلكوم يتكفّل بيكم، انت أخدم برك وكواغطك راهم مريقلين عندنا»</div>
    </div>
</div>

    <div class="footer-note">شكراً لتعاملكم معنا — هذه الفاتورة صادرة إلكترونياً</div>
    <div class="no-print">
        <button onclick="window.print()">🖨 طباعة الفاتورة</button>
    </div>

</div>
</div>
</body>
</html>
