@extends('layouts.app')

@section('content')
<style>
    .Back {
        background-color: #a2c066;
}
</style>

<div class="Back">
<div class="container mt-4 mb-5" dir="rtl">
    
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded-3">
        <div class="logo-box text-center" style="width: 120px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo Right" class="img-fluid">
        </div>
        
        <div class="text-center">
            <h2 class="fw-bold text-primary mb-0">إضافة ناقل جديد</h2>
            <small class="text-muted">ملء بيانات الناقل والمركبة والسائق</small>
        </div>
        
        <div class="logo-box text-center" style="width: 120px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo Left" class="img-fluid">
        </div>
    </div>

<form method="POST"
      action="{{ route('transporters.store') }}"
      enctype="multipart/form-data"
      class="card shadow-sm border-0 rounded-3 p-4">
                 @csrf

        <ul class="nav nav-tabs mb-4 custom-tabs border-bottom-0" id="transporterFormTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold px-4" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal-content" type="button" role="tab">
                    1. المعلومات الشخصية
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-4" id="vehicle-tab" data-bs-toggle="tab" data-bs-target="#vehicle-content" type="button" role="tab">
                    2. معلومات المركبة
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-4" id="driver-tab" data-bs-toggle="tab" data-bs-target="#driver-content" type="button" role="tab">
                    3. معلومات السائق
                </button>
            </li>
            <li class="nav-item" role="presentation">
    <button class="nav-link fw-bold px-4"
            id="documents-tab"
            data-bs-toggle="tab"
            data-bs-target="#documents-content"
            type="button"
            role="tab">
        <i class="bi bi-folder2-open me-1"></i>
        الوثائق
    </button>
</li>
        </ul>

        <div class="tab-content" id="transporterFormTabsContent">
            
            <div class="tab-pane fade show active" id="personal-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-12 mb-2">
                        <label class="form-label fw-bold">الغرض من الطلب</label>
                        <select name="object" class="form-select form-control-lg border-2" >
                            <option value="">-- اختر الغرض --</option>
                            <option value="طلب رخصة سير مركبة">طلب رخصة سير مركبة</option>
                            <option value="شطب رخصة سير مركبة">شطب  رخصة سير مركبة</option>
                            <option value="طلب رخصة سير مركبة+ مقرر النشاط">طلب رخصة سير مركبة+ مقرر النشاط</option>
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">الاسم (بالعربية)</label>
                        <input type="text" name="first_name" class="form-control"  placeholder="أدخل الاسم">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">اللقب (بالعربية)</label>
                        <input type="text" name="last_name" class="form-control"  placeholder="أدخل اللقب">
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label text-primary fw-bold">Prénom (Français)</label>
                        <input type="text" name="first_namefr" class="form-control fw-bold"  placeholder="Prénom">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label text-primary fw-bold">Nom (Français)</label>
                        <input type="text" name="last_namefr" class="form-control fw-bold"  placeholder="NOM">
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" class="form-control" >
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">مكان الميلاد</label>
                        <input type="text" name="place_of_birth" class="form-control"  placeholder="مكان الازدياد">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">رقم التعريف الوطني</label>
                        <input type="text" name="number_of_identity_card" class="form-control"  placeholder="رقم  التعريف الوطني">
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control"  placeholder="05/06/07...">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="address" class="form-control"  placeholder="العنوان الشخصي الكامل">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">البريد الإلكتروني (اختياري)</label>
                        <input type="email" name="email" class="form-control" placeholder="example@mail.com">
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="vehicle-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم تسجيل المركبة (الرقم المنجمي)</label>
                        <input type="text" name="number_of_registration" class="form-control"  placeholder="00000-000-00">
                    </div>
                    <div class="col-md-6 mt-3">
                     <label class="form-label fw-bold">رقم القيد في سجل  الناقلين</label>
                     <input type="text" name="carriers_registry_number" class="form-control"  placeholder="رقم القيد في سجل الناقلين">
                   </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label ">نوع المركبة</label>
                        <input name="type_of_vehicle" class="form-control" >
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">صنف المركبة</label>
                        <input type="text" name="category_of_vehicle" class="form-control"  placeholder="مثال : رينو">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">الحمولة الكلية (Load Total)</label>
                        <input type="number" name="load_total" class="form-control" step="0.1"  placeholder="بالطن">
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">سنة بداية الاستعمال</label>
                        <input type="number" name="first_year_of_using" class="form-control" min="1900" max="{{ date('Y') }}"  placeholder="2024">
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label fw-bold">النشاط</label>
                        <select name="activity" class="form-select border-2" >
                            <option value="">-- اختر النشاط --</option>
                            <option value="النقل العمومي للبضائع">النقل العمومي للبضائع</option>
                            <option value="نقل البضائع لحساب الخاص">نقل البضائع لحساب الخاص</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="driver-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">اسم ولقب السائق</label>
                        <input type="text" name="first_last_name_of_driver" class="form-control"  placeholder="الاسم الكامل للسائق">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">هاتف السائق</label>
                        <input type="text" name="phone_of_driver" class="form-control"  placeholder="رقم هاتف السائق">
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">تاريخ ميلاد السائق</label>
                        <input type="date" name="date_of_birth_of_driver" class="form-control" >
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">مكان ميلاد السائق</label>
                        <input type="text" name="place_of_birth_of_driver" class="form-control" >
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">عنوان السائق</label>
                        <input type="text" name="address_of_driver" class="form-control"  placeholder="العنوان الكامل للسائق">
                    </div>
                </div>
            </div>
<div class="tab-pane fade" id="documents-content" role="tabpanel">

    @php
        $documents = [
            'register_pdf' => 'السجل التجاري',
            'scanner_pdf' => 'Scanner',
            'carte_grise_pdf' => 'البطاقة الرمادية',
            'mou9arar_na9l_pdf' => 'مقرر النقل',
            'kafaa_pdf' => 'شهادة الكفاءة',
            'permit_pdf' => 'رخصة السياقة',
            'permit_cerculer_pdf' => 'رخصة السير',
            'casnos_pdf' => 'CASNOS',
            'nif_pdf' => 'NIF',
        ];
    @endphp

    <div class="row">

        @foreach($documents as $name => $label)

        <div class="col-md-6 mb-3">

            <label class="form-label fw-bold">
                {{ $label }}
            </label>

            <input
                type="file"
                name="{{ $name }}"
                class="form-control"
                accept=".pdf,.jpg,.jpeg,.png">

        </div>

        @endforeach

    </div>

</div>
        </div>

        <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
            <a href="{{ route('transporters.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">
                <i class="bi bi-arrow-right"></i> رجوع للقائمة
            </a>
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow">
                <i class="bi bi-check-circle"></i> حفظ البيانات بشكل نهائي
            </button>
        </div>

    </form>
</div>
</div>

<style>
    .custom-tabs .nav-link {
        color: #6c757d;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
    }
    .custom-tabs .nav-link.active {
        color: #0d6efd !important;
        background-color: transparent !important;
        border-bottom: 3px solid #0d6efd !important;
    }
    .custom-tabs .nav-link:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    .form-label {
        font-size: 0.9rem;
        color: #495057;
        margin-bottom: 5px;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
    }
    .logo-box {
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #eee;
        border-radius: 10px;
    }
</style>
@endsection