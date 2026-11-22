@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    .cp { --ground:#f3f5f7; --surface:#fff; --ink:#1b2430; --muted:#697586; --line:#e3e8ee;
          --accent:#0f6b5c; --accent-soft:#e3f2ef; --late:#b42318; --late-soft:#fdeceb; --blue:#1d5fd1; --blue-soft:#e8f0fc;
          font-family:'IBM Plex Sans Arabic',system-ui,sans-serif; color:var(--ink); direction:rtl;
          background:var(--ground); min-height:100vh; padding:1.5rem 0; }
    .cp .amt { direction:ltr; unicode-bidi:isolate; display:inline-block; white-space:nowrap; }

    .cp-head { display:flex; flex-wrap:wrap; align-items:center; gap:1rem; margin-bottom:1.25rem; }
    .cp-head h1 { font-size:1.4rem; font-weight:600; margin:0; }
    .cp-head p { margin:0; color:var(--muted); font-size:.88rem; }
    .cp-spacer { flex:1; }

    .cp-btn { display:inline-flex; align-items:center; gap:.45rem; padding:.55rem 1.1rem; border-radius:10px;
        border:1px solid var(--line); background:var(--surface); color:var(--ink); font-weight:500;
        text-decoration:none; font-size:.9rem; cursor:pointer; transition:border-color .15s,color .15s,background .15s; }
    .cp-btn:hover { border-color:var(--accent); color:var(--accent); }
    .cp-btn.primary { background:var(--accent); border-color:var(--accent); color:#fff; }
    .cp-btn.primary:hover { background:#0b574b; color:#fff; }
    .cp-btn.sm { padding:.3rem .7rem; font-size:.82rem; border-radius:8px; }
    .cp-btn.danger:hover { border-color:var(--late); color:var(--late); background:var(--late-soft); }

    .cp-stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:1rem; margin-bottom:1.25rem; }
    .cp-stat { display:flex; align-items:center; gap:1rem; padding:1rem 1.25rem; background:var(--surface);
        border:1px solid var(--line); border-radius:14px; text-decoration:none; color:inherit; transition:border-color .15s; }
    .cp-stat:hover { border-color:var(--ink); color:inherit; }
    .cp-stat .ico { width:44px; height:44px; border-radius:12px; display:grid; place-items:center; font-size:1.1rem; }
    .cp-stat.debt .ico { background:var(--late-soft); color:var(--late); }
    .cp-stat.over .ico { background:var(--blue-soft); color:var(--blue); }
    .cp-stat strong { display:block; font-size:1.5rem; line-height:1.1; }
    .cp-stat span { color:var(--muted); font-size:.85rem; }

    .cp-card { background:var(--surface); border:1px solid var(--line); border-radius:14px; overflow:hidden; }
    .cp-toolbar { display:flex; flex-wrap:wrap; align-items:center; gap:.75rem 1rem; padding:1rem 1.25rem; border-bottom:1px solid var(--line); }
    .cp-search { position:relative; min-width:280px; flex:1; max-width:420px; }
    .cp-search i { position:absolute; inset-inline-start:.85rem; top:50%; transform:translateY(-50%); color:var(--muted); }
    .cp-search input { width:100%; padding:.55rem 2.3rem; border-radius:10px; border:1px solid var(--line); background:var(--ground); font:inherit; }
    .cp-search input:focus { outline:none; border-color:var(--accent); background:var(--surface); box-shadow:0 0 0 3px var(--accent-soft); }

    .cp-scroll { overflow-x:auto; }
    .cp-table { width:100%; border-collapse:collapse; }
    .cp-table th { padding:.75rem 1.1rem; font-size:.82rem; font-weight:500; color:var(--muted); background:#fafbfc;
        border-bottom:1px solid var(--line); text-align:start; white-space:nowrap; }
    .cp-table td { padding:.85rem 1.1rem; border-bottom:1px solid var(--line); vertical-align:middle; }
    .cp-table tbody tr:last-child td { border-bottom:0; }
    .cp-table tbody tr:hover { background:#f7f9fa; }
    .cp-table tr.expired { background:var(--late-soft); box-shadow:inset -3px 0 0 var(--late); }
    .cp-table tr.expired:hover { background:#fbe0de; }

    .cp-name { font-weight:600; }
    .cp-sub { display:block; color:var(--muted); font-size:.8rem; }
    .cp-neg { color:var(--late); }
    .cp-pos { color:var(--accent); }
    .cp-blue { color:var(--blue); }
    .cp-mono { font-variant-numeric:tabular-nums; }
    .cp-chip { display:inline-block; padding:.1rem .6rem; border-radius:999px; background:var(--ground); border:1px solid var(--line); font-size:.82rem; }

    .cp-status { display:inline-flex; align-items:center; gap:.4rem; font-size:.82rem; font-weight:600; white-space:nowrap; }
    .cp-status::before { content:''; width:8px; height:8px; border-radius:50%; background:currentColor; }
    .cp-status.ok { color:var(--accent); } .cp-status.debt { color:var(--late); } .cp-status.over { color:var(--blue); }
    .cp-status.muted { color:var(--muted); font-weight:500; }
    .cp-flag { display:inline-block; padding:.1rem .55rem; border-radius:6px; font-size:.78rem; font-weight:600; background:var(--late); color:#fff; }

    .cp-actions { display:flex; align-items:center; gap:.35rem; }
    .cp-actions form { margin:0; }
    .cp-empty { padding:2.5rem 1rem; text-align:center; color:var(--muted); }
</style>

<div class="cp">
<div class="container-fluid px-3">

    {{-- HEADER --}}
    <div class="cp-head">
        <div>
            <h1>دفعات CASNOS</h1>
            <p>{{ $payments->count() }} سجل</p>
        </div>
        <div class="cp-spacer"></div>
        <a href="{{ route('traders.index') }}" class="cp-btn"><i class="fas fa-arrow-right"></i> قائمة التجار</a>
        <a href="{{ route('casnos-payments.create') }}" class="cp-btn primary"><i class="fas fa-plus"></i> إضافة دفع</a>
    </div>

    {{-- STATS --}}
    @if($count_creditors > 0 || $count_debtors > 0)
        <div class="cp-stats">
            @if($count_creditors > 0)
                <a href="{{ route('casnos-payments.creditors') }}" class="cp-stat debt">
                    <div class="ico"><i class="fas fa-exclamation-triangle"></i></div>
                    <div><strong>{{ $count_creditors }}</strong><span>ديون متبقية (نقص في الدفع)</span></div>
                </a>
            @endif
            @if($count_debtors > 0)
                <a href="{{ route('casnos-payments.overpaid') }}" class="cp-stat over">
                    <div class="ico"><i class="fas fa-hand-holding-usd"></i></div>
                    <div><strong>{{ $count_debtors }}</strong><span>دفعات زائدة عن المطلوب</span></div>
                </a>
            @endif
        </div>
    @endif

    {{-- TABLE --}}
    <div class="cp-card">

        <div class="cp-toolbar">
            <div class="cp-search">
                <i class="fas fa-search"></i>
                <input type="text" id="search" value="{{ request('search') }}" placeholder="بحث بـ NIN أو الاسم..." autocomplete="off">
            </div>
            @if(request('search'))
                <a href="{{ route('casnos-payments.index') }}" class="cp-btn sm danger"><i class="fas fa-times"></i> إلغاء البحث</a>
            @endif
        </div>

        <div class="cp-scroll">
            <table class="cp-table">
                <thead>
                    <tr>
                        <th>التاجر</th>
                        <th>Matricule</th>
                        <th>Recours</th>
                        <th>المدفوع</th>
                        <th>المستحق</th>
                        <th>الرصيد</th>
                        <th>الحالة</th>
                        <th>Carte Chifa</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>

                <tbody id="paymentsTable">
                @forelse($payments as $p)
                    @php
                        $recoursExpired = $p->recoursExpired();
                        $remaining = $p->getAdjustedBalance();                            // المتبقي مع الزيادة
                        $overpaid  = max(0, $p->montant_versse - $p->montant_enkissi);    // الدفع الزائد
                    @endphp

                    <tr class="{{ $recoursExpired ? 'expired' : '' }}">

                        <td>
                            <span class="cp-name">{{ $p->trader->first_name ?? '' }} {{ $p->trader->last_name ?? '' }}</span>
                            <span class="cp-sub">{{ $p->trader->NIN ?? '' }}</span>
                        </td>

                        <td><span class="cp-chip cp-mono">{{ $p->matricule }}</span></td>

                        <td>
                            @if($p->recours)
                                @if($recoursExpired)
                                    <span class="cp-flag">Recours dépassé</span>
                                @else
                                    <span class="cp-status ok">Oui</span>
                                @endif
                            @else
                                <span class="cp-status muted">Non</span>
                            @endif
                        </td>

                        <td class="cp-pos cp-mono fw-semibold">
                            <span class="amt">{{ number_format($p->montant_versse, 2) }} DA</span>
                        </td>

                        <td class="cp-mono fw-semibold">
                            <span class="amt">{{ number_format($p->montant_enkissi, 2) }} DA</span>
                            @if($p->penalty_amount > 0)
                                <span class="cp-sub cp-neg">
                                    <span class="amt">+ {{ number_format($p->penalty_amount, 2) }} DA ({{ $p->penalty_rate }}%)</span>
                                </span>
                            @endif
                        </td>

                        <td class="cp-mono fw-semibold {{ $remaining > 0 ? 'cp-neg' : ($overpaid > 0 ? 'cp-blue' : '') }}">
                            @if($remaining > 0)
                                <span class="amt">- {{ number_format($remaining, 2) }} DA</span>
                            @elseif($overpaid > 0)
                                <span class="amt">+ {{ number_format($overpaid, 2) }} DA</span>
                            @else
                                <span class="amt">0.00 DA</span>
                            @endif
                        </td>

                        <td>
                            @if($remaining > 0)
                                <span class="cp-status debt">DEBT</span>
                            @elseif($overpaid > 0)
                                <span class="cp-status over">OVERPAID</span>
                            @else
                                <span class="cp-status ok">OK</span>
                            @endif
                        </td>

                        <td>
                            @if($p->carte_chifa)
                                <span class="cp-status ok">Oui</span>
                            @else
                                <span class="cp-status muted">Non</span>
                            @endif
                        </td>

                        <td>
                           
                            <div class="cp-actions">
                                 @if(
    $remaining > 0 &&
    $p->date_paiement &&
    \Carbon\Carbon::parse($p->date_paiement)->addDays(25)->lte(now()) &&
    (
        !$p->last_whatsapp_reminder_at ||
        \Carbon\Carbon::parse($p->last_whatsapp_reminder_at)->addDays(3)->lte(now())
    )
)
    <a href="{{ route('casnos-payments.whatsapp-reminder', $p->id) }}"
       class="cp-btn sm"
       style="background:#128c5e;color:white;border-color:#128c5e">
        <i class="fab fa-whatsapp"></i> whatsapp
    </a>
@endif
                                <a href="{{ route('casnos-payments.transactions.index', $p->id) }}" class="cp-btn sm primary">
                                    <i class="fas fa-money-bill-wave"></i> Paiements
                                </a>
                                <a href="{{ route('casnos-payments.edit', $p->id) }}" class="cp-btn sm" title="تعديل">
                                    <i class="fas fa-edit"></i>edit
                                </a>
                                <form method="POST" action="{{ route('casnos-payments.destroy', $p->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="cp-btn sm danger" title="حذف" onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                        <i class="fas fa-trash"></i>delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="cp-empty">لا توجد نتائج</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
</div>

<script>
    (function () {
        const input = document.getElementById('search');
        let timer = null;

        input.addEventListener('input', function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                fetch('/casnos-payments?search=' + encodeURIComponent(input.value.trim()))
                    .then(r => r.text())
                    .then(html => {
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const fresh = doc.querySelector('#paymentsTable');
                        if (fresh) document.getElementById('paymentsTable').innerHTML = fresh.innerHTML;
                    });
            }, 250);
        });
    })();
</script>
@endsection