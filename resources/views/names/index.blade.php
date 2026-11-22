@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="nm-card">

        {{-- HEADER --}}
        <div class="nm-card-header">
            <div class="nm-title">
                <div class="nm-icon"><i class="fas fa-signature"></i></div>
                <h4 class="mb-0">طلبات التسمية</h4>
            </div>
            <a href="{{ route('names.create') }}" class="nm-add">
                <i class="fas fa-plus"></i> إضافة
            </a>
        </div>

        {{-- BODY --}}
        <div class="nm-card-body">

            {{-- SEARCH --}}
            <div class="nm-searchbar">
                <div class="nm-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="search" placeholder="بحث بالاسم، العنوان أو النوع...">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="nm-table-wrap">
                <table class="nm-table text-center">
                    <thead>
                        <tr>
                            <th>الاسم الكامل</th>
                            <th>العنوان</th>
                            <th>النوع</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="namesTable">
                        @forelse($names as $name)
                        <tr>
                            <td class="fw-semibold">{{ $name->full_name }}</td>
                            <td class="text-muted">{{ $name->address }}</td>
                            <td><span class="nm-badge">{{ $name->type }}</span></td>
                            <td>
                                <div class="nm-actions">
                                    <a href="{{ route('names.pdf.naming', $name->id) }}" class="nm-btn nm-btn-secondary" target="_blank">
                                        PDF
                                    </a>
                                    <a href="{{ route('names.edit', $name->id) }}" class="nm-btn nm-btn-primary">
                                        تعديل
                                    </a>
                                    <form action="{{ route('names.destroy', $name->id) }}" method="POST" class="d-inline" onsubmit="return confirm('تأكيد الحذف ؟')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="nm-btn nm-btn-danger">حذف</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="nm-empty">
                                <i class="fas fa-inbox"></i>
                                لا توجد بيانات
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<style>
:root {
    --nm-primary: #3b82f6;
    --nm-warning: #f59e0b;
    --nm-danger: #ef4444;
    --nm-border: #e5e7eb;
    --nm-bg-soft: #f8fafc;
    --nm-text: #1e293b;
    --nm-muted: #64748b;
}

/* ===== CARD ===== */
.nm-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--nm-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}

.nm-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 12px;
    padding: 18px 24px;
    background: var(--nm-bg-soft);
    border-bottom: 1px solid var(--nm-border);
}
.nm-title { display: flex; align-items: center; gap: 12px; }
.nm-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: var(--nm-warning);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}
.nm-title h4 { color: var(--nm-text); font-weight: 700; font-size: 1.1rem; }

.nm-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--nm-primary);
    color: #fff;
    padding: 9px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.85rem;
    transition: opacity .15s ease;
}
.nm-add:hover { opacity: .88; color: #fff; }

.nm-card-body { padding: 22px 24px; }

/* ===== SEARCH ===== */
.nm-searchbar { margin-bottom: 18px; }
.nm-search { position: relative; max-width: 420px; }
.nm-search > i {
    position: absolute;
    inset-inline-start: 14px;
    top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.nm-search input {
    width: 100%;
    padding: 11px 14px;
    padding-inline-start: 38px;
    border-radius: 10px;
    border: 1px solid var(--nm-border);
    background: #fff;
    color: var(--nm-text);
    font-size: 0.9rem;
}
.nm-search input::placeholder { color: #94a3b8; }
.nm-search input:focus {
    outline: none;
    border-color: var(--nm-primary);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* ===== TABLE ===== */
.nm-table-wrap { overflow-x: auto; border: 1px solid var(--nm-border); border-radius: 12px; }
.nm-table { width: 100%; border-collapse: collapse; }
.nm-table thead { background: var(--nm-bg-soft); }
.nm-table th {
    padding: 13px 18px;
    color: var(--nm-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid var(--nm-border);
}
.nm-table td {
    padding: 13px 18px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--nm-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.nm-table tbody tr:hover { background: var(--nm-bg-soft); }
.nm-table tbody tr:last-child td { border-bottom: none; }

.nm-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #e0f2fe;
    color: #0284c7;
}

/* ===== ACTIONS ===== */
.nm-actions { display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; }
.nm-btn {
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
.nm-btn-secondary { background: #f1f5f9; color: #475569; border-color: #e2e8f0; }
.nm-btn-secondary:hover { background: #475569; color: #fff; }

.nm-btn-primary { background: #eff6ff; color: #2563eb; border-color: #bfdbfe; }
.nm-btn-primary:hover { background: #2563eb; color: #fff; }

.nm-btn-danger { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.nm-btn-danger:hover { background: #dc2626; color: #fff; }

/* ===== EMPTY ===== */
.nm-empty { padding: 50px 20px !important; color: #94a3b8; }
.nm-empty i { font-size: 2.2rem; margin-bottom: 12px; opacity: .4; display: block; }

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .nm-card-header { flex-direction: column; align-items: flex-start; }
    .nm-add { width: 100%; justify-content: center; }
    .nm-search { max-width: 100%; }
}
</style>

<script>
document.getElementById('search').addEventListener('keyup', function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('#namesTable tr');
    rows.forEach(row => {
        let text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
</script>
@endsection