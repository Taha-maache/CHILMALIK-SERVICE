@extends('layouts.app')

@section('content')

<div class="taxes-wrapper">
    <div class="container-fluid py-4">

        {{-- ===== HEADER ===== --}}
        <div class="tx-header">
            <div class="tx-title">
                <div class="tx-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <h1>إدارة الضرائب</h1>
                    <span>قائمة المكلفين والمستحقات</span>
                </div>
            </div>
            <a href="{{ route('taxes.create') }}" class="tx-add">
                <i class="fas fa-plus"></i>
                ضريبة جديدة
            </a>
        </div>

        {{-- ===== BOTTOM LINKS ===== --}}
        <div class="tx-links">
            <a href="{{ route('taxes.debtors') }}" class="tx-link tx-danger">
                <i class="fas fa-exclamation-circle"></i>
                الديون المتأخرة
                @if($overdueTaxes->count() > 0)
                <span class="tx-count">{{ $overdueTaxes->count() }}</span>
                @endif
            </a>
        </div>

        {{-- ===== MAIN CARD ===== --}}
        <div class="tx-card">

            {{-- Search --}}
            <div class="tx-card-header">
                <div class="tx-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="liveSearch" placeholder="بحث بالاسم، اللقب أو NIN...">
                </div>
            </div>

            {{-- Table --}}
            <div class="tx-table-wrap">
                <table class="tx-table">
                    <thead>
                        <tr>
                            <th>المكلف</th>
                            <th>NIF</th>
                            <th>NIN</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="taxTableBody">
                        @forelse($taxes as $tax)
                        <tr>
                            <td>
                                <div class="tx-user">
                                    <div class="tx-avatar" style="background: hsl({{ ($tax->id * 137) % 360 }}, 65%, 50%)">
                                        {{ mb_substr($tax->first_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="tx-name">{{ $tax->first_name }} {{ $tax->last_name }}</div>
                                        <div class="tx-name-fr">{{ $tax->first_nameFR }} {{ $tax->last_nameFR }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="tx-code">{{ $tax->Nif }}</span></td>
                            <td><span class="tx-code">{{ $tax->NIN }}</span></td>
                            <td>
                                <div class="tx-actions">
                                    <a href="{{ route('taxes.pdf', ['tax' => $tax->id, 'type' => 'full']) }}" class="tx-btn tx-g12" target="_blank">
                                        G12
                                    </a>
                                    <a href="{{ route('taxes.pdf', ['tax' => $tax->id, 'type' => 'receipt']) }}" class="tx-btn tx-g12bis" target="_blank">
                                        G12 Bis
                                    </a>
                                    <a href="{{ route('taxes.edit', $tax->id) }}" class="tx-btn tx-edit">
                                        تعديل
                                    </a>
<a href="{{ route('tax-payments.index', $tax->id) }}"
   class="tx-btn tx-payments">
    Paiements
</a>
                                    <form action="{{ route('taxes.destroy', $tax->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل تريد الحذف؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="tx-btn tx-delete">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="tx-empty">
                                <i class="fas fa-inbox"></i>
                                لا يوجد مكلفين
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== PAGINATION ===== --}}
        @if ($taxes->hasPages())
        <div class="tx-paginate">
            <div class="tx-page-nav">
                @if ($taxes->onFirstPage())
                    <span class="tx-page-btn tx-disabled"><i class="fas fa-chevron-right"></i></span>
                @else
                    <a href="{{ $taxes->previousPageUrl() }}" class="tx-page-btn"><i class="fas fa-chevron-right"></i></a>
                @endif

                @foreach ($taxes->getUrlRange(1, $taxes->lastPage()) as $page => $url)
                    @if ($page == $taxes->currentPage())
                        <span class="tx-page-btn tx-active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="tx-page-btn">{{ $page }}</a>
                    @endif
                @endforeach

                @if ($taxes->hasMorePages())
                    <a href="{{ $taxes->nextPageUrl() }}" class="tx-page-btn"><i class="fas fa-chevron-left"></i></a>
                @else
                    <span class="tx-page-btn tx-disabled"><i class="fas fa-chevron-left"></i></span>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<style>
:root {
    --tx-primary: #3b82f6;
    --tx-warning: #f59e0b;
    --tx-danger: #ef4444;
    --tx-success: #22c55e;
    --tx-border: #e5e7eb;
    --tx-bg-soft: #f8fafc;
    --tx-text: #1e293b;
    --tx-muted: #64748b;
}

.taxes-wrapper {
    min-height: 100vh;
    background: #f1f5f9;
    padding-bottom: 40px;
}
.taxes-wrapper * { box-sizing: border-box; }

/* ===== HEADER ===== */
.tx-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 22px;
}
.tx-title { display: flex; align-items: center; gap: 14px; }
.tx-icon {
    width: 46px; height: 46px;
    background: var(--tx-warning);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.tx-title h1 { color: var(--tx-text); font-size: 1.35rem; font-weight: 700; margin: 0; }
.tx-title span { color: var(--tx-muted); font-size: 0.85rem; }
.tx-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--tx-warning);
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: opacity .15s ease;
}
.tx-add:hover { opacity: .88; color: #fff; }

/* ===== ALERT ===== */
.alert-box {
    display: flex;
    align-items: center;
    gap: 16px;
    background: #fff;
    border: 1px solid var(--tx-border);
    border-inline-start: 4px solid var(--tx-danger);
    border-radius: 14px;
    padding: 16px 20px;
    margin-bottom: 18px;
}
.alert-icon {
    width: 42px; height: 42px;
    background: #fee2e2;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: var(--tx-danger);
    font-size: 1.05rem;
    flex-shrink: 0;
}
.alert-content { flex: 1; }
.alert-header { display: flex; align-items: center; gap: 12px; margin-bottom: 4px; flex-wrap: wrap; }
.alert-header h3 { color: var(--tx-text); font-size: 1rem; font-weight: 700; margin: 0; }
.alert-badge {
    background: var(--tx-danger); color: #fff;
    padding: 3px 10px; border-radius: 6px;
    font-size: 0.72rem; font-weight: 700;
}
.alert-content p { color: var(--tx-muted); margin: 0; font-size: 0.85rem; }

/* ===== DEBTORS GRID ===== */
.debtors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 12px;
    margin-bottom: 22px;
}
.debtor-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fff;
    border: 1px solid var(--tx-border);
    border-radius: 12px;
    padding: 14px 16px;
    transition: box-shadow .15s ease;
}
.debtor-card:hover { box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
.debtor-info { display: flex; align-items: center; gap: 10px; }
.debtor-avatar {
    width: 36px; height: 36px;
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 0.9rem;
    flex-shrink: 0;
}
.debtor-name { color: var(--tx-text); font-weight: 600; font-size: 0.9rem; }
.debtor-nin { color: var(--tx-muted); font-size: 0.75rem; margin-top: 2px; }
.debtor-meta { display: flex; flex-direction: column; align-items: flex-end; gap: 4px; }
.debtor-status {
    background: #fee2e2; color: #dc2626;
    padding: 3px 10px; border-radius: 6px;
    font-size: 0.75rem; font-weight: 600;
}
.debtor-date { color: #94a3b8; font-size: 0.75rem; }

/* ===== BOTTOM LINKS ===== */
.tx-links { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 20px; }
.tx-link {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600; font-size: 0.85rem;
    background: #fff;
    border: 1px solid var(--tx-border);
    color: var(--tx-muted);
    transition: all .15s ease;
}
.tx-link:hover { background: var(--tx-bg-soft); color: var(--tx-text); }
.tx-danger { background: #fff; border-color: #fecaca; color: var(--tx-danger); }
.tx-danger:hover { background: #fef2f2; }
.tx-count {
    background: var(--tx-danger); color: #fff;
    padding: 2px 8px; border-radius: 6px;
    font-size: 0.7rem; font-weight: 700;
}

/* ===== CARD ===== */
.tx-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--tx-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 18px;
}
.tx-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid var(--tx-border);
    background: var(--tx-bg-soft);
}

/* ===== SEARCH ===== */
.tx-search { position: relative; max-width: 420px; }
.tx-search > i {
    position: absolute;
    inset-inline-start: 14px;
    top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.tx-search input {
    width: 100%;
    padding: 10px 14px;
    padding-inline-start: 38px;
    border-radius: 10px;
    border: 1px solid var(--tx-border);
    background: #fff;
    color: var(--tx-text);
    font-size: 0.9rem;
}
.tx-search input::placeholder { color: #94a3b8; }
.tx-search input:focus {
    outline: none;
    border-color: var(--tx-primary);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* ===== TABLE ===== */
.tx-table-wrap { overflow-x: auto; }
.tx-table { width: 100%; border-collapse: collapse; }
.tx-table thead { background: var(--tx-bg-soft); }
.tx-table th {
    padding: 14px 20px;
    text-align: right;
    color: var(--tx-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid var(--tx-border);
}
.tx-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--tx-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.tx-table tbody tr:hover { background: var(--tx-bg-soft); }
.tx-table tbody tr:last-child td { border-bottom: none; }

.tx-user { display: flex; align-items: center; gap: 12px; }
.tx-avatar {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 0.9rem;
    flex-shrink: 0;
}
.tx-name { color: var(--tx-text); font-weight: 600; font-size: 0.92rem; }
.tx-name-fr { color: #94a3b8; font-size: 0.76rem; margin-top: 2px; }

.tx-code {
    font-family: 'Courier New', monospace;
    background: var(--tx-bg-soft);
    border: 1px solid var(--tx-border);
    padding: 5px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    color: var(--tx-muted);
}

/* ===== ACTIONS ===== */
.tx-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.tx-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 58px;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid transparent;
    cursor: pointer;
    transition: all .15s ease;
    white-space: nowrap;
}
.tx-g12 { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
.tx-g12:hover { background: #2563eb; color: #fff; }

.tx-g12bis { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.tx-g12bis:hover { background: #d97706; color: #fff; }

.tx-edit { background: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
.tx-edit:hover { background: #16a34a; color: #fff; }

.tx-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.tx-delete:hover { background: #dc2626; color: #fff; }

/* ===== EMPTY ===== */
.tx-empty { text-align: center !important; padding: 60px 20px !important; color: #94a3b8; }
.tx-empty i { font-size: 2.4rem; margin-bottom: 14px; opacity: .4; display: block; }

/* ===== PAGINATION ===== */
.tx-paginate { display: flex; justify-content: center; margin-bottom: 20px; }
.tx-page-nav { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
.tx-page-btn {
    display: inline-flex;
    align-items: center; justify-content: center;
    min-width: 38px; min-height: 38px;
    padding: 8px 12px;
    border-radius: 9px;
    text-decoration: none;
    color: var(--tx-muted);
    background: #fff;
    border: 1px solid var(--tx-border);
    font-size: 0.85rem;
    font-weight: 600;
    transition: all .15s ease;
}
.tx-page-btn:hover { background: var(--tx-bg-soft); color: var(--tx-text); }
.tx-active { background: var(--tx-warning) !important; color: #fff !important; border-color: transparent !important; }
.tx-disabled { opacity: .4; cursor: not-allowed; }
.tx-disabled:hover { background: #fff !important; color: var(--tx-muted) !important; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .tx-header { flex-direction: column; align-items: flex-start; }
    .tx-add { width: 100%; justify-content: center; }
    .tx-search { max-width: 100%; }
    .tx-links { flex-direction: column; }
    .tx-link { width: 100%; justify-content: center; }
}
.tx-payments {
    background: #f0fdf4;
    color: #16a34a;
    border-color: #bbf7d0;
}

.tx-payments:hover {
    background: #16a34a;
    color: #fff;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('liveSearch');
    const rows = document.querySelectorAll('#taxTableBody tr');

    searchInput.addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(value) ? '' : 'none';
        });
    });
});
</script>
@endsection