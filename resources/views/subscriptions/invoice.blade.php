@php
    // مسافة غير قابلة للكسر + dir=ltr حتى لا تنقلب الأرقام داخل PDF عربي (10 000 ← 000 10)
    $money = fn ($n, $d = 2) => '<span dir="ltr">' . number_format((float) $n, $d, ',', "\u{00A0}") . '&nbsp;DA</span>';
    $ltr = fn ($v) => '<span dir="ltr">' . e($v) . '</span>';
    $isPaid = $remaining <= 0;
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">

    <style>
        body { margin:0; padding:0; font-family:dejavusans, sans-serif; direction:rtl; color:#1b2430; font-size:11px; }
        table { width:100%; border-collapse:collapse; }

        /* HEADER */
        .top-bar { border-top:5px solid #0f6b5c; }
        .header td { vertical-align:top; padding:14px 4px 12px; }
        .brand { font-size:21px; font-weight:bold; color:#0f6b5c; }
        .tagline { font-size:10px; color:#697586; margin-top:3px; }
        .doc-title { font-size:20px; font-weight:bold; color:#1b2430; text-align:left; }
        .doc-meta { font-size:10px; color:#697586; text-align:left; margin-top:4px; line-height:1.8; }
        .rule { border-bottom:1px solid #e3e8ee; }

        /* BADGES */
        .type { display:inline-block; padding:3px 10px; border:1px solid #0f6b5c; color:#0f6b5c; font-size:10px; font-weight:bold; margin-top:8px; }
        .status-ok { color:#0f6b5c; border:1px solid #0f6b5c; padding:3px 10px; font-weight:bold; font-size:10px; }
        .status-due { color:#b42318; border:1px solid #b42318; padding:3px 10px; font-weight:bold; font-size:10px; }

        /* SECTIONS */
        .section-title { font-size:12px; font-weight:bold; color:#0f6b5c; margin:18px 0 6px; padding-bottom:4px; border-bottom:2px solid #0f6b5c; }

        .info td { padding:7px 10px; border:1px solid #e3e8ee; }
        .info .label { width:22%; background:#f6f8fa; color:#697586; font-weight:bold; }
        .info .value { width:28%; }

        .benefits { margin-top:12px; padding:10px 12px; background:#f3f9f8; border-right:4px solid #0f6b5c; line-height:1.9; color:#33404d; }
        .benefits strong { color:#0f6b5c; }

        /* PAYMENTS */
        .payments th { background:#0f6b5c; color:#ffffff; padding:8px 6px; text-align:center; font-weight:bold; border:1px solid #0f6b5c; }
        .payments td { padding:8px 6px; text-align:center; border:1px solid #e3e8ee; }
        .payments .alt td { background:#f6f8fa; }
        .paid { color:#0f6b5c; font-weight:bold; }
        .remaining { color:#b42318; font-weight:bold; }
        .empty { color:#697586; padding:14px !important; }

        /* SUMMARY */
        .summary-wrap td { vertical-align:top; }
        .summary td { padding:9px 12px; border:1px solid #e3e8ee; }
        .summary .label { background:#f6f8fa; font-weight:bold; width:55%; }
        .summary .grand td { background:#0f6b5c; color:#ffffff; font-size:13px; font-weight:bold; border:1px solid #0f6b5c; }
        .summary .grand-due td { background:#b42318; color:#ffffff; font-size:13px; font-weight:bold; border:1px solid #b42318; }

        /* FOOTER */
        .footer { margin-top:28px; padding-top:10px; border-top:1px solid #e3e8ee; text-align:center; color:#697586; font-size:10px; }
        .footer strong { color:#1b2430; font-size:11px; }
    </style>
</head>

<body>

    {{-- HEADER --}}
    <div class="top-bar"></div>
    <table class="header">
        <tr>
            <td style="width:60%;">
                <div class="brand">CHILLCOM SERVICE</div>
                <div class="tagline">Services &amp; Accompagnement Administratif</div>
                <div class="type">{{ $type }}</div>
            </td>
            <td style="width:40%;">
                <div class="doc-title">فاتورة الاشتراك</div>
                <div class="doc-meta">
                    رقم الفاتورة: {!! $ltr($invoiceNumber) !!}<br>
                    تاريخ الإصدار: {!! $ltr(now()->format('Y-m-d')) !!}<br>
                    @if($isPaid)
                        <span class="status-ok">مسدّد بالكامل</span>
                    @else
                        <span class="status-due">متبقٍ للدفع</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>
    <div class="rule"></div>

    {{-- INFO --}}
    <div class="section-title">معلومات الزبون والاشتراك</div>

    <table class="info">
        <tr>
            <td class="label">الاسم الكامل</td>
            <td class="value">{{ $subscription->full_name }}</td>
            <td class="label">رقم الاشتراك</td>
            <td class="value">{!! $ltr('#' . $subscription->id) !!}</td>
        </tr>
        <tr>
            <td class="label">رقم الهاتف</td>
            <td class="value">{!! $ltr($subscription->phone) !!}</td>
            <td class="label">تاريخ البداية</td>
            <td class="value">{!! $ltr($subscription->start_date) !!}</td>
        </tr>
        <tr>
            <td class="label">تاريخ النهاية</td>
            <td class="value">{!! $ltr($subscription->end_date) !!}</td>
            <td class="label">نوع الاشتراك</td>
            <td class="value">{{ $type }}</td>
        </tr>
    </table>

    <div class="benefits">
        <strong>الاستفادات:</strong>
        الاشتراك السنوي: يتكفّل المكتب باستخراج NIF ورقم المادة (ART) وتفعيلهما لدى الضرائب دون أي تنقّل منك، مع إيداع التصريح G12 وتسديده قبل 30 جوان، والتصريح G12 bis قبل 20 جانفي.
        كما نضمن تسجيلك في CASNOS وتفعيل بطاقة الشفاء في الآجال المحددة، لتفادي أي عقوبة أو غرامة تأخير.
    </div>

    {{-- PAYMENTS --}}
    <div class="section-title">سجل الدفعات</div>

    <table class="payments">
        <thead>
            <tr>
                <th style="width:15%;">رقم</th>
                <th>تاريخ الدفع</th>
                <th style="width:35%;">المبلغ المدفوع</th>
            </tr>
        </thead>
        <tbody>
        @forelse($payments as $i => $payment)
            <tr class="{{ $i % 2 ? 'alt' : '' }}">
                <td>{!! $ltr('#' . $payment->id) !!}</td>
                <td>
                    {!! $ltr($payment->payment_date instanceof \Carbon\Carbon
                        ? $payment->payment_date->format('Y-m-d')
                        : $payment->payment_date) !!}
                </td>
                <td class="paid">{!! $money($payment->amount) !!}</td>
            </tr>
        @empty
            <tr><td colspan="3" class="empty">لم يتم تسجيل أي دفعة لهذه الفاتورة.</td></tr>
        @endforelse
        </tbody>
    </table>

    {{-- SUMMARY --}}
    <div class="section-title">الملخص المالي</div>

    <table class="summary-wrap">
        <tr>
            <td style="width:45%;"></td>
            <td style="width:55%;">
                <table class="summary">
                    <tr>
                        <td class="label">المبلغ الإجمالي للاشتراك</td>
                        <td>{!! $money($amount) !!}</td>
                    </tr>
                    <tr>
                        <td class="label">مجموع الدفعات</td>
                        <td class="paid">{!! $money($totalPaid) !!}</td>
                    </tr>
                    <tr class="{{ $isPaid ? 'grand' : 'grand-due' }}">
                        <td>المبلغ المتبقي</td>
                        <td>{!! $money($remaining) !!}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- FOOTER --}}
    <div class="footer">
        <strong>شكراً لاشتراككم في CHILLCOM SERVICE</strong>
        <p>هذه الفاتورة تعرض جميع الدفعات المسجلة لهذا الاشتراك إلى غاية وقت إصدارها.</p>
    </div>

</body>
</html>