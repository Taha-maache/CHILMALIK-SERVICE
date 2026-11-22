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

            {{-- TAX INFO --}}
            <div class="alert alert-light border mb-4">

                <strong>Tax :</strong>
                #{{ $payment->tax->id }}

                <br>

                <strong>Année :</strong>
                {{ $payment->tax->tax_year }}

                <br>

                <strong>Type :</strong>
                {{ $payment->tax->tax_type ?? '-' }}

                <br>

                <strong>Montant dû :</strong>
                {{ number_format($payment->tax->amount ?? 0, 2, ',', ' ') }} DA

            </div>


            {{-- FORM --}}
            <form method="POST"
                  action="{{ route('tax-payments.update', $payment->id) }}">

                @csrf
                @method('PUT')

                <div class="row">

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
                            value="{{ old('amount', $payment->amount) }}"
                            required
                        >

                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- DATE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date de paiement
                        </label>

                        <input
                            type="date"
                            name="payment_date"
                            class="form-control @error('payment_date') is-invalid @enderror"
                            value="{{ old('payment_date', $payment->payment_date?->format('Y-m-d')) }}"
                            required
                        >

                        @error('payment_date')
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


                {{-- BUTTONS --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success">

                        <i class="fas fa-save"></i>
                        Enregistrer les modifications

                    </button>


                    <a href="{{ route('tax-payments.index', $payment->tax_id) }}"
                       class="btn btn-secondary">

                        Retour

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection