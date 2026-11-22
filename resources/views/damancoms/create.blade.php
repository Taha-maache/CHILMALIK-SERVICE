@extends('layouts.app')

@section('content')

<style>

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

<h3><i class="fas fa-plus-circle"></i> Nouveau Compte Damancom</h3>

<p>Ajouter un nouveau compte Damancom</p>

</div>

<div class="form-body">

<form action="{{ route('damancoms.store') }}"
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
Pièce justificative
</label>

<input
type="file"
name="prove_pdf"
class="form-control"
accept=".pdf,.jpg,.jpeg,.png">

</div>

</div>

<div class="text-center mt-4">

<button class="btn-save">

<i class="fas fa-save"></i>

 Enregistrer

</button>

<a href="{{ route('damancoms.index') }}"
class="btn-back">

<i class="fas fa-arrow-left"></i>

 Retour

</a>

</div>

</form>

</div>

</div>

</div>

@endsection