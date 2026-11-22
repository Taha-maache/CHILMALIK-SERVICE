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
    background:linear-gradient(135deg,#10b981,#059669);
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
    border-color:#10b981;
    box-shadow:0 0 0 .20rem rgba(16,185,129,.15);
}

input[type=file]{
    padding:13px;
}

.file-box{

    background:#f8fafc;

    border:1px solid #e5e7eb;

    border-radius:15px;

    padding:15px;

}

.btn-open{

    background:#3b82f6;

    color:white;

    border-radius:10px;

    padding:8px 18px;

    text-decoration:none;

    margin-right:10px;

}

.btn-open:hover{

    color:white;

    background:#2563eb;

}

.btn-save{

    background:linear-gradient(135deg,#10b981,#059669);

    color:white;

    padding:14px 35px;

    border:none;

    border-radius:14px;

    font-weight:bold;

    transition:.3s;

}

.btn-save:hover{

    color:white;

    transform:translateY(-3px);

}

.btn-back{

    background:#ef4444;

    color:white;

    padding:14px 35px;

    border-radius:14px;

    text-decoration:none;

    font-weight:bold;

    margin-left:10px;

}

.btn-back:hover{

    color:white;

    background:#dc2626;

}

</style>

<div class="container py-4">

<div class="form-card">

<div class="form-header">

<h3>
<i class="fas fa-edit"></i>
Modifier Damancom
</h3>

<p>Modification des informations</p>

</div>

<div class="form-body">

<form action="{{ route('damancoms.update',$damancom->id) }}"
      method="POST"
      enctype="multipart/form-data">

@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-4">

<label class="form-label">Nom Complet</label>

<input
type="text"
name="full_name"
class="form-control"
value="{{ old('full_name',$damancom->full_name) }}"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">NIN</label>

<input
type="text"
name="NIN"
class="form-control"
value="{{ old('NIN',$damancom->NIN) }}">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">Téléphone</label>

<input
type="text"
name="phone"
class="form-control"
value="{{ old('phone',$damancom->phone) }}"
required>

</div>

<div class="col-md-6 mb-4">

<label class="form-label">Code</label>

<input
type="text"
name="code"
class="form-control"
value="{{ old('code',$damancom->code) }}">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">Mot de passe</label>

<input
type="text"
name="mot_de_passe"
class="form-control"
value="{{ old('mot_de_passe',$damancom->mot_de_passe) }}">

</div>

<div class="col-md-6 mb-4">

<label class="form-label">

Remplacer le fichier

</label>

<input
type="file"
name="prove_pdf"
class="form-control"
accept=".pdf,.jpg,.jpeg,.png">

</div>
@if($damancom->prove_pdf)

<div class="mt-3">

    <div class="d-flex align-items-center gap-2">

        <a href="{{ asset('storage/damancoms/'.$damancom->prove_pdf) }}"
           target="_blank"
           class="btn btn-primary">

            <i class="fas fa-file-pdf"></i>
            Voir le PDF

        </a>

    </div>

</div>

@endif

</div>

<div class="text-center mt-4">

<button class="btn-save">

<i class="fas fa-save"></i>

 Modifier

</button>

<a href="{{ route('damancoms.index') }}"
class="btn-back">

<i class="fas fa-arrow-left"></i>

 Retour

</a>

</div>

</form>

<form action="{{ route('damancoms.deletePdf', $damancom->id) }}"
      method="POST"
      style="display:inline;">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-danger"
            onclick="return confirm('Supprimer ce PDF ?')">

        <i class="fas fa-trash"></i>
        Supprimer PDF

    </button>

</form>


</div>

</div>

</div>

@endsection