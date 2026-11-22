@extends('layouts.app')

@section('content')

<style>
    :root {
        --tmo-primary: #6C7DF7;
        --tmo-primary-dark: #5567e0;
        --tmo-bg: #F6F7FB;
        --tmo-card: #FFFFFF;
        --tmo-border: #ECEDF5;
        --tmo-text: #2E3140;
        --tmo-muted: #8A8FA3;
        --tmo-radius: 16px;
        --tmo-shadow: 0 4px 18px rgba(60, 66, 130, 0.06);
    }

    .tmo-wrap {
        background: var(--tmo-bg);
        border-radius: var(--tmo-radius);
        padding: 28px;
    }

    /* NOTIFICATIONS BUTTON */
    .tmo-notif-btn {
        background: var(--tmo-card);
        border: 1px solid var(--tmo-border);
        color: var(--tmo-text);
        font-weight: 700;
        padding: 12px 20px;
        border-radius: 12px;
        box-shadow: var(--tmo-shadow);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: all .2s ease;
        margin-bottom: 24px;
    }

    .tmo-notif-btn:hover {
        background: #FAFAFF;
        border-color: var(--tmo-primary);
        color: var(--tmo-text);
    }

    .tmo-notif-badge {
        background: #E5484D;
        color: #fff;
        font-size: 0.72rem;
        font-weight: 800;
        padding: 3px 8px;
        border-radius: 999px;
        min-width: 22px;
        text-align: center;
    }

    /* OFFCANVAS */
    .offcanvas {
        border: none;
    }

    .tmo-offcanvas-header {
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        padding: 22px 24px;
        border-bottom: 1px solid var(--tmo-border);
    }

    .tmo-offcanvas-header h5 {
        margin: 0;
        font-weight: 800;
        color: var(--tmo-text);
    }

    .tmo-offcanvas-body {
        background: var(--tmo-bg);
        padding: 22px;
    }

    .tmo-notif-section-title {
        font-weight: 800;
        font-size: 0.9rem;
        margin-bottom: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tmo-notif-title-cnrc { color: #4C7EF3; }
    .tmo-notif-title-delivery { color: #1E8A54; }
    .tmo-notif-title-expired { color: #C6303E; }

    .tmo-notif-card {
        background: var(--tmo-card);
        border: 1px solid var(--tmo-border);
        border-radius: 14px;
        padding: 14px 16px;
        margin-bottom: 12px;
        font-size: 0.88rem;
        color: var(--tmo-text);
        line-height: 1.7;
    }

    .tmo-notif-card.tmo-notif-urgent {
        background: #FDEBEC;
        border-color: #F7C9CC;
        color: #A5232F;
    }

    .tmo-notif-card strong {
        display: block;
        margin-bottom: 4px;
        color: var(--tmo-text);
    }

    .tmo-notif-card.tmo-notif-urgent strong {
        color: #A5232F;
    }

    .tmo-notif-empty {
        color: var(--tmo-muted);
        font-size: 0.86rem;
        margin-bottom: 20px;
    }

    /* HEADER CARD */
    .tmo-card-main {
        background: var(--tmo-card);
        border: 1px solid var(--tmo-border);
        border-radius: var(--tmo-radius);
        box-shadow: var(--tmo-shadow);
        overflow: hidden;
    }

    .tmo-card-header {
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        padding: 22px 28px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
    }

    .tmo-card-header h3 {
        margin: 0;
        font-weight: 800;
        color: var(--tmo-text);
        font-size: 1.3rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .tmo-btn-add {
        background: var(--tmo-primary);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 11px 20px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(108, 125, 247, 0.35);
        transition: all .2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .tmo-btn-add:hover {
        background: var(--tmo-primary-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .tmo-card-body {
        padding: 28px;
    }

    .tmo-search {
        background: var(--tmo-bg);
        border: 1px solid var(--tmo-border);
        border-radius: 14px;
        padding: 4px 8px;
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }

    .tmo-search .tmo-search-icon {
        padding: 0 12px;
        color: var(--tmo-muted);
        font-size: 1.1rem;
    }

    .tmo-search input {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
        padding: 14px 6px;
        font-size: 0.98rem;
        color: var(--tmo-text);
    }

    /* TABLE */
    .tmo-table-wrap {
        border: 1px solid var(--tmo-border);
        border-radius: 14px;
        overflow: hidden;
    }

    .tmo-table {
        margin-bottom: 0;
    }

    .tmo-table thead th {
        background: #FAFAFD;
        color: var(--tmo-muted);
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none;
        padding: 14px 16px;
        border-bottom: 1px solid var(--tmo-border);
        text-align: center;
    }

    .tmo-table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        border-bottom: 1px solid var(--tmo-border);
        color: var(--tmo-text);
        font-size: 0.9rem;
        text-align: center;
    }

    .tmo-table tbody tr:last-child td {
        border-bottom: none;
    }

    .tmo-table tbody tr {
        transition: background .15s ease;
    }

    .tmo-table tbody tr:hover {
        background: #FAFAFF;
    }

    .tmo-table tbody tr.tmo-resale-expired {
        background: #FEF3F3;
    }

    .tmo-table tbody tr.tmo-resale-expired:hover {
        background: #FDEAEA;
    }

    .tmo-table tbody tr.tmo-resale-expired td {
        color: #C6303E;
    }

    .tmo-resale-flag::before {
        content: "🔴 ";
    }

    .tmo-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.76rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .tmo-badge-new { background: #F1F2F6; color: #767A8C; }
    .tmo-badge-cnrc { background: #E9EBFE; color: #4C5CD6; }
    .tmo-badge-recovered { background: #E6F5FC; color: #157DA6; }
    .tmo-badge-delivered { background: #E4F8ED; color: #1E8A54; }

    .tmo-actions {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .tmo-btn-icon {
        border: none;
        border-radius: 10px;
        padding: 7px 12px;
        font-weight: 700;
        font-size: 0.76rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all .15s ease;
        white-space: nowrap;
    }

    .tmo-btn-doc {
        background: #EEF0F5;
        color: #43485A;
    }

    .tmo-btn-doc:hover {
        background: #E3E5EE;
        color: #2E3140;
    }

    .tmo-btn-doc-blue {
        background: #E9EBFE;
        color: #4C5CD6;
    }

    .tmo-btn-doc-blue:hover {
        background: #DCDFFC;
        color: #3B4BC7;
    }

    .tmo-btn-g08 {
        background: #FDEBEC;
        color: #C6303E;
    }

    .tmo-btn-g08:hover {
        background: #FADADC;
        color: #A5232F;
    }

    .tmo-btn-edit {
        background: #FFF4E0;
        color: #B4790E;
    }

    .tmo-btn-edit:hover {
        background: #FCE7C2;
        color: #8C5C09;
    }

    .tmo-btn-delete {
        background: #F1F2F6;
        color: #43485A;
    }

    .tmo-btn-delete:hover {
        background: #E5E6EE;
        color: #2E3140;
    }

    .tmo-btn-status {
        border: none;
        border-radius: 10px;
        padding: 7px 12px;
        font-weight: 700;
        font-size: 0.76rem;
        white-space: nowrap;
    }

    .tmo-btn-status-cnrc {
        background: #E9EBFE;
        color: #4C5CD6;
    }

    .tmo-btn-status-cnrc:hover {
        background: #DCDFFC;
    }

    .tmo-btn-status-recover {
        background: #E6F5FC;
        color: #157DA6;
    }

    .tmo-btn-status-recover:hover {
        background: #D6EEFA;
    }

    .tmo-btn-status-deliver {
        background: #E4F8ED;
        color: #1E8A54;
    }

    .tmo-btn-status-deliver:hover {
        background: #D3F3E1;
    }
</style>

<div class="container py-4">

    @php
        $cnrcNotifications = app(\App\Http\Controllers\TmoralController::class)->getCnrcNotifications();

        $deliveryNotifications = app(\App\Http\Controllers\TmoralController::class)->getDeliveryNotifications();

        $importResaleNotifications = app(\App\Http\Controllers\TmoralController::class)->getImportResaleNotifications();

        $count = $cnrcNotifications->count()
               + $deliveryNotifications->count()
               + $importResaleNotifications->count();
    @endphp

    <div class="tmo-wrap">

        {{-- NOTIFICATIONS BUTTON --}}
        <button class="tmo-notif-btn"
                data-bs-toggle="offcanvas"
                data-bs-target="#notifSidebar">

            <i class="fas fa-bell"></i>
            Notifications

            @if($count)
                <span class="tmo-notif-badge">{{ $count }}</span>
            @endif

        </button>

        {{-- OFFCANVAS --}}
        <div class="offcanvas offcanvas-end" tabindex="-1" id="notifSidebar">

            <div class="tmo-offcanvas-header d-flex justify-content-between align-items-center">
                <h5>Notifications</h5>
                <button class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>

            <div class="offcanvas-body tmo-offcanvas-body">

                <div class="tmo-notif-section-title tmo-notif-title-cnrc">
                    📦 Récupération CNRC
                </div>

                @forelse($cnrcNotifications as $tmoral)

                    <div class="tmo-notif-card">
                        <strong>{{ $tmoral->first_name }} {{ $tmoral->last_name }}</strong>
                        Le dossier est transféré depuis plus de <b>4 jours</b>.
                        <br>
                        Veuillez le récupérer.
                    </div>

                @empty

                    <p class="tmo-notif-empty">Aucun dossier à récupérer.</p>

                @endforelse

                <div class="tmo-notif-section-title tmo-notif-title-delivery mt-4">
                    🚚 Livraison
                </div>

                @forelse($deliveryNotifications as $tmoral)

                    <div class="tmo-notif-card">
                        <strong>{{ $tmoral->first_name }} {{ $tmoral->last_name }}</strong>
                        Le dossier est récupéré depuis plus de <b>2 jours</b>.
                        <br>
                        Veuillez le livrer au client.
                    </div>

                @empty

                    <p class="tmo-notif-empty">Aucun dossier à livrer.</p>

                @endforelse

                <div class="tmo-notif-section-title tmo-notif-title-expired mt-4">
                    🔄 Renouvellement Import pour revente
                </div>

                @forelse($importResaleNotifications as $tmoral)

                    <div class="tmo-notif-card tmo-notif-urgent">
                        <strong>{{ $tmoral->first_name }} {{ $tmoral->last_name }}</strong>
                        Le registre pour importation pour revente est arrivé à expiration.
                        <br>
                        Date d'inscription :
                        <b>{{ \Carbon\Carbon::parse($tmoral->Date_of_this_register)->format('d/m/Y') }}</b>
                        <br>
                        <span class="fw-bold">⚠️ Veuillez renouveler le registre.</span>
                    </div>

                @empty

                    <p class="tmo-notif-empty">Aucun renouvellement nécessaire.</p>

                @endforelse

            </div>
        </div>

        {{-- MAIN CARD --}}
        <div class="tmo-card-main">

            <div class="tmo-card-header">
                <h3>📋 قائمة الأشخاص المعنويين</h3>

                <a href="{{ route('tmorals.create') }}" class="tmo-btn-add">
                    <span>+</span> إضافة جديد
                </a>
            </div>

            <div class="tmo-card-body">

                <div class="tmo-search">
                    <span class="tmo-search-icon">🔍</span>
                    <input
                        type="text"
                        id="searchInput"
                        class="form-control"
                        placeholder="ابحث بالاسم أو اللقب أو الهاتف..."
                    >
                </div>

                <div class="tmo-table-wrap">
                    <div class="table-responsive">

                        <table class="table tmo-table align-middle mb-0">

                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>اللقب</th>
                                    <th>الحالة</th>
                                    <th>الهاتف</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>

                            <tbody id="myTable">

                            @foreach($tmorals as $tmoral)

                                @php
                                    $importResaleExpired = false;

                                    if (
                                        $tmoral->Import_for_resale_asis == 1 &&
                                        $tmoral->Date_of_this_register
                                    ) {
                                        $importResaleExpired = \Carbon\Carbon::parse(
                                            $tmoral->Date_of_this_register
                                        )->addMonths(23)->isPast();
                                    }
                                @endphp

                                <tr class="{{ $importResaleExpired ? 'tmo-resale-expired' : '' }}">

                                    <td class="{{ $importResaleExpired ? 'tmo-resale-flag' : '' }}">
                                        {{ $tmoral->first_name }}
                                    </td>

                                    <td>{{ $tmoral->last_name }}</td>

                                    <td>

                                        @if($tmoral->status == 'nouveau')

                                            <span class="tmo-badge tmo-badge-new">Nouveau</span>

                                        @elseif($tmoral->status == 'transfere_cnrc')

                                            <span class="tmo-badge tmo-badge-cnrc">Transféré au CNRC</span>

                                        @elseif($tmoral->status == 'recupere_cnrc')

                                            <span class="tmo-badge tmo-badge-recovered">Récupéré du CNRC</span>

                                        @elseif($tmoral->status == 'livre_client')

                                            <span class="tmo-badge tmo-badge-delivered">Livré au client</span>

                                        @endif

                                    </td>

                                    <td>{{ $tmoral->phone }}</td>

                                    <td>

                                        <div class="tmo-actions">

                                            {{-- السجل التجاري Noir --}}
                                            <a href="{{ route('tmorals.pdf', ['tmoral' => $tmoral->id, 'color' => 'black']) }}"
                                               class="tmo-btn-icon tmo-btn-doc"
                                               target="_blank">
                                                السجل التجاري
                                            </a>

                                            {{-- السجل التجاري Bleu --}}
                                            <a href="{{ route('tmorals.pdf', ['tmoral' => $tmoral->id, 'color' => 'blue']) }}"
                                               class="tmo-btn-icon tmo-btn-doc-blue"
                                               target="_blank">
                                                السجل التجاري
                                            </a>

                                            <a href="{{ route('tmorals.pdfg08', $tmoral->id) }}"
                                               class="tmo-btn-icon tmo-btn-g08"
                                               target="_blank">
                                                G08
                                            </a>

                                            <a href="{{ route('tmorals.edit', $tmoral->id) }}"
                                               class="tmo-btn-icon tmo-btn-edit">
                                                Edit
                                            </a>

                                            <form action="{{ route('tmorals.destroy', $tmoral->id) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    onclick="return confirm('تأكيد الحذف ؟')"
                                                    class="tmo-btn-icon tmo-btn-delete">
                                                    Delete
                                                </button>

                                            </form>

                                            @if($tmoral->status != 'livre_client')

                                                <form action="{{ route('tmorals.changeStatus', $tmoral->id) }}"
                                                      method="POST"
                                                      class="d-inline"
                                                      onsubmit="return confirm('Êtes-vous sûr de vouloir changer le statut ?')">

                                                    @csrf
                                                    @method('PATCH')

                                                    @if($tmoral->status == 'nouveau')

                                                        <button class="tmo-btn-status tmo-btn-status-cnrc">
                                                            Transférer au CNRC
                                                        </button>

                                                    @elseif($tmoral->status == 'transfere_cnrc')

                                                        <button class="tmo-btn-status tmo-btn-status-recover">
                                                            Récupérer du CNRC
                                                        </button>

                                                    @elseif($tmoral->status == 'recupere_cnrc')

                                                        <button class="tmo-btn-status tmo-btn-status-deliver">
                                                            Livrer au client
                                                        </button>

                                                    @endif

                                                </form>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>

                        </table>

                    </div>
                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.getElementById('searchInput').addEventListener('keyup', function () {

    let value = this.value.toLowerCase().trim();

    let rows = document.querySelectorAll('#myTable tr');

    rows.forEach(function(row){

        let cols = row.querySelectorAll('td');

        let fullname1 = '';
        let fullname2 = '';

        if(cols.length >= 2){

            let first = cols[0].innerText.toLowerCase().trim();
            let last  = cols[1].innerText.toLowerCase().trim();

            fullname1 = first + ' ' + last;
            fullname2 = last + ' ' + first;
        }

        row.style.display =
            row.innerText.toLowerCase().includes(value)
            || fullname1.includes(value)
            || fullname2.includes(value)
            ? ''
            : 'none';

    });

});

</script>

@endsection