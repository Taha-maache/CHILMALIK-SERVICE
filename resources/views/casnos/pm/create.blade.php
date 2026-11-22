@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3>Ajouter un paiement CASNOS</h3>

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


    {{-- Informations actuelles --}}
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Montant versé actuel</small>

                    <h5 class="mt-2">
                        {{ number_format($casnos->montant_versse, 2, ',', ' ') }}
                        DA
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Montant encaissé actuel</small>

                    <h5 class="mt-2">
                        {{ number_format($casnos->montant_enkissi, 2, ',', ' ') }}
                        DA
                    </h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Montant restant</small>

                    <h5 class="mt-2 text-danger">
{{ number_format(abs($casnos->montant_rest), 2, ',', ' ') }} DA
                    </h5>
                </div>
            </div>
        </div>

    </div>


    {{-- Formulaire --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-dark text-white">
            <strong>Informations du paiement</strong>
        </div>

        <div class="card-body">

            <form action="{{ route('casnos.pm.store', $casnos->id) }}"
                  method="POST">

                @csrf

                <div class="row">

                    {{-- Date --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Date paiement
                        </label>

                        <input type="date"
                               name="date_paiement"
                               class="form-control"
                               value="{{ old('date_paiement', date('Y-m-d')) }}"
                               required>

                        @error('date_paiement')
                            <div class="text-danger small">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Reference --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Référence
                        </label>

                        <input type="text"
                               name="reference"
                               class="form-control"
                               value="{{ old('reference') }}"
                               >

                        @error('reference')
                            <div class="text-danger small">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Montant versé --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Montant versé
                        </label>

                        <div class="input-group">

                            <input type="number"
                                   name="montant_versse"
                                   id="montant_versse"
                                   class="form-control"
                                   step="0.01"
                                   min="0.01"
                                   value="{{ old('montant_versse') }}"
                                   required>

                            <span class="input-group-text">
                                DA
                            </span>

                        </div>

                        @error('montant_versse')
                            <div class="text-danger small">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Description --}}
                    <div class="col-md-6 mb-3">

                        <label class="form-label">
                            Description
                        </label>

                        <input type="text"
                               name="description"
                               class="form-control"
                               value="{{ old('description') }}"
                               placeholder="Description du paiement">

                    </div>

                </div>


                <hr class="my-4">


                <div class="d-flex justify-content-end gap-2">

                    <a href="{{ route('casnos.pm.index', $casnos->id) }}"
                       class="btn btn-secondary">

                        Annuler

                    </a>

                    <button type="submit"
                            class="btn btn-primary">

                        <i class="fas fa-save"></i>

                        Enregistrer paiement

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection