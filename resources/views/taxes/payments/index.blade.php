@extends('layouts.app')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">
                Paiements Tax
            </h3>

            <div class="text-muted">
                Tax ID:
                <strong>{{ $tax->id }}</strong>
            </div>

            <div class="text-muted mt-1">
                Année fiscale:
                <strong>{{ $tax->tax_year }}</strong>

                —

                Type:
                <strong>{{ $tax->tax_type ?? '-' }}</strong>
            </div>
        </div>

        <div>

            <a href="{{ route('tax-payments.create', $tax->id) }}"
               class="btn btn-primary">

                <i class="fas fa-plus"></i>
                Ajouter paiement

            </a>

            <a href="{{ route('taxes.index') }}"
               class="btn btn-secondary">

                Retour

            </a>

        </div>

    </div>


    {{-- SUMMARY --}}
    <div class="row mb-4">

        {{-- MONTANT DÛ --}}
        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Montant dû
                    </small>

                    <h4 class="mt-2">

                        {{ number_format($totalDue, 2, ',', ' ') }}
                        DA

                    </h4>

                </div>

            </div>

        </div>


        {{-- TOTAL PAYÉ --}}
        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Total payé
                    </small>

                    <h4 class="mt-2 text-success">

                        {{ number_format($totalPaid, 2, ',', ' ') }}
                        DA

                    </h4>

                </div>

            </div>

        </div>


        {{-- RESTE --}}
        <div class="col-md-4">

            <div class="card shadow-sm border-0">

                <div class="card-body">

                    <small class="text-muted">
                        Reste à payer
                    </small>

                    <h4 class="mt-2
                        {{ $remaining > 0 ? 'text-danger' : 'text-success' }}">

                        {{ number_format($remaining, 2, ',', ' ') }}
                        DA

                    </h4>

                    @if($overpaid > 0)

                        <small class="text-primary">

                            Surplus:
                            {{ number_format($overpaid, 2, ',', ' ') }}
                            DA

                        </small>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- PAYMENTS TABLE --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">

            <strong>
                Historique des paiements
            </strong>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>#</th>

                            <th>Date</th>

                            <th>Référence</th>

                            <th>Description</th>

                            <th>Montant payé</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($payments as $payment)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>


                                <td>

                                    {{ $payment->payment_date?->format('d/m/Y') }}

                                </td>


                                <td>

                                    {{ $payment->reference ?? '-' }}

                                </td>


                                <td>

                                    {{ $payment->description ?? '-' }}

                                </td>


                                <td>

                                    <strong class="text-success">

                                        {{ number_format($payment->amount, 2, ',', ' ') }}
                                        DA

                                    </strong>

                                </td>


                                <td>
<a href="{{ route('taxes-payments.facture', $payment->id) }}"
   class="btn btn-sm btn-success"
   target="_blank">

    <i class="fas fa-file-invoice"></i>
    Facture

</a>
                                    {{-- EDIT --}}
                                    <a href="{{ route('tax-payments.edit', $payment->id) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="fas fa-edit"></i>
                                        Modifier

                                    </a>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('tax-payments.destroy', $payment->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Voulez-vous vraiment supprimer ce paiement ?');"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger">

                                            <i class="fas fa-trash"></i>
                                            Supprimer

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6"
                                    class="text-center py-4 text-muted">

                                    Aucun paiement enregistré.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>


                    @if($payments->count() > 0)

                        <tfoot>

                            <tr>

                                <th colspan="4"
                                    class="text-end">

                                    TOTAL DES PAIEMENTS

                                </th>

                                <th>

                                    {{ number_format($totalPaid, 2, ',', ' ') }}
                                    DA

                                </th>

                                <th></th>

                            </tr>

                        </tfoot>

                    @endif

                </table>

            </div>

        </div>

    </div>

</div>

@endsection