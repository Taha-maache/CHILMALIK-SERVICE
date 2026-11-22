@extends('layouts.app')

@section('content')

<style>
    /* Notifications */
    .np-bell {
        display: inline-flex; align-items: center; gap: .6rem;
        padding: .55rem 1rem; border-radius: 10px; cursor: pointer;
        background: var(--dt-surface, #fff); color: var(--dt-ink, #1b2430);
        border: 1px solid var(--dt-line, #e3e8ee); font-weight: 500;
        transition: border-color .15s, color .15s;
    }
    .np-bell:hover { border-color: var(--dt-accent, #0f6b5c); color: var(--dt-accent, #0f6b5c); }
    .np-bell .np-pill {
        min-width: 1.4rem; padding: 0 .4rem; border-radius: 999px; text-align: center;
        background: var(--dt-late, #b42318); color: #fff; font-size: .78rem; line-height: 1.4rem;
    }

    .np-panel { font-family: 'IBM Plex Sans Arabic', system-ui, sans-serif; width: 380px !important; }
    .np-panel .offcanvas-header { border-bottom: 1px solid var(--dt-line, #e3e8ee); }
    .np-panel .offcanvas-title { font-weight: 600; font-size: 1.05rem; }

    .np-section { padding: 1rem 1.25rem .25rem; }
    .np-section h6 {
        display: flex; align-items: center; gap: .5rem; margin: 0 0 .5rem;
        font-size: .95rem; font-weight: 600;
    }
    .np-section h6 span {
        margin-inline-start: auto; font-size: .78rem; font-weight: 500;
        padding: .05rem .5rem; border-radius: 999px; background: var(--dt-ground, #f3f5f7); color: var(--dt-muted, #697586);
    }
    .np-item { padding: .75rem 0; border-bottom: 1px solid var(--dt-line, #e3e8ee); }
    .np-item:last-child { border-bottom: 0; }
    .np-name { font-weight: 600; }
    .np-text { color: var(--dt-muted, #697586); font-size: .88rem; margin: .15rem 0 0; }
    .np-empty { color: var(--dt-muted, #697586); font-size: .88rem; padding: .5rem 0 1rem; }
    .np-actions { display: flex; gap: .5rem; margin-top: .6rem; }
    .np-actions .dt-btn { flex: 1; justify-content: center; }

    /* Warning modal */
    .np-modal .modal-content { border: 0; border-radius: 16px; font-family: 'IBM Plex Sans Arabic', system-ui, sans-serif; }
    .np-modal .np-icon {
        width: 56px; height: 56px; border-radius: 50%; margin: 0 auto 1rem;
        display: grid; place-items: center; font-size: 1.5rem;
        background: #fff4e0; color: #b25e09;
    }
    /* Badge rouge pour les taxes en retard */
.dt-nav .notification-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 23px;
    height: 23px;
    padding: 0 7px;
    margin-inline-start: 8px;
    border-radius: 50px;
    background-color: #dc2626 !important;
    color: #fff !important;
    font-size: 12px;
    font-weight: 800;
    line-height: 1;
    border: none;
    box-shadow: 0 2px 6px rgba(220, 38, 38, .3);
}
</style>

@php
    $traderController = app(\App\Http\Controllers\TraderController::class);
    $notifications = $traderController->getNotifications();
    $cnrcNotifications = $traderController->getCnrcNotifications();
    $deliveryNotifications = $traderController->getDeliveryNotifications();

    $count = $notifications->count() + $cnrcNotifications->count() + $deliveryNotifications->count();
@endphp

<div
    x-data="{
        selectedItem: null,
        handleRowSelected(event) {
            if (event.detail.tableName === 'traders') {
                this.selectedItem = event.detail.item;
            }
        }
    }"
    x-on:row-selected.window="handleRowSelected($event)"
    class="container mt-4"
>

    {{-- شريط التنقل --}}
    <div class="dt-nav">
        <button class="np-bell" type="button" data-bs-toggle="offcanvas" data-bs-target="#notifSidebar">
            <i class="fas fa-bell"></i>
            <span>الإشعارات</span>
            @if($count > 0)
                <span class="np-pill">{{ $count }}</span>
            @endif
        </button>
<a href="{{ route('trader_taxes.index') }}" class="dt-nav-btn">
    <i class="fas fa-hand-holding-usd"></i>
    قائمة الضرائب

    @if(($sidebarNotifications['trader_taxes'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['trader_taxes'] }}
        </span>
    @endif
</a>
   </div>

    {{-- لوحة الإشعارات --}}
    <div class="offcanvas offcanvas-end np-panel" tabindex="-1" id="notifSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">الإشعارات</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="offcanvas-body p-0">

            {{-- CASNOS --}}
            <div class="np-section">
                <h6>
                    <i class="fas fa-shield-alt text-warning"></i> مراجعة CASNOS
                    <span>{{ $notifications->count() }}</span>
                </h6>

                @forelse($notifications as $trader)
                    <div class="np-item">
                        <div class="np-name">{{ $trader->first_name }} {{ $trader->last_name }}</div>
                        <p class="np-text">مرّت 7 أيام على التسجيل ولم يُصرَّح به بعد.</p>
                        <div class="np-actions">
                            <a href="{{ route('traders.declare_casnos', $trader->id) }}" class="dt-btn primary">تم التصريح</a>
                            <button type="button" class="dt-btn danger" data-bs-toggle="modal" data-bs-target="#casnosWarningModal">
                                لم يتم
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="np-empty">كل التجار تم التصريح بهم.</p>
                @endforelse
            </div>

            {{-- CNRC --}}
            <div class="np-section">
                <h6>
                    <i class="fas fa-box text-primary"></i> Récupération CNRC
                    <span>{{ $cnrcNotifications->count() }}</span>
                </h6>

                @forelse($cnrcNotifications as $trader)
                    <div class="np-item">
                        <div class="np-name">{{ $trader->first_name }} {{ $trader->last_name }}</div>
                        <p class="np-text">Dossier transféré depuis plus de 4 jours. À récupérer au CNRC.</p>
                    </div>
                @empty
                    <p class="np-empty">Aucun dossier à récupérer.</p>
                @endforelse
            </div>

            {{-- Livraison --}}
            <div class="np-section">
                <h6>
                    <i class="fas fa-truck text-success"></i> Livraison
                    <span>{{ $deliveryNotifications->count() }}</span>
                </h6>

                @forelse($deliveryNotifications as $trader)
                    <div class="np-item">
                        <div class="np-name">{{ $trader->first_name }} {{ $trader->last_name }}</div>
                        <p class="np-text">Dossier récupéré depuis plus de 2 jours. À livrer au client.</p>
                    </div>
                @empty
                    <p class="np-empty">Aucun dossier à livrer.</p>
                @endforelse
            </div>

        </div>
    </div>

    {{-- جدول التجار --}}
    <x-table
        :data="$traders"
        :columns="[
            'first_name' => 'الاسم',
            'last_name' => 'اللقب',
            'phone' => 'الهاتف',
            'status' => 'الحالة'
        ]"
        title="التجار"
        tableName="traders"
        :isMaster="true"
    />

    {{-- نافذة تنبيه CASNOS --}}
    <div class="modal fade np-modal" id="casnosWarningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <div class="np-icon"><i class="fas fa-exclamation"></i></div>
                    <h5 class="fw-semibold mb-2">لم يتم التصريح بعد</h5>
                    <p class="text-muted mb-4">
                        توجّه إلى مصالح CASNOS للتصريح بالتاجر في أقرب وقت لتجنّب الغرامات.
                    </p>
                    <button type="button" class="dt-btn primary px-4" data-bs-dismiss="modal">فهمت</button>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection