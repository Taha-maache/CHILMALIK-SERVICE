@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow-sm">

        <div class="card-header">
            <h4 class="mb-0">
                Ajouter un paiement Tax
            </h4>
        </div>

        <div class="card-body">

            {{-- INFORMATIONS TAX --}}
            <div class="alert alert-light border mb-4">

                <strong>Client :</strong>

                {{ $traderTax->trader->first_name ?? '' }}
                {{ $traderTax->trader->last_name ?? '' }}

                <br>

                <strong>NIN :</strong>
                {{ $traderTax->trader->NIN ?? '-' }}

                <br>

                <strong>Année fiscale :</strong>
                {{ $traderTax->tax_year }}

                <br>

                <strong>Taux :</strong>
                {{ $traderTax->tax_value }}%

                <br>

                <strong>Montant dû :</strong>
                {{ number_format($traderTax->amount, 2, ',', ' ') }} DA

            </div>


            {{-- FORM --}}

            <form method="POST"
                  action="{{ route('trader-tax-payments.store', $traderTax->id) }}">

                @csrf

                <div class="row">

                    {{-- DATE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date de paiement
                        </label>

                        <input
                            type="date"
                            name="payment_date"
                            class="form-control @error('payment_date') is-invalid @enderror"
                            value="{{ old('payment_date', date('Y-m-d')) }}"
                            required
                        >

                        @error('payment_date')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            class="form-control @error('amount') is-invalid @enderror"
                            value="{{ old('amount') }}"
                            required
                        >

                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

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
                            value="{{ old('reference') }}"
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
                            value="{{ old('description') }}"
                        >

                    </div>

                </div>


                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="fas fa-save"></i>
                        Enregistrer

                    </button>

                    <a href="{{ route('trader-tax-payments.index', $traderTax->id) }}"
                       class="btn btn-secondary">

                        Retour

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection