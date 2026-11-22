@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
    --ink:#0f172a;
    --body-c:#475569;
    --muted:#94a3b8;
    --line:#e6e9f0;
    --bg:#f4f6fb;
    --surface:#ffffff;

    --navy:#0b1324;
    --navy-soft:#141f38;
    --navy-line:rgba(255,255,255,.08);

    --accent:#0f766e;
    --accent-dark:#0b5c56;
    --accent-soft:#effaf8;

    --radius-lg:16px;
    --radius-md:12px;
    --radius-sm:8px;
    --shadow-sm:0 1px 2px rgba(15,23,42,.04);
    --shadow-md:0 4px 16px rgba(15,23,42,.06);
    --shadow-lg:0 12px 32px rgba(15,23,42,.10);
}

body{
    background:var(--bg);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    color:var(--body-c);
}

.page-wrap{
    width:100%;
    max-width:1900px;
    margin:24px auto;
    padding:0 24px 60px;
}

.layout{
    display:grid;
    grid-template-columns:272px 1fr;
    gap:24px;
    align-items:start;
}

/* ===== SIDEBAR ===== */
.sidebar-card{
    background:var(--navy);
    border-radius:var(--radius-lg);
    overflow:hidden;
    position:sticky;
    top:24px;
    box-shadow:var(--shadow-lg);
}

.sidebar-head{
    display:flex;
    align-items:center;
    gap:10px;
    color:#fff;
    padding:22px 20px 18px;
    font-weight:700;
    font-size:15px;
    letter-spacing:.2px;
    border-bottom:1px solid var(--navy-line);
}

.sidebar-head .icon-chip{
    width:34px;
    height:34px;
    border-radius:10px;
    background:linear-gradient(135deg,var(--accent),#14b8a6);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:14px;
    flex-shrink:0;
}

.sidebar-body{
    padding:14px 12px 18px;
}

.sidebar-group{
    margin-bottom:6px;
}

.sidebar-group-last{
    margin-top:10px;
    padding-top:12px;
    border-top:1px solid var(--navy-line);
}

.sidebar-group-title{
    padding:14px 12px 8px;
    font-size:11px;
    font-weight:700;
    color:#64748b;
    text-transform:uppercase;
    letter-spacing:.6px;
}

.sidebar-card .nav-link{
    display:flex;
    align-items:center;
    gap:11px;
    padding:10px 12px;
    border-radius:var(--radius-sm);
    font-size:13.5px;
    font-weight:500;
    color:#cbd5e1;
    text-decoration:none;
    transition:.15s ease;
    margin-bottom:2px;
}

.sidebar-card .nav-link i{
    width:16px;
    text-align:center;
    color:#64748b;
    font-size:13px;
    transition:.15s ease;
}

.sidebar-card .nav-link:hover{
    background:var(--navy-soft);
    color:#fff;
}

.sidebar-card .nav-link:hover i{
    color:var(--accent);
}

/* ===== MAIN CONTENT ===== */
.content-col{
    min-width:0;
}

.header-bar{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    flex-wrap:wrap;
    gap:14px;
    margin-bottom:24px;
}

.header-bar h4{
    margin:0 0 4px;
    font-weight:800;
    font-size:22px;
    color:var(--ink);
    letter-spacing:-.3px;
}

.header-sub{
    font-size:13.5px;
    color:var(--muted);
    margin:0;
}

.header-actions{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn-add{
    background:var(--accent);
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-size:13.5px;
    font-weight:600;
    transition:.15s ease;
    display:inline-flex;
    align-items:center;
    gap:8px;
    box-shadow:0 2px 8px rgba(15,118,110,.25);
    border:1px solid transparent;
}

.btn-add:hover{
    background:var(--accent-dark);
    color:#fff;
    transform:translateY(-1px);
    box-shadow:0 4px 12px rgba(15,118,110,.3);
}

.btn-add.secondary{
    background:#fff;
    color:var(--ink);
    border:1px solid var(--line);
    box-shadow:var(--shadow-sm);
}

.btn-add.secondary:hover{
    background:var(--bg);
    color:var(--ink);
    border-color:#cbd5e1;
}

.btn-add.secondarye{
    background:#fff;
    color:#334155;
    border:1px solid var(--line);
    box-shadow:var(--shadow-sm);
}

.btn-add.secondarye:hover{
    background:var(--bg);
    color:var(--ink);
    border-color:#cbd5e1;
}

/* ===== STATS ROW ===== */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(6,1fr);
    gap:16px;
    margin-bottom:24px;
}

.stat-card{
    background:var(--surface);
    border:1px solid var(--line);
    border-top:3px solid transparent;
    border-radius:var(--radius-md);
    padding:18px 18px 16px;
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    box-shadow:var(--shadow-sm);
    transition:.18s ease;
    position:relative;
}

.stat-card:hover{
    box-shadow:var(--shadow-md);
    transform:translateY(-3px);
}

.stat-text{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.stat-icon{
    width:42px;
    height:42px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
    flex-shrink:0;
    order:2;
}

.stat-card h6{
    font-size:11.5px;
    font-weight:700;
    color:var(--muted);
    margin:0;
    letter-spacing:.4px;
    text-transform:uppercase;
}

.stat-card h2{
    font-size:26px;
    font-weight:800;
    margin:0;
    color:var(--ink);
    letter-spacing:-.5px;
    line-height:1;
}

.stat-primary{ border-top-color:#2563eb; }
.stat-success{ border-top-color:#16a34a; }
.stat-info{ border-top-color:#0891b2; }
.stat-warning{ border-top-color:#d97706; }
.stat-dark{ border-top-color:#0f172a; }
.stat-purple{ border-top-color:#7c3aed; }

.stat-primary .stat-icon{ background:#eff6ff; color:#2563eb; }
.stat-success .stat-icon{ background:#ecfdf5; color:#16a34a; }
.stat-info .stat-icon{ background:#ecfeff; color:#0891b2; }
.stat-warning .stat-icon{ background:#fffbeb; color:#d97706; }
.stat-dark .stat-icon{ background:#f1f5f9; color:#0f172a; }
.stat-purple .stat-icon{ background:#f5f3ff; color:#7c3aed; }

@media (max-width:1400px){
    .stats-grid{ grid-template-columns:repeat(3,1fr); }
}

@media (max-width:640px){
    .stats-grid{ grid-template-columns:repeat(2,1fr); }
}

/* ===== CHARTS ===== */
.charts-row{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
    margin-bottom:24px;
}

.chart-card{
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:var(--radius-md);
    padding:20px;
    box-shadow:var(--shadow-sm);
}

.chart-card h5{
    font-size:14.5px;
    font-weight:700;
    color:var(--ink);
    margin-bottom:16px;
    display:flex;
    align-items:center;
    gap:8px;
}

@media (max-width:900px){
    .charts-row{ grid-template-columns:1fr; }
}

/* ===== SEARCH ===== */
.search-wrap{
    position:relative;
    margin-bottom:18px;
}

.search-wrap i{
    position:absolute;
    left:16px;
    top:50%;
    transform:translateY(-50%);
    color:var(--muted);
    font-size:13px;
}

#liveSearch{
    border-radius:11px;
    border:1px solid var(--line);
    padding:12px 16px 12px 40px;
    width:100%;
    background:var(--surface);
    font-size:13.5px;
    box-shadow:var(--shadow-sm);
    transition:.15s ease;
}

#liveSearch:focus{
    outline:none;
    border-color:var(--accent);
    box-shadow:0 0 0 3px rgba(15,118,110,.12);
}

/* ===== TABLE CARD ===== */
.card-box{
    background:var(--surface);
    border:1px solid var(--line);
    border-radius:var(--radius-lg);
    padding:22px;
    box-shadow:var(--shadow-sm);
}

table{
    width:100%;
    border-collapse:separate;
    border-spacing:0;
}

thead th{
    background:var(--bg);
    color:#64748b;
    font-size:11.5px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.4px;
    border-bottom:1px solid var(--line);
}

th, td{
    padding:14px 12px;
    text-align:center;
    vertical-align:middle;
}

thead th:first-child{ border-top-left-radius:10px; text-align:left; padding-left:16px; }
thead th:last-child{ border-top-right-radius:10px; }

tbody tr{
    border-bottom:1px solid var(--line);
    transition:.12s ease;
}

tbody tr:last-child{
    border-bottom:none;
}

tbody tr:hover{
    background:var(--bg);
}

.name-cell{
    display:flex;
    align-items:center;
    gap:10px;
    text-align:left;
    padding-left:16px !important;
}

.avatar-chip{
    width:32px;
    height:32px;
    border-radius:9px;
    background:var(--accent-soft);
    color:var(--accent-dark);
    font-weight:700;
    font-size:12.5px;
    display:flex;
    align-items:center;
    justify-content:center;
    flex-shrink:0;
}

.name-text{
    font-weight:600;
    color:var(--ink);
    font-size:13.5px;
}

.phone-text{
    font-size:13px;
    color:var(--body-c);
    font-variant-numeric:tabular-nums;
}

.price-text{
    font-weight:700;
    color:var(--ink);
    font-size:13.5px;
}

.badge{
    font-size:11.5px;
    font-weight:600;
    padding:5px 10px;
    border-radius:20px;
}

.form-select-sm{
    border-radius:8px;
    font-size:12.5px;
    border:1px solid var(--line);
    padding:6px 10px;
}

.actions-cell{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;
    flex-wrap:wrap;
}

.btn-icon{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:6px 11px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    text-decoration:none;
    border:none;
    transition:.15s ease;
}

.btn-edit{ background:#fffbeb; color:#b45309; }
.btn-edit:hover{ background:#fef3c7; color:#92400e; }

.btn-pdf{ background:#eff6ff; color:#2563eb; }
.btn-pdf:hover{ background:#dbeafe; color:#1d4ed8; }

.btn-pay{ background:#ecfdf5; color:#16a34a; }
.btn-pay:hover{ background:#d1fae5; color:#15803d; }

.btn-del{ background:#fef2f2; color:#dc2626; cursor:pointer; }
.btn-del:hover{ background:#fee2e2; color:#b91c1c; }

.form-control{
    border-radius:10px;
}

.mt-3 :is(.pagination){
    margin-top:6px;
}

/* ===== SIDEBAR COLLAPSES BELOW CONTENT ON SMALL SCREENS ===== */
@media (max-width:992px){
    .layout{
        grid-template-columns:1fr;
    }
    .sidebar-card{
        position:static;
    }
}
/* Notification badges dans le menu */
.sidebar-card .notification-badge {
    margin-left: auto;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 50px;
    background: #ef4444;
    color: #fff;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 800;
    line-height: 1;
    box-shadow: 0 2px 6px rgba(239, 68, 68, .25);
}
</style>

<div class="page-wrap">
<div class="layout">

    <!-- Sidebar -->
    <div class="sidebar-card">

        <div class="sidebar-head">
            <span class="icon-chip"><i class="fa fa-layer-group"></i></span>
            Services
        </div>

        <div class="sidebar-body">

            <div class="sidebar-group">
                <div class="sidebar-group-title">Personne Physique</div>

 <a href="{{ route('traders.index') }}" class="nav-link">
    <i class="fa fa-store"></i>
    <span>Registre de Commerce</span>
@php
    $cnrcTotal = ($sidebarNotifications['traders_casnos'] ?? 0)
               + ($sidebarNotifications['cnrc'] ?? 0)
               + ($sidebarNotifications['delivery'] ?? 0);
@endphp

@if($cnrcTotal > 0)
    <span class="notification-badge">{{ $cnrcTotal }}</span>
@endif
</a>
   <a href="{{ route('casnos.index') }}" class="nav-link">
    <i class="fa fa-id-card"></i>
    <span>CASNOS</span>

    @if(($sidebarNotifications['casnos'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['casnos'] }}
        </span>
    @endif
</a>
<a href="{{ route('taxes.index') }}" class="nav-link">
    <i class="fa fa-file-invoice-dollar"></i>
    <span>Taxes</span>

    @if(($sidebarNotifications['taxes'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['taxes'] }}
        </span>
    @endif
</a>
                <a href="{{ route('artisans.index') }}" class="nav-link">
                    <i class="fa fa-file-invoice-dollar"></i> Carte d'artisan
                </a>
                
                <a href="{{ route('efficacites.index') }}" class="nav-link">
                    <i class="fa fa-file-invoice-dollar"></i> capacité
                </a>


                <a href="{{ route('jibayatics.index') }}" class="nav-link">
                    <i class="fa fa-file-invoice"></i> Jibayatic
                </a>

                <a href="{{ route('damancoms.index') }}" class="nav-link">
                    <i class="fa fa-hand-holding-dollar"></i> Damancom
                </a>

                <a href="{{ route('cnases.index') }}" class="nav-link">
                    <i class="fa fa-shield-halved"></i> CNAS
                </a>
            </div>

            <div class="sidebar-group">
                <div class="sidebar-group-title">Personne Morale</div>

    <a href="{{ route('tmorals.index') }}" class="nav-link">
    <i class="fa fa-building"></i>
    <span>Registre de Commerce</span>

    @if(($sidebarNotifications['tmorals'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['tmorals'] }}
        </span>
    @endif
</a>

                <a href="{{ route('beneficiaries.index') }}" class="nav-link">
                    <i class="fa fa-users"></i> Bénéficiaires
                </a>
                
    <a href="{{ route('respectes.index') }}" class="nav-link">
    <i class="fa fa-users"></i>
    <span>Respectes</span>

    @if(($sidebarNotifications['respectes'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['respectes'] }}
        </span>
    @endif
</a>
                <a href="{{ route('jibayatic-moral.index') }}" class="nav-link">
                    <i class="fa fa-file-invoice"></i> Jibayatic
                </a>

                <a href="{{ route('damancom-moral.index') }}" class="nav-link">
                    <i class="fa fa-hand-holding-dollar"></i> Damancom
                </a>

                <a href="{{ route('cnas-morals.index') }}" class="nav-link">
                    <i class="fa fa-shield-halved"></i> CNAS
                </a>
            </div>

            <div class="sidebar-group">
                <div class="sidebar-group-title">Autres Services</div>

    <a href="{{ route('clients.index') }}" class="nav-link">
    <i class="fas fa-id-card-alt"></i>
    <span>INAPI</span>

    @if(($sidebarNotifications['clients'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['clients'] }}
        </span>
    @endif
</a>
                <a href="{{ route('transporters.index') }}" class="nav-link">
                    <i class="fa fa-truck"></i> Direction des Transports
                </a>
                                <a href="{{ route('names.index') }}" class="nav-link">
                    <i class="fa fa-signature"></i> Naming
                </a>

            </div>

            <div class="sidebar-group sidebar-group-last">
                <div class="sidebar-group-title">Services</div>

                <a href="{{ route('services.index') }}" class="nav-link">
                    <i class="fa fa-gears"></i> Services
                </a>

               <a href="{{ route('subscriptions.index') }}" class="nav-link">
    <i class="fas fa-calendar-times"></i>
    <span>Subscriptions</span>

    @if(($sidebarNotifications['subscriptions'] ?? 0) > 0)
        <span class="notification-badge">
            {{ $sidebarNotifications['subscriptions'] }}
        </span>
    @endif
</a>
            </div>

        </div>

    </div>

    <!-- Contenu -->
    <div class="content-col">

        <div class="header-bar">

            <div>
                <h4>Gestion des Services</h4>
                <p class="header-sub">Vue d'ensemble de l'activité et des dossiers clients</p>
            </div>

            <div class="header-actions">
                <a href="{{ route('services.create') }}" class="btn-add">
                    <i class="fa fa-plus"></i> Ajouter Service
                </a>
                
                <a href="{{ route('credits.index') }}" class="btn-add secondary">
                    <i class="fa fa-wallet"></i> Crédits
                </a>
                <a href="{{ route('backups.index') }}" class="btn-add secondarye">
                    <i class="fa fa-database"></i> Sauvegarde
                </a>
                <a href="{{ route('services.statistics') }}" class="btn-add secondary">
                    <i class="fa fa-chart-line"></i> Statistiques Avancées
                </a>
                <a href="{{ route('service-prices.index') }}" class="btn-add secondary">
                    <i class="fa fa-tag"></i> Gestion des Prix
                </a>
            </div>

        </div>

        <!-- Stats row -->
        <div class="stats-grid">

            <div class="stat-card stat-primary">
                <div class="stat-text">
                    <h6>Total Services</h6>
                    <h2>{{ $totalServices }}</h2>
                </div>
                <div class="stat-icon"><i class="fa fa-briefcase"></i></div>
            </div>

            <div class="stat-card stat-success">
                <div class="stat-text">
                    <h6>Total Revenus</h6>
                    <h2>{{ number_format($totalRevenue,0,',',' ') }}</h2>
                </div>
                <div class="stat-icon"><i class="fa fa-sack-dollar"></i></div>
            </div>

            <div class="stat-card stat-info">
                <div class="stat-text">
                    <h6>Abonnés</h6>
                    <h2>{{ $totalSubscribers }}</h2>
                </div>
                <div class="stat-icon"><i class="fa fa-user-check"></i></div>
            </div>

            <div class="stat-card stat-warning">
                <div class="stat-text">
                    <h6>Non abonnés</h6>
                    <h2>{{ $totalNonSubscribers }}</h2>
                </div>
                <div class="stat-icon"><i class="fa fa-user-xmark"></i></div>
            </div>

            <div class="stat-card stat-dark">
                <div class="stat-text">
                    <h6>Services Aujourd'hui</h6>
                    <h2>{{ $todayServices }}</h2>
                </div>
                <div class="stat-icon"><i class="fa fa-calendar-day"></i></div>
            </div>

            <div class="stat-card stat-purple">
                <div class="stat-text">
                    <h6>Revenus Aujourd'hui</h6>
                    <h2>{{ number_format($todayRevenue,0,',',' ') }}</h2>
                </div>
                <div class="stat-icon"><i class="fa fa-coins"></i></div>
            </div>

        </div>

        <!-- Charts -->
        <div class="charts-row">

            <div class="chart-card">
                <h5><i class="fa fa-users" style="color:var(--accent)"></i> Clients par jour</h5>
                <canvas id="clientsChart" height="120"></canvas>
            </div>

            <div class="chart-card">
                <h5><i class="fa fa-money-bill-wave" style="color:var(--accent)"></i> Revenus par jour</h5>
                <canvas id="revenusChart" height="120"></canvas>
            </div>

        </div>

        <div class="search-wrap">
            <i class="fa fa-magnifying-glass"></i>
            <input
                type="text"
                id="liveSearch"
                class="form-control"
                placeholder="Recherche par nom ou téléphone">
        </div>

        <div class="card-box">

            <table class="table table-hover align-middle">

                <thead>
                <tr>
                    <th style="text-align:left;padding-left:16px;">Nom</th>
                    <th>Téléphone</th>
                    <th>Total</th>
                    <th>État Paiement</th>
                    <th>État Service</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody id="servicesTable">

                @foreach($services as $s)

                    <tr>

                        <td class="name-cell">
                            <span class="avatar-chip">{{ strtoupper(substr($s->full_name,0,1)) }}</span>
                            <span class="name-text">{{ $s->full_name }}</span>
                        </td>

                        <td class="phone-text">{{ $s->phone }}</td>

                        <td>
                            <span class="price-text">
                                {{ number_format($s->total_price,0,',',' ') }} DA
                            </span>
                        </td>
                        <td>

@if($s->credit)

    @if($s->credit->remaining_amount <= 0)

        <span class="badge bg-success">
            Payé
        </span>

    @elseif($s->credit->amount_paid > 0)

        <span class="badge bg-warning text-dark">
            Partiel
        </span>

    @else

        <span class="badge bg-danger">
            Non payé
        </span>

    @endif

@else

    <span class="badge bg-danger">
        Non payé
    </span>

@endif

</td>
<td>

<form action="{{ route('services.changeStatus',$s) }}"
      method="POST">

    @csrf
    @method('PATCH')

    <select
        name="service_status"
        class="form-select form-select-sm"
        onchange="this.form.submit()">

        <option value="pending"
            {{ $s->service_status=='pending' ? 'selected' : '' }}>
            En attente
        </option>

        <option value="progress"
            {{ $s->service_status=='progress' ? 'selected' : '' }}>
            En cours
        </option>

        <option value="finished"
            {{ $s->service_status=='finished' ? 'selected' : '' }}>
            Terminé
        </option>

    </select>

</form>

</td>
                        <td>

                            <div class="actions-cell">

                                <a href="{{ route('services.edit',$s->id) }}"
                                   class="btn-icon btn-edit">
                                    <i class="fa fa-pen"></i> Edit
                                </a>

                                <a href="{{ route('services.pdf',$s->id) }}"
                                   class="btn-icon btn-pdf">
                                    <i class="fa fa-file-pdf"></i> Facture
                                </a>

                                <a href="{{ route('credits.create',$s->id) }}"
                                   class="btn-icon btn-pay">
                                    <i class="fa fa-money-check-dollar"></i> Pay
                                </a>
                               @if($s->credit && $s->credit->remaining_amount > 0)

    @php
        $credit = $s->credit;

        // آخر payment
        $lastPayment = $credit->payments()
            ->orderByDesc('payment_date')
            ->first();

        $lastPaymentDate = $lastPayment
            ? \Carbon\Carbon::parse($lastPayment->payment_date)
            : null;

        // آخر WhatsApp reminder
        $lastReminderDate = $credit->last_whatsapp_reminder_at
            ? \Carbon\Carbon::parse($credit->last_whatsapp_reminder_at)
            : null;

        /*
         * نأخذ أحدث تاريخ بين:
         * - آخر Payment
         * - آخر WhatsApp reminder
         */
        $lastActionDate = collect([
            $lastPaymentDate,
            $lastReminderDate
        ])
        ->filter()
        ->sortDesc()
        ->first();

        // إذا ماكان حتى Payment ولا Reminder
        // نخلي الزر يظهر
        $canSendWhatsapp = !$lastActionDate ||
            $lastActionDate->lt(now()->subDays(3));
    @endphp

    @if($canSendWhatsapp)

        <a href="{{ route('whatsapp.send', ['id' => $credit->id]) }}"
           class="btn-icon btn-pay">
            <i class="fab fa-whatsapp"></i>
            WhatsApp
        </a>

    @endif

@endif
                                <form
                                    method="POST"
                                    action="{{ route('services.destroy',$s->id) }}"
                                    style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        class="btn-icon btn-del"
                                        onclick="openDeleteModal({{ $s->id }})">
                                        <i class="fa fa-trash"></i> Supprimer
                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

            <div class="mt-3">
                {{ $services->links() }}
            </div>

        </div>

    </div>

</div>
</div>

<script>
const input=document.getElementById("liveSearch");
const rows=document.querySelectorAll("#servicesTable tr");

input.addEventListener("input",function(){

    let value=this.value.toLowerCase();

    rows.forEach(row=>{

        let name=row.cells[0].textContent.toLowerCase();
        let phone=row.cells[1].textContent.toLowerCase();

        row.style.display=
            (name.includes(value)||phone.includes(value))
            ? ""
            : "none";

    });

});
</script>

<div id="deleteModal"
style="
display:none;
position:fixed;
top:0;
left:0;
width:100%;
height:100%;
background:rgba(15,23,42,.55);
justify-content:center;
align-items:center;
z-index:9999;
backdrop-filter:blur(2px);
">

<div style="
background:white;
padding:28px;
border-radius:16px;
width:340px;
text-align:center;
box-shadow:0 20px 50px rgba(0,0,0,.25);
font-family:'Inter',sans-serif;
">

<div style="
width:48px;height:48px;border-radius:12px;
background:#fef2f2;color:#dc2626;
display:flex;align-items:center;justify-content:center;
font-size:20px;margin:0 auto 14px;
">
<i class="fa fa-triangle-exclamation"></i>
</div>

<h4 style="font-weight:700;font-size:17px;color:#0f172a;margin-bottom:6px;">Confirmation</h4>

<p style="color:#64748b;font-size:13.5px;margin-bottom:0;">Voulez-vous vraiment supprimer ce service ?</p>

<form id="deleteForm" method="POST">

@csrf
@method('DELETE')

<div style="display:flex;justify-content:space-between;gap:10px;margin-top:22px;">

<button
type="button"
onclick="closeDeleteModal()"
class="btn btn-secondary"
style="flex:1;border-radius:10px;padding:10px;font-weight:600;font-size:13.5px;">

Annuler

</button>

<button
type="submit"
class="btn btn-danger"
style="flex:1;border-radius:10px;padding:10px;font-weight:600;font-size:13.5px;">

Supprimer

</button>

</div>

</form>

</div>

</div>

<script>

function openDeleteModal(id){

    document.getElementById("deleteModal").style.display="flex";

    document.getElementById("deleteForm").action="/services/"+id;

}

function closeDeleteModal(){

    document.getElementById("deleteModal").style.display="none";

}

</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($clientsChart->pluck('day'));

new Chart(document.getElementById('clientsChart'), {

    type: 'line',

    data: {
        labels: labels,
        datasets: [{
            label: 'Clients',
            data: @json($clientsChart->pluck('total')),
            borderColor: '#0f766e',
            backgroundColor: 'rgba(15,118,110,.08)',
            borderWidth: 3,
            fill: true,
            tension: .4,
            pointRadius: 3,
            pointBackgroundColor: '#0f766e'
        }]
    },

    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: { grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8' } },
            x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
        }
    }

});

new Chart(document.getElementById('revenusChart'), {

    type: 'bar',

    data: {
        labels: @json($revenusChart->pluck('day')),
        datasets: [{
            label: 'Revenus',
            data: @json($revenusChart->pluck('total')),
            backgroundColor: '#2563eb',
            borderRadius: 6,
            borderWidth: 0,
            maxBarThickness: 36
        }]
    },

    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: { grid: { color: '#f1f5f9' }, ticks: { color: '#94a3b8' } },
            x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
        }
    }

});

</script>
@endsection