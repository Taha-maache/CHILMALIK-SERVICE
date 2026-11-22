@extends('layouts.app')

@section('content')

<style>

.btn-renew{
    background:#ecfdf5;
    color:#16a34a;
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    border:1px solid #bbf7d0;
}

.btn-renew:hover{
    filter:brightness(0.97);
}

:root{
    --bg: #f8fafc;
    --card: #ffffff;
    --ink: #1e293b;
    --muted: #94a3b8;
    --primary: #6366f1;
    --primary-soft: #eef2ff;
    --success: #22c55e;
    --success-soft: #ecfdf5;
    --danger: #f43f5e;
    --danger-soft: #fef2f2;
    --warning: #f59e0b;
    --warning-soft: #fffbeb;
    --border: #eef1f5;
}

body{
    background:var(--bg);
    font-family: 'Segoe UI', Tahoma, sans-serif;
}

.page{
    max-width:1300px;
    margin:30px auto;
}

.header{
    background: linear-gradient(135deg, #818cf8, #6366f1);
    color:white;
    padding:22px 26px;
    border-radius:20px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow: 0 8px 20px rgba(99,102,241,0.25);
}

.header h3{margin:0;font-weight:600}

.btn{
    padding:9px 16px;
    border-radius:12px;
    text-decoration:none;
    color:white;
    font-size:14px;
    transition: transform .15s ease, opacity .15s ease;
    display:inline-block;
}
.btn:hover{transform:translateY(-1px); opacity:.92}

.btn-add{
    background:rgba(255,255,255,0.18);
    border:1px solid rgba(255,255,255,0.35);
    backdrop-filter: blur(4px);
}

.btn-invoice{
    background:var(--primary-soft);
    color:var(--primary);
    padding:6px 12px;
    border-radius:10px;
    text-decoration:none;
    margin:0 3px;
    font-size:13px;
    font-weight:600;
    border:1px solid #e0e7ff;
}

.btn-edit{
    background:var(--warning-soft);
    color:var(--warning);
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
    border:1px solid #fef3c7;
}

.btn-del{
    background:var(--danger-soft);
    color:var(--danger);
    padding:6px 12px;
    border-radius:10px;
    border:1px solid #fee2e2;
    font-size:13px;
    font-weight:600;
    cursor:pointer;
}
.btn-edit:hover, .btn-invoice:hover, .btn-del:hover{filter:brightness(0.97)}

.actions-cell{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
}
.inline-form{
    display:inline-flex;
    margin:0;
    padding:0;
}
.inline-form input[type="hidden"]{
    display:none !important;
}

.card{
    background:var(--card);
    margin-top:20px;
    border-radius:20px;
    padding:22px;
    box-shadow:0 10px 30px rgba(15,23,42,0.04);
    border:1px solid var(--border);
}

table{width:100%;border-collapse:collapse}
th,td{padding:14px 12px;text-align:center}
thead th{
    background:transparent;
    color:var(--muted);
    font-size:13px;
    font-weight:600;
    border-bottom:2px solid var(--border);
    text-transform:uppercase;
    letter-spacing:.03em;
}
tbody tr{border-bottom:1px solid var(--border)}
tbody tr:hover{background:#fafbff}
tbody td{color:var(--ink); font-size:14px}

.badge-active{
    color:var(--success);
    background:var(--success-soft);
    font-weight:600;
    padding:5px 12px;
    border-radius:999px;
    font-size:13px;
}
.badge-expired{
    color:var(--danger);
    background:var(--danger-soft);
    font-weight:600;
    padding:5px 12px;
    border-radius:999px;
    font-size:13px;
}

input{
    padding:10px 14px;
    border-radius:12px;
    border:1px solid var(--border);
    background:#fbfcfe;
    outline:none;
    transition: border-color .15s ease, box-shadow .15s ease;
}
input:focus{
    border-color:var(--primary);
    box-shadow:0 0 0 3px var(--primary-soft);
}

.btn-switch{
    background:#f1f5f9;
    color:var(--ink);
    padding:9px 16px;
    border-radius:12px;
    text-decoration:none;
    margin-left:8px;
    font-size:14px;
}

.loading-spinner {
    display: none;
    width: 16px;
    height: 16px;
    border: 2px solid var(--border);
    border-top-color: var(--primary);
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
    margin-right: 8px;
    vertical-align: middle;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

.no-results {
    text-align: center;
    padding: 40px;
    color: var(--muted);
    font-size: 15px;
}

/* 🔥 تأثير التحديد */
tr.highlight {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<div class="page">

<div class="header">
    <h3>📋 الاشتراكات</h3>
    <div>
        <a href="{{ route('subscriptions.create') }}" class="btn btn-add">➕ جديد</a>
    </div>
</div>

<div class="card">

{{-- 🔍 البحث المباشر بدون زر --}}
<div style="margin-bottom:15px; display:flex; align-items:center;">
    <input 
        type="text" 
        id="searchInput" 
        placeholder="🔍 ابحث بالاسم أو الهاتف..." 
        value="{{ request('search') }}"
        style="flex:1; padding:10px 14px; font-size:15px;"
        autocomplete="off"
    >
    <div class="loading-spinner" id="loadingSpinner"></div>
</div>

{{-- 📊 الجدول --}}
<table>
<thead>
<tr>
    <th>الاسم</th>
    <th>الهاتف</th>
    <th>البداية</th>
    <th>النهاية</th>
    <th>الحالة</th>
    <th>إجراءات</th>
</tr>
</thead>

<tbody id="tableBody">
@forelse($subscriptions as $sub)
<tr data-name="{{ strtolower($sub->full_name) }}" data-phone="{{ $sub->phone }}">
    <td>{{ $sub->full_name }}</td>
    <td>{{ $sub->phone }}</td>
    <td>{{ $sub->start_date }}</td>
    <td>{{ $sub->end_date }}</td>

    <td>
        @if($sub->end_date < now())
            <span class="badge-expired">منتهي ❌</span>
        @else
            <span class="badge-active">نشط ✔</span>
        @endif
    </td>

    <td>
        <div class="actions-cell">
            <a href="{{ route('subscriptions.edit', $sub->id) }}" class="btn-edit">تعديل</a>
            <a href="{{ route('subscriptions.payments.index', $sub->id) }}"
   class="btn-invoice">
    💳 دفع
</a>
            @if($sub->end_date < now())
    <a href="{{ route('subscriptions.renew', $sub->id) }}"target="_blank" class="btn-renew">
        🔄 تجديد
    </a>
@endif
            <a href="{{ route('subscriptions.invoice', $sub->id) }}" target="_blank" class="btn-invoice">🧾 فاتورة</a>
            
@php
    $totalPaid = (float) $sub->payments->sum('amount');
    $remaining = max(0, (float) $sub->total_amount - $totalPaid);

    $latestPayment = $sub->payments
        ->sortByDesc('payment_date')
        ->first();

    $lastPaymentDate = $latestPayment
        ? \Illuminate\Support\Carbon::parse($latestPayment->payment_date)
        : \Illuminate\Support\Carbon::parse($sub->created_at);

    $lastBalanceReminder = $sub->last_whatsapp_balance_reminder_at
        ? \Illuminate\Support\Carbon::parse($sub->last_whatsapp_balance_reminder_at)
        : null;

    $balanceReminderDue = $remaining > 0
        && $lastPaymentDate->lte(now()->subDays(3))
        && (!$lastBalanceReminder || $lastBalanceReminder->lte(now()->subDays(3)));

    $lastRenewalReminder = $sub->last_whatsapp_renewal_reminder_at
        ? \Illuminate\Support\Carbon::parse($sub->last_whatsapp_renewal_reminder_at)
        : null;

    $endDate = \Illuminate\Support\Carbon::parse($sub->end_date);

    $renewalReminderDue = $endDate->lte(now()->addDays(7))
        && (!$lastRenewalReminder || $lastRenewalReminder->lte(now()->subDays(3)));
@endphp

@if($balanceReminderDue)
    <a href="{{ route('subscriptions.whatsapp', [
        'subscription' => $sub->id,
        'type' => 'balance'
    ]) }}" class="btn-invoice">
        💰 تذكير بالدفع
    </a>
@endif

@if($renewalReminderDue)
    <a href="{{ route('subscriptions.whatsapp', [
        'subscription' => $sub->id,
        'type' => 'renewal'
    ]) }}" class="btn-invoice">
        🔄 تذكير بالتجديد
    </a>
@endif

            <form method="POST" action="{{ route('subscriptions.destroy', $sub->id) }}" class="inline-form">
                @csrf
                @method('DELETE')
                <button type="button" class="btn-del" onclick="openDeleteModal({{ $sub->id }})">حذف</button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr id="noResultsRow">
    <td colspan="6" class="no-results">
        😕 لا توجد نتائج مطابقة
    </td>
</tr>
@endforelse
</tbody>
</table>

<div style="margin-top:10px" id="paginationContainer">
    {{ $subscriptions->links() }}
</div>

</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('tableBody');
    const spinner = document.getElementById('loadingSpinner');
    const pagination = document.getElementById('paginationContainer');
    
    let allRows = [];
    let debounceTimer;

    // 🔥 نخزن كل الصفوف في الذاكرة
    function cacheRows() {
        allRows = Array.from(tableBody.querySelectorAll('tr[data-name]')).map(row => ({
            element: row,
            name: row.getAttribute('data-name'),
            phone: row.getAttribute('data-phone')
        }));
    }

    cacheRows();

    function filterTable(query) {
        const lowerQuery = query.toLowerCase().trim();
        let visibleCount = 0;

        allRows.forEach(function(row) {
            const match = row.name.includes(lowerQuery) || row.phone.includes(lowerQuery);
            
            if (match) {
                row.element.style.display = '';
                row.element.classList.add('highlight');
                setTimeout(() => row.element.classList.remove('highlight'), 300);
                visibleCount++;
            } else {
                row.element.style.display = 'none';
            }
        });

        // إظهار/إخفاء رسالة "لا توجد نتائج"
        let noResultsRow = document.getElementById('noResultsRow');
        
        if (visibleCount === 0) {
            if (!noResultsRow) {
                noResultsRow = document.createElement('tr');
                noResultsRow.id = 'noResultsRow';
                noResultsRow.innerHTML = '<td colspan="6" class="no-results">😕 لا توجد نتائج مطابقة</td>';
                tableBody.appendChild(noResultsRow);
            }
            noResultsRow.style.display = '';
        } else if (noResultsRow) {
            noResultsRow.style.display = 'none';
        }

        // 🔥 إخفاء الترقيم لأن الفلترة صارت محلية
        if (lowerQuery.length > 0) {
            pagination.style.display = 'none';
        } else {
            pagination.style.display = '';
            // نرجع نعرض الكل
            allRows.forEach(row => row.element.style.display = '');
            if (noResultsRow) noResultsRow.style.display = 'none';
        }
    }

    searchInput.addEventListener('keyup', function() {
        spinner.style.display = 'inline-block';
        
        clearTimeout(debounceTimer);
        
        debounceTimer = setTimeout(function() {
            filterTable(searchInput.value);
            spinner.style.display = 'none';
        }, 300); // ⏱️ 300ms debounce
    });

    // لصق نص
    searchInput.addEventListener('paste', function() {
        setTimeout(() => {
            spinner.style.display = 'inline-block';
            setTimeout(function() {
                filterTable(searchInput.value);
                spinner.style.display = 'none';
            }, 300);
        }, 10);
    });
});
</script>
<script>
function openDeleteModal(id) {
    document.getElementById('deleteModal').style.display = 'flex';
    document.getElementById('deleteForm').action = "/subscriptions/" + id;
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}
</script>
<!-- Delete Modal -->
<div id="deleteModal" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
     background:rgba(15,23,42,0.4); backdrop-filter:blur(2px); justify-content:center; align-items:center; z-index:9999;">

    <div style="background:white; padding:28px; border-radius:18px; width:320px; text-align:center; box-shadow:0 20px 40px rgba(0,0,0,0.15);">

        <h4 style="margin-top:0">⚠️ تأكيد الحذف</h4>
        <p style="color:#64748b">هل أنت متأكد أنك تريد حذف هذا الاشتراك؟</p>

        <form id="deleteForm" method="POST">
            @csrf
            @method('DELETE')

            <div style="display:flex; justify-content:space-between; margin-top:20px; gap:10px;">
                
                <button type="button" 
                        onclick="closeDeleteModal()" 
                        style="background:#f1f5f9; color:#475569; padding:9px 14px; border:none; border-radius:10px; flex:1; font-weight:600;">
                    إلغاء
                </button>

                <button type="submit" 
                        style="background:#f43f5e; color:white; padding:9px 14px; border:none; border-radius:10px; flex:1; font-weight:600;">
                    حذف
                </button>

            </div>
        </form>

    </div>
</div>
@endsection