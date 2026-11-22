@extends('layouts.app')

@section('content')

<div class="transport-page">
    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="tp-header">
            <div class="tp-title">
                <div class="tp-icon">
                    <i class="fas fa-road"></i>
                </div>
                <div>
                    <h1>مديرية النقل</h1>
                    <span>قائمة الناقلين</span>
                </div>
            </div>
            <a href="{{ route('transporters.create') }}" class="tp-add">
                <i class="fas fa-plus"></i>
                ناقل جديد
            </a>
        </div>

        {{-- MAIN CARD --}}
        <div class="tp-card">

            {{-- SEARCH --}}
            <div class="tp-card-header">
                <div class="tp-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="بحث بالاسم أو اللقب أو الهاتف...">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="tp-table-wrap">
                <table class="tp-table">
                    <thead>
                        <tr>
                            <th>الناقل</th>
                            <th>الهاتف</th>
                            <th>المركبة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($transporters as $t)
                        <tr>
                            <td>
                                <div class="tp-user">
                                    <div class="tp-avatar" style="background: hsl({{ ($t->id * 137) % 360 }}, 65%, 50%)">
                                        {{ mb_substr($t->first_name, 0, 1) }}
                                    </div>
                                    <span class="tp-name">{{ $t->first_name }} {{ $t->last_name }}</span>
                                </div>
                            </td>
                            <td class="text-muted">{{ $t->phone ?? '---' }}</td>
                            <td>
                                <span class="tp-tag">{{ $t->type_of_vehicle }}</span>
                            </td>
                            <td>
                                <div class="tp-actions">
                                    <a href="{{ route('transporters.edit', $t->id) }}" class="tp-btn tp-edit">
                                        تعديل
                                    </a>
                                    <a href="{{ route('transporters.pdf', $t->id) }}" class="tp-btn tp-pdf" target="_blank">
                                        PDF
                                    </a>
                                    <form method="POST" action="{{ route('transporters.destroy', $t->id) }}" style="display:inline;" onsubmit="return confirm('حذف {{ $t->first_name }} {{ $t->last_name }}؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="tp-btn tp-del">
                                            حذف
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="tp-empty">
                                <i class="fas fa-inbox"></i>
                                لا يوجد ناقلين
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        <div class="tp-paginate">
            {{ $transporters->links() }}
        </div>

    </div>
</div>

<style>
:root {
    --tp-blue: #3b82f6;
    --tp-warning: #f59e0b;
    --tp-danger: #ef4444;
    --tp-border: #e5e7eb;
    --tp-bg-soft: #f8fafc;
    --tp-text: #1e293b;
    --tp-muted: #64748b;
}

.transport-page {
    min-height: 100vh;
    background: #f1f5f9;
    padding-bottom: 40px;
}
.transport-page * { box-sizing: border-box; }

/* ===== HEADER ===== */
.tp-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 22px;
}
.tp-title { display: flex; align-items: center; gap: 14px; }
.tp-icon {
    width: 46px; height: 46px;
    background: var(--tp-blue);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.tp-title h1 { color: var(--tp-text); font-size: 1.35rem; font-weight: 700; margin: 0; }
.tp-title span { color: var(--tp-muted); font-size: 0.85rem; }
.tp-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--tp-blue);
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: opacity .15s ease;
}
.tp-add:hover { opacity: .88; color: #fff; }

/* ===== CARD ===== */
.tp-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--tp-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 18px;
}
.tp-card-header {
    padding: 18px 22px;
    border-bottom: 1px solid var(--tp-border);
    background: var(--tp-bg-soft);
    display: flex;
    justify-content: flex-end;
}

/* ===== SEARCH ===== */
.tp-search { position: relative; width: 100%; max-width: 420px; }
.tp-search > i {
    position: absolute;
    inset-inline-start: 14px;
    top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.tp-search input {
    width: 100%;
    padding: 10px 14px;
    padding-inline-start: 38px;
    border-radius: 10px;
    border: 1px solid var(--tp-border);
    background: #fff;
    color: var(--tp-text);
    font-size: 0.9rem;
}
.tp-search input::placeholder { color: #94a3b8; }
.tp-search input:focus {
    outline: none;
    border-color: var(--tp-blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* ===== TABLE ===== */
.tp-table-wrap { overflow-x: auto; }
.tp-table { width: 100%; border-collapse: collapse; table-layout: fixed; direction: rtl; }
.tp-table thead { background: var(--tp-bg-soft); }
.tp-table th {
    padding: 14px 20px;
    text-align: right;
    color: var(--tp-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.4px;
    border-bottom: 1px solid var(--tp-border);
}
.tp-table td {
    padding: 14px 20px;
    text-align: right;
    border-bottom: 1px solid #f1f5f9;
    color: var(--tp-text);
    font-size: 0.9rem;
    vertical-align: middle;
    overflow: hidden;
    text-overflow: ellipsis;
}
.tp-table th:nth-child(1), .tp-table td:nth-child(1) { width: 26%; }
.tp-table th:nth-child(2), .tp-table td:nth-child(2) { width: 18%; }
.tp-table th:nth-child(3), .tp-table td:nth-child(3) { width: 20%; }
.tp-table th:nth-child(4), .tp-table td:nth-child(4) { width: 36%; }
.tp-table tbody tr:hover { background: var(--tp-bg-soft); }
.tp-table tbody tr:last-child td { border-bottom: none; }

.tp-user { display: flex; align-items: center; gap: 12px; }
.tp-avatar {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-weight: 700; font-size: 0.9rem;
    flex-shrink: 0;
}
.tp-name { color: var(--tp-text); font-weight: 600; font-size: 0.92rem; }

.tp-tag {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #eff6ff;
    color: #2563eb;
}

/* ===== ACTIONS ===== */
.tp-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.tp-btn {
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
.tp-edit { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.tp-edit:hover { background: #d97706; color: #fff; }

.tp-pdf { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.tp-pdf:hover { background: #dc2626; color: #fff; }

.tp-del { background: #f1f5f9; color: #64748b; border-color: #e2e8f0; }
.tp-del:hover { background: #ef4444; color: #fff; border-color: #ef4444; }

/* ===== EMPTY ===== */
.tp-empty { text-align: center !important; padding: 60px 20px !important; color: #94a3b8; }
.tp-empty i { font-size: 2.4rem; margin-bottom: 14px; opacity: .4; display: block; }

/* ===== PAGINATION ===== */
.tp-paginate { display: flex; justify-content: center; }
.tp-paginate nav { display: flex; gap: 6px; flex-wrap: wrap; justify-content: center; }
.tp-paginate a,
.tp-paginate span {
    padding: 8px 14px;
    border-radius: 9px;
    text-decoration: none;
    color: var(--tp-muted);
    background: #fff;
    border: 1px solid var(--tp-border);
    font-size: 0.85rem;
    font-weight: 600;
    transition: all .15s ease;
}
.tp-paginate a:hover { background: var(--tp-bg-soft); color: var(--tp-text); }
.tp-paginate .active span { background: var(--tp-blue); color: #fff; border-color: transparent; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .tp-header { flex-direction: column; align-items: flex-start; }
    .tp-add { width: 100%; justify-content: center; }
    .tp-search { max-width: 100%; }
}
</style>

<script>
document.getElementById('searchInput')?.addEventListener('keyup', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#tableBody tr').forEach(row => {
        if (row.querySelector('.tp-empty')) return;
        row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>

@endsection