@extends('layouts.app')

@section('content')

<style>

body{
    background:#f5f7fb;
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

.form-body{
    padding:35px;
}

.form-control{
    height:55px;
    border-radius:14px;
}

.form-label{
    font-weight:700;
}

.document-card{
    background:#fafafa;
    border-radius:16px;
    padding:15px;
    border:1px solid #eee;
}

</style>

<div class="container py-4">

<div class="form-card">

<div class="form-header">

<h3>

<i class="fas fa-edit"></i>

Edit CNAS Moral

</h3>

<p>

Modifier les informations du compte

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
action="{{ route('cnas-morals.update',$cnas_moral) }}"
method="POST"
enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">

<label class="form-label">Tasmya Ijtima3iya</label>

<input type="text"
name="label_name"
class="form-control"
value="{{ old('label_name',$cnas_moral->label_name) }}">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">NIN</label>

<input type="text"
name="NIN"
class="form-control"
value="{{ old('NIN',$cnas_moral->NIN) }}">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Téléphone</label>

<input type="text"
name="phone"
class="form-control"
value="{{ old('phone',$cnas_moral->phone) }}">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Code</label>

<input type="text"
name="code"
class="form-control"
value="{{ old('code',$cnas_moral->code) }}">

</div>

<div class="col-md-6 mb-3">

<label class="form-label">Mot de passe</label>

<input type="text"
name="mot_de_passe"
class="form-control"
value="{{ old('mot_de_passe',$cnas_moral->mot_de_passe) }}">

</div>

</div>

<hr class="my-4">

<h4>Documents de la société</h4>
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

@foreach($documents as $doc)

<div class="col-md-6 mb-3">

<div class="document-card">

<label class="form-label fw-bold">

{{ $doc[1] }}

</label>

<input
type="file"
name="{{ $doc[0] }}"
class="form-control"
accept=".pdf,.jpg,.jpeg,.png,.webp">

@if($cnas_moral->{$doc[0]})

<div class="mt-2 d-flex gap-2">

<a href="{{ Storage::url($cnas_moral->{$doc[0]}) }}"
target="_blank"
class="btn btn-primary btn-sm">

<i class="fas fa-eye"></i> Voir

</a>

<a href="{{ route('cnas-morals.deleteFile', [$cnas_moral, $doc[0]]) }}"
class="btn btn-danger btn-sm"
onclick="return confirm('Supprimer ce fichier ?')">

<i class="fas fa-trash"></i> Supprimer

</a>

</div>

@endif

</div>

</div>

@endforeach

</div>

<hr class="my-4">

<h4>Les bénéficiaires</h4>

<div id="beneficiaries-container">

@foreach($cnas_moral->beneficiaries as $i => $b)

<div class="card mb-3 p-3 beneficiary-card">

<div class="row">

<input type="hidden"
name="beneficiaries[{{ $i }}][id]"
value="{{ $b->id }}">

<div class="col-md-12 mb-2">

<label>Nom complet</label>

<input type="text"
name="beneficiaries[{{ $i }}][full_name]"
class="form-control"
value="{{ $b->full_name }}">

</div>

<div class="col-md-4">

<label>Carte</label>

<input type="file"
name="beneficiaries[{{ $i }}][cart_pdf]"
class="form-control">

@if($b->cart_pdf)

<a href="{{ Storage::url($b->cart_pdf) }}"
target="_blank"
class="btn btn-sm btn-primary mt-1">

Voir

</a>

<a href="{{ route('cnas-moral-beneficiaries.deleteFile',[$b,'cart_pdf']) }}"
class="btn btn-sm btn-danger mt-1"
onclick="return confirm('Supprimer ?')">

Supprimer

</a>

@endif

</div>

<div class="col-md-4">

<label>Photo</label>

<input type="file"
name="beneficiaries[{{ $i }}][photo_pdf]"
class="form-control">

@if($b->photo_pdf)

<a href="{{ Storage::url($b->photo_pdf) }}"
target="_blank"
class="btn btn-sm btn-primary mt-1">

Voir

</a>

<a href="{{ route('cnas-moral-beneficiaries.deleteFile',[$b,'photo_pdf']) }}"
class="btn btn-sm btn-danger mt-1"
onclick="return confirm('Supprimer ?')">

Supprimer

</a>

@endif

</div>

<div class="col-md-4">

<label>Résidence</label>

<input type="file"
name="beneficiaries[{{ $i }}][residence_pdf]"
class="form-control">

@if($b->residence_pdf)

<a href="{{ Storage::url($b->residence_pdf) }}"
target="_blank"
class="btn btn-sm btn-primary mt-1">

Voir

</a>

<a href="{{ route('cnas-moral-beneficiaries.deleteFile',[$b,'residence_pdf']) }}"
class="btn btn-sm btn-danger mt-1"
onclick="return confirm('Supprimer ?')">

Supprimer

</a>

@endif

</div>

</div>

</div>

@endforeach

</div>

<h4 class="mt-4 mb-3">Ajouter un bénéficiaire</h4>

<div id="new-beneficiaries"></div>

<button
type="button"
class="btn btn-primary mb-4"
onclick="addBeneficiary()">

<i class="fas fa-plus"></i>

Ajouter

</button>

<script>

let beneficiaryIndex = {{ $cnas_moral->beneficiaries->count() }};

function addBeneficiary(){

    let html = `

    <div class="card p-3 mb-3 beneficiary-card">

        <div class="d-flex justify-content-between mb-3">

            <strong>Bénéficiaire</strong>

            <button type="button"
                class="btn btn-danger btn-sm"
                onclick="this.closest('.beneficiary-card').remove()">

                <i class="fas fa-trash"></i>delete

            </button>

        </div>

        <div class="row">

            <div class="col-md-12 mb-2">

                <label>Nom complet</label>

                <input type="text"
                    name="beneficiaries[${beneficiaryIndex}][full_name]"
                    class="form-control">

            </div>

            <div class="col-md-4">

                <label>Carte</label>

                <input type="file"
                    name="beneficiaries[${beneficiaryIndex}][cart_pdf]"
                    class="form-control">

            </div>

            <div class="col-md-4">

                <label>Photo</label>

                <input type="file"
                    name="beneficiaries[${beneficiaryIndex}][photo_pdf]"
                    class="form-control">

            </div>

            <div class="col-md-4">

                <label>Résidence</label>

                <input type="file"
                    name="beneficiaries[${beneficiaryIndex}][residence_pdf]"
                    class="form-control">

            </div>

        </div>

    </div>

    `;

    document
        .getElementById('new-beneficiaries')
        .insertAdjacentHTML('beforeend', html);

    beneficiaryIndex++;

}

</script>
<div class="text-center mt-5">

    <button
        type="submit"
        class="btn btn-success px-5 py-2">

        <i class="fas fa-save"></i>

        Mettre à jour

    </button>

    <a
        href="{{ route('cnas-morals.index') }}"
        class="btn btn-secondary px-5 py-2">

        <i class="fas fa-arrow-left"></i>

        Retour

    </a>

</div>

</form>

</div>

</div>

</div>

@endsection
