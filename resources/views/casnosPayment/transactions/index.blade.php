@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
<h3>
    Paiements de :

    {{ $casnosPayment->trader->first_name ?? '' }}
    {{ $casnosPayment->trader->last_name ?? '' }}
</h3>

<p>
    Matricule :
    {{ $casnosPayment->matricule }}
</p>
        </div>

        <a href="{{ route('casnos-payments.transactions.create', $casnosPayment->id) }}"
           class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Ajouter Paiement
        </a>
        
            <a href="{{ route('casnos-payments.index') }}"
               class="btn btn-secondary">
                Retour
            </a>

    </div>


    {{-- CLIENT INFO --}}

    <div class="card shadow-sm mb-4">

        <div class="card-body">

            <div class="row">

                <div class="col-md-3">
                    <strong>Matricule</strong>
                    <div>{{ $casnosPayment->matricule }}</div>
                </div>

                <div class="col-md-3">
                    <strong>Type</strong>
                    <div>{{ $casnosPayment->pay_type }}</div>
                </div>

                <div class="col-md-3">
                    <strong>Montant versé</strong>
                    <div>
                        {{ number_format($casnosPayment->montant_versse, 2) }} DA
                    </div>
                </div>

             <div class="col-md-3">
    <strong>Montant dû</strong>

    <div>
        {{ number_format($casnosPayment->montant_enkissi, 2) }} DA
    </div>

    @php
        $originalRemaining = $casnosPayment->getOriginalRemaining();
        $penaltyAmount = $casnosPayment->getPenaltyAmount();
        $penaltyRate = $casnosPayment->getPenaltyRate();
        $monthsLate = $casnosPayment->getMonthsLate();
        $adjustedBalance = $casnosPayment->getAdjustedBalance();
    @endphp

    @if($originalRemaining > 0 && $penaltyAmount > 0)

        <small class="text-danger">
            + {{ number_format($penaltyAmount, 2) }} DA
            ({{ $penaltyRate }}%)
        </small>

        <br>

        <small class="text-muted">
            Retard : {{ $monthsLate }} mois
        </small>

    @endif
</div>
<div class="col-md-3">

    <strong>Reste à payer</strong>

    <div class="text-danger fw-bold">

        @if($adjustedBalance > 0)

            {{ number_format($adjustedBalance, 2) }} DA

        @else

            0,00 DA

        @endif

    </div>

</div>

            </div>

        </div>

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- PAYMENTS TABLE --}}

    <div class="card shadow-sm">

        <div class="card-body">

            <h5 class="mb-3">
                Historique des paiements
            </h5>

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>

                            <th>Date</th>

                            <th>Montant</th>

                            <th>Référence</th>

                            <th>Description</th>

                            <th>Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($transactions as $transaction)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $transaction->payment_date->format('d/m/Y') }}
                            </td>

                            <td>
                                <strong>
                                    {{ number_format($transaction->amount, 2) }}
                                    DA
                                </strong>
                            </td>

                            <td>
                                {{ $transaction->reference ?? '-' }}
                            </td>

                            <td>
                                {{ $transaction->description ?? '-' }}
                            </td>

                            <td>

                                <a href="{{ route('casnos-payment-transactions.edit', $transaction->id) }}"
                                   class="btn btn-sm btn-warning">

                                    <i class="fas fa-edit"></i>
                                    Modifier

                                </a>
                                <a href="{{ route('casnos-payment-transactions.facture', $transaction->id) }}"
   target="_blank"
   class="btn btn-sm btn-dark">

    Facture

</a>


                                <form action="{{ route('casnos-payment-transactions.destroy', $transaction->id) }}"
                                      method="POST"
                                      class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn btn-sm btn-danger"
                                            onclick="return confirm('Supprimer ce paiement ?')">

                                        <i class="fas fa-trash"></i>delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center text-muted py-4">

                                Aucun paiement enregistré.

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{ $transactions->links() }}

        </div>

    </div>

</div>

@endsection