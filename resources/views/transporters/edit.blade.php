@extends('layouts.app')

@section('content')
<style>
    .Back {
        background-color: #c37d44;
}
</style>
<div class="Back">
<div class="container mt-4 mb-5" dir="rtl">
    
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded-3">
        <div class="logo-box text-center" style="width: 120px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo Right" class="img-fluid">
        </div>
        
        <div class="text-center">
            <h2 class="fw-bold text-success mb-0">تعديل بيانات الناقل</h2>
            <small class="text-muted">تحديث معلومات: {{ $transporter->first_name }} {{ $transporter->last_name }}</small>
        </div>
        
        <div class="logo-box text-center" style="width: 120px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo Left" class="img-fluid">
        </div>
    </div>

    <form method="POST"
      action="{{ route('transporters.update', $transporter->id) }}"
      enctype="multipart/form-data"
      class="card shadow-sm border-0 rounded-3 p-4">
    @csrf
        @method('PUT')

        <ul class="nav nav-tabs mb-4 custom-tabs border-bottom-0" id="transporterEditTabs" role="tablist">
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
                <button class="nav-link fw-bold px-4" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents-content" type="button" role="tab">
                    4. الوثائق
                </button>
            </li>
        </ul>

        <div class="tab-content" id="transporterEditTabsContent">
            
            <div class="tab-pane fade show active" id="personal-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-12 mb-2">
                        <label class="form-label fw-bold">الغرض من الطلب</label>
                        <select name="object" class="form-select form-control-lg border-2" required>
                            @php $objects = ['طلب رخصة سير مركبة', 'شطب رخصة سير مركبة', 'طلب رخصة سير مركبة+ مقرر النشاط']; @endphp
                            @foreach($objects as $obj)
                                <option value="{{ $obj }}" {{ old('object', $transporter->object) == $obj ? 'selected' : '' }}>{{ $obj }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">الاسم (بالعربية)</label>
                        <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $transporter->first_name) }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">اللقب (بالعربية)</label>
                        <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $transporter->last_name) }}" required>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label text-primary fw-bold">Prénom (Français)</label>
                        <input type="text" name="first_namefr" class="form-control fw-bold text-uppercase" value="{{ old('first_namefr', $transporter->first_namefr) }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label text-primary fw-bold">Nom (Français)</label>
                        <input type="text" name="last_namefr" class="form-control fw-bold text-uppercase" value="{{ old('last_namefr', $transporter->last_namefr) }}" required>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth', $transporter->date_of_birth) }}" required>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">مكان الميلاد</label>
                        <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth', $transporter->place_of_birth) }}" required>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">رقم التعريف الوطني</label>
                        <input type="text" name="number_of_identity_card" class="form-control" value="{{ old('number_of_identity_card', $transporter->number_of_identity_card) }}" required>
                    </div>

                    <div class="col-md-6 mt-3">
                        <label class="form-label">رقم الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $transporter->phone) }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">العنوان</label>
                        <input type="text" name="address" class="form-control" value="{{ old('address', $transporter->address) }}" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $transporter->email) }}">
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="vehicle-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">رقم تسجيل المركبة</label>
                        <input type="text" name="number_of_registration" class="form-control" value="{{ old('number_of_registration', $transporter->number_of_registration) }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
    <label class="form-label fw-bold">رقم القيد في سجل  الناقلين</label>
    <input type="text" name="carriers_registry_number" 
        class="form-control"
        value="{{ old('carriers_registry_number', $transporter->carriers_registry_number) }}"required>
</div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">نوع المركبة</label>
                        <input type="text" name="type_of_vehicle" class="form-control" value="{{ old('type_of_vehicle', $transporter->type_of_vehicle) }}" required>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">صنف المركبة</label>
                        <input type="text" name="category_of_vehicle" class="form-control" value="{{ old('category_of_vehicle', $transporter->category_of_vehicle) }}" required>
                    </div>                    <div class="col-md-4 mt-3">
                        <label class="form-label">الحمولة الكلية</label>
                        <input type="number" name="load_total" class="form-control" value="{{ old('load_total', $transporter->load_total) }}" required>
                    </div>
                    <div class="col-md-4 mt-3">
                        <label class="form-label">سنة بداية الاستعمال</label>
                        <input type="number" name="first_year_of_using" class="form-control" value="{{ old('first_year_of_using', $transporter->first_year_of_using) }}" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label fw-bold">النشاط</label>
                        <select name="activity" class="form-select border-2" required>
                            <option value="النقل العمومي للبضائع" {{ old('activity', $transporter->activity) == 'النقل العمومي للبضائع' ? 'selected' : '' }}>النقل العمومي للبضائع</option>
                            <option value="نقل البضائع لحساب الخاص" {{ old('activity', $transporter->activity) == 'نقل البضائع لحساب الخاص' ? 'selected' : '' }}>نقل البضائع لحساب الخاص</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="driver-content" role="tabpanel">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">اسم ولقب السائق</label>
                        <input type="text" name="first_last_name_of_driver" class="form-control" value="{{ old('first_last_name_of_driver', $transporter->first_last_name_of_driver) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">هاتف السائق</label>
                        <input type="text" name="phone_of_driver" class="form-control" value="{{ old('phone_of_driver', $transporter->phone_of_driver) }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">تاريخ ميلاد السائق</label>
                        <input type="date" name="date_of_birth_of_driver" class="form-control" value="{{ old('date_of_birth_of_driver', $transporter->date_of_birth_of_driver) }}" required>
                    </div>
                    <div class="col-md-6 mt-3">
                        <label class="form-label">مكان ميلاد السائق</label>
                        <input type="text" name="place_of_birth_of_driver" class="form-control" value="{{ old('place_of_birth_of_driver', $transporter->place_of_birth_of_driver) }}" required>
                    </div>
                    <div class="col-md-12 mt-3">
                        <label class="form-label">عنوان السائق</label>
                        <input type="text" name="address_of_driver" class="form-control" value="{{ old('address_of_driver', $transporter->address_of_driver) }}" required>
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

        <div class="col-md-6 mb-4">

            <label class="form-label fw-bold">
                {{ $label }}
            </label>

            <input
                type="file"
                name="{{ $name }}"
                class="form-control"
                accept=".pdf,.jpg,.jpeg,.png">

            @if($transporter->$name)

                <div class="mt-2 d-flex gap-2">

                    <a href="{{ asset('storage/'.$transporter->$name) }}"
                       target="_blank"
                       class="btn btn-primary btn-sm">
                        <i class="bi bi-eye"></i>
                        Voir
                    </a>
<a href="{{ route('transporters.deleteFile', [$transporter->id, $name]) }}"
   class="btn btn-danger btn-sm"
   onclick="return confirm('هل أنت متأكد من حذف هذا الملف؟')">

    <i class="bi bi-trash"></i>
    Supprimer

</a>
                </div>

            @endif

        </div>

        @endforeach

    </div>

</div>
        </div>

        <div class="mt-5 pt-3 border-top d-flex justify-content-between align-items-center">
            <a href="{{ route('transporters.index') }}" class="btn btn-outline-secondary px-4">
                 إلغاء التعديل
            </a>
            <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow">
                 تحديث البيانات الآن
            </button>
        </div>

    </form>
</div>
</div>

<style>
    .custom-tabs .nav-link { color: #6c757d; border: none; border-bottom: 3px solid transparent; }
    .custom-tabs .nav-link.active { color: #198754 !important; background-color: transparent !important; border-bottom: 3px solid #198754 !important; }
    .form-control, .form-select { border-radius: 8px; padding: 0.6rem 1rem; }
    .logo-box { min-height: 80px; display: flex; align-items: center; justify-content: center; border: 1px dashed #eee; border-radius: 10px; }
</style>
@endsection