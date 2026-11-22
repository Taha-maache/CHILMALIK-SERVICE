@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">
                Modifier le paiement
            </h4>
        </div>
        <div class="alert alert-light border mb-4">

    <strong>Client :</strong>

    {{ $casnosPayment->trader?->first_name }}
    {{ $casnosPayment->trader?->last_name }}

    <br>

    <strong>Matricule :</strong>
    {{ $casnosPayment->matricule }}

</div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('casnos-payment-transactions.update', $transaction->id) }}">

                @csrf
                @method('PUT')


                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Montant payé
                        </label>

                        <input type="number"
                               name="amount"
                               step="0.01"
                               min="0.01"
                               class="form-control"
                               value="{{ old('amount', $transaction->amount) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date de paiement
                        </label>

                        <input type="date"
                               name="payment_date"
                               class="form-control"
                               value="{{ old('payment_date', $transaction->payment_date->format('Y-m-d')) }}"
                               required>

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Référence
                        </label>

                        <input type="text"
                               name="reference"
                               class="form-control"
                               value="{{ old('reference', $transaction->reference) }}">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <input type="text"
                               name="description"
                               class="form-control"
                               value="{{ old('description', $transaction->description) }}">

                    </div>

                </div>


                <button type="submit"
                        class="btn btn-success">

                    <i class="fas fa-save"></i>
                    Enregistrer les modifications

                </button>


                <a href="{{ route('casnos-payments.transactions.index', $casnosPayment->id) }}"
                   class="btn btn-secondary">

                    Retour

                </a>

            </form>

        </div>

    </div>

</div>

@endsection