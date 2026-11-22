@extends('layouts.app')

@section('content')

<style>
.beneficiary-card{

    border-left:6px solid #4f46e5;

    transition:.3s;

}

.beneficiary-card:hover{

    transform:translateY(-3px);

    box-shadow:0 15px 30px rgba(79,70,229,.15);

}

body{
    background:#f4f7fb;
    font-family:'Cairo',sans-serif;
}

.form-card{
    max-width:900px;
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

    box-shadow:0 0 0 .20rem rgba(79,70,229,.15);

}

input[type=file]{

    padding:13px;

}

.btn-save{

    background:linear-gradient(135deg,#4f46e5,#7c3aed);

    color:#fff;

    padding:14px 35px;

    border:none;

    border-radius:14px;

    font-weight:bold;

    transition:.3s;

    box-shadow:0 12px 25px rgba(79,70,229,.25);

}

.btn-save:hover{

    transform:translateY(-3px);

    color:#fff;

}

.btn-back{

    background:#ef4444;

    color:#fff;

    padding:14px 35px;

    border-radius:14px;

    text-decoration:none;

    font-weight:bold;

    margin-left:10px;

}

.btn-back:hover{

    color:#fff;

    background:#dc2626;

}

</style>

<div class="container py-4">

<div class="form-card">

<div class="form-header">

<h3><i class="fas fa-plus-circle"></i> Nouveau Compte CNAS</h3>

<p>Ajouter un nouveau compte CNAS</p>

</div>

<div class="form-body">

<form action="{{ route('cnases.store') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">
Nom Complet
</label>

<input
type="text"
name="full_name"
class="form-control"
value="{{ old('full_name') }}"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">
NIN
</label>

<input
type="text"
name="NIN"
class="form-control"
value="{{ old('NIN') }}">

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
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">
Code
</label>

<input
type="text"
name="code"
class="form-control"
value="{{ old('code') }}">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">
Mot de passe
</label>

<input
type="text"
name="mot_de_passe"
class="form-control"
value="{{ old('mot_de_passe') }}">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">
كلمة المرور 
</label>

<input
type="file"
name="prove_pdf"
class="form-control"
accept=".pdf,.jpg,.jpeg,.png">

</div>
<div class="col-md-6 mb-4">
    <label class="form-label">ايجار</label>
    <input type="file"
           name="rent_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

<div class="col-md-6 mb-4">
    <label class="form-label">سجل تجاري</label>
    <input type="file"
           name="register_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

<div class="col-md-6 mb-4">
    <label class="form-label">بطاقة حرفي</label>
    <input type="file"
           name="craft_cart_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

<div class="col-md-6 mb-4">
    <label class="form-label">بطاقة التعريف</label>
    <input type="file"
           name="cart_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

<div class="col-md-6 mb-4">
    <label class="form-label">شهادة الميلاد</label>
    <input type="file"
           name="birth_certificate_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

<div class="col-md-6 mb-4">
    <label class="form-label">NIF</label>
    <input type="file"
           name="nif_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

<div class="col-md-6 mb-4">
    <label class="form-label">Chèque Barré</label>
    <input type="file"
           name="chek_barre_pdf"
           class="form-control"
           accept=".pdf,.jpg,.jpeg,.png">
</div>

</div>
<hr class="my-5">

<h3 class="mb-4">
    Les bénéficiaires
</h3>

<div id="beneficiaries"></div>

<button
type="button"
class="btn btn-primary"
onclick="addBeneficiary()">

<i class="fas fa-plus"></i>

Ajouter un bénéficiaire

</button>

<div class="text-center mt-4">

<button class="btn-save">

<i class="fas fa-save"></i>

 Enregistrer

</button>

<a href="{{ route('cnases.index') }}"
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

let beneficiaryIndex = 0;

function addBeneficiary(){

    let html = `

    <div class="card shadow-sm border-0 rounded-4 p-4 mb-4 beneficiary-card">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h5 class="fw-bold text-primary mb-0">

                <i class="fas fa-user"></i>

                Bénéficiaire

            </h5>

            <button
                type="button"
                class="btn btn-danger btn-sm"
                onclick="this.closest('.beneficiary-card').remove()">

                <i class="fas fa-trash"></i>delete

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
                    required>

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Carte

                </label>

                <input
                    type="file"
                    name="beneficiaries[${beneficiaryIndex}][cart_pdf]"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png">

            </div>
            
            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Photo

                </label>

                <input
                    type="file"
                    name="beneficiaries[${beneficiaryIndex}][photo_pdf]"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png">

            </div>

            <div class="col-md-6 mb-3">

                <label class="form-label">

                    Acte de naissance

                </label>

                <input
                    type="file"
                    name="beneficiaries[${beneficiaryIndex}][birth_pdf]"
                    class="form-control"
                    accept=".pdf,.jpg,.jpeg,.png">

            </div>

        </div>

    </div>

    `;

    document
        .getElementById('beneficiaries')
        .insertAdjacentHTML('beforeend', html);

    beneficiaryIndex++;

}

addBeneficiary();

</script>
@endsection