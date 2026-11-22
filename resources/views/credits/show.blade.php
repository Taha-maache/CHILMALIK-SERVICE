@extends('layouts.app')

@section('content')

<div class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-4">

<div>

<h2>{{ $credit->service->full_name }}</h2>

<small class="text-muted">

{{ $credit->service->phone }}

</small>

</div>

<a href="{{ route('credits.index') }}" class="btn btn-secondary">

Retour

</a>

</div>


<div class="row">

<div class="col-md-3">

<div class="card bg-primary text-white">

<div class="card-body text-center">

<h6>Total</h6>

<h3>{{ number_format($credit->service->total_price) }} DA</h3>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-success text-white">

<div class="card-body text-center">

<h6>Payé</h6>

<h3>{{ number_format($credit->amount_paid) }} DA</h3>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-danger text-white">

<div class="card-body text-center">

<h6>Reste</h6>

<h3>{{ number_format($credit->remaining_amount) }} DA</h3>

</div>

</div>

</div>


<div class="col-md-3">

<div class="card bg-dark text-white">

<div class="card-body text-center">

<h6>Etat</h6>

@if($credit->remaining_amount==0)

<span class="badge bg-success fs-6">

Payé

</span>

@else

<span class="badge bg-warning text-dark fs-6">

En cours

</span>

@endif

</div>

</div>

</div>

</div>


<div class="card mt-4">

<div class="card-header d-flex justify-content-between align-items-center">

<h5 class="mb-0">

Historique des Paiements

</h5>

<a href="{{ route('credits.payments',$credit) }}"

class="btn btn-success">

+ Paiement

</a>

</div>

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>Date</th>

<th>Montant</th>

<th>Note</th>

</tr>

</thead>

<tbody>

@forelse($credit->payments as $payment)

<tr>

<td>

{{ $payment->payment_date }}

</td>

<td>

{{ number_format($payment->amount) }} DA

</td>

<td>

{{ $payment->note }}

</td>

</tr>

@empty

<tr>

<td colspan="3" class="text-center">

Aucun paiement.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

</div>

@endsection 