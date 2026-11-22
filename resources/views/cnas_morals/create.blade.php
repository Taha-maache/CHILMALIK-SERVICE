@extends('layouts.app')

@section('content')

<style>

body{

    background:#f4f7fb;
    font-family:'Cairo',sans-serif;

}

.form-card{

    max-width:1000px;
    margin:auto;
    background:#fff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 20px 45px rgba(0,0,0,.08);

}

.form-header{

    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    color:#fff;
    padding:28px;

}

.form-header h3{

    margin:0;
    font-weight:800;

}

.form-header p{

    margin-top:8px;
    opacity:.9;

}

.form-body{

    padding:35px;

}

.form-label{

    font-weight:700;
    margin-bottom:8px;

}

.form-control{

    height:55px;
    border-radius:14px;
    border:1px solid #e5e7eb;
    transition:.3s;

}

.form-control:focus{

    border-color:#4f46e5;
    box-shadow:0 0 0 .2rem rgba(79,70,229,.15);

}

input[type=file]{

    padding:13px;

}

.document-card{

    background:#fafafa;
    border:1px solid #ececec;
    border-radius:16px;
    padding:18px;
    margin-bottom:20px;
    transition:.3s;

}

.document-card:hover{

    border-color:#4f46e5;
    box-shadow:0 8px 20px rgba(79,70,229,.08);

}

.btn-save{

    background:linear-gradient(135deg,#4f46e5,#7c3aed);
    color:#fff;
    padding:14px 35px;
    border:none;
    border-radius:14px;
    font-weight:bold;
    box-shadow:0 12px 25px rgba(79,70,229,.20);

}

.btn-save:hover{

    color:#fff;
    transform:translateY(-2px);

}

.btn-back{

    background:#ef4444;
    color:white;
    padding:14px 35px;
    border-radius:14px;
    text-decoration:none;
    margin-left:10px;

}

.btn-back:hover{

    color:white;
    background:#dc2626;

}

.beneficiary-card{

    border-left:6px solid #4f46e5;
    border-radius:18px;
    transition:.3s;

}

.beneficiary-card:hover{

    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(79,70,229,.15);

}

</style>

<div class="container py-4">

<div class="form-card">

<div class="form-header">

<h3>

<i class="fas fa-plus-circle"></i>

Nouveau Compte CNAS Moral

</h3>

<p>

Créer un nouveau compte CNAS Moral

</p>

</div>

<div class="form-body">

@if($errors->any())

<div class="alert alert-danger">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif

<form
action="{{ route('cnas-morals.store') }}"
method="POST"
enctype="multipart/form-data">

@csrf

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">

التسمية الاجتماعية

</label>

<input
type="text"
name="label_name"
class="form-control"
value="{{ old('label_name') }}"
>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

NIN

</label>

<input
type="text"
name="NIN"
class="form-control"
value="{{ old('NIN') }}"
>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Téléphone

</label>

<input
type="text"
name="phone"
class="form-control"
value="{{ old('phone') }}"
>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Code

</label>

<input
type="text"
name="code"
class="form-control"
value="{{ old('code') }}"
>

</div>

<div class="col-md-12 mb-4">

<label class="form-label">

Mot de passe

</label>

<div class="input-group">

<input
type="text"
name="mot_de_passe"
id="password"
class="form-control"
>

<button
type="button"
class="btn btn-outline-secondary"
id="togglePassword">

<i class="fas fa-eye"></i>

</button>

</div>

</div>

<hr class="my-4">

<h4 class="mb-4">

Documents de la société

</h4>
<div class="row">

@php
$documents = [

['prove_pdf','Justificatif'],
['rent_pdf','Contrat de location'],
['G08_pdf','G08'],
['register_pdf','Registre de commerce'],
['cart_pdf',"Carte d'identité"],
['residence_pdf','Résidence'],
['Boal_pdf','Boal'],
['rential_law_pdf','Loi de location'],
['Nif_pdf','NIF'],
['chek_baree_pdf','Chèque barré'],

];
@endphp

@foreach($documents as $document)

<div class="col-md-6">

<div class="document-card">

<label class="form-label fw-bold">

{{ $document[1] }}

</label>

<input
type="file"
name="{{ $document[0] }}"
class="form-control"
accept=".pdf,.jpg,.jpeg,.png,.webp">

</div>

</div>

@endforeach

</div>

<hr class="my-5">

<h4 class="fw-bold mb-4">

Les bénéficiaires

</h4>


<button
type="button"
class="btn btn-primary"
onclick="addBeneficiary()">

<i class="fas fa-plus"></i>

Ajouter un bénéficiaire

</button>

<hr class="my-5">
<div id="beneficiaries-container"></div>

<div class="mt-4 mb-5">

    <button
        type="button"
        class="btn btn-primary"
        onclick="addBeneficiary()">

        <i class="fas fa-plus"></i>

        Ajouter un bénéficiaire

    </button>

</div>

<script>

let beneficiaryIndex = 0;

function addBeneficiary(){

    let html = `

    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 beneficiary-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="fw-bold text-primary mb-0">

                <i class="fas fa-user"></i>delete

                Bénéficiaire

            </h5>

            <button
                type="button"
                class="btn btn-danger btn-sm"
                onclick="this.closest('.beneficiary-card').remove()">

                <i class="fas fa-trash"></i>

            </button>

        </div>

        <div class="row">

            <div class="col-md-12 mb-3">

                <label class="form-label">

                    Nom complet

                </label>

                <input
                    type="text"
                    name="beneficiaries[${beneficiaryIndex}][full_name]"
                    class="form-control"
                    >

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Carte d'identité

                </label>

                <input
                    type="file"
                    name="beneficiaries[${beneficiaryIndex}][cart_pdf]"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png,.webp">

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Photo

                </label>

                <input
                    type="file"
                    name="beneficiaries[${beneficiaryIndex}][photo_pdf]"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png,.webp">

            </div>

            <div class="col-md-4 mb-3">

                <label class="form-label">

                    Résidence

                </label>

                <input
                    type="file"
                    name="beneficiaries[${beneficiaryIndex}][residence_pdf]"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png,.webp">

            </div>

        </div>

    </div>

    `;

    document
        .getElementById('beneficiaries-container')
        .insertAdjacentHTML('beforeend', html);

    beneficiaryIndex++;

}

</script>
<div class="text-center mt-5">

    <button
        type="submit"
        class="btn-save">

        <i class="fas fa-save"></i>

        Enregistrer

    </button>

    <a
        href="{{ route('cnas-morals.index') }}"
        class="btn-back">

        <i class="fas fa-arrow-left"></i>

        Retour

    </a>

</div>

</form>

</div>

</div>

</div>

<script>

// =========================
// Show / Hide Password
// =========================

const password = document.getElementById('password');
const togglePassword = document.getElementById('togglePassword');

togglePassword.addEventListener('click', function () {

    if (password.type === 'password') {

        password.type = 'text';

        this.innerHTML =
            '<i class="fas fa-eye-slash"></i>';

    } else {

        password.type = 'password';

        this.innerHTML =
            '<i class="fas fa-eye"></i>';

    }

});

</script>

@endsection