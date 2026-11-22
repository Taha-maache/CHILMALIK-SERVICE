@extends('layouts.app')

@section('content')
<style>
    :root {
        --danger-glow: rgba(239, 68, 68, 0.15);
        --accent-amber: #f59e0b;
    }
    body { background-color: #0b0f19; color: #f3f4f6; }
    .debt-card {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(245, 158, 11, 0.2);
        border-radius: 16px;
        transition: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .debt-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent-amber);
        box-shadow: 0 10px 20px var(--danger-glow);
    }
    .status-badge {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.3);
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }
    .days-late {
        font-size: 0.75rem;
        color: var(--accent-amber);
    }
</style>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold text-warning"><i class="fas fa-hand-holding-usd me-2"></i> سجل المتأخرين عن الدفع</h2>
            <p >قائمة الأشخاص الذين تجاوزوا تاريخ الاستحقاق المحدد</p>
        </div>
        <a href="{{ route('taxes.index') }}" class="btn btn-outline-light rounded-pill px-4">
            <i class="fas fa-arrow-right ms-2"></i> الرجوع للقائمة العامة
        </a>
    </div>

    <div class="row g-4">
        @forelse($debtors as $debtor)
        <div class="col-md-6 col-lg-4">
            <div class="debt-card p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="status-badge">متأخر</div>
                    <div class="days-late">
                        <i class="far fa-clock me-1"></i>
                        {{ (int) now()->diffInDays($debtor->credit_date) }} يوم تأخير
                    </div>
                </div>

                <h4 class="fw-bold mb-1">{{ $debtor->first_name }} {{ $debtor->last_name }}</h4>
                <p class="text-muted small mb-3">NIN: {{ $debtor->NIN }}</p>

                <div class="d-flex justify-content-between align-items-center bg-black bg-opacity-25 rounded-3 p-3">
                    <div>
                        <div>المبلغ المطلوب</div>
                        <div class="fw-bold text-white fs-5">{{ number_format($debtor->amount, 2) }} DA</div>
                    </div>
                    <div class="text-end">
                        <div>كان يستحق في</div>
                        <div class="text-warning fw-bold">{{ $debtor->credit_date }}</div>
                    </div>
                </div>

                <div class="mt-4 d-grid gap-2">
                    <a href="{{ route('taxes.edit', $debtor->id) }}" class="btn btn-warning fw-bold">تعديل الوضعية / تسديد</a>
                    <a> {{ $debtor->phone}}  &nbsp;&nbsp;&nbsp;&nbsp; :اتصال بالمعني</a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="opacity-25 mb-3"><i class="fas fa-check-double fa-5x text-success"></i></div>
            <h3 class="text-muted">ممتاز! لا يوجد أي ديون متأخرة حالياً.</h3>
        </div>
        @endforelse
    </div>

    <div class="mt-5">
        {{ $debtors->links() }}
    </div>
</div>
@endsection