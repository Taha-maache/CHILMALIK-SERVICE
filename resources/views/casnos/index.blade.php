@extends('layouts.app')

@section('content')
<div class="container py-4">

    {{-- ===== Alerts ===== --}}
    <div class="row g-3 mb-4">
        @if($count_creditors > 0)
        <div class="col-md-6">
            <div class="cs-alert cs-alert-danger">
                 <div class="cs-alert-icon"><i class="fas fa-exclamation-triangle"></i></div>
                <div>
                    <h6 class="mb-1 fw-semibold">تنبيه الديون المتبقية</h6>
                    <span class="text-muted small">يوجد <strong>{{ $count_creditors }}</strong> أشخاص لم يكملوا الدفع</span>
                </div>
            </div>
        </div>
        @endif

        @if($count_debtors > 0)
        <div class="col-md-6">
            <div class="cs-alert cs-alert-info">
                <div class="cs-alert-icon"><i class="fas fa-hand-holding-usd"></i></div>
                <div>
                    <h6 class="mb-1 fw-semibold">تنبيه المستحقات الزائدة</h6>
                    <span class="text-muted small">يوجد <strong>{{ $count_debtors }}</strong> أشخاص دفعوا زيادة</span>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- ===== Quick actions ===== --}}
    <div class="d-flex justify-content-center gap-2 mb-4">
        <a href="{{ route('casnos.creditors') }}" class="cs-btn cs-btn-outline-danger">
            <i class="fas fa-user-minus"></i> CREDITORS
        </a>
        <a href="{{ route('casnos.debtors') }}" class="cs-btn cs-btn-outline-primary">
            <i class="fas fa-user-plus"></i> OVERPAID
        </a>
    </div>

    {{-- ===== Main card ===== --}}
    <div class="cs-card">

        {{-- Header --}}
        <div class="cs-card-header">
            <div class="row align-items-center g-3">
                <div class="col-md-4">
                    <h5 class="fw-bold mb-0"><i class="fas fa-users-cog me-2 text-warning"></i>قائمة CASNOS</h5>
                </div>
                <div class="col-md-5">
                    <div class="cs-search">
                        <i class="fas fa-search cs-search-icon"></i>
                        <input type="text" id="liveSearchCasnos" class="form-control cs-search-input"
                               placeholder="بحث بالإسم أو Matricule...">
                    </div>
                </div>
                <div class="col-md-3 text-md-end">
                    <a href="{{ route('casnos.create') }}" class="cs-btn cs-btn-warning w-100 w-md-auto">
                        <i class="fas fa-plus-circle"></i> إضافة جديد
                    </a>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table cs-table align-middle mb-0 text-center">
                <thead>
                    <tr>
                        <th>الإسم واللقب</th>
                        <th>Matricule</th>
                        <th>المبلغ المستحق</th>
                        <th>المبلغ المدفوع</th>
                        <th>الدين المتبقي</th>
                        <th>Recours</th>
                        <th>Carte Chifa</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="casnosTable">
                    @foreach($clients as $client)
        
        @php
    $recoursExpired = $client->recoursExpired();
@endphp

<tr class="{{ $recoursExpired ? 'recours-expired' : '' }}">

                        <td class="fw-semibold">{{ $client->nom }} {{ $client->prenom }}</td>
                        <td><span class="cs-badge cs-badge-light">{{ $client->matricule }}</span></td>
                        <td>{{ number_format($client->montant_enkissi, 2) }} دج
                        </td>
                        <td class="text-success fw-semibold">{{ number_format($client->montant_versse, 2) }} دج</td>
                       
<td class="fw-semibold">
    @if($client->adjusted_balance < 0)
        <span class="text-danger">
            {{ number_format($client->adjusted_remaining, 2, ',', ' ') }} دج
        </span>

        @if($client->penalty_amount > 0)
            <div class="small mt-1 text-muted">
                أصل الدين:
                {{ number_format($client->original_remaining, 2, ',', ' ') }} دج
            </div>
            <div class="small text-warning">
                زيادة ({{ $client->months_late }} شهر ×
                {{ number_format($client->penalty_rate, 0) }}%):
                +{{ number_format($client->penalty_amount, 2, ',', ' ') }} دج
            </div>
        @endif

    @elseif($client->adjusted_balance > 0)
        <span class="text-success">
            +{{ number_format($client->adjusted_balance, 2, ',', ' ') }} دج
        </span>
        <div class="small text-muted">فائض للعميل</div>

    @else
        <span class="text-success">0,00 دج</span>
        <div class="small text-muted">مسدد بالكامل</div>
    @endif
</td>
                       <td>

    @if($client->recours)

        @if($recoursExpired)

            <span class="badge bg-danger">
                ⚠️ Recours dépassé
            </span>

        @else

            <span class="badge bg-success">
                Oui
            </span>

        @endif

    @else

        <span class="badge bg-secondary">
            Non
        </span>

    @endif

</td>
                            <td>
                            @if($client->carte_chifa)
                                <span class="cs-badge cs-badge-info">Oui</span>
                            @else
                                <span class="cs-badge cs-badge-secondary">Non</span>
                            @endif
                        </td>
                        <td>
    <div class="d-flex justify-content-center flex-wrap gap-2">
        @if(
    $client->getOriginalRemaining() > 0 &&
    $client->getAdjustedRemaining() > 0 &&
    $client->date_paiement &&
    \Carbon\Carbon::parse($client->date_paiement)->addDays(25)->lte(now()) &&
    (
        !$client->last_whatsapp_reminder_at ||
        $client->last_whatsapp_reminder_at->copy()->addDays(3)->lte(now())
    )
)
    <a href="{{ route('casnos.whatsapp-reminder', $client->id) }}"
       class="cs-action-btn"
       style="color:#16a34a;background:#f0fdf4;border-color:#bbf7d0;">
        <i class="fab fa-whatsapp"></i>
        WhatsApp
    </a>
@endif

        <a href="{{ route('casnos.edit', $client->id) }}" class="cs-action-btn cs-action-primary">
            تعديل
        </a>
        <a href="{{ route('casnos.print', $client->id) }}" class="cs-action-btn cs-action-secondary" target="_blank">
            PDF
        </a>
        <a href="{{ route('casnos.pm.index', $client->id) }}" class="cs-action-btn cs-action-success">
            دفعات
        </a>
        <form action="{{ route('casnos.destroy', $client->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد؟')" class="d-inline">
            @csrf @method('DELETE')
            <button type="submit" class="cs-action-btn cs-action-danger">
                حذف
            </button>
        </form>
    </div>
</td>
                    </tr>
                    @endforeach

                    @if($clients->isEmpty())
                    <tr>
                        <td colspan="8" class="py-5 text-muted">
                            <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                            لا توجد بيانات لعرضها
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    :root {
        --cs-primary: #3b82f6;
        --cs-primary-dark: #2563eb;
        --cs-danger: #ef4444;
        --cs-danger-dark: #dc2626;
        --cs-warning: #f59e0b;
        --cs-success: #22c55e;
        --cs-info: #06b6d4;
        --cs-border: #e5e7eb;
        --cs-bg-soft: #f8fafc;
        --cs-text: #1e293b;
        --cs-radius: 12px;
    }

    /* Alerts */
    .cs-alert {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 18px;
        border-radius: var(--cs-radius);
        background: #fff;
        border: 1px solid var(--cs-border);
        border-inline-start: 4px solid transparent;
    }
    .cs-alert-danger { border-inline-start-color: var(--cs-danger); }
    .cs-alert-info { border-inline-start-color: var(--cs-primary); }
    .cs-alert-icon {
        width: 40px; height: 40px;
        display: flex; align-items: center; justify-content: center;
        border-radius: 10px;
        font-size: 1rem;
        flex-shrink: 0;
    }
    .cs-alert-danger .cs-alert-icon { background: #fee2e2; color: var(--cs-danger); }
    .cs-alert-info .cs-alert-icon { background: #dbeafe; color: var(--cs-primary); }

    /* Buttons */
    .cs-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        border: 1.5px solid transparent;
        transition: all .15s ease;
        cursor: pointer;
    }
    .cs-btn-outline-danger { color: var(--cs-danger); border-color: #fecaca; background: #fff; }
    .cs-btn-outline-danger:hover { background: var(--cs-danger); color: #fff; border-color: var(--cs-danger); }
    .cs-btn-outline-primary { color: var(--cs-primary); border-color: #bfdbfe; background: #fff; }
    .cs-btn-outline-primary:hover { background: var(--cs-primary); color: #fff; border-color: var(--cs-primary); }
    .cs-btn-warning { background: var(--cs-warning); color: #fff; }
    .cs-btn-warning:hover { background: #d97706; color: #fff; }

    /* Card */
    .cs-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid var(--cs-border);
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        overflow: hidden;
    }
    .cs-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid var(--cs-border);
        background: var(--cs-bg-soft);
    }

    /* Search */
    .cs-search { position: relative; }
    .cs-search-icon {
        position: absolute;
        top: 50%; transform: translateY(-50%);
        inset-inline-start: 14px;
        color: #94a3b8;
        font-size: 0.85rem;
    }
    .cs-search-input {
        padding-inline-start: 38px;
        border-radius: 10px;
        border: 1px solid var(--cs-border);
        background: #fff;
    }
    .cs-search-input:focus {
        border-color: var(--cs-primary);
        box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
    }

    /* Table */
    .cs-table thead th {
        background: var(--cs-bg-soft);
        color: #64748b;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border-bottom: 1px solid var(--cs-border);
        padding: 14px 12px;
    }
    .cs-table tbody td {
        padding: 14px 12px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.9rem;
        color: var(--cs-text);
    }
    .cs-table tbody tr:hover { background: var(--cs-bg-soft); }
    .cs-table tbody tr:last-child td { border-bottom: none; }

    /* Badges */
    .cs-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.78rem;
        font-weight: 600;
    }
    .cs-badge-light { background: #f1f5f9; color: #475569; border: 1px solid var(--cs-border); }
    .cs-badge-success { background: #dcfce7; color: #16a34a; }
    .cs-badge-danger { background: #fee2e2; color: #dc2626; }
    .cs-badge-info { background: #cffafe; color: #0891b2; }
    .cs-badge-secondary { background: #f1f5f9; color: #64748b; }

    /* Icon buttons (actions) */
    .cs-icon-btn {
        width: 34px; height: 34px;
        display: inline-flex;
        align-items: center; justify-content: center;
        border-radius: 9px;
        border: 1px solid var(--cs-border);
        background: #fff;
        cursor: pointer;
        font-size: 0.85rem;
        transition: all .15s ease;
    }
    .cs-icon-btn-primary { color: var(--cs-primary); }
    .cs-icon-btn-primary:hover { background: var(--cs-primary); color: #fff; border-color: var(--cs-primary); }
    .cs-icon-btn-secondary { color: #64748b; }
    .cs-icon-btn-secondary:hover { background: #64748b; color: #fff; border-color: #64748b; }
    .cs-icon-btn-success { color: var(--cs-success); }
    .cs-icon-btn-success:hover { background: var(--cs-success); color: #fff; border-color: var(--cs-success); }
    .cs-icon-btn-danger { color: var(--cs-danger); }
    .cs-icon-btn-danger:hover { background: var(--cs-danger); color: #fff; border-color: var(--cs-danger); }

    /* Back button (kept from original, restyled) */
    .btn-back-traders {
        background: #64748b;
        color: #fff !important;
        padding: 8px 18px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }
    .cs-action-btn {
    min-width: 62px;
    height: 32px;
    padding: 0 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    border: 1.5px solid transparent;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none !important;
    cursor: pointer;
    line-height: 1;
    transition: all .15s ease;
    white-space: nowrap;
}

.cs-action-primary { color: #2563eb; background: #eff6ff; border-color: #bfdbfe; }
.cs-action-primary:hover { background: #2563eb; color: #fff; }

.cs-action-secondary { color: #475569; background: #f1f5f9; border-color: #e2e8f0; }
.cs-action-secondary:hover { background: #475569; color: #fff; }

.cs-action-success { color: #16a34a; background: #f0fdf4; border-color: #bbf7d0; }
.cs-action-success:hover { background: #16a34a; color: #fff; }

.cs-action-danger { color: #dc2626; background: #fef2f2; border-color: #fecaca; }
.cs-action-danger:hover { background: #dc2626; color: #fff; }
</style>

<script>
const input = document.getElementById("liveSearchCasnos");
const rows = document.querySelectorAll("#casnosTable tr");

input.addEventListener("input", function () {
    let value = this.value.toLowerCase();

    rows.forEach(row => {
        if (!row.cells || row.cells.length < 6) return;

        let nom = row.cells[0].textContent.toLowerCase();
        let matricule = row.cells[1].textContent.toLowerCase();
        let phone = row.cells[5].textContent.toLowerCase();

        row.style.display = (nom.includes(value) || matricule.includes(value) || phone.includes(value))
            ? "" : "none";
    });
});
</script>
<style>
.recours-expired {
    background-color: #ffcccc !important;
}

.recours-expired td {
    color: #b30000 !important;
    font-weight: 700;
}
</style>
@endsection