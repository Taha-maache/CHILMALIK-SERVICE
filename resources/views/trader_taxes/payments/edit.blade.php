@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">

            <h4 class="mb-0">
                Modifier le paiement
            </h4>

        </div>

        <div class="card-body">

            <div class="alert alert-light border mb-4">

                <strong>Client :</strong>

                {{ $payment->traderTax->trader->first_name ?? '' }}
                {{ $payment->traderTax->trader->last_name ?? '' }}

                <br>

                <strong>NIN :</strong>
                {{ $payment->traderTax->trader->NIN ?? '-' }}

                <br>

                <strong>Année fiscale :</strong>
                {{ $payment->traderTax->tax_year }}

                <br>

                <strong>Taux :</strong>
                {{ $payment->traderTax->tax_value }}%

            </div>


            <form method="POST"
                  action="{{ route('trader-tax-payments.update', $payment->id) }}">

                @csrf
                @method('PUT')


                <div class="row">

                    {{-- DATE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date de paiement
                        </label>

                        <input
                            type="date"
                            name="payment_date"
                            class="form-control"
                            value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d')) }}"
                            required
                        >

                    </div>


                    {{-- AMOUNT --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Montant payé
                        </label>

                        <input
                            type="number"
                            name="amount"
                            step="0.01"
                            min="0.01"
                            class="form-control"
                            value="{{ old('amount', $payment->amount) }}"
                            required
                        >

                    </div>


                    {{-- REFERENCE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Référence
                        </label>

                        <input
                            type="text"
                            name="reference"
                            class="form-control"
                            value="{{ old('reference', $payment->reference) }}"
                        >

                    </div>


                    {{-- DESCRIPTION --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <input
                            type="text"
                            name="description"
                            class="form-control"
                            value="{{ old('description', $payment->description) }}"
                        >

                    </div>

                </div>


                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="fas fa-save"></i>
                        Enregistrer les modifications

                    </button>

                    <a href="{{ route('trader-tax-payments.index', $payment->trader_tax_id) }}"
                       class="btn btn-secondary">

                        Retour

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection