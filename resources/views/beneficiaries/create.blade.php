@extends('layouts.app')

@section('content')

<form method="POST" enctype="multipart/form-data"  action="{{ route('beneficiaries.store') }}">
    @csrf

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
                    <option value="طلب قيد">طلب قيد</option>
                    <option value="طلب تعديل">طلب تعديل</option>
                </select>
            </div>


            <div class="col-md-6 mb-3">
                <label>التسمية الاجتماعية</label>
                <input type="text" name="social_label" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>هوية الشخص المصرح</label>
                <input type="text" name="authorized_person_identity" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>التسمية الاجتماعية (FR)</label>
                <input type="text" name="social_label_fr" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>هوية الشخص المصرح(FR)</label>
                <input type="text" name="authorized_person_identity_fr" class="form-control">
            </div>

                        <div class="col-md-6 mb-3">
                <label>رقم السجل التجاري</label>
                <input type="text" name="number_of_register" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>هل المستفيد الحقيقي مذكور في السجل التجاري ؟ </label>
                <select name="mentioned" id="mentioned" class="form-control">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>التاريخ الذي اصبح فيه الشخص مستفيدا حقيقيا</label>
                <input type="date" name="date_of_this" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>النسبة</label>
                <input type="number" step="0.01" name="percentage" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>الجنسة(الجنسيات في حال تعددها )</label>
                <input type="text" name="nationalities" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>الجنسة(الجنسيات في حال تعددها )(FR)</label>
                <input type="text" name="nationalities_fr" class="form-control">
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

    <!-- إذا كانت Oui -->
    <div id="full_identity_div">

        <div class="mb-3">
            <label>الهوية الكاملة</label>
            <input type="text" name="full_identity" class="form-control">
        </div>
        
        <div class="mb-3">
            <label>الهوية الكاملة(FR)</label>
            <input type="text" name="full_identity_fr" class="form-control">
        </div>

    </div>

    <!-- إذا كانت Non -->
    <div id="other_fields">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label>الاسم واللقب</label>
                <input type="text" name="full_name" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>الاسم واللقب(FR)</label>
                <input type="text" name="full_name_fr" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>تاريخ الميلاد</label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>مكان الميلاد</label>
                <input type="text" name="place_of_birth" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>مكان الميلاد(FR)</label>
                <input type="text" name="place_of_birth_fr" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>العنوان</label>
                <input type="text" name="address" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>العنوان(FR)</label>
                <input type="text" name="address_fr" class="form-control">
            </div>

            <!-- بطاقة التعريف -->
            <div class="col-md-6 mb-3">
                <label>رقم البطاقة</label>
                <input type="text" name="number_card" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>تاريخ اصدار البطاقة</label>
                <input type="date" name="date1_card" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>تاريخ انتهاء صلاحية البطاقة</label>
                <input type="date" name="date2_card" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>مكان إصدار البطاقة</label>
                <input type="text" name="place_card" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>مكان إصدار البطاقة(FR)</label>
                <input type="text" name="place_card_fr" class="form-control">
            </div>

            <!-- Passeport -->
            <div class="col-md-6 mb-3">
                <label>رقم جواز السفر</label>
                <input type="text" name="number_of_passport" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>تاريخ بداية الجواز</label>
                <input type="date" name="date1_passport" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>تاريخ نهاية الجواز</label>
                <input type="date" name="date2_passport" class="form-control">
            </div>

            <div class="col-md-6 mb-3">
                <label>مكان إصدار الجواز</label>
                <input type="text" name="place_passport" class="form-control">
            </div>
            
            <div class="col-md-6 mb-3">
                <label>مكان إصدار الجواز(FR)</label>
                <input type="text" name="place_passport_fr" class="form-control">
            </div>

            <div class="col-12 mb-3">
                <label>وثيقة أخرى</label>
                <textarea class="form-control" rows="4" name="other_document"></textarea>
            </div>
            
            <div class="col-12 mb-3">
                <label>وثيقة أخرى(FR)</label>
                <textarea class="form-control" rows="4" name="other_document_fr"></textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label>هل يوجد مستفيد حقيقي اخر؟</label>
                <select name="found" class="form-control">
                    <option value="oui">Oui</option>
                    <option value="non">Non</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label>تاريخ التصريح</label>
                <input type="date" name="declaration_date" class="form-control">
            </div>


        </div>

    </div>

</div>

</div>

<!-- PDF -->
<div class="card shadow mb-4">
    <div class="card-header bg-info text-white">
        Pièce jointe
    </div>

    <div class="card-body">
        <div class="col-md-12 mb-3">
            <label>Carte PDF</label>
            <input type="file"
                   name="cart_pdf"
                   class="form-control"
                   accept=".pdf,.jpg,.jpeg,.png">
        </div>
    </div>
</div>


<div class="text-center mb-4">

    <button class="btn btn-success btn-lg">
        Enregistrer
    </button>

    <a href="{{ route('beneficiaries.index') }}" class="btn btn-danger btn-lg">
        Retour
    </a>

</div>

</form>

<script>

function toggleFields()
{
    let mentioned = document.getElementById('mentioned').value;

    if(mentioned=="oui")
    {
        document.getElementById('full_identity_div').style.display='block';
        document.getElementById('other_fields').style.display='none';
    }
    else
    {
        document.getElementById('full_identity_div').style.display='none';
        document.getElementById('other_fields').style.display='block';
    }
}

document.getElementById('mentioned').addEventListener('change',toggleFields);

toggleFields();

</script>
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

    document.getElementById('mentioned')
        .addEventListener('change', toggleFields);

});

</script>

@endsection
