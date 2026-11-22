@extends('layouts.app')

@section('content')

<form method="POST" enctype="multipart/form-data" action="{{ route('beneficiaries.update', $beneficiary->id) }}">    @csrf
    @method('PUT')

<!-- Informations générales -->
<div class="card shadow mb-4">
    <div class="card-header bg-primary text-white">
        Informations générales
    </div>

    <div class="card-body">
        <div class="row">
     <div class="col-md-6 mb-3">
                    <label>السجل التجاري</label>
                    <select name="demande" class="form-control">
                        <option value="طلب قيد" {{ $beneficiary->found == 'طلب قيد' ? 'selected' : '' }}>طلب قيد</option>
                        <option value="طلب تعديل" {{ $beneficiary->found == 'طلب تعديل' ? 'selected' : '' }}>طلب تعديل</option>
                    </select>
                </div>

            <div class="col-md-6 mb-3">
                <label>التسمية الاجتماعية</label>
                <input type="text" name="social_label" class="form-control"
                    value="{{ old('social_label', $beneficiary->social_label) }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>التسمية الاجتماعية(FR)</label>
                <input type="text" name="social_label_fr" class="form-control"
                    value="{{ old('social_label_fr', $beneficiary->social_label_fr) }}">
            </div>


            <div class="col-md-6 mb-3">
                <label>هوية الشخص المصرح</label>
                <input type="text" name="authorized_person_identity" class="form-control"
                    value="{{ old('authorized_person_identity', $beneficiary->authorized_person_identity) }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>هوية الشخص المصرح(FR)</label>
                <input type="text" name="authorized_person_identity_fr" class="form-control"
                    value="{{ old('authorized_person_identity_fr', $beneficiary->authorized_person_identity_fr) }}">
            </div>
                       <div class="col-md-6 mb-3">
                <label>رقم السجل التجاري</label>
                <input type="text" name="number_of_register" class="form-control"
                    value="{{ old('number_of_register', $beneficiary->number_of_register) }}">
            </div>


            <div class="col-md-6 mb-3">
                <label>هل المستفيد الحقيقي مذكور في السجل التجاري ؟</label>
                <select name="mentioned" id="mentioned" class="form-control">
                    <option value="oui" {{ $beneficiary->mentioned == 'oui' ? 'selected' : '' }}>Oui</option>
                    <option value="non" {{ $beneficiary->mentioned == 'non' ? 'selected' : '' }}>Non</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>التاريخ الذي اصبح فيه الشخص مستفيدا حقيقيا</label>
                <input type="date" name="date_of_this" class="form-control"
                    value="{{ old('date_of_this', $beneficiary->date_of_this) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>النسبة</label>
                <input type="number" step="0.01" name="percentage" class="form-control"
                    value="{{ old('percentage', $beneficiary->percentage) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>الجنسيات</label>
                <input type="text" name="nationalities" class="form-control"
                    value="{{ old('nationalities', $beneficiary->nationalities) }}">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>الجنسيات(FR)</label>
                <input type="text" name="nationalities_fr" class="form-control"
                    value="{{ old('nationalities_fr', $beneficiary->nationalities_fr) }}">
            </div>

        </div>
    </div>
</div>

<!-- Informations du bénéficiaire -->
<div class="card shadow mb-4">
    <div class="card-header bg-success text-white">
        Informations du bénéficiaire
    </div>

    <div class="card-body">

        <!-- full identity -->

        <div id="full_identity_div">
            <div class="mb-3">
                <label>الهوية الكاملة</label>
                <input type="text" name="full_identity" class="form-control"
                    value="{{ old('full_identity', $beneficiary->full_identity) }}">
            </div>
               <div class="mb-3">
                <label>الهوية الكاملة(FR)</label>
                <input type="text" name="full_identity_fr" class="form-control"
                    value="{{ old('full_identity_fr', $beneficiary->full_identity_fr) }}">
            </div>
        </div>

        <!-- other fields -->
        <div id="other_fields">

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label>الاسم واللقب</label>
                    <input type="text" name="full_name" class="form-control"
                        value="{{ old('full_name', $beneficiary->full_name) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>الاسم واللقب(FR)</label>
                    <input type="text" name="full_name_fr" class="form-control"
                        value="{{ old('full_name_fr', $beneficiary->full_name_fr) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاريخ الميلاد</label>
                    <input type="date" name="date_of_birth" class="form-control"
                        value="{{ old('date_of_birth', $beneficiary->date_of_birth) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>مكان الميلاد</label>
                    <input type="text" name="place_of_birth" class="form-control"
                        value="{{ old('place_of_birth', $beneficiary->place_of_birth) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>مكان الميلاد(fr)</label>
                    <input type="text" name="place_of_birth_fr" class="form-control"
                        value="{{ old('place_of_birth_fr', $beneficiary->place_of_birth_fr) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>العنوان</label>
                    <input type="text" name="address" class="form-control"
                        value="{{ old('address', $beneficiary->address) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>العنوان(FR)</label>
                    <input type="text" name="address_fr" class="form-control"
                        value="{{ old('address_fr', $beneficiary->address_fr) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>رقم البطاقة</label>
                    <input type="text" name="number_card" class="form-control"
                        value="{{ old('number_card', $beneficiary->number_card) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاريخ إصدار البطاقة</label>
                    <input type="date" name="date1_card" class="form-control"
                        value="{{ old('date1_card', $beneficiary->date1_card) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاريخ انتهاء البطاقة</label>
                    <input type="date" name="date2_card" class="form-control"
                        value="{{ old('date2_card', $beneficiary->date2_card) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>مكان إصدار البطاقة</label>
                    <input type="text" name="place_card" class="form-control"
                        value="{{ old('place_card', $beneficiary->place_card) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>مكان إصدار البطاقة(FR)</label>
                    <input type="text" name="place_card_fr" class="form-control"
                        value="{{ old('place_card_fr', $beneficiary->place_card_fr) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>رقم جواز السفر</label>
                    <input type="text" name="number_of_passport" class="form-control"
                        value="{{ old('number_of_passport', $beneficiary->number_of_passport) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاريخ بداية الجواز</label>
                    <input type="date" name="date1_passport" class="form-control"
                        value="{{ old('date1_passport', $beneficiary->date1_passport) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>تاريخ نهاية الجواز</label>
                    <input type="date" name="date2_passport" class="form-control"
                        value="{{ old('date2_passport', $beneficiary->date2_passport) }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>مكان إصدار الجواز</label>
                    <input type="text" name="place_passport" class="form-control"
                        value="{{ old('place_passport', $beneficiary->place_passport) }}">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>مكان إصدار الجواز(FR)</label>
                    <input type="text" name="place_passport_fr" class="form-control"
                        value="{{ old('place_passport_fr', $beneficiary->place_passport_fr) }}">
                </div>

                <div class="col-12 mb-3">
                    <label>وثيقة أخرى</label>
                    <textarea class="form-control" name="other_document" rows="4">{{ old('other_document', $beneficiary->other_document) }}</textarea>
                </div>
                
                <div class="col-12 mb-3">
                    <label>وثيقة أخرى(FR)</label>
                    <textarea class="form-control" name="other_document_fr" rows="4">{{ old('other_document', $beneficiary->other_document_fr) }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>هل يوجد مستفيد آخر؟</label>
                    <select name="found" class="form-control">
                        <option value="oui" {{ $beneficiary->found == 'oui' ? 'selected' : '' }}>Oui</option>
                        <option value="non" {{ $beneficiary->found == 'non' ? 'selected' : '' }}>Non</option>
                    </select>
                </div>
                 <div class="col-md-6 mb-3">
                <label>تاريخ التصريح</label>
                <input type="date" name="declaration_date" class="form-control"
                    value="{{ old('declaration_date', $beneficiary->declaration_date) }}">
            </div>


            </div>

        </div>

    </div>
</div>
@if($beneficiary->cart_pdf)
<div class="mb-3">
    <label>Fichier actuel</label><br>

    <a href="{{ asset('storage/beneficiaries/'.$beneficiary->cart_pdf) }}"
       target="_blank"
       class="btn btn-primary">
        <i class="fas fa-eye"></i> Voir le fichier
    </a>
</div>
@endif
        <div class="mb-3">
            <label>Carte (PDF / JPG / PNG)</label>
            <input type="file"
                   name="cart_pdf"
                   class="form-control"
                   accept=".pdf,.jpg,.jpeg,.png">
            <small class="text-muted">
                Laissez vide si vous ne voulez pas changer le fichier.
            </small>
        </div>

    </div>
</div>


<div class="text-center mb-4">

    <button class="btn btn-primary btn-lg">
        Modifier
    </button>

    <a href="{{ route('beneficiaries.index') }}" class="btn btn-danger btn-lg">
        Retour
    </a>

</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function toggleFields() {
        let val = document.getElementById('mentioned').value;

        if (val === 'oui') {
            document.getElementById('full_identity_div').style.display = 'block';
            document.getElementById('other_fields').style.display = 'none';
        } else {
            document.getElementById('full_identity_div').style.display = 'none';
            document.getElementById('other_fields').style.display = 'block';
        }
    }

    toggleFields();
    document.getElementById('mentioned').addEventListener('change', toggleFields);

});
</script>

@endsection