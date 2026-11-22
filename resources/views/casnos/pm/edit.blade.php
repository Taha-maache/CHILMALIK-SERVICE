@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>Modifier le paiement</h3>

            <div class="text-muted">
                {{ $casnos->nom }} {{ $casnos->prenom }}
                — Matricule : {{ $casnos->matricule }}
            </div>
        </div>

        <a href="{{ route('casnos.pm.index', $casnos->id) }}"
           class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Retour
        </a>

    </div>


    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            <strong>Modifier les informations du paiement</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('casnos.pm.update', [$casnos->id, $payment->id]) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- DATE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date paiement
                        </label>

                        <input type="date"
                               name="date_paiement"
                               class="form-control"
                               value="{{ old('date_paiement', $payment->date_paiement?->format('Y-m-d')) }}"
                               required>

                    </div>


                    {{-- REFERENCE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Référence
                        </label>

                        <input type="text"
                               name="reference"
                               class="form-control"
                               value="{{ old('reference', $payment->reference) }}">

                    </div>


                    {{-- MONTANT VERSE --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Montant versé
                        </label>

                        <div class="input-group">

                            <input type="number"
                                   name="montant_versse"
                                   class="form-control"
                                   step="0.01"
                                   min="0.01"
                                   value="{{ old('montant_versse', $payment->montant_versse) }}"
                                   required>

                            <span class="input-group-text">
                                DA
                            </span>

                        </div>

                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <input type="text"
                               name="description"
                               class="form-control"
                               value="{{ old('description', $payment->description) }}">

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2 mt-3">

                    <a href="{{ route('casnos.pm.index', $casnos->id) }}"
                       class="btn btn-secondary">
                        Annuler
                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save"></i>
                        Enregistrer les modifications

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection