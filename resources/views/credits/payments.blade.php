@extends('layouts.app')

@section('content')

<div class="container py-4">

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>💳 Historique des Paiements</h2>
        <small class="text-muted">
            {{ $credit->service->full_name }}
        </small>
    </div>

    <a href="{{ route('credits.index') }}" class="btn btn-dark">
        Retour
    </a>

</div>


<div class="row mb-4">

<div class="col-md-4">

<div class="card border-0 shadow">

<div class="card-body text-center">

<h6>Total</h6>

<h2 class="text-primary">
{{ number_format($credit->service->total_price,0,',',' ') }}
</h2>

</div>

</div>

</div>


<div class="col-md-4">

<div class="card border-0 shadow">

<div class="card-body text-center">

<h6>Payé</h6>

<h2 class="text-success">
{{ number_format($credit->amount_paid,0,',',' ') }}
</h2>

</div>

</div>

</div>


<div class="col-md-4">

<div class="card border-0 shadow">

<div class="card-body text-center">

<h6>Reste</h6>

<h2 class="text-danger">
{{ number_format($credit->remaining_amount,0,',',' ') }}
</h2>

</div>

</div>

</div>

</div>


<div class="card shadow mb-4">

<div class="card-header">

➕ Ajouter un paiement

</div>

<div class="card-body">

<form action="{{ route('credits.payments.store',$credit->id) }}" method="POST">

@csrf

<div class="row">

<div class="col-md-3">

<label>Date</label>

<input
type="date"
name="payment_date"
class="form-control"
value="{{ date('Y-m-d') }}"
required>

</div>

<div class="col-md-3">

<label>Montant</label>

<input
type="number"
name="amount"
class="form-control"
required>

</div>

<div class="col-md-4">

<label>Remarque</label>

<input
type="text"
name="note"
class="form-control">

</div>

<div class="col-md-2 d-flex align-items-end">

<button class="btn btn-success w-100">

Ajouter

</button>

</div>

</div>

</form>

</div>

</div>



<div class="card shadow">

<div class="card-header">

📜 Historique

</div>

<div class="card-body p-0">

<table class="table table-hover mb-0">

<thead class="table-dark">

<tr>

<th>Date</th>

<th>Montant</th>

<th>Remarque</th>

<th></th>

</tr>

</thead>

<tbody>

@forelse($payments as $payment)

<tr>

<td>

{{ $payment->payment_date }}

</td>

<td>

{{ number_format($payment->amount,0,',',' ') }}

DA

</td>

<td>

{{ $payment->note }}

</td>

<td>

<form
action="{{ route('payments.destroy',$payment->id) }}"
method="POST">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm">

Supprimer

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4" class="text-center">

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
