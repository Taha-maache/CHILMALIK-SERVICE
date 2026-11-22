@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap" rel="stylesheet">

<style>
    .cf { --ground:#f3f5f7; --surface:#fff; --ink:#1b2430; --muted:#697586; --line:#e3e8ee;
          --accent:#0f6b5c; --accent-soft:#e3f2ef; --late:#b42318; --late-soft:#fdeceb;
          font-family:'IBM Plex Sans Arabic',system-ui,sans-serif; color:var(--ink); direction:rtl;
          background:var(--ground); min-height:100vh; padding:1.5rem 0; }
    .cf-wrap { max-width:820px; margin:0 auto; }
    .cf-head { display:flex; align-items:center; gap:1rem; margin-bottom:1.25rem; }
    .cf-head h1 { font-size:1.4rem; font-weight:600; margin:0; }
    .cf-head p { margin:0; color:var(--muted); font-size:.88rem; }
    .cf-back { margin-inline-start:auto; color:var(--muted); text-decoration:none; font-size:.9rem; }
    .cf-back:hover { color:var(--accent); }

    .cf-card { background:var(--surface); border:1px solid var(--line); border-radius:14px; padding:1.5rem 1.75rem; margin-bottom:1rem; }
    .cf-card h2 { display:flex; align-items:center; gap:.6rem; font-size:1rem; font-weight:600; margin:0 0 1.1rem; }
    .cf-card h2 i { color:var(--accent); }

    .cf label.lbl { display:block; font-size:.85rem; font-weight:500; color:var(--muted); margin-bottom:.35rem; }
    .cf .field { width:100%; padding:.6rem .85rem; border-radius:10px; border:1px solid var(--line); background:var(--surface); font:inherit; color:var(--ink); transition:border-color .15s, box-shadow .15s; }
    .cf .field:focus { outline:none; border-color:var(--accent); box-shadow:0 0 0 3px var(--accent-soft); }
    .cf .amt { direction:ltr; text-align:right; }

    .cf-pw { position:relative; }
    .cf-pw button { position:absolute; inset-inline-start:.4rem; top:50%; transform:translateY(-50%); border:0; background:none; color:var(--muted); padding:.3rem .5rem; }

    .cf-seg { display:inline-flex; background:var(--ground); border-radius:10px; padding:3px; gap:3px; }
    .cf-seg input { position:absolute; opacity:0; pointer-events:none; }
    .cf-seg label { margin:0; padding:.4rem 1.1rem; border-radius:8px; cursor:pointer; font-size:.88rem; font-weight:500; color:var(--muted); transition:background .15s,color .15s; }
    .cf-seg input:checked + label { background:var(--surface); color:var(--ink); box-shadow:0 1px 2px rgba(0,0,0,.1); }
    .cf-seg input.yes:checked + label { color:var(--accent); }
    .cf-seg input.no:checked + label { color:var(--late); }

    .cf-results { display:none; position:absolute; top:100%; inset-inline:0; z-index:50; margin-top:4px; background:var(--surface);
        border:1px solid var(--line); border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,.08); overflow:hidden; max-height:260px; overflow-y:auto; }
    .cf-results button, .cf-results div { display:block; width:100%; text-align:start; padding:.6rem .9rem; border:0; background:none; border-bottom:1px solid var(--line); font:inherit; }
    .cf-results button:hover { background:var(--accent-soft); }
    .cf-results small { color:var(--muted); display:block; }
    .cf-picked { display:none; align-items:center; gap:.5rem; margin-top:.5rem; padding:.45rem .8rem; background:var(--accent-soft); color:var(--accent); border-radius:8px; font-size:.88rem; font-weight:500; }

    .cf-footer { display:flex; gap:.75rem; justify-content:flex-start; }
    .cf-btn { display:inline-flex; align-items:center; gap:.45rem; padding:.65rem 1.6rem; border-radius:10px; border:1px solid var(--line); background:var(--surface); color:var(--ink); font-weight:500; text-decoration:none; cursor:pointer; }
    .cf-btn.primary { background:var(--accent); border-color:var(--accent); color:#fff; }
    .cf-btn.primary:hover { background:#0b574b; }
    .cf-err { background:var(--late-soft); color:var(--late); border:1px solid #f5c6c2; border-radius:12px; padding:.8rem 1.1rem; margin-bottom:1rem; font-size:.9rem; }
    .cf-err ul { margin:0; padding-inline-start:1.1rem; }
</style>

<div class="cf">
<div class="container"><div class="cf-wrap">

    <div class="cf-head">
        <div>
            <h1>إضافة دفعة CASNOS</h1>
            <p>سجّل ملف CASNOS جديد لتاجر</p>
        </div>
        <a href="{{ route('casnos-payments.index') }}" class="cf-back"><i class="fas fa-arrow-right"></i> رجوع للقائمة</a>
    </div>

    @if($errors->any())
        <div class="cf-err"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ route('casnos-payments.store') }}" id="paymentForm">
        @csrf

        {{-- التاجر --}}
        <div class="cf-card">
            <h2><i class="fas fa-user"></i> التاجر</h2>
            <div class="position-relative">
                <label class="lbl" for="traderSearch">ابحث بالاسم أو رقم التعريف (NIN)</label>
                <input type="text" id="traderSearch" class="field" placeholder="ابدأ الكتابة..." autocomplete="off">
                <input type="hidden" name="trader_id" id="trader_id" value="{{ old('trader_id') }}">
                <div id="traderResults" class="cf-results"></div>
                <div id="traderPicked" class="cf-picked"><i class="fas fa-check-circle"></i> <span></span></div>
            </div>
        </div>

        {{-- الدفع --}}
        <div class="cf-card">
            <h2><i class="fas fa-money-bill-wave"></i> الدفع</h2>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="lbl">تاريخ التصريح</label>
                    <input type="date" name="date_paiement" class="field" value="{{ old('date_paiement', date('Y-m-d')) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="lbl">نوع الدفع</label>
                    <select name="pay_type" class="field" required>
                        <option value="كامل" {{ old('pay_type') == 'كامل' ? 'selected' : '' }}>كامل</option>
                        <option value="دين" {{ old('pay_type') == 'دين' ? 'selected' : '' }}>دين</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="lbl">المبلغ المستحق (DA)</label>
                    <input type="number" step="0.01" min="0" name="montant_enkissi" class="field amt" value="{{ old('montant_enkissi') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="lbl">المبلغ المدفوع (DA)</label>
                    <input type="number" step="0.01" min="0" name="montant_versse" class="field amt" value="{{ old('montant_versse') }}" required>
                </div>
            </div>
        </div>

        {{-- حساب CASNOS --}}
        <div class="cf-card">
            <h2><i class="fas fa-id-card"></i> حساب CASNOS</h2>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="lbl">Matricule</label>
                    <input type="text" name="matricule" id="matricule" class="field" value="{{ old('matricule') }}" required>
                </div>
                <div class="col-md-4">
                    <label class="lbl">اسم المستخدم</label>
                    <input type="text" name="username" class="field" value="{{ old('username') }}">
                </div>
                <div class="col-md-4">
                    <label class="lbl">كلمة المرور</label>
                    <div class="cf-pw">
                        <input type="password" name="password" id="pw" class="field">
                        <button type="button" onclick="const p=document.getElementById('pw');p.type=p.type==='password'?'text':'password'"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
            </div>
        </div>

        {{-- خيارات --}}
        <div class="cf-card">
            <h2><i class="fas fa-sliders-h"></i> خيارات إضافية</h2>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="lbl">Carte Chifa</label>
                    <div class="cf-seg">
                        <input type="radio" class="yes" name="carte_chifa" id="oui" value="1" {{ old('carte_chifa') === '1' ? 'checked' : '' }}>
                        <label for="oui">Oui</label>
                        <input type="radio" class="no" name="carte_chifa" id="non" value="0" {{ old('carte_chifa', '0') === '0' ? 'checked' : '' }}>
                        <label for="non">Non</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="lbl">Recours</label>
                    <div class="cf-seg">
                        <input type="radio" class="yes" name="recours" id="recours_oui" value="1" {{ old('recours') === '1' ? 'checked' : '' }}>
                        <label for="recours_oui">Oui</label>
                        <input type="radio" class="no" name="recours" id="recours_non" value="0" {{ old('recours', '0') === '0' ? 'checked' : '' }}>
                        <label for="recours_non">Non</label>
                    </div>
                </div>
                <div class="col-md-4" id="recoursDateBox">
                    <label class="lbl">تاريخ Recours</label>
                    <input type="datetime-local" name="recours_date" class="field" value="{{ old('recours_date') }}">
                </div>
            </div>
        </div>

        <div class="cf-footer">
            <button type="submit" class="cf-btn primary"><i class="fas fa-save"></i> حفظ الدفعة</button>
            <a href="{{ route('casnos-payments.index') }}" class="cf-btn">إلغاء</a>
        </div>
    </form>

</div></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('traderSearch');
    const results = document.getElementById('traderResults');
    const hiddenId = document.getElementById('trader_id');
    const picked = document.getElementById('traderPicked');
    let timer = null;

    function esc(s) { const d = document.createElement('div'); d.textContent = s ?? ''; return d.innerHTML; }

    function setPicked(name) {
        picked.style.display = name ? 'flex' : 'none';
        picked.querySelector('span').textContent = name || '';
    }

    input.addEventListener('input', function () {
        clearTimeout(timer);
        const search = this.value.trim();
        hiddenId.value = '';
        setPicked('');

        if (!search) { results.style.display = 'none'; return; }

        timer = setTimeout(() => {
            fetch("{{ route('casnos-payments.search-traders') }}?search=" + encodeURIComponent(search), { headers: { 'Accept': 'application/json' } })
                .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.json(); })
                .then(traders => {
                    results.innerHTML = '';
                    if (!traders.length) {
                        results.innerHTML = '<div class="text-muted">لا يوجد تاجر بهذا الاسم</div>';
                    }
                    traders.forEach(t => {
                        const b = document.createElement('button');
                        b.type = 'button';
                        b.innerHTML = '<strong>' + esc((t.first_name ?? '') + ' ' + (t.last_name ?? '')) + '</strong><small>NIN: ' + esc(t.NIN ?? '-') + '</small>';
                        b.addEventListener('click', function () {
                            const name = ((t.first_name ?? '') + ' ' + (t.last_name ?? '')).trim();
                            hiddenId.value = t.id;
                            input.value = name;
                            setPicked(name);
                            results.style.display = 'none';
                        });
                        results.appendChild(b);
                    });
                    results.style.display = 'block';
                })
                .catch(() => {
                    results.innerHTML = '<div class="text-danger">خطأ في البحث</div>';
                    results.style.display = 'block';
                });
        }, 200);
    });

    document.addEventListener('click', e => { if (!results.contains(e.target) && e.target !== input) results.style.display = 'none'; });

    // لازم يختار تاجر من القائمة
    document.getElementById('paymentForm').addEventListener('submit', function (e) {
        if (!hiddenId.value) { e.preventDefault(); input.focus(); input.style.borderColor = '#b42318'; }
    });

    // تاريخ Recours يظهر فقط إذا Recours = Oui
    const box = document.getElementById('recoursDateBox');
    const toggle = () => { box.style.display = document.getElementById('recours_oui').checked ? '' : 'none'; };
    document.querySelectorAll('input[name="recours"]').forEach(r => r.addEventListener('change', toggle));
    toggle();
});
</script>
@endsection