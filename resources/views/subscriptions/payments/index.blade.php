@php
    // الأرقام تُكتب بمسافة غير قابلة للكسر + اتجاه LTR حتى لا تنقلب (10 000 ← 000 10) داخل صفحة RTL
    $money = fn ($n, $d = 0) => '<span class="num">' . number_format((float) $n, $d, ',', "\u{00A0}") . '&nbsp;DA</span>';
    $percent = $totalAmount > 0 ? min(100, round($totalPaid / $totalAmount * 100)) : 0;
@endphp
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>دفعات الاشتراك</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --ground:#f3f5f7; --surface:#fff; --ink:#1b2430; --muted:#697586; --line:#e3e8ee;
            --accent:#0f6b5c; --accent-soft:#e3f2ef; --late:#b42318; --late-soft:#fdeceb;
        }
        body { background:var(--ground); color:var(--ink); font-family:'IBM Plex Sans Arabic',system-ui,sans-serif; }
        .num { direction:ltr; unicode-bidi:isolate; display:inline-block; white-space:nowrap; font-variant-numeric:tabular-nums; }

        .head { display:flex; flex-wrap:wrap; align-items:center; gap:1rem; margin-bottom:1.5rem; }
        .head h1 { font-size:1.4rem; font-weight:600; margin:0; }
        .head p { margin:.15rem 0 0; color:var(--muted); font-size:.9rem; }
        .head .spacer { flex:1; }

        .btn-x { display:inline-flex; align-items:center; gap:.45rem; padding:.55rem 1.1rem; border-radius:10px; border:1px solid var(--line);
            background:var(--surface); color:var(--ink); font-weight:500; text-decoration:none; cursor:pointer; font-size:.9rem; }
        .btn-x:hover { border-color:var(--accent); color:var(--accent); }
        .btn-x.primary { background:var(--accent); border-color:var(--accent); color:#fff; }
        .btn-x.primary:hover { background:#0b574b; color:#fff; }

        .stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-bottom:1rem; }
        .stat { background:var(--surface); border:1px solid var(--line); border-radius:14px; padding:1.1rem 1.3rem; }
        .stat span { color:var(--muted); font-size:.85rem; }
        .stat strong { display:block; font-size:1.55rem; font-weight:600; margin-top:.25rem; }
        .stat.paid strong { color:var(--accent); }
        .stat.rest strong { color:var(--late); }

        .progress-x { background:var(--line); border-radius:999px; height:8px; overflow:hidden; margin-bottom:.35rem; }
        .progress-x div { height:100%; background:var(--accent); border-radius:999px; }
        .progress-note { color:var(--muted); font-size:.82rem; margin-bottom:1.5rem; }

        .card-x { background:var(--surface); border:1px solid var(--line); border-radius:14px; margin-bottom:1rem; overflow:hidden; }
        .card-x h2 { font-size:1rem; font-weight:600; margin:0; padding:1rem 1.4rem; border-bottom:1px solid var(--line); }
        .card-x .body { padding:1.3rem 1.4rem; }

        .lbl { display:block; font-size:.85rem; font-weight:500; color:var(--muted); margin-bottom:.35rem; }
        .field { width:100%; padding:.6rem .85rem; border-radius:10px; border:1px solid var(--line); background:var(--surface); font:inherit; color:var(--ink); }
        .field:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-soft); }
        .hint { color:var(--muted); font-size:.8rem; margin-top:.3rem; }

        .alert-x { border-radius:12px; padding:.8rem 1.1rem; margin-bottom:1rem; font-size:.92rem; }
        .alert-x.ok { background:var(--accent-soft); color:var(--accent); border:1px solid #bfe0d9; }
        .alert-x.err { background:var(--late-soft); color:var(--late); border:1px solid #f5c6c2; }
        .alert-x ul { margin:0; padding-inline-start:1.1rem; }

        .tbl { width:100%; border-collapse:collapse; }
        .tbl th { padding:.7rem 1.4rem; font-size:.82rem; font-weight:500; color:var(--muted); background:#fafbfc; border-bottom:1px solid var(--line); text-align:start; white-space:nowrap; }
        .tbl td { padding:.85rem 1.4rem; border-bottom:1px solid var(--line); }
        .tbl tbody tr:last-child td { border-bottom:0; }
        .tbl tbody tr:hover { background:#f7f9fa; }
        .tbl .amount { color:var(--accent); font-weight:600; }
        .empty { padding:2.5rem 1rem; text-align:center; color:var(--muted); }
    </style>
</head>
<body>
<div class="container py-4">

    <div class="head">
        <div>
            <h1>دفعات الاشتراك</h1>
            <p>{{ $subscription->full_name }} · <span class="num">{{ $subscription->phone }}</span></p>
        </div>
        <div class="spacer"></div>
        <a href="{{ route('subscriptions.index') }}" class="btn-x">↩ الرجوع للاشتراكات</a>
    </div>

    @if(session('success'))
        <div class="alert-x ok">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert-x err">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    {{-- الملخص --}}
    <div class="stats">
        <div class="stat">
            <span>المبلغ الإجمالي</span>
            <strong>{!! $money($totalAmount) !!}</strong>
        </div>
        <div class="stat paid">
            <span>مجموع المدفوع</span>
            <strong>{!! $money($totalPaid) !!}</strong>
        </div>
        <div class="stat rest">
            <span>المتبقي</span>
            <strong>{!! $money($remaining) !!}</strong>
        </div>
    </div>

    <div class="progress-x"><div style="width: {{ $percent }}%"></div></div>
    <div class="progress-note">تم تسديد <span class="num">{{ $percent }}%</span> من الاشتراك</div>

    {{-- تسجيل دفعة --}}
    @if($remaining > 0)
        <div class="card-x">
            <h2>تسجيل دفعة جديدة</h2>
            <div class="body">
                <form method="POST" action="{{ route('subscriptions.payments.store', $subscription) }}">
                    @csrf
                    <div class="row g-3 align-items-start">
                        <div class="col-md-4">
                            <label class="lbl">المبلغ (DA)</label>
                            <input type="number" name="amount" class="field" min="0.01" max="{{ $remaining }}" step="0.01"
                                   value="{{ old('amount') }}" style="direction:ltr;text-align:right" required>
                            <div class="hint">أقصى مبلغ: {!! $money($remaining, 2) !!}</div>
                        </div>
                        <div class="col-md-4">
                            <label class="lbl">تاريخ الدفع</label>
                            <input type="date" name="payment_date" class="field" value="{{ old('payment_date', now()->toDateString()) }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="lbl">ملاحظات (اختياري)</label>
                            <input type="text" name="notes" class="field" value="{{ old('notes') }}" maxlength="1000" placeholder="ملاحظات حول الدفعة">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn-x primary">تسجيل الدفع</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="alert-x ok">تم تسديد الاشتراك بالكامل.</div>
    @endif

    {{-- سجل الدفعات --}}
    <div class="card-x">
        <h2>سجل الدفعات</h2>
        <div class="table-responsive">
            <table class="tbl">
                <thead>
                    <tr>
                        <th>رقم الدفعة</th>
                        <th>تاريخ الدفع</th>
                        <th>المبلغ</th>
                        <th>ملاحظات</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($subscription->payments as $payment)
                    <tr>
                        <td><span class="num">#{{ $payment->id }}</span></td>
                        <td><span class="num">{{ $payment->payment_date->format('Y-m-d') }}</span></td>
                        <td class="amount">{!! $money($payment->amount, 2) !!}</td>
                        <td>{{ $payment->notes ?: '—' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="empty">لا توجد دفعات مسجلة لهذا الاشتراك.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</body>
</html>