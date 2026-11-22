@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow border-0">

                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">

                    <h4 class="mb-0">
                        <i class="fas fa-building me-2"></i>
                        Add New Damancom Moral
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

                    <form action="{{ route('damancom-moral.store') }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <!-- Label Name -->
                            <div class="col-md-12 mb-3">

                                <label class="form-label fw-bold">
                                    التسمية الاجتماعية
                                </label>

                                <input
                                    type="text"
                                    name="label_name"
                                    class="form-control"
                                    value="{{ old('label_name') }}"
                                    placeholder="Enter Label Name"
                                    required>

                            </div>

                            <!-- NIN -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    NIN
                                </label>

                                <input
                                    type="text"
                                    name="NIN"
                                    class="form-control"
                                    value="{{ old('NIN') }}"
                                    placeholder="Enter NIN"
                                    >

                            </div>

                            <!-- Phone -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    Phone
                                </label>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                    value="{{ old('phone') }}"
                                    placeholder="Enter Phone"
                                    >

                            </div>

                            <!-- Code -->
                            <div class="col-md-6 mb-3">

                                <label class="form-label fw-bold">
                                    Code
                                </label>

                                <input
                                    type="text"
                                    name="code"
                                    class="form-control"
                                    value="{{ old('code') }}"
                                    placeholder="Enter Code"
                                    >

                            </div>

                            <!-- Password -->
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
                                        placeholder="Enter Password"
                                        >

                                    <button
                                        class="btn btn-outline-secondary"
                                        type="button"
                                        id="togglePassword">

                                        <i class="fas fa-eye"></i>

                                    </button>

                                </div>

                            </div>

                            <!-- File -->
                            <div class="col-md-12 mb-4">

                                <label class="form-label fw-bold">

                                    PDF / Image

                                </label>

                                <input
                                    type="file"
                                    name="prove_pdf"
                                    id="prove_pdf"
                                    class="form-control"
                                    accept=".pdf,.jpg,.jpeg,.png,.webp">

                                <small
                                    id="fileName"
                                    class="text-muted">

                                    No file selected

                                </small>

                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">

                            <a href="{{ route('damancom-moral.index') }}"
                               class="btn btn-secondary me-2">

                                Cancel

                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary">

                                <i class="fas fa-save"></i>

                                Save

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

    // ==========================
    // Show / Hide Password
    // ==========================

    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';
            this.innerHTML = '<i class="fas fa-eye-slash"></i>';

        } else {

            password.type = 'password';
            this.innerHTML = '<i class="fas fa-eye"></i>';

        }

    });

    // ==========================
    // Show Selected File Name
    // ==========================

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
                '<span class="text-muted">No file selected</span>';

        }

    });

});

</script>

@endpush