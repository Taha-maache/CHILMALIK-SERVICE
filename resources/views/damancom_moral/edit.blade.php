@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        <i class="fas fa-edit me-2"></i>
                        Edit Damancom Moral
                    </h4>

                    <a href="{{ route('damancom-moral.index') }}" class="btn btn-light btn-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>

                </div>

                <div class="card-body">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach ($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('damancom-moral.update',$damancom->id) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="col-md-12 mb-3">

                                <label class="form-label fw-bold">
                                    Tasmya Ijtima3iya
                                </label>

                                <input
                                    type="text"
                                    name="label_name"
                                    class="form-control"
                                    value="{{ old('label_name',$damancom->label_name) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    NIN
                                </label>

                                <input
                                    type="text"
                                    name="NIN"
                                    class="form-control"
                                    value="{{ old('NIN',$damancom->NIN) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone',$damancom->phone) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    Code
                                </label>

                                <input
                                    type="text"
                                    name="code"
                                    class="form-control"
                                    value="{{ old('code',$damancom->code) }}"
                                    required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    Mot de Passe
                                </label>

                                <div class="input-group">

                                    <input
                                        type="text"
                                        id="password"
                                        name="mot_de_passe"
                                        class="form-control"
                                        value="{{ old('mot_de_passe',$damancom->mot_de_passe) }}"
                                        required>

                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        id="togglePassword">

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <div class="col-md-12 mb-3">

                                <label class="form-label fw-bold">
                                    Nouveau fichier
                                </label>

                                <input
                                    type="file"
                                    class="form-control"
                                    id="prove_pdf"
                                    name="prove_pdf"
                                    accept=".pdf,.jpg,.jpeg,.png,.webp">

                                <small id="fileName" class="text-muted">
                                    Aucun fichier sélectionné
                                </small>

                            </div>
@if($damancom->prove_pdf)

<div class="mt-2">

    <a href="{{ asset('storage/'.$damancom->prove_pdf) }}"
       target="_blank"
       class="btn btn-primary btn-sm">

        <i class="fas fa-eye"></i> Voir

    </a>

    <a href="{{ route('damancom-moral.deleteFile', [$damancom, 'prove_pdf']) }}"
       class="btn btn-danger btn-sm"
       onclick="return confirm('Supprimer ce fichier ?')">

        <i class="fas fa-trash"></i> Supprimer

    </a>

</div>

@endif
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">

                            <a href="{{ route('damancom-moral.index') }}"
                               class="btn btn-secondary me-2">

                                Cancel

                            </a>

                            <button
                                type="submit"
                                class="btn btn-warning">

                                <i class="fas fa-save"></i>

                                Update

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function () {

    // ===============================
    // Show / Hide Password
    // ===============================

    const password = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');

    togglePassword.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';
            this.innerHTML = '<i class="fas fa-eye-slash"></i>';

        } else {

            password.type = 'password';
            this.innerHTML = '<i class="fas fa-eye"></i>';

        }

    });

    // ===============================
    // Selected File Name
    // ===============================

    const fileInput = document.getElementById('prove_pdf');
    const fileName = document.getElementById('fileName');

    fileInput.addEventListener('change', function () {

        if (this.files.length > 0) {

            fileName.innerHTML =
                '<span class="text-success fw-bold">' +
                this.files[0].name +
                '</span>';

        } else {

            fileName.innerHTML =
                '<span class="text-muted">Aucun fichier sélectionné</span>';

        }

    });

});

</script>

@endpush