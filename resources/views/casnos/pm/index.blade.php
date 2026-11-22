@extends('layouts.app')

@section('content')

<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">
                Paiements CASNOS
            </h3>

            <div class="text-muted">
                {{ $casnos->nom }} {{ $casnos->prenom }}
                — Matricule: {{ $casnos->matricule }}
            </div>
        </div>

        <div>
            <a href="{{ route('casnos.pm.create', $casnos->id) }}"
               class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Ajouter paiement
            </a>

            <a href="{{ route('casnos.index') }}"
               class="btn btn-secondary">
                Retour
            </a>
        </div>

    </div>


    {{-- SUMMARY --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">
                        Montant versé
                    </small>

                    <h4 class="mt-2">
                        {{ number_format($casnos->montant_versse, 2, ',', ' ') }}
                        DA
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">
                        Montant encaissé
                    </small>

                    <h4 class="mt-2">
                        {{ number_format($casnos->montant_enkissi, 2, ',', ' ') }}
                        DA
                    </h4>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <small class="text-muted">
                        Montant restant
                    </small>

                    <h4 class="mt-2 text-danger">
    {{ number_format($casnos->getAdjustedRemaining(), 2, ',', ' ') }} DA</h4>
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
                            <th>Montant versé</th>
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
                                    {{ $payment->date_paiement?->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $payment->reference ?? '-' }}
                                </td>


                                <td>
                                    <strong>
                                        {{ number_format($payment->montant_versse, 2, ',', ' ') }}
                                        DA
                                    </strong>
                                </td>
                                <td>

                                    {{-- FACTURE --}}
           <a href="{{ route('casnos.pm.facture', $payment->id) }}"
   target="_blank"
   class="btn btn-sm btn-success"
   title="Facture">

    <i class="fas fa-file-invoice"></i>facture

</a>
<a href="{{ route('casnos.pm.edit', [$casnos->id, $payment->id]) }}"
   class="btn btn-sm btn-warning"
   title="Modifier">

    <i class="fas fa-edit"></i>Modifier

</a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('casnos.pm.destroy', $payment->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Voulez-vous vraiment supprimer ce paiement ?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Supprimer">

                                            <i class="fas fa-trash"></i>supprimer

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7"
                                    class="text-center py-4 text-muted">

                                    Aucun paiement enregistré.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection