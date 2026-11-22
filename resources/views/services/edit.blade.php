@extends('layouts.app')

@section('content')

@php
    $servicePrices = $servicePrices ?? [];
    $formatPrice = function ($key, $fallback) use ($servicePrices) {
        return number_format((float) ($servicePrices[$key] ?? $fallback), 0, '.', ' ');
    };
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

<style>
    :root{
        --ink:      #0f172a;
        --slate:    #64748b;
        --canvas:   #f4f5f7;
        --surface:  #ffffff;
        --line:     #e5e7eb;
        --accent:   #0d6e63;
        --accent-08:#0d6e6314;
        --radius:   16px;
    }

    body{
        background: var(--canvas);
        font-family:'Tajawal', sans-serif;
    }

    .service-container{
        background: var(--surface);
        padding: 40px;
        border-radius: 20px;
        box-shadow:
            0 1px 2px rgba(15,23,42,0.04),
            0 12px 32px rgba(15,23,42,0.06);
        max-width: 1200px;
        margin: 36px auto;
        border: 1px solid var(--line);
    }

    .page-title{
        color: var(--ink);
        font-weight: 800;
        text-align: center;
        letter-spacing: -0.01em;
        margin-bottom: 6px;
    }

    .page-subtitle{
        text-align: center;
        color: var(--slate);
        font-size: 14px;
        margin-bottom: 32px;
    }

    /* ---- الحقول العامة ---- */

    .form-control,
    .form-select{
        background: var(--canvas);
        border: 1.5px solid var(--line);
        padding: 12px 14px;
        border-radius: 12px;
        color: var(--ink);
        font-family: inherit;
        transition:
            border-color .15s ease,
            box-shadow .15s ease,
            background .15s ease;
    }

    .form-control:focus,
    .form-select:focus{
        background: var(--surface);
        border-color: var(--accent);
        box-shadow: 0 0 0 3px var(--accent-08);
        outline: none;
    }

    .form-control::placeholder{ color: #94a3b8; }

    .form-label{ color: var(--ink); font-size: 13px; font-weight: 600; margin-bottom: 6px; }

    .search-wrap{ position: relative; }

    .search-wrap .form-control{ padding-inline-start: 42px; }

    .search-icon{
        position:absolute;
        top:50%;
        transform:translateY(-50%);
        inset-inline-start: 14px;
        color: var(--slate);
        pointer-events:none;
        font-size: 15px;
    }

    #subscriberResults{
        display:flex;
        flex-direction:column;
        gap:8px;
    }

    .subscriber-item{
        background: var(--surface);
        border: 1.5px solid var(--line) !important;
        border-radius: 12px !important;
        padding: 10px 14px !important;
        color: var(--ink) !important;
        text-decoration: none;
        display:block;
        transition:
            border-color .15s ease,
            background .15s ease;
    }

    .subscriber-item:hover{
        border-color: var(--accent) !important;
        background: var(--accent-08);
    }

    .subscriber-item strong{ color: var(--ink); }

    .alert{
        border-radius: 12px;
        border: 1.5px solid var(--line);
        background: var(--canvas);
        color: var(--ink);
        font-size: 14px;
        padding: 10px 14px;
    }

    /* ---- الكروت ---- */

    .section-card{
        background: var(--surface);
        border: 1.5px solid var(--line);
        border-radius: var(--radius);
        height: 100%;
        overflow: hidden;
        transition:
            box-shadow .2s ease,
            border-color .2s ease;
    }

    .section-card:hover{
        box-shadow: 0 8px 20px rgba(15,23,42,0.06);
        border-color:#d7dbe1;
    }

    .section-header{
        display:flex;
        align-items:center;
        gap:10px;
        padding: 16px 18px;
        border-bottom: 1.5px solid var(--line);
        background: var(--canvas);
    }

    .section-header .dot{
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--accent);
        flex: none;
    }

    .section-header .label{
        font-weight: 700;
        color: var(--ink);
        font-size: 15.5px;
    }

    .section-body{
        padding: 18px;
        display:flex;
        flex-direction:column;
        gap:12px;
    }

    .field-check{
        display:flex;
        align-items:center;
        gap:10px;
        padding: 4px 0;
    }

    .field-check input[type="checkbox"]{
        width: 18px;
        height: 18px;
        border-radius: 5px;
        border: 1.5px solid #cbd5e1;
        accent-color: var(--accent);
        cursor: pointer;
        margin: 0;
        flex: none;
    }

    .field-check label{
        color: var(--ink);
        font-size: 14.5px;
        cursor: pointer;
        margin: 0;
    }

    .field-number label{
        display:block;
        font-size: 13px;
        color: var(--slate);
        margin-top: 4px;
    }

    .field-select label{
        display:block;
        font-size: 13px;
        color: var(--slate);
        margin-bottom: 6px;
        font-weight: 500;
    }

    hr.section-divider{
        border: none;
        border-top: 1px dashed var(--line);
        margin: 2px 0;
    }

    .year-note{
        font-size: 12px;
        color: var(--slate);
        margin-top: -5px;
        line-height: 1.5;
    }

    .service-price{
        display:inline-block;
        margin-inline-start:8px;
        padding:3px 8px;
        border-radius:999px;
        background:var(--accent-08);
        color:var(--accent);
        font-size:11.5px;
        font-weight:700;
        white-space:nowrap;
    }

    .total-box{
        margin-top:30px;
        padding:20px 22px;
        border:1.5px solid var(--accent);
        border-radius:16px;
        background:linear-gradient(135deg,#f0fdfa,#ffffff);
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:20px;
    }

    .total-label{
        color:var(--ink);
        font-size:18px;
        font-weight:800;
    }

    .total-note{
        color:var(--slate);
        font-size:12px;
        margin-top:4px;
    }

    .total-value{
        color:var(--accent);
        font-size:30px;
        font-weight:800;
        white-space:nowrap;
    }

    .total-value small{
        font-size:15px;
        font-weight:700;
    }

    /* ---- زر التحديث ---- */

    .btn-save{
        background: var(--ink);
        color: #f8fafc;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        font-family: inherit;
        border: none;
        width: 100%;
        font-size: 17px;
        letter-spacing: .01em;
        margin-top: 32px;
        transition:
            background .2s ease,
            transform .1s ease;
    }

    .btn-save:hover{ background: var(--accent); }

    .btn-save:active{ transform: translateY(1px); }

    .row-fields{ margin-bottom: 28px; }

    @media (max-width:767px){
        .service-container{ padding: 22px; margin: 16px; }

        .service-price{
            display:block;
            width:max-content;
            margin-inline-start:0;
            margin-top:4px;
        }

        .total-box{
            flex-direction:column;
            align-items:flex-start;
        }

        .total-value{ font-size:26px; }
    }
</style>

<div class="container">

    <form action="{{ route('services.update', $service->id) }}"
          method="POST"
          id="serviceForm"
          class="service-container">

        @csrf
        @method('PUT')

        <input type="hidden" name="is_subscriber" id="is_subscriber" value="{{ (int) $service->is_subscriber }}">

        <h3 class="page-title">تعديل الخدمة</h3>
        <p class="page-subtitle">حدّث بيانات المشترك أو الخدمات المطلوبة</p>

        {{-- ========================================================= --}}
        {{-- معلومات المشترك --}}
        {{-- ========================================================= --}}

        <div class="row row-fields g-3">

            <div class="col-md-12">
                <label class="form-label">بحث عن مشترك</label>
                <div class="search-wrap">
                    <span class="search-icon">🔍</span>
                    <input
                        type="text"
                        id="subscriberSearch"
                        class="form-control"
                        placeholder="الاسم أو رقم الهاتف">
                </div>
                <div id="subscriberResults" class="mt-2"></div>
            </div>

            <div class="col-md-4">
                <label class="form-label">الاسم الكامل</label>
                <input type="text" id="full_name" name="full_name" class="form-control"
                       value="{{ old('full_name', $service->full_name) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">رقم الهاتف</label>
                <input type="text" id="phone" name="phone" class="form-control"
                       value="{{ old('phone', $service->phone) }}">
            </div>

            <div class="col-md-4">
                <label class="form-label">التاريخ</label>
                <input type="date" name="service_date" class="form-control"
                       value="{{ old('service_date', $service->service_date) }}">
            </div>

            <div class="col-md-12">
                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="form-control"
                       value="{{ old('address', $service->address) }}">
            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- 4 SECTIONS --}}
        {{-- ========================================================= --}}

        <div class="row g-4">


            {{-- ===================================================== --}}
            {{-- 1. السجل التجاري --}}
            {{-- ===================================================== --}}

            <div class="col-md-6 col-lg-3">

                <div class="section-card">

                    <div class="section-header">
                        <span class="dot"></span>
                        <span class="label">السجل التجاري</span>
                    </div>

                    <div class="section-body">

                        <div class="field-check">
                            <input type="checkbox" name="sijil_moutanaiqil" id="sijil_moutanaiqil" value="1"
                                   {{ $service->sijil_moutanaiqil ? 'checked' : '' }}>
                            <label for="sijil_moutanaiqil">متنقل <span class="service-price">{{ $formatPrice('sijil_moutanaiqil', 11000) }} DA</span></label>
                        </div>

                        <div class="field-number">
                            <input type="number" name="sijil_ramz_count" id="sijil_ramz_count" class="form-control"
                                   value="{{ old('sijil_ramz_count', $service->sijil_ramz_count) }}"
                                   placeholder="عدد الرموز" min="0">
                            <label>سعر الرمز <span class="service-price">{{ $formatPrice('sijil_ramz_unit', 240) }} DA / رمز</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="naql_badaie" id="naql_badaie" value="1"
                                   {{ $service->naql_badaie ? 'checked' : '' }}>
                            <label for="naql_badaie">نقل بضائع <span class="service-price">{{ $formatPrice('naql_badaie', 14000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="hanout" id="hanout" value="1"
                                   {{ $service->hanout ? 'checked' : '' }}>
                            <label for="hanout">حانوت <span class="service-price">{{ $formatPrice('hanout', 15000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="sina3a" id="sina3a" value="1"
                                   {{ $service->sina3a ? 'checked' : '' }}>
                            <label for="sina3a">صناعة <span class="service-price">{{ $formatPrice('sina3a', 16000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="eljemla" id="eljemla" value="1"
                                   {{ $service->eljemla ? 'checked' : '' }}>
                            <label for="eljemla">الجملة <span class="service-price">{{ $formatPrice('eljemla', 16000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="wakala" id="wakala" value="1"
                                   {{ $service->wakala ? 'checked' : '' }}>
                            <label for="wakala">وكالة <span class="service-price">{{ $formatPrice('wakala', 2000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="tamdid_salahya" id="tamdid_salahya" value="1"
                                   {{ $service->tamdid_salahya ? 'checked' : '' }}>
                            <label for="tamdid_salahya">تمديد الصلاحية <span class="service-price">{{ $formatPrice('tamdid_salahya', 18000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="istirad" id="istirad" value="1"
                                   {{ $service->istirad ? 'checked' : '' }}>
                            <label for="istirad">استيراد <span class="service-price">{{ $formatPrice('istirad', 45000) }} DA</span></label>
                        </div>

                        <div class="field-number">
                            <input type="number" name="mosada9a" id="mosada9a" class="form-control"
                                   value="{{ old('mosada9a', $service->mosada9a) }}"
                                   placeholder="عدد المصادقات" min="0">
                            <label>
                                مصادقة
                                <span class="service-price">1 = {{ $formatPrice('mosada9a_one', 1500) }} DA / أكثر = {{ $formatPrice('mosada9a_multiple', 1200) }} DA للواحدة</span>
                            </label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="ta3dil" id="ta3dil" value="1"
                                   {{ $service->ta3dil ? 'checked' : '' }}>
                            <label for="ta3dil">تعديل <span class="service-price">{{ $formatPrice('ta3dil', 13000) }} DA</span></label>
                        </div>

                        <hr class="section-divider">

                        {{-- الخدمات الجديدة للسجل التجاري --}}

                        <div class="field-check">
                            <input type="checkbox" name="creation_CA" id="creation_CA" value="1"
                                   {{ $service->creation_CA ? 'checked' : '' }}>
                            <label for="creation_CA">إنشاء بطاقة الحرفي <span class="service-price">{{ $formatPrice('creation_CA', 11000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="creation_dplm_CA" id="creation_dplm_CA" value="1"
                                   {{ $service->creation_dplm_CA ? 'checked' : '' }}>
                            <label for="creation_dplm_CA">إنشاء ديبلوم بطاقة الحرفي <span class="service-price">{{ $formatPrice('creation_dplm_CA', 11000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="annulation_CA" id="annulation_CA" value="1"
                                   {{ $service->annulation_CA ? 'checked' : '' }}>
                            <label for="annulation_CA">شطب بطاقة الحرفي <span class="service-price">{{ $formatPrice('annulation_CA', 11000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="efficacite" id="efficacite" value="1"
                                   {{ $service->efficacite ? 'checked' : '' }}>
                            <label for="efficacite">الكفاءة <span class="service-price">{{ $formatPrice('efficacite', 30000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="khidma_ijer_mahal" id="khidma_ijer_mahal" value="1"
                                   {{ $service->khidma_ijer_mahal ? 'checked' : '' }}>
                            <label for="khidma_ijer_mahal">خدمة إيجار محل <span class="service-price">{{ $formatPrice('khidma_ijer_mahal', 3000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="ta3dil_CA" id="ta3dil_CA" value="1"
                                   {{ $service->ta3dil_CA ? 'checked' : '' }}>
                            <label for="ta3dil_CA">تعديل بطاقة الحرفي <span class="service-price">{{ $formatPrice('ta3dil_CA_base', 11000) }} DA + حسب السنة</span></label>
                        </div>

                        <div class="field-number">
                            <input type="number" name="anne_de_modification" id="anne_de_modification"
                                   class="form-control" placeholder="سنة التعديل"
                                   min="1900" max="{{ now()->year }}"
                                   value="{{ old('anne_de_modification', $service->anne_de_modification) }}">
                            <div class="year-note">مثال: 2024</div>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ===================================================== --}}
            {{-- 2. الضرائب + Visa --}}
            {{-- ===================================================== --}}

            <div class="col-md-6 col-lg-3">

                <div class="section-card">

                    <div class="section-header">
                        <span class="dot"></span>
                        <span class="label">visa + الضرائب</span>
                    </div>

                    <div class="section-body">

                        <div class="field-check">
                            <input type="checkbox" name="casnos" id="casnos" value="1"
                                   {{ $service->casnos ? 'checked' : '' }}>
                            <label for="casnos">CASNOS <span class="service-price">{{ $formatPrice('casnos', 1500) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="carte_chifa" id="carte_chifa" value="1"
                                   {{ $service->carte_chifa ? 'checked' : '' }}>
                            <label for="carte_chifa">بطاقة الشفاء <span class="service-price">{{ $formatPrice('carte_chifa', 500) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="nif" id="nif" value="1"
                                   {{ $service->nif ? 'checked' : '' }}>
                            <label for="nif">NIF <span class="service-price">{{ $formatPrice('nif', 800) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="nif_plus_g08" id="nif_plus_g08" value="1"
                                   {{ $service->nif_plus_g08 ? 'checked' : '' }}>
                            <label for="nif_plus_g08">NIF + G08 <span class="service-price">{{ $formatPrice('nif_plus_g08', 1000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="g12_price" id="g12_price" value="1"
                                   {{ $service->g12_price ? 'checked' : '' }}>
                            <label for="g12_price">G12 <span class="service-price">{{ $formatPrice('g12_price', 1200) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="g12bis_price" id="g12bis_price" value="1"
                                   {{ $service->g12bis_price ? 'checked' : '' }}>
                            <label for="g12bis_price">G12bis <span class="service-price">{{ $formatPrice('g12bis_price', 1200) }} DA</span></label>
                        </div>

                        <div class="field-select">
                            <label for="tarjama_register">
                                ترجمة السجل التجاري
                                <span class="service-price">1 = {{ $formatPrice('tarjama_register_1', 1800) }} DA · 2 = {{ $formatPrice('tarjama_register_2', 2400) }} DA</span>
                            </label>
                            <select name="tarjama_register" id="tarjama_register" class="form-select">
                                <option value="0" {{ $service->tarjama_register == 0 ? 'selected' : '' }}>لا يوجد</option>
                                <option value="1" {{ $service->tarjama_register == 1 ? 'selected' : '' }}>1 — {{ $formatPrice('tarjama_register_1', 1800) }} DA</option>
                                <option value="2" {{ $service->tarjama_register == 2 ? 'selected' : '' }}>2 — {{ $formatPrice('tarjama_register_2', 2400) }} DA</option>
                            </select>
                        </div>

                        <hr class="section-divider">

                        <div class="field-check">
                            <input type="checkbox" name="tarjamat_sawabi9" value="1" id="tarjamat_sawabi9"
                                   {{ $service->tarjamat_sawabi9 ? 'checked' : '' }}>
                            <label for="tarjamat_sawabi9">ترجمة السوابق العدلية <span class="service-price">{{ $formatPrice('tarjamat_sawabi9', 1400) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="talab_c20" value="1" id="talab_c20"
                                   {{ $service->talab_c20 ? 'checked' : '' }}>
                            <label for="talab_c20">طلب C20 <span class="service-price">{{ $formatPrice('talab_c20', 4000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="kachf_hisseb" value="1" id="kachf_hisseb"
                                   {{ $service->kachf_hisseb ? 'checked' : '' }}>
                            <label for="kachf_hisseb">كشف الحساب <span class="service-price">{{ $formatPrice('kachf_hisseb', 3000) }} DA</span></label>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ===================================================== --}}
            {{-- 3. خدمات أخرى + الختم --}}
            {{-- ===================================================== --}}

            <div class="col-md-6 col-lg-3">

                <div class="section-card">

                    <div class="section-header">
                        <span class="dot"></span>
                        <span class="label">خدمات أخرى</span>
                    </div>

                    <div class="section-body">

                        <div class="field-check">
                            <input type="checkbox" name="nis" id="nis" value="1"
                                   {{ $service->nis ? 'checked' : '' }}>
                            <label for="nis">NIS <span class="service-price">{{ $formatPrice('nis', 4800) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="inapi" id="inapi" value="1"
                                   {{ $service->inapi ? 'checked' : '' }}>
                            <label for="inapi">INAPI <span class="service-price">{{ $formatPrice('inapi', 11000) }} DA</span></label>
                        </div>

                        <div class="field-number">
                            <input type="number" name="logo_price" id="logo_price" class="form-control"
                                   value="{{ old('logo_price', $service->logo_price) }}"
                                   placeholder="سعر Logo" min="0">
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="coderbar" id="coderbar" value="1"
                                   {{ $service->coderbar ? 'checked' : '' }}>
                            <label for="coderbar">Codebar <span class="service-price">{{ $formatPrice('coderbar_base', 11000) }} DA + {{ $formatPrice('coderbar_product', 500) }} DA/منتج</span></label>
                        </div>

                        <div class="field-number">
                            <input type="number" name="coderbar_products_count" id="coderbar_products_count" class="form-control"
                                   value="{{ old('coderbar_products_count', $service->coderbar_products_count) }}"
                                   placeholder="عدد المنتجات" min="0">
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="moudirya_naql" id="moudirya_naql" value="1"
                                   {{ $service->moudirya_naql ? 'checked' : '' }}>
                            <label for="moudirya_naql">permis cerculaire <span class="service-price">{{ $formatPrice('moudirya_naql', 5000) }} DA</span></label>
                        </div>

                        <hr class="section-divider">

                        <div class="field-select">
                            <label for="khatm_type">
                                نوع الختم <span class="service-price">حسب النوع × التصديقات</span>
                            </label>
                            <select name="khatm_type" id="khatm_type" class="form-select">
                                <option value="بدون ختم" {{ $service->khatm_type == 'بدون ختم' ? 'selected' : '' }}>بدون ختم — 0 DA</option>
                                <option value="11" {{ $service->khatm_type == '11' ? 'selected' : '' }}>11 — {{ $formatPrice('khatm_11', 1400) }} DA</option>
                                <option value="12" {{ $service->khatm_type == '12' ? 'selected' : '' }}>12 — {{ $formatPrice('khatm_12', 1700) }} DA</option>
                                <option value="13" {{ $service->khatm_type == '13' ? 'selected' : '' }}>13 — {{ $formatPrice('khatm_13', 2100) }} DA</option>
                                <option value="14" {{ $service->khatm_type == '14' ? 'selected' : '' }}>14 — {{ $formatPrice('khatm_14', 2900) }} DA</option>
                                <option value="15" {{ $service->khatm_type == '15' ? 'selected' : '' }}>15 — {{ $formatPrice('khatm_15', 3500) }} DA</option>
                                <option value="42" {{ $service->khatm_type == '42' ? 'selected' : '' }}>42 — {{ $formatPrice('khatm_42', 3200) }} DA</option>
                            </select>
                        </div>

                        {{-- عدد التصديقات تحت الختم --}}
                        <div class="field-select">
                            <label for="number_of_galization">عدد التصديقات</label>
                            <select name="number_of_galization" id="number_of_galization" class="form-select">
                                <option value="1" {{ $service->number_of_galization == 1 ? 'selected' : '' }}>1</option>
                                <option value="2" {{ $service->number_of_galization == 2 ? 'selected' : '' }}>2</option>
                            </select>
                        </div>

                        <div class="field-select">
                            <label for="cnas_type">
                                CNAS <span class="service-price">{{ $formatPrice('cnas_abattement', 15000) }} / {{ $formatPrice('cnas_sans_abattement', 12000) }} DA</span>
                            </label>
                            <select name="cnas_type" id="cnas_type" class="form-select">
                                <option value="0" {{ $service->cnas_type == '0' ? 'selected' : '' }}>بدون CNAS</option>
                                <option value="1" {{ $service->cnas_type == '1' ? 'selected' : '' }}>CNAS Abatment — {{ $formatPrice('cnas_abattement', 15000) }} DA</option>
                                <option value="2" {{ $service->cnas_type == '2' ? 'selected' : '' }}>San Abotment — {{ $formatPrice('cnas_sans_abattement', 12000) }} DA</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ===================================================== --}}
            {{-- 4. الشركات --}}
            {{-- ===================================================== --}}

            <div class="col-md-6 col-lg-3">

                <div class="section-card">

                    <div class="section-header">
                        <span class="dot"></span>
                        <span class="label">الشركات</span>
                    </div>

                    <div class="section-body">

                        <div class="field-check">
                            <input type="checkbox" name="tasmya" id="tasmya" value="1"
                                   {{ $service->tasmya ? 'checked' : '' }}>
                            <label for="tasmya">تسمية <span class="service-price">{{ $formatPrice('tasmya', 1500) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="tarjamat_boal" id="tarjamat_boal" value="1"
                                   {{ $service->tarjamat_boal ? 'checked' : '' }}>
                            <label for="tarjamat_boal">ترجمة Boal <span class="service-price">{{ $formatPrice('tarjamat_boal', 3000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="ichhar_boal" id="ichhar_boal" value="1"
                                   {{ $service->ichhar_boal ? 'checked' : '' }}>
                            <label for="ichhar_boal">إشهار Boal <span class="service-price">{{ $formatPrice('ichhar_boal', 10000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="creation_entreprise" id="creation_entreprise" value="1"
                                   {{ $service->creation_entreprise ? 'checked' : '' }}>
                            <label for="creation_entreprise">تأسيس شركة <span class="service-price">{{ $formatPrice('creation_entreprise', 45000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="chahedat_ihtiram" id="chahedat_ihtiram" value="1"
                                   {{ $service->chahedat_ihtiram ? 'checked' : '' }}>
                            <label for="chahedat_ihtiram">شهادة احترام <span class="service-price">{{ $formatPrice('chahedat_ihtiram', 10000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="nif_alces" id="nif_alces" value="1"
                                   {{ $service->nif_alces ? 'checked' : '' }}>
                            <label for="nif_alces">NIF ALCES <span class="service-price">{{ $formatPrice('nif_alces', 10000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="nif_dowan" id="nif_dowan" value="1"
                                   {{ $service->nif_dowan ? 'checked' : '' }}>
                            <label for="nif_dowan">NIF الديوان <span class="service-price">{{ $formatPrice('nif_dowan', 3000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="g50" id="g50" value="1"
                                   {{ $service->g50 ? 'checked' : '' }}>
                            <label for="g50">G50 <span class="service-price">{{ $formatPrice('g50', 1000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="irg_salaire" id="irg_salaire" value="1"
                                   {{ $service->irg_salaire ? 'checked' : '' }}>
                            <label for="irg_salaire">IRG الأجر <span class="service-price">{{ $formatPrice('irg_salaire', 1000) }} DA</span></label>
                        </div>

                        <div class="field-check">
                            <input type="checkbox" name="tva" id="tva" value="1"
                                   {{ $service->tva ? 'checked' : '' }}>
                            <label for="tva">TVA <span class="service-price">{{ $formatPrice('tva', 1000) }} DA</span></label>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- TOTAL AUTOMATIQUE --}}
        {{-- ========================================================= --}}

        <div class="total-box">
            <div>
                <div class="total-label">المجموع الإجمالي</div>
                <div class="total-note">يتحدث تلقائياً حسب الخدمات والكمية المختارة</div>
            </div>
            <div class="total-value">
                <span id="serviceTotal">0</span> <small>DA</small>
            </div>
        </div>

        <button type="submit" class="btn-save">تحديث البيانات</button>

    </form>

</div>


{{-- ============================================================= --}}
{{-- البحث عن مشترك --}}
{{-- ============================================================= --}}

<script>
const search = document.getElementById('subscriberSearch');
const results = document.getElementById('subscriberResults');
const fullName = document.getElementById('full_name');
const phone = document.getElementById('phone');
const isSubscriberInput = document.getElementById('is_subscriber');

search.addEventListener('keyup', function () {
    let value = this.value.trim();
    isSubscriberInput.value = '0';

    if (value.length < 2) {
        results.innerHTML = '';
        return;
    }

    fetch('/search-subscriber?search=' + encodeURIComponent(value))
        .then(response => response.json())
        .then(data => {
            results.innerHTML = '';

            if (data.length === 0) {
                results.innerHTML = `
                    <div class="alert">
                        لا يوجد مشترك بهذا الاسم.<br>
                        تابع الإدخال يدوياً.
                    </div>
                `;
                fullName.value = value;
                phone.value = '';
                return;
            }

            data.forEach(item => {
                results.innerHTML += `
                    <a href="#"
                       class="subscriber-item"
                       data-name="${item.full_name}"
                       data-phone="${item.phone}">
                        <strong>${item.full_name}</strong><br>
                        ${item.phone}
                    </a>
                `;
            });
        });
});

document.addEventListener('click', function(e){
    let item = e.target.closest('.subscriber-item');
    if(!item) return;

    e.preventDefault();

    fullName.value = item.dataset.name;
    phone.value = item.dataset.phone;
    isSubscriberInput.value = '1';

    search.value = item.dataset.name;
    results.innerHTML = `
        <div class="alert">✔ تم اختيار المشترك</div>
    `;

    // Trigger calculation update when subscriber status changes
    const event = new Event('change');
    isSubscriberInput.dispatchEvent(event);
});
</script>


{{-- ============================================================= --}}
{{-- حساب المجموع — نفس منطق صفحة الإضافة، والأسعار من $servicePrices --}}
{{-- ============================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const money = number => new Intl.NumberFormat('fr-FR').format(Math.round(number));

    function checked(id) {
        const el = document.getElementById(id);
        return el && el.checked;
    }

    function value(id) {
        const el = document.getElementById(id);
        return el ? Number(el.value || 0) : 0;
    }

    // الأسعار تأتي من ServiceController عبر $servicePrices
    const prices = @json($servicePrices ?? []);
    const price = (key, fallback = 0) => Number(prices[key] ?? fallback);

    function calculateTotal() {

        let total = 0;

        // السجل التجاري
        if (checked('sijil_moutanaiqil')) total += price('sijil_moutanaiqil', 11000);
        total += value('sijil_ramz_count') * price('sijil_ramz_unit', 240);
        if (checked('naql_badaie')) total += price('naql_badaie', 14000);
        if (checked('hanout')) total += price('hanout', 15000);
        if (checked('sina3a')) total += price('sina3a', 16000);
        if (checked('eljemla')) total += price('eljemla', 16000);
        if (checked('wakala')) total += price('wakala', 2000);
        if (checked('tamdid_salahya')) total += price('tamdid_salahya', 18000);
        if (checked('istirad')) total += price('istirad', 45000);

        const mosada9a = value('mosada9a');
        if (mosada9a === 1) total += price('mosada9a_one', 1500);
        if (mosada9a > 1) total += price('mosada9a_multiple', 1200) * mosada9a;

        if (checked('ta3dil')) total += price('ta3dil', 13000);

        const tarjamaRegister = value('tarjama_register');
        if (tarjamaRegister === 1) total += price('tarjama_register_1', 1800);
        if (tarjamaRegister === 2) total += price('tarjama_register_2', 2400);

        if (checked('tarjamat_sawabi9')) total += price('tarjamat_sawabi9', 1400);
        if (checked('talab_c20')) total += price('talab_c20', 4000);
        if (checked('kachf_hisseb')) total += price('kachf_hisseb', 3000);

        // خدمات بطاقة الحرفي
        if (checked('creation_CA')) total += price('creation_CA', 11000);
        if (checked('creation_dplm_CA')) total += price('creation_dplm_CA', 11000);
        if (checked('annulation_CA')) total += price('annulation_CA', 11000);
        if (checked('efficacite')) total += price('efficacite', 30000);
        if (checked('khidma_ijer_mahal')) total += price('khidma_ijer_mahal', 3000);

        // تعديل بطاقة الحرفي
        if (checked('ta3dil_CA')) {
            total += price('ta3dil_CA_base', 11000);

            const startYear = value('anne_de_modification');
            if (startYear) {
                const currentYear = new Date().getFullYear();

                for (let year = startYear; year <= currentYear; year++) {
                    total += year <= 2024
                        ? price('ta3dil_CA_before_2025', 300)
                        : price('ta3dil_CA_from_2025', 1000);
                }
            }
        }

        // الضرائب والخدمات الخاصة بالمشتركين
        const isSubscriber = document.getElementById('is_subscriber')?.value === '1';

        if (!isSubscriber) {
            if (checked('casnos')) total += price('casnos', 1500);
            if (checked('carte_chifa')) total += price('carte_chifa', 500);
            if (checked('g12_price')) total += price('g12_price', 1200);
            if (checked('g12bis_price')) total += price('g12bis_price', 1200);
            if (checked('nif')) total += price('nif', 800);
            if (checked('nif_plus_g08')) total += price('nif_plus_g08', 1000);
        }

        // خدمات أخرى
        if (checked('nis')) total += price('nis', 4800);
        if (checked('inapi')) total += price('inapi', 11000);

        total += value('logo_price');

        if (checked('coderbar')) {
            total += price('coderbar_base', 11000)
                   + (value('coderbar_products_count') * price('coderbar_product', 500));
        }

        if (checked('moudirya_naql')) total += price('moudirya_naql', 5000);

        // الشركات
        if (checked('tasmya')) total += price('tasmya', 1500);
        if (checked('tarjamat_boal')) total += price('tarjamat_boal', 3000);
        if (checked('ichhar_boal')) total += price('ichhar_boal', 10000);
        if (checked('creation_entreprise')) total += price('creation_entreprise', 45000);
        if (checked('chahedat_ihtiram')) total += price('chahedat_ihtiram', 10000);
        if (checked('nif_alces')) total += price('nif_alces', 10000);
        if (checked('nif_dowan')) total += price('nif_dowan', 3000);
        if (checked('g50')) total += price('g50', 1000);
        if (checked('irg_salaire')) total += price('irg_salaire', 1000);
        if (checked('tva')) total += price('tva', 1000);

        // الختم
        const khatmType = document.getElementById('khatm_type');
        const khatmPrice = (khatmType && khatmType.value !== 'بدون ختم') 
            ? price('khatm_' + khatmType.value, 0) 
            : 0;

        const galization = value('number_of_galization') || 1;
        total += khatmPrice * galization;

        // CNAS
        const cnas = document.getElementById('cnas_type');
        if (cnas) {
            if (cnas.value === '1') {
                total += price('cnas_abattement', 15000);
            }
            if (cnas.value === '2') {
                total += price('cnas_sans_abattement', 12000);
            }
        }

        document.getElementById('serviceTotal').textContent = money(total);
    }

    // أي checkbox / select / number يتبدل → نعاود الحساب مباشرة
    document.querySelectorAll('#serviceForm input, #serviceForm select').forEach(el => {
        el.addEventListener('change', calculateTotal);
        el.addEventListener('input', calculateTotal);
    });

    // الحساب الأولي عند فتح صفحة التعديل
    calculateTotal();
});
</script>

@endsection