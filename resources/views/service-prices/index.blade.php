<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>إدارة أسعار الخدمات</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --ink: #18212b;
            --muted: #6b7684;
            --line: #e3e7ed;
            --bg: #f3f5f8;
            --surface: #ffffff;
            --accent: #0e6b5c;
            --accent-dark: #0a5247;
            --accent-soft: #e9f5f2;
            --radius: 14px;
        }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'IBM Plex Sans Arabic', Tahoma, Arial, sans-serif;
        }

        .page { max-width: 980px; }

        /* ---------- Header ---------- */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .5rem .9rem .5rem 1rem;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: var(--surface);
            color: var(--ink);
            font-size: .9rem;
            font-weight: 500;
            text-decoration: none;
            transition: background .15s, border-color .15s;
        }
        .back-link:hover { background: var(--accent-soft); border-color: var(--accent); color: var(--accent-dark); }
        .back-link svg { width: 18px; height: 18px; }

        .page-title { font-size: 1.6rem; font-weight: 700; margin: 0; }
        .page-sub { color: var(--muted); margin: .25rem 0 0; }

        /* ---------- Panel ---------- */
        .panel {
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .75rem;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--line);
        }

        .search-wrap { position: relative; flex: 1 1 260px; max-width: 340px; }
        .search-wrap svg {
            position: absolute; top: 50%; right: 12px; transform: translateY(-50%);
            width: 18px; height: 18px; color: var(--muted); pointer-events: none;
        }
        .search-wrap input {
            padding-right: 40px;
            border-radius: 10px;
            border-color: var(--line);
            background: var(--bg);
        }
        .search-wrap input:focus {
            background: var(--surface);
            border-color: var(--accent);
            box-shadow: 0 0 0 .2rem rgba(14,107,92,.15);
        }

        .tool-btn {
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--ink);
            border-radius: 10px;
            font-size: .88rem;
            font-weight: 500;
            padding: .45rem .9rem;
            transition: background .15s, border-color .15s;
        }
        .tool-btn:hover { background: var(--bg); border-color: #cfd5de; }

        .hint { color: var(--muted); font-size: .85rem; margin-inline-start: auto; }

        /* ---------- Table ---------- */
        .table { margin: 0; }
        .table > :not(caption) > * > * { padding: .85rem 1.25rem; border-bottom-color: var(--line); }
        .table thead th {
            background: #fafbfc;
            color: var(--muted);
            font-size: .82rem;
            font-weight: 600;
            white-space: nowrap;
            border-bottom: 1px solid var(--line);
            position: sticky; top: 0; z-index: 1;
        }
        .table tbody tr { transition: background .15s; }
        .table tbody tr:hover { background: #fafbfc; }
        .table tbody tr.selected-row { background: var(--accent-soft); }
        .table tbody tr:last-child td { border-bottom: 0; }

        .col-check { width: 64px; text-align: center; }
        .service-label { font-weight: 600; }

        .form-check-input { width: 1.2rem; height: 1.2rem; cursor: pointer; border-color: #b6bfcb; }
        .form-check-input:checked { background-color: var(--accent); border-color: var(--accent); }
        .form-check-input:focus { box-shadow: 0 0 0 .2rem rgba(14,107,92,.2); border-color: var(--accent); }

        .price-group { max-width: 200px; }
        .price-group .form-control { border-radius: 0 10px 10px 0; font-variant-numeric: tabular-nums; font-weight: 500; }
        .price-group .input-group-text {
            border-radius: 10px 0 0 10px;
            background: var(--bg);
            color: var(--muted);
            font-size: .85rem;
            border-color: var(--line);
        }
        .price-group .form-control:disabled { background: var(--bg); color: var(--muted); }
        .price-group .form-control:not(:disabled) { background: var(--surface); border-color: var(--accent); }
        .price-group .form-control:focus { box-shadow: 0 0 0 .2rem rgba(14,107,92,.15); border-color: var(--accent); }

        .empty-state { display: none; padding: 2.5rem 1rem; text-align: center; color: var(--muted); }

        /* ---------- Sticky action bar ---------- */
        .action-bar {
            position: sticky; bottom: 0; z-index: 5;
            display: flex; flex-wrap: wrap; align-items: center; gap: .75rem;
            padding: .9rem 1.25rem;
            background: rgba(255,255,255,.96);
            backdrop-filter: blur(6px);
            border-top: 1px solid var(--line);
        }
        .count {
            display: inline-flex; align-items: center; gap: .5rem;
            font-size: .92rem; color: var(--muted);
        }
        .count b {
            min-width: 28px; height: 28px; padding: 0 .5rem;
            display: inline-flex; align-items: center; justify-content: center;
            border-radius: 999px; background: var(--bg); color: var(--ink);
            transition: background .15s, color .15s;
        }
        .count.has-selection b { background: var(--accent); color: #fff; }

        .btn-save {
            background: var(--accent); border-color: var(--accent); color: #fff;
            border-radius: 10px; font-weight: 600; padding: .55rem 1.4rem;
        }
        .btn-save:hover:not(:disabled) { background: var(--accent-dark); border-color: var(--accent-dark); color: #fff; }
        .btn-save:disabled { background: #c5ccd6; border-color: #c5ccd6; color: #fff; opacity: 1; }
        .btn-reset {
            border: 1px solid var(--line); background: var(--surface); color: var(--ink);
            border-radius: 10px; font-weight: 500; padding: .55rem 1.1rem;
        }
        .btn-reset:hover { background: var(--bg); }

        /* ---------- Alerts ---------- */
        .alert { border-radius: 12px; border-width: 1px; }

        :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

        @media (max-width: 576px) {
            .hint { margin-inline-start: 0; width: 100%; }
            .search-wrap { max-width: none; }
            .action-bar .ms-auto { width: 100%; justify-content: flex-end; }
        }
    </style>
</head>
<body>
@php $oldSelected = (array) old('selected', []); @endphp

<div class="container page py-4 py-md-5">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="page-title">إدارة أسعار الخدمات</h1>
            <p class="page-sub">اختر الخدمات التي تريد تعديل أسعارها، ثم احفظ التغييرات.</p>
        </div>

        <a href="{{ route('services.index') }}" class="back-link">
            {{-- Arrow points right = "back" in RTL --}}
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14M13 6l6 6-6 6"/>
            </svg>
            العودة إلى الخدمات
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('service-prices.update') }}" id="pricesForm">
        @csrf
        @method('PUT')

        <div class="panel">
            {{-- Toolbar --}}
            <div class="toolbar">
                <div class="search-wrap">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/>
                    </svg>
                    <input type="search" id="priceSearch" class="form-control"
                           placeholder="ابحث عن خدمة..." aria-label="ابحث عن خدمة">
                </div>

                <button type="button" id="selectVisible" class="tool-btn">تحديد الظاهر</button>
                <button type="button" id="unselectAll" class="tool-btn">إلغاء التحديد</button>

                <span class="hint">لا يتغير السعر إلا للخدمات المحددة.</span>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table align-middle" id="pricesTable">
                    <thead>
                    <tr>
                        <th class="col-check">اختيار</th>
                        <th>الخدمة</th>
                        <th>السعر (دج)</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prices as $price)
                        @php $isSelected = in_array($price->key, $oldSelected); @endphp
                        <tr data-label="{{ mb_strtolower($price->label) }}" class="{{ $isSelected ? 'selected-row' : '' }}">
                            <td class="col-check">
                                <input type="checkbox"
                                       class="form-check-input service-check"
                                       name="selected[]"
                                       value="{{ $price->key }}"
                                       aria-label="تحديد {{ $price->label }}"
                                       {{ $isSelected ? 'checked' : '' }}>
                            </td>
                            <td class="service-label">{{ $price->label }}</td>
                            <td>
                                <div class="input-group price-group">
                                    <input type="number"
                                           class="form-control price-input"
                                           name="prices[{{ $price->key }}]"
                                           value="{{ old('prices.'.$price->key, $price->price) }}"
                                           min="0" step="0.01"
                                           aria-label="سعر {{ $price->label }}"
                                           {{ $isSelected ? '' : 'disabled' }}>
                                    <span class="input-group-text">دج</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <div class="empty-state" id="emptyState">لا توجد خدمة بهذا الاسم.</div>
            </div>

            {{-- Sticky action bar --}}
            <div class="action-bar">
                <div class="count" id="countWrap">
                    <b id="countNum">0</b>
                    <span>خدمة محددة</span>
                </div>

                <div class="d-flex gap-2 ms-auto">
                    <button type="reset" class="btn btn-reset">إلغاء التغييرات</button>
                    <button type="submit" class="btn btn-save" id="saveBtn" disabled>حفظ الأسعار المختارة</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const form      = document.getElementById('pricesForm');
    const rows      = () => document.querySelectorAll('#pricesTable tbody tr');
    const countNum  = document.getElementById('countNum');
    const countWrap = document.getElementById('countWrap');
    const saveBtn   = document.getElementById('saveBtn');
    const emptyState = document.getElementById('emptyState');

    function syncRow(row) {
        const checkbox = row.querySelector('.service-check');
        row.querySelector('.price-input').disabled = !checkbox.checked;
        row.classList.toggle('selected-row', checkbox.checked);
    }

    function syncCount() {
        const n = document.querySelectorAll('.service-check:checked').length;
        countNum.textContent = n;
        countWrap.classList.toggle('has-selection', n > 0);
        saveBtn.disabled = n === 0;
    }

    rows().forEach(row => {
        row.querySelector('.service-check').addEventListener('change', () => {
            syncRow(row);
            syncCount();
        });
    });

    document.getElementById('selectVisible').addEventListener('click', () => {
        rows().forEach(row => {
            if (row.style.display === 'none') return;
            row.querySelector('.service-check').checked = true;
            syncRow(row);
        });
        syncCount();
    });

    document.getElementById('unselectAll').addEventListener('click', () => {
        rows().forEach(row => {
            row.querySelector('.service-check').checked = false;
            syncRow(row);
        });
        syncCount();
    });

    document.getElementById('priceSearch').addEventListener('input', function () {
        const search = this.value.trim().toLowerCase();
        let visible = 0;

        rows().forEach(row => {
            const match = row.dataset.label.includes(search);
            row.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        emptyState.style.display = visible === 0 ? 'block' : 'none';
    });

    // The native reset does not fire "change", so re-sync after it runs.
    form.addEventListener('reset', () => {
        setTimeout(() => {
            rows().forEach(syncRow);
            syncCount();
        }, 0);
    });

    // Initial state (also handles old() values after a validation error).
    rows().forEach(syncRow);
    syncCount();
</script>
</body>
</html>