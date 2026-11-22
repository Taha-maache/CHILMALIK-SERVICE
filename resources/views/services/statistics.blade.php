@extends('layouts.app')

@section('content')

<style>
body{
    background:#f4f6f9;
}

.stats-card{
    border:none;
    border-radius:18px;
    transition:.3s;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.stats-card:hover{
    transform:translateY(-5px);
}

.chart-card,
.table-card{
    border:none;
    border-radius:18px;
    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.progress{
    height:22px;
    border-radius:30px;
}

.progress-bar{
    font-weight:bold;
}
</style>

<div class="container mt-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>
<h2 class="fw-bold mb-0">📊 Statistiques Avancées</h2>
<small class="text-muted">Analyse complète</small>
</div>

<a href="{{ route('services.index') }}" class="btn btn-dark">
⬅ Retour
</a>

</div>

{{-- ================= FIRST ROW ================= --}}

<div class="row g-3 mb-4">

<div class="col-lg-3 col-md-6">
<div class="card bg-primary text-white stats-card">
<div class="card-body text-center">
<h6>Total Services</h6>
<h2>{{ $totalServices }}</h2>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card bg-success text-white stats-card">
<div class="card-body text-center">
<h6>Revenus</h6>
<h2>{{ number_format($totalRevenue) }} DA</h2>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card bg-info text-white stats-card">
<div class="card-body text-center">
<h6>Abonnés</h6>
<h2>{{ $totalSubscribers }}</h2>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card bg-warning text-dark stats-card">
<div class="card-body text-center">
<h6>Non Abonnés</h6>
<h2>{{ $totalNonSubscribers }}</h2>
</div>
</div>
</div>

</div>

{{-- ================= SECOND ROW ================= --}}

<div class="row g-3 mb-4">

<div class="col-lg-3 col-md-6">
<div class="card stats-card border-success">
<div class="card-body text-center">
<h6 class="text-success">💳 Total Encaissé</h6>
<h2>{{ number_format($totalPaid) }} DA</h2>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card stats-card border-danger">
<div class="card-body text-center">
<h6 class="text-danger">📌 Restant</h6>
<h2>{{ number_format($totalRemaining) }} DA</h2>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card stats-card border-warning">
<div class="card-body text-center">
<h6 class="text-warning">💵 Service Moyen</h6>
<h2>{{ number_format($averageService) }} DA</h2>
</div>
</div>
</div>

<div class="col-lg-3 col-md-6">
<div class="card stats-card border-info">
<div class="card-body text-center">
<h6 class="text-info">💳 Paiements</h6>
<h2>{{ $totalPayments }}</h2>
</div>
</div>
</div>
{{-- ================= PAIEMENTS AUJOURD'HUI ================= --}}

<div class="row g-3 mb-4">

    {{-- Encaissé aujourd'hui --}}
    <div class="col-lg-4 col-md-6">
        <div class="card stats-card border-success h-100">
            <div class="card-body text-center">
                <h6 class="text-success">💰 Encaissé aujourd'hui</h6>
                <h2 class="text-success">
                    {{ number_format($todayPaid, 0, ',', ' ') }} DA
                </h2>
                <small class="text-muted">Paiements réellement reçus aujourd'hui</small>
            </div>
        </div>
    </div>

    {{-- Revenus des services du jour --}}
    <div class="col-lg-4 col-md-6">
        <div class="card stats-card border-primary h-100">
            <div class="card-body text-center">
                <h6 class="text-primary">📊 Revenus aujourd'hui</h6>
                <h2 class="text-primary">
                    {{ number_format($todayRevenue, 0, ',', ' ') }} DA
                </h2>
                <small class="text-muted">Valeur totale des services créés aujourd'hui</small>
            </div>
        </div>
    </div>

    {{-- Reste à payer pour les services du jour --}}
    <div class="col-lg-4 col-md-6">
        <div class="card stats-card border-danger h-100">
            <div class="card-body text-center">
                <h6 class="text-danger">📌 Restant aujourd'hui</h6>
                <h2 class="text-danger">
                    {{ number_format($todayRemaining, 0, ',', ' ') }} DA
                </h2>
                <small class="text-muted">Reste à payer sur les services du jour</small>
            </div>
        </div>
    </div>

</div>

</div>

{{-- ================= THIRD ROW ================= --}}

<div class="row g-3 mb-4">

<div class="col-lg-4">

<div class="card stats-card h-100">

<div class="card-body">

<h5>📊 Taux de Recouvrement</h5>

<div class="progress mt-4">

<div class="progress-bar bg-success"

style="width:{{ $collectionRate }}%">

{{ $collectionRate }}%

</div>

</div>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card stats-card h-100">

<div class="card-body text-center">

<h6>📅 Aujourd'hui</h6>

<h2>{{ $todayServices }}</h2>

<p class="mb-0">

{{ number_format($todayRevenue) }} DA

</p>

</div>

</div>

</div>

<div class="col-lg-4">

<div class="card stats-card h-100">

<div class="card-body text-center">

<h6>⚠️ Clients Débiteurs</h6>

<h2 class="text-danger">

{{ $clientsWithDebt }}

</h2>

</div>

</div>

</div>

</div>

{{-- ================= WEEK / MONTH ================= --}}

<div class="row g-3 mb-4">

<div class="col-md-6">

<div class="card stats-card">

<div class="card-body">

<h5>📆 Cette semaine</h5>

<hr>

<div class="d-flex justify-content-between">

<span>Services</span>

<strong>{{ $weekServices }}</strong>

</div>

<div class="d-flex justify-content-between mt-2">

<span>Revenus</span>

<strong>{{ number_format($weekRevenue) }} DA</strong>

</div>

</div>

</div>

</div>

<div class="col-md-6">

<div class="card stats-card">

<div class="card-body">

<h5>📅 Ce mois</h5>

<hr>

<div class="d-flex justify-content-between">

<span>Services</span>

<strong>{{ $monthServices }}</strong>

</div>

<div class="d-flex justify-content-between mt-2">

<span>Revenus</span>

<strong>{{ number_format($monthRevenue) }} DA</strong>

</div>

</div>

</div>

</div>

</div>

{{-- ================= CHARTS ================= --}}

<div class="row g-4 mb-4">

<div class="col-lg-6">

<div class="card chart-card">

<div class="card-body">

<h5 class="mb-3">💰 Revenus par mois</h5>

<canvas id="revenuChart"></canvas>

</div>

</div>

</div>

<div class="col-lg-6">

<div class="card chart-card">

<div class="card-body">

<h5 class="mb-3">📈 Services par mois</h5>

<canvas id="serviceChart"></canvas>

</div>

</div>

</div>

</div>

{{-- ================= TOP CLIENTS ================= --}}

<div class="card table-card">

<div class="card-header bg-dark text-white">

🏆 Top 10 Clients

</div>

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>Nom</th>

<th>Téléphone</th>

<th>Services</th>

<th>Revenus</th>

</tr>

</thead>

<tbody>

@foreach($topClients as $client)

<tr>

<td>{{ $client['name'] }}</td>

<td>{{ $client['phone'] }}</td>

<td>{{ $client['count'] }}</td>

<td>{{ number_format($client['revenue']) }} DA</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('revenuChart'),{

type:'bar',

data:{

labels:@json($revenusParMois->pluck('month')),

datasets:[{

data:@json($revenusParMois->pluck('total'))

}]

},

options:{

plugins:{legend:{display:false}}

}

});

new Chart(document.getElementById('serviceChart'),{

type:'line',

data:{

labels:@json($servicesParMois->pluck('month')),

datasets:[{

data:@json($servicesParMois->pluck('total')),

fill:false,

tension:.35

}]

},

options:{

plugins:{legend:{display:false}}

}

});

</script>

@endsection