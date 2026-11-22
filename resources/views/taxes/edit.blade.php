@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
    :root{
        --ink: #16213a;
        --slate: #6b7a99;
        --canvas: #f3f6fb;
        --surface: #ffffff;
        --line: #e6ebf3;
        --accent: #4c7ef3;
        --accent-08:#4c7ef314;
        --accent-soft:#eef3ff;
        --success:#2fb380;
        --warn:#e08a3c;
        --warn-08:#e08a3c14;
        --radius:18px;
    }

    body{
        background:var(--canvas);
        font-family:'Tajawal',sans-serif;
        color:var(--ink);
    }

    .tax-wrap{
        max-width:1100px;
        margin:40px auto;
    }

    .tax-card{
        background:var(--surface);
        border:1px solid var(--line);
        border-radius:var(--radius);
        overflow:hidden;
        box-shadow:
            0 1px 2px rgba(22,33,58,0.04),
            0 16px 36px rgba(22,33,58,0.06);
    }

    .tax-head{
        padding:32px 36px 24px;
        background:linear-gradient(135deg,var(--accent-soft),#ffffff);
        border-bottom:1px solid var(--line);
        text-align:center;
    }

    .tax-head h2{
        color:var(--ink);
        font-weight:800;
        margin-bottom:4px;
    }

    .tax-head p{
        color:var(--slate);
        font-size:14px;
        margin:0;
    }

    .tax-body{
        padding:32px 36px;
    }

    label,
    .form-label{
        color:var(--ink);
        font-size:13px;
        font-weight:600;
        margin-bottom:6px;
        display:block;
    }

    .form-control,
    .form-select{
        background:var(--canvas);
        border:1.5px solid var(--line);
        padding:11px 14px;
        border-radius:12px;
        color:var(--ink) !important;
        font-family:inherit;
        font-size:14.5px;
        transition:
            border-color .15s ease,
            box-shadow .15s ease,
            background .15s ease;
    }

    .form-control:focus,
    .form-select:focus{
        background:var(--surface);
        border-color:var(--accent);
        box-shadow:0 0 0 3px var(--accent-08);
        outline:none;
    }

    .form-control::placeholder{
        color:#9aa8c2;
    }

    .section-block{
        background:var(--canvas);
        border:1px solid var(--line);
        border-radius:16px;
        padding:22px;
        height:100%;
    }

    .section-block h5{
        color:var(--accent);
        font-weight:700;
        font-size:16px;
        margin-bottom:18px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .section-panel{
        background:var(--surface);
        border:1.5px solid var(--line);
        border-radius:16px;
        padding:26px;
        margin-top:24px;
    }

    .service-section{
        background:var(--canvas);
        border:1px solid var(--line);
        border-radius:16px;
        padding:22px;
        margin-top:24px;
    }

    .service-section-title{
        color:var(--accent);
        font-weight:800;
        font-size:17px;
        margin-bottom:20px;
        display:flex;
        align-items:center;
        gap:8px;
    }

    .service-option{
        background:var(--surface);
        border:1px solid var(--line);
        border-radius:12px;
        padding:12px 14px;
        height:100%;
        transition:.15s ease;
    }

    .service-option:hover{
        border-color:#cdd8ec;
        box-shadow:0 4px 12px rgba(22,33,58,.04);
    }

    .service-option label{
        margin:0;
        cursor:pointer;
        font-size:14px;
    }

    .service-option input[type="checkbox"]{
        width:18px;
        height:18px;
        cursor:pointer;
        accent-color:var(--accent);
    }

    .service-price{
        color:var(--slate);
        font-size:12px;
        margin-top:3px;
    }

    .annee-box{
        margin-top:12px;
    }

    #results,
    #results-fr{
        border-radius:10px !important;
        overflow:hidden;
        border-color:var(--line) !important;
    }

    #results div,
    #results-fr div{
        background:var(--surface);
        color:var(--ink);
        font-size:14px;
        border-color:var(--line) !important;
        transition:background .12s ease;
    }

    #results div:hover,
    #results-fr div:hover{
        background:var(--accent-08);
    }

    .credit-fields .form-control{
        border-color:var(--warn);
        background:var(--warn-08);
    }

    .credit-label{
        color:var(--warn) !important;
        font-weight:700;
    }

    .document-section{
        background:var(--surface);
        border:1.5px solid var(--line);
        border-radius:16px;
        padding:26px;
        margin-top:24px;
    }

    .document-section h5{
        color:var(--accent);
        font-weight:800;
    }

    .btn-row{
        display:flex;
        gap:10px;
        margin-top:36px;
    }

    .btn-primary-soft{
        background:var(--success);
        color:#fff;
        border:none;
        padding:14px 24px;
        border-radius:12px;
        font-weight:700;
        font-size:15px;
        flex:1;
        transition:background .2s ease,transform .1s ease;
    }

    .btn-primary-soft:hover{
        background:#279c6e;
        color:#fff;
    }

    .btn-primary-soft:active{
        transform:translateY(1px);
    }

    .btn-ghost{
        background:var(--surface);
        color:var(--slate);
        border:1.5px solid var(--line);
        padding:14px 24px;
        border-radius:12px;
        font-weight:700;
        font-size:15px;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        transition:.15s ease;
    }

    .btn-ghost:hover{
        background:var(--canvas);
        border-color:#c9d4e5;
        color:var(--ink);
    }

    @media(max-width:767px){
        .tax-head{
            padding:24px;
        }

        .tax-body{
            padding:22px;
        }
    }
</style>

<div class="container">

<div class="tax-wrap">

<div class="tax-card">

    {{-- HEADER --}}
    <div class="tax-head">

        <h2>✏️ تعديل الملف الضريبي</h2>

        <p>
            تعديل بيانات:
            {{ $tax->first_name }}
            {{ $tax->last_name }}
        </p>

    </div>


    <div class="tax-body">

        <form action="{{ route('taxes.update', $tax->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')


            {{-- ========================================================= --}}
            {{-- المعلومات الشخصية + بيانات النشاط --}}
            {{-- ========================================================= --}}

            <div class="row g-4">

                {{-- المعلومات الشخصية --}}
                <div class="col-md-6">

                    <div class="section-block">

                        <h5>📌 المعلومات الشخصية</h5>

                        <div class="row">

                            <div class="col-6 mb-3">
                                <label>الاسم</label>
                                <input type="text"
                                       name="first_name"
                                       class="form-control"
                                       value="{{ $tax->first_name }}"
                                       required>
                            </div>

                            <div class="col-6 mb-3">
                                <label>اللقب</label>
                                <input type="text"
                                       name="last_name"
                                       class="form-control"
                                       value="{{ $tax->last_name }}"
                                       required>
                            </div>

                            <div class="col-6 mb-3">
                                <label>Prénom</label>
                                <input type="text"
                                       name="first_nameFR"
                                       class="form-control"
                                       value="{{ $tax->first_nameFR }}"
                                       required>
                            </div>

                            <div class="col-6 mb-3">
                                <label>Nom</label>
                                <input type="text"
                                       name="last_nameFR"
                                       class="form-control"
                                       value="{{ $tax->last_nameFR }}"
                                       required>
                            </div>

                            <div class="col-6 mb-3">
                                <label>اسم المستخدم</label>
                                <input type="text"
                                       name="username"
                                       class="form-control"
                                       value="{{ $tax->username }}">
                            </div>

                            <div class="col-6 mb-3">
                                <label>كلمة المرور</label>
                                <input type="text"
                                       name="password"
                                       class="form-control"
                                       value="{{ $tax->password }}">
                            </div>

                        </div>

                    </div>

                </div>


                {{-- بيانات النشاط --}}
                <div class="col-md-6">

                    <div class="section-block">

                        <h5>🏢 بيانات النشاط</h5>

                        <div class="mb-3">

                            <label>عنوان ممارسة النشاط (Arabe)</label>

                            <select id="address_presets"
                                    class="form-select mb-2">

                                <option value="">
                                    -- اختر عنواناً جاهزاً --
                                </option>

                                <option value="تاجر متنقل"
                                    {{ $tax->adrress_activity == 'تاجر متنقل' ? 'selected' : '' }}>
                                    تاجر متنقل
                                </option>

                                <option value="نقل عمومي للبضائع"
                                    {{ $tax->adrress_activity == 'نقل عمومي للبضائع' ? 'selected' : '' }}>
                                    نقل عمومي للبضائع
                                </option>

                            </select>

                            <input type="text"
                                   name="adrress_activity"
                                   id="adrress_activity"
                                   class="form-control"
                                   value="{{ $tax->adrress_activity }}">

                        </div>


                        <div class="mb-3">

                            <label>Adresse (عنوان التاجر)(FR)</label>

                            <input type="text"
                                   name="addres_FR"
                                   class="form-control"
                                   value="{{ $tax->addres_FR }}">

                        </div>

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- البيانات الإضافية --}}
            {{-- ========================================================= --}}

            <div class="section-panel">

                <div class="row g-3">

                    <div class="col-md-3">
                        <label>NIF</label>

                        <input type="text"
                               name="Nif"
                               class="form-control"
                               value="{{ $tax->Nif }}">
                    </div>


                    <div class="col-md-3">
                        <label>NIN</label>

                        <input type="text"
                               name="NIN"
                               class="form-control"
                               value="{{ $tax->NIN }}">
                    </div>


                    <div class="col-md-3">
                        <label>BP (صندوق البريد)</label>

                        <input type="text"
                               name="BP"
                               class="form-control"
                               value="{{ $tax->BP }}">
                    </div>


                    <div class="col-md-3">
                        <label>Matricule</label>

                        <input type="text"
                               name="matricule"
                               class="form-control"
                               value="{{ $tax->matricule }}">
                    </div>


                    <div class="col-md-3">

                        <label>Structure (المصلحة)</label>

                        <select name="structure" class="form-select">

                            <option value="CPI AIN OULMENE"
                                {{ $tax->structure == 'CPI AIN OULMENE' ? 'selected' : '' }}>
                                CPI AIN OULMENE
                            </option>

                            <option value="CPI ELEUMA"
                                {{ $tax->structure == 'CPI ELEUMA' ? 'selected' : '' }}>
                                CPI ELEUMA
                            </option>

                            <option value="CDI ELEUMA"
                                {{ $tax->structure == 'CDI ELEUMA' ? 'selected' : '' }}>
                                CDI ELEUMA
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3">

                        <label>تاريخ بداية النشاط</label>

                        <input type="date"
                               name="date_start"
                               class="form-control"
                               value="{{ $tax->date_start }}">

                    </div>


                    <div class="col-md-3">

                        <label>رقم المادة</label>

                        <input type="text"
                               name="numero_matiere"
                               class="form-control"
                               value="{{ $tax->numero_matiere }}">

                    </div>


                    <div class="col-md-3">

                        <label>رقم الهاتف</label>

                        <input type="text"
                               name="phone"
                               class="form-control"
                               value="{{ $tax->phone }}">

                    </div>


                    <div class="col-md-3">

                        <label>المكان</label>

                        <input type="text"
                               name="place"
                               class="form-control"
                               value="{{ $tax->place }}">

                    </div>


                    {{-- النشاط --}}
                    <div class="col-md-6">

                        <label class="mt-2">
                            النشاط
                        </label>

                        <input type="text"
                               id="code"
                               class="form-control"
                               placeholder="ابحث بالكود">

                        <div id="results"
                             class="border mt-2">
                        </div>

                        <input type="hidden"
                               name="activity_id"
                               id="activity_id"
                               value="{{ $tax->activity_id }}">

                        <input type="text"
                               id="selected_activity"
                               class="form-control mt-2"
                               readonly
                               value="{{ $tax->activity->code ?? '' }} - {{ $tax->activity->activity ?? '' }}">

                    </div>


                    {{-- النشاط FR --}}
                    <div class="col-md-6">

                        <label class="mt-2">
                            النشاط FR
                        </label>

                        <input type="text"
                               id="code-fr"
                               class="form-control"
                               placeholder="ابحث بالكود">

                        <div id="results-fr"
                             class="border mt-2">
                        </div>

                        <input type="hidden"
                               name="activity_fr_id"
                               id="activity_fr_id"
                               value="{{ $tax->activity_fr_id }}">

                        <input type="text"
                               id="selected_activityfr"
                               class="form-control mt-2"
                               readonly
                               value="{{ $tax->activityFr->code ?? '' }} - {{ $tax->activityFr->activity ?? '' }}">

                    </div>


                    <div class="col-md-3">

                        <label>قيمة الضريبة</label>

                        <select name="tax_value"
                                class="form-select">

                            <option value="12"
                                {{ $tax->tax_value == 12 ? 'selected' : '' }}>
                                12%
                            </option>

                            <option value="5"
                                {{ $tax->tax_value == 5 ? 'selected' : '' }}>
                                5%
                            </option>

                            <option value="0.5"
                                {{ $tax->tax_value == 0.5 ? 'selected' : '' }}>
                                0.5%
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3">

                        <label>السنة المالية</label>

                        <input type="number"
                               name="tax_year"
                               class="form-control"
                               value="{{ $tax->tax_year }}"
                               required>

                    </div>


                    <div class="col-md-3">

                        <label>طريقة الدفع</label>

                        <select name="pay_type"
                                id="pay_type_select"
                                class="form-select">

                            <option value="total"
                                {{ $tax->pay_type == 'total' ? 'selected' : '' }}>
                                كامل
                            </option>

                            <option value="credit"
                                {{ $tax->pay_type == 'credit' ? 'selected' : '' }}>
                                دين
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3 credit-fields"
                         style="{{ $tax->pay_type == 'credit' ? '' : 'display:none;' }}">

                        <label class="credit-label">
                            تاريخ استحقاق الدين
                        </label>

                        <input type="date"
                               name="credit_date"
                               class="form-control"
                               value="{{ $tax->credit_date }}">

                    </div>


                    <div class="col-md-3 credit-fields"
                         style="{{ $tax->pay_type == 'credit' ? '' : 'display:none;' }}">

                        <label class="credit-label">
                            المبلغ المالي (DA)
                        </label>

                        <input type="number"
                               step="0.01"
                               name="amount"
                               class="form-control"
                               value="{{ $tax->amount }}">

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- الوثائق القديمة --}}
            {{-- ========================================================= --}}

            <div class="document-section">

                <h5 class="mb-4">
                    📄 الوثائق
                </h5>

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <label>NIF PDF</label>

                        @if($tax->nif_pdf)

                            <div class="mb-2">

                                <a href="{{ asset('storage/'.$tax->nif_pdf) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">

                                    عرض الملف الحالي

                                </a>

                            </div>

                        @endif

                        <input type="file"
                               name="nif_pdf"
                               class="form-control">

                    </div>


                    <div class="col-md-6 mb-3">

                        <label>NIS PDF</label>

                        @if($tax->nis_pdf)

                            <div class="mb-2">

                                <a href="{{ asset('storage/'.$tax->nis_pdf) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">

                                    عرض الملف الحالي

                                </a>

                            </div>

                        @endif

                        <input type="file"
                               name="nis_pdf"
                               class="form-control">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label>G12 PDF</label>

                        @if($tax->g12_pdf)

                            <div class="mb-2">

                                <a href="{{ asset('storage/'.$tax->g12_pdf) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">

                                    عرض الملف الحالي

                                </a>

                            </div>

                        @endif

                        <input type="file"
                               name="g12_pdf"
                               class="form-control">

                    </div>


                    <div class="col-md-4 mb-3">

                        <label>G12 BIS PDF</label>

                        @if($tax->g12bis_pdf)

                            <div class="mb-2">

                                <a href="{{ asset('storage/'.$tax->g12bis_pdf) }}"
                                   target="_blank"
                                   class="btn btn-sm btn-outline-primary">

                                    عرض الملف الحالي

                                </a>

                            </div>

                        @endif

                        <input type="file"
                               name="g12bis_pdf"
                               class="form-control">

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- BUTTONS --}}
            {{-- ========================================================= --}}

            <div class="btn-row">

                <button type="submit"
                        class="btn-primary-soft">

                    💾 تحديث الملف الآن

                </button>

                <a href="{{ route('taxes.index') }}"
                   class="btn-ghost">

                    رجوع

                </a>

            </div>


        </form>

    </div>

</div>

</div>

</div>


{{-- ========================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================
       PAYMENT / CREDIT
    ========================= */

    const payTypeSelect =
        document.getElementById('pay_type_select');

    function toggleCreditFields() {

        const creditFields =
            document.querySelectorAll('.credit-fields');

        const isCredit =
            payTypeSelect.value === 'credit';

        creditFields.forEach(field => {

            field.style.display =
                isCredit ? 'block' : 'none';

            const input =
                field.querySelector('input');

            if (input) {

                if (isCredit) {

                    input.setAttribute(
                        'required',
                        'required'
                    );

                } else {

                    input.removeAttribute(
                        'required'
                    );

                }

            }

        });

    }

    payTypeSelect.addEventListener(
        'change',
        toggleCreditFields
    );

    toggleCreditFields();


    /* =========================
       ADDRESS PRESETS
    ========================= */

    const addressPresets =
        document.getElementById('address_presets');

    if (addressPresets) {

        addressPresets.addEventListener(
            'change',
            function () {

                document.getElementById(
                    'adrress_activity'
                ).value = this.value;

            }
        );

    }


    /* =========================
       SEARCH ACTIVITY AR
    ========================= */

    const codeInput =
        document.getElementById('code');

    if (codeInput) {

        codeInput.addEventListener(
            'input',
            function () {

                let code = this.value;

                if (code.length < 1) {

                    document.getElementById(
                        'results'
                    ).innerHTML = '';

                    return;
                }

                fetch(
                    '/search-activities?code='
                    + encodeURIComponent(code)
                )
                .then(res => res.json())
                .then(data => {

                    let box =
                        document.getElementById(
                            'results'
                        );

                    box.innerHTML = '';

                    data.forEach(item => {

                        let div =
                            document.createElement(
                                'div'
                            );

                        div.innerHTML =
                            item.code +
                            ' - ' +
                            item.activity;

                        div.classList.add(
                            'p-2',
                            'border'
                        );

                        div.style.cursor =
                            'pointer';

                        div.onclick =
                            function () {

                                document.getElementById(
                                    'activity_id'
                                ).value =
                                    item.id;

                                document.getElementById(
                                    'selected_activity'
                                ).value =
                                    item.code +
                                    ' - ' +
                                    item.activity;

                                box.innerHTML =
                                    '';

                            };

                        box.appendChild(div);

                    });

                });

            }
        );

    }


    /* =========================
       SEARCH ACTIVITY FR
    ========================= */

    const codeFrInput =
        document.getElementById('code-fr');

    if (codeFrInput) {

        codeFrInput.addEventListener(
            'input',
            function () {

                let code = this.value;

                if (code.length < 1) {

                    document.getElementById(
                        'results-fr'
                    ).innerHTML = '';

                    return;
                }

                fetch(
                    '/search-activities-fr?code='
                    + encodeURIComponent(code)
                )
                .then(res => res.json())
                .then(data => {

                    let box =
                        document.getElementById(
                            'results-fr'
                        );

                    box.innerHTML = '';

                    data.forEach(item => {

                        let div =
                            document.createElement(
                                'div'
                            );

                        div.innerHTML =
                            item.code +
                            ' - ' +
                            item.activity;

                        div.classList.add(
                            'p-2',
                            'border'
                        );

                        div.style.cursor =
                            'pointer';

                        div.onclick =
                            function () {

                                document.getElementById(
                                    'activity_fr_id'
                                ).value =
                                    item.id;

                                document.getElementById(
                                    'selected_activityfr'
                                ).value =
                                    item.code +
                                    ' - ' +
                                    item.activity;

                                box.innerHTML =
                                    '';

                            };

                        box.appendChild(div);

                    });

                });

            }
        );

    }

});

</script>

@endsection