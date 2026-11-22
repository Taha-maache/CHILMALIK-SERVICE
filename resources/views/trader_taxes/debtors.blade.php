@extends('layouts.app')

@section('content')
<style>
    :root {
        --danger-glow: rgba(239, 68, 68, 0.15);
        --accent-amber: #f59e0b;
        --card-bg: rgba(30, 41, 59, 0.7);
    }
    body { background-color: #0b0f19; color: #f3f4f6; font-family: 'Segoe UI', sans-serif; }
    
    .debt-card {
        background: var(--card-bg);
        border: 1px solid rgba(245, 158, 11, 0.2);
        border-radius: 20px;
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    
    .debt-card:hover {
        transform: translateY(-8px);
        border-color: var(--accent-amber);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.4), 0 0 20px var(--danger-glow);
    }

    .status-badge {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        padding: 5px 15px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .days-late {
        font-size: 0.8rem;
        color: var(--accent-amber);
        background: rgba(245, 158, 11, 0.1);
        padding: 5px 12px;
        border-radius: 50px;
    }

    .trader-name {
        background: linear-gradient(to left, #fff, #94a3b8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 1.4rem;
    }

    .info-box {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.05);
        transition: 0.3s;
    }
    
    .info-box:hover { background: rgba(0, 0, 0, 0.5); }

    .btn-pay {
        background: var(--accent-amber);
        color: #000;
        border: none;
        font-weight: 700;
        border-radius: 12px;
        transition: 0.3s;
    }

    .btn-pay:hover {
        background: #d97706;
        color: #000;
        box-shadow: 0 0 15px rgba(245, 158, 11, 0.4);
    }

    .phone-link {
        color: #94a3b8;
        text-decoration: none;
        font-size: 0.9rem;
        transition: 0.3s;
    }
    .phone-link:hover { color: #fff; }

    /* تحسين التنقل بين الصفحات */
    .pagination .page-link {
        background: var(--card-bg);
        border-color: rgba(255,255,255,0.1);
        color: #fff;
    }
</style>

<div class="container py-5" dir="rtl">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-warning mb-1">
                <i class="fas fa-exclamation-triangle me-2"></i> سجل الديون المتأخرة
            </h2>
            <p class="text-muted">متابعة ضرائب التجار (Trader Taxes) التي تجاوزت الموعد</p>
        </div>
        <a href="{{ route('trader_taxes.index') }}" class="btn btn-outline-light rounded-pill px-4">
            الرجوع للقائمة العامة <i class="fas fa-arrow-left ms-2"></i>
        </a>
    </div>

    <div class="row g-4">
        @forelse($debtors as $debt)
        <div class="col-md-6 col-lg-4">
            <div class="debt-card p-4 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <span class="status-badge">متأخر</span>
                    @if($debt->credit_date)
                    <div class="days-late">
                        <i class="far fa-clock ms-1"></i>
                        {{ (int) now()->diffInDays($debt->credit_date) }} يوم تأخير
                    </div>
                    @endif
                </div>

                <h4 class="fw-bold trader-name mb-1">
                    {{ $debt->trader->first_name }} {{ $debt->trader->last_name }}
                </h4>
                <p class="text-muted small mb-4">
                    <i class="fas fa-tag ms-1"></i> سنة الضريبة: {{ $debt->tax_year }}
                </p>

                <div class="info-box rounded-3 p-3 mb-4 mt-auto">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">المبلغ المتبقي</span>
                        <span class="text-muted small">نسبة الضريبة</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-white fs-5">{{ number_format($debt->amount, 2) }} <small>DA</small></span>
                        <span class="badge bg-primary">{{ $debt->tax_value }}%</span>
                    </div>
                    <hr class="my-2 opacity-10">
                    <div class="d-flex justify-content-between align-items-center text-warning small">
                        <span><i class="far fa-calendar-alt ms-1"></i> موعد الدفع:</span>
                        <span class="fw-bold">{{ $debt->credit_date }}</span>
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <a href="{{ route('trader_taxes.edit', $debt->id) }}" class="btn btn-pay py-2">
                        تعديل / تسديد <i class="fas fa-chevron-left ms-1"></i>
                    </a>
                    <a href="tel:{{ $debt->trader->phone }}" class="phone-link text-center py-2">
                        <i class="fas fa-phone-alt ms-2"></i> اتصل بالتاجر: {{ $debt->trader->phone }}
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="opacity-25 mb-4">
                <i class="fas fa-shield-check fa-6x text-success"></i>
            </div>
            <h3 class="text-muted">الوضعية ممتازة!</h3>
            <p>لا يوجد أي تجار متأخرين عن الدفع في الوقت الحالي.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5">
        {{ $debtors->links() }}
    </div>
</div>
@endsection