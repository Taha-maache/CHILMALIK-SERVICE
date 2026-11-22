@extends('layouts.app')

@section('content')

<style>
    .lp-banner {
        background: var(--dt-late-soft, #fdeceb);
        border: 1px solid #f5c6c2; border-radius: 14px; overflow: hidden;
        margin-bottom: 1rem; font-family: 'IBM Plex Sans Arabic', system-ui, sans-serif;
    }
    .lp-head {
        display: flex; align-items: center; gap: .75rem; padding: .85rem 1.25rem;
        color: var(--dt-late, #b42318);
    }
    .lp-head strong { font-weight: 600; }
    .lp-head .dt-btn { margin-inline-start: auto; }
    .lp-list { background: #fff; padding: 0 1.25rem; border-top: 1px solid #f5c6c2; }
    .lp-row {
        display: flex; flex-wrap: wrap; align-items: center; gap: .5rem 1.5rem;
        padding: .75rem 0; border-bottom: 1px solid var(--dt-line, #e3e8ee);
    }
    .lp-row:last-child { border-bottom: 0; }
    .lp-name { font-weight: 600; }
    .lp-nin { color: var(--dt-muted, #697586); font-size: .88rem; }
    .lp-date { margin-inline-start: auto; color: var(--dt-late, #b42318); font-size: .88rem; font-weight: 500; }
    /* Badge rouge تاع CASNOS */
.casnos-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 23px;
    height: 23px;
    padding: 0 7px;
    margin-inline-start: 6px;
    border-radius: 50px;
    background: #dc2626 !important;
    color: #fff !important;
    font-size: 12px;
    font-weight: 800;
    line-height: 1;
    box-shadow: 0 2px 6px rgba(220, 38, 38, .25);
}
</style>

@php
    $lateList = isset($late_payers) ? $late_payers : collect();

    // نحافظ على الـ Pagination ونعدّل البيانات داخلها
    $displayData = $trader_taxes->getCollection()->map(function ($tax) {
        return [
            'id' => $tax->id,
            'full_name' => ($tax->trader->first_name ?? '') . ' ' . ($tax->trader->last_name ?? ''),
            'NIN' => $tax->trader->NIN ?? '',
            'tax_year' => $tax->tax_year,
            'tax_value' => $tax->tax_value . '%',
            'pay_type' => $tax->pay_type == 'credit' ? 'دين' : 'كامل',
        ];
    });
    $trader_taxes->setCollection($displayData);
@endphp

<div class="container-fluid">

    {{-- تنبيه المتأخرين --}}
    @if($lateList->count() > 0)
        <div class="lp-banner">
            <div class="lp-head">
                <i class="fas fa-exclamation-circle"></i>
                <span><strong>{{ $lateList->count() }}</strong> تاجر لم يسدّد في الوقت المحدد</span>
                <button class="dt-btn" type="button" data-bs-toggle="collapse" data-bs-target="#checkLate">
                    عرض القائمة
                </button>
            </div>

            <div class="collapse" id="checkLate">
                <div class="lp-list">
                    @foreach($lateList as $lp)
                        <div class="lp-row">
                            <span class="lp-name">{{ $lp->trader->first_name ?? '' }} {{ $lp->trader->last_name ?? '' }}</span>
                            <span class="lp-nin">رقم التعريف الوطني: {{ $lp->trader->NIN ?? '-' }}</span>
                            <span class="lp-date">{{ $lp->credit_date }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- شريط التنقل --}}
    <div class="dt-nav">
        <a href="{{ route('traders.index') }}" class="dt-nav-btn">
            <i class="fas fa-arrow-right"></i> قائمة التجار
        </a>
        <a href="{{ route('trader_taxes.debtors') }}" class="dt-nav-btn">
            <i class="fas fa-hand-holding-usd"></i> قائمة الديون
        </a>
 <a href="{{ route('casnos-payments.index') }}" class="dt-nav-btn">
    <i class="fas fa-hand-holding-usd"></i>
    CASNOS

    @if(($casnosTotalCount) > 0)
     <span class="casnos-count-badge">
    {{ $casnosTotalCount }}
</span>
    @endif
</a>
   </div>

    {{-- الجدول (الترقيم داخل الـ component) --}}
    <x-table
        :data="$trader_taxes"
        :columns="[
            'full_name' => 'الاسم واللقب',
            'NIN' => 'رقم التعريف الوطني',
            'tax_year' => 'السنة',
            'tax_value' => 'النسبة',
            'pay_type' => 'الدفع',
        ]"
        :late-ids="$lateList->pluck('id')"
        title="الضرائب"
        tableName="trader_taxes"
    />

</div>
@endsection