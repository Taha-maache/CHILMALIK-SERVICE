@extends('layouts.app')

@section('content')

<style>
/* ===== PAGE BACKGROUND ===== */
.page-bg {
    background: linear-gradient(135deg, #6a0dad 0%, #9b2cc4 50%, #c044e0 100%);
    min-height: 100vh;
    padding: 24px 0 48px;
}

/* ===== HEADER CARD ===== */
.header-card {
    background: #fff;
    border-radius: 16px;
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
}
.header-card .logo-wrap {
    width: 110px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8f5ff;
    border-radius: 12px;
    border: 1.5px dashed #c044e0;
    overflow: hidden;
}
.header-card .logo-wrap img { max-width: 90px; max-height: 60px; object-fit: contain; }
.header-card .title-block { text-align: center; }
.header-card .title-block h2 {
    font-size: 1.55rem;
    font-weight: 700;
    color: #6a0dad;
    margin: 0 0 4px;
}
.header-card .title-block p { color: #888; font-size: 0.88rem; margin: 0; }

/* ===== MAIN FORM CARD ===== */
.form-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 32px rgba(0,0,0,0.10);
    overflow: hidden;
}

/* ===== TABS ===== */
.tabs-bar {
    background: #f8f5ff;
    border-bottom: 2px solid #e8d8f8;
    padding: 14px 16px 0;
}
.tabs-bar .nav-pills {
    display: flex;
    flex-wrap: nowrap;
    overflow-x: auto;
    gap: 6px;
    padding-bottom: 14px;
    scrollbar-width: thin;
    scrollbar-color: #9b2cc4 #e8d8f8;
}
.tabs-bar .nav-pills::-webkit-scrollbar { height: 5px; }
.tabs-bar .nav-pills::-webkit-scrollbar-thumb { background: #9b2cc4; border-radius: 10px; }
.tabs-bar .nav-pills::-webkit-scrollbar-track { background: #e8d8f8; }

.tabs-bar .nav-link {
    border-radius: 50px;
    padding: 7px 16px;
    font-size: 0.82rem;
    font-weight: 600;
    color: #7a4fa0;
    background: #fff;
    border: 1.5px solid #d4b8f0;
    white-space: nowrap;
    transition: all 0.2s;
}
.tabs-bar .nav-link:hover { background: #f0e0ff; border-color: #9b2cc4; color: #6a0dad; }
.tabs-bar .nav-link.active {
    background: #9b2cc4 !important;
    color: #fff !important;
    border-color: #9b2cc4 !important;
    box-shadow: 0 3px 12px rgba(155,44,196,0.35);
}

/* ===== TAB CONTENT ===== */
.tab-body { padding: 32px 28px; }

/* ===== SECTION TITLE ===== */
.section-title {
    font-size: 1rem;
    font-weight: 700;
    color: #6a0dad;
    border-right: 4px solid #9b2cc4;
    padding-right: 10px;
    margin-bottom: 20px;
}

/* ===== FORM CONTROLS ===== */
.form-label {
    font-size: 0.84rem;
    font-weight: 600;
    color: #555;
    margin-bottom: 5px;
}
.form-label.fr { color: #1565C0; }

.form-control, .form-select {
    border-radius: 10px;
    border: 1.5px solid #ddd;
    font-size: 0.9rem;
    padding: 9px 13px;
    color: #333;
    transition: border-color 0.2s, box-shadow 0.2s;
    background: #fdfbff;
}
.form-control:focus, .form-select:focus {
    border-color: #9b2cc4;
    box-shadow: 0 0 0 3px rgba(155,44,196,0.13);
    outline: none;
    background: #fff;
}
.form-control::placeholder { color: #bbb; font-size: 0.85rem; }

/* ===== ACTIVITY SEARCH ===== */
.activity-search-wrap { position: relative; }
.activity-results {
    border: 1.5px solid #e0c8f5;
    border-radius: 10px;
    margin-top: 6px;
    max-height: 220px;
    overflow-y: auto;
    background: #fff;
    box-shadow: 0 4px 16px rgba(155,44,196,0.10);
    display: none;
}
.activity-results.open { display: block; }
.activity-results div {
    padding: 9px 14px;
    font-size: 0.86rem;
    cursor: pointer;
    border-bottom: 1px solid #f3e8ff;
    color: #444;
    transition: background 0.15s;
}
.activity-results div:hover { background: #f3e8ff; color: #6a0dad; }
.activity-results div:last-child { border-bottom: none; }

.selected-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
.activity-tag {
    background: #9b2cc4;
    color: #fff;
    padding: 5px 13px;
    border-radius: 50px;
    font-size: 0.82rem;
    display: flex;
    align-items: center;
    gap: 7px;
    cursor: pointer;
    transition: background 0.15s, transform 0.15s;
}
.activity-tag:hover { background: #7a1fa0; transform: scale(1.04); }
.activity-tag .remove-tag { font-weight: 700; font-size: 1rem; line-height: 1; opacity: 0.85; }

/* ===== ACTIVITY TOGGLE CARDS (Tab 10) ===== */
.toggle-card {
    background: #faf7ff;
    border: 1.5px solid #e0c8f5;
    border-radius: 12px;
    padding: 16px 12px;
    text-align: center;
    transition: all 0.2s;
}
.toggle-card label { font-size: 0.85rem; font-weight: 600; color: #6a0dad; display: block; margin-bottom: 10px; }
.toggle-card .form-select { font-size: 0.85rem; padding: 7px 10px; }

/* ===== FILE UPLOAD ===== */
.file-upload-row {
    background: #faf7ff;
    border: 1.5px dashed #d4b8f0;
    border-radius: 12px;
    padding: 14px 18px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: border-color 0.2s;
}
.file-upload-row:hover { border-color: #9b2cc4; }
.file-upload-row label {
    min-width: 130px;
    font-weight: 700;
    font-size: 0.88rem;
    color: #6a0dad;
    margin: 0;
}
.file-upload-row .form-control { background: #fff; flex: 1; }

/* ===== FOOTER ===== */
.form-footer {
    background: #f8f5ff;
    border-top: 2px solid #e8d8f8;
    padding: 18px 28px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.btn-cancel {
    border: 1.5px solid #9b2cc4;
    color: #9b2cc4;
    background: transparent;
    border-radius: 50px;
    padding: 9px 28px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.2s;
}
.btn-cancel:hover { background: #f3e8ff; }
.btn-save {
    background: #9b2cc4;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 10px 38px;
    font-weight: 700;
    font-size: 0.95rem;
    box-shadow: 0 4px 16px rgba(155,44,196,0.35);
    transition: all 0.2s;
    cursor: pointer;
}
.btn-save:hover { background: #7a1fa0; box-shadow: 0 6px 20px rgba(155,44,196,0.45); }

/* ===== DIVIDER BETWEEN GROUPS ===== */
.field-divider { border: none; border-top: 1.5px dashed #e8d8f8; margin: 20px 0; }

/* ===== SMALL BADGE for tab context ===== */
.tab-badge {
    display: inline-block;
    background: #f3e8ff;
    color: #6a0dad;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 700;
    padding: 2px 8px;
    margin-bottom: 14px;
}
</style>

<div class="page-bg">
<div class="container">

    {{-- HEADER --}}
    <div class="header-card">
        <div class="logo-wrap">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo">
        </div>
        <div class="title-block">
            <h2>إضافة تاجر جديد</h2>
            <p>يرجى ملء جميع الخانات المطلوبة في التبويبات أدناه</p>
        </div>
        <div class="logo-wrap">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo">
        </div>
    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ route('tmorals.store') }}"
          enctype="multipart/form-data"
          class="form-card">
        @csrf

        {{-- TABS NAV --}}
        <div class="tabs-bar">
            <ul class="nav nav-pills" id="traderTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1"  type="button">1. الشخصية</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab2"  type="button">2. بطاقة التعريف</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab3"  type="button">3. تفاصيل إضافية</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab4"  type="button">4. الحالة الاجتماعية</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab5"  type="button">5. السجل التجاري</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab6"  type="button">6. المحل 1</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab7"  type="button">7. المحل 2</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab8"  type="button">8.  الممثلون القانونيون </button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab9"  type="button">9. التعديل</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab10" type="button">10. النشاط المصرح</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab11" type="button">11. الشركة المعنوية</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab12" type="button">12. الوثائق</button></li>  
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab13" type="button">13. الوكالة</button></li>
                <li class="nav-item"><button class="nav-link"        data-bs-toggle="tab" data-bs-target="#tab14" type="button">14. G08</button></li>

            </ul>
        </div>

        {{-- TAB CONTENT --}}
        <div class="tab-body">
        <div class="tab-content" id="traderTabsContent">

            {{-- ===== TAB 1: الشخصية ===== --}}
            <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                <div class="section-title">المعلومات الشخصية</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-6">
                        <label class="form-label">الاسم <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" required placeholder="الاسم بالعربي" value="{{ old('first_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اللقب</label>
                        <input type="text" name="last_name" class="form-control" placeholder="اللقب بالعربي" value="{{ old('last_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fr">First Name (FR)</label>
                        <input type="text" name="first_nameFR" class="form-control" placeholder="PRENOM" value="{{ old('first_nameFR') }}" style="font-weight:700; letter-spacing:0.03em;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fr">Last Name (FR)</label>
                        <input type="text" name="last_nameFR" class="form-control" placeholder="NOM" value="{{ old('last_nameFR') }}" style="font-weight:700; letter-spacing:0.03em;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">مكان الميلاد</label>
                        <input type="text" name="place_of_birth" class="form-control" value="{{ old('place_of_birth') }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 2: بطاقة التعريف ===== --}}
            <div class="tab-pane fade" id="tab2" role="tabpanel">
                <div class="section-title">بيانات بطاقة التعريف الوطنية</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-6">
                        <label class="form-label">رقم التعريف الوطني (NIN)</label>
                        <input type="text" name="NIN" class="form-control" value="{{ old('NIN') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رقم بطاقة التعريف</label>
                        <input type="text" name="number_card" class="form-control" value="{{ old('number_card') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الإصدار</label>
                        <input type="date" name="date1_card" class="form-control" value="{{ old('date1_card') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ الانتهاء</label>
                        <input type="date" name="date2_card" class="form-control" value="{{ old('date2_card') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">مكان الإصدار</label>
                        <input type="text" name="place_card" class="form-control" value="{{ old('place_card') }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 3: تفاصيل إضافية ===== --}}
            <div class="tab-pane fade" id="tab3" role="tabpanel">
                <div class="section-title">تفاصيل العائلة والجنسية</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-6">
                        <label class="form-label">اسم الأب</label>
                        <input type="text" name="father_name" class="form-control" value="{{ old('father_name') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اسم ولقب الأم</label>
                        <input type="text" name="mother_name" class="form-control" value="{{ old('mother_name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الجنسية <span class="text-danger">*</span></label>
                        <input type="text" name="nationality" class="form-control" value="{{ old('nationality', 'جزائرية') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رمز البلدية</label>
                        <input type="text" name="county_code" class="form-control" value="{{ old('county_code', '19000') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الولاية</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state', 'سطيف') }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 4: الحالة الاجتماعية ===== --}}
            <div class="tab-pane fade" id="tab4" role="tabpanel">
                <div class="section-title">الحالة الاجتماعية والتواصل</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-6">
                        <label class="form-label">الجنس <span class="text-danger">*</span></label>
                        <select name="gender" class="form-select" required>
                            <option value="ذكر"  {{ old('gender','ذكر')=='ذكر'  ?'selected':'' }}>ذكر</option>
                            <option value="أنثى" {{ old('gender')=='أنثى' ?'selected':'' }}>أنثى</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الحالة الاجتماعية</label>
                        <select name="marital_status" class="form-select">
                            <option value="أعزب"  {{ old('marital_status','أعزب')=='أعزب'  ?'selected':'' }}>أعزب</option>
                            <option value="متزوج" {{ old('marital_status')=='متزوج' ?'selected':'' }}>متزوج</option>
                            <option value="مطلق"  {{ old('marital_status')=='مطلق'  ?'selected':'' }}>مطلق</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">عنوان السكن</label>
                        <textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fr">Adresse (Français)</label>
                        <input type="text" name="address_fr" class="form-control" placeholder="L'adresse en français..." value="{{ old('address_fr') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">الهاتف</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 5: السجل التجاري ===== --}}
            <div class="tab-pane fade" id="tab5" role="tabpanel">
                <div class="section-title">بيانات السجل التجاري</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-4">
                        <label class="form-label">طبيعة النشاط</label>
                        <select name="nature_RC" class="form-select">
                            <option value="قيد جديد" {{ old('nature_RC','قيد جديد')=='قيد جديد'?'selected':'' }}>قيد جديد</option>
                            <option value="تعديل"    {{ old('nature_RC')=='تعديل'   ?'selected':'' }}>تعديل</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">طبيعة المحل</label>
                        <select name="nature_local" class="form-select">
                            <option value="رئيسي" {{ old('nature_local','رئيسي')=='رئيسي'?'selected':'' }}>رئيسي</option>
                            <option value="ثانوي" {{ old('nature_local')=='ثانوي' ?'selected':'' }}>ثانوي</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">تاريخ السجل</label>
                        <input type="date" name="Date_of_this_register" class="form-control" value="{{ old('Date_of_this_register', date('Y-m-d')) }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 6: المحل 1 ===== --}}
            <div class="tab-pane fade" id="tab6" role="tabpanel">
                <div class="section-title">عنوان المحل التجاري</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-12">
                        <label class="form-label">عنوان المحل التجاري</label>
                        <input type="text" name="Business_address" class="form-control" value="{{ old('Business_address') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">رمز البلدية</label>
                        <input type="text" name="Municipality_code_Business" class="form-control" value="{{ old('Municipality_code_Business') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الولاية</label>
                        <input type="text" name="state_Business" class="form-control" value="{{ old('state_Business') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">تاريخ بداية النشاط</label>
                        <input type="date" name="Activity_start_date" class="form-control" value="{{ old('Activity_start_date') }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 7: المحل 2 ===== --}}
            <div class="tab-pane fade" id="tab7" role="tabpanel">
                <div class="section-title">تفاصيل عقد الإيجار والمحل</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-4">
                        <label class="form-label">مدة الإيجار</label>
                        <input type="text" name="Rental_period" class="form-control" value="{{ old('Rental_period') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">من تاريخ</label>
                        <input type="date" name="date1" class="form-control" value="{{ old('date1') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">إلى تاريخ</label>
                        <input type="date" name="date2" class="form-control" value="{{ old('date2') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">اسم ولقب المؤجر</label>
                        <input type="text" name="Name_surname_landlord" class="form-control" value="{{ old('Name_surname_landlord') }}">
                    </div>                                            
                    <div class="col-md-6">
                        <label class="form-label">تبعية المحل التجاري</label>
                        <input type="text" name="Subordination_CP" class="form-control">
                    </div>                  
                    <div class="col-md-6">
                        <label class="form-label">تبعية القاعدة التجارية</label>
                        <input type="text" name="Commercial_base_dependency" class="form-control">
                    </div>

                </div>
            </div>

{{-- ===== TAB 8: الممثلون القانونيون ===== --}}
<div class="tab-pane fade" id="tab8" role="tabpanel">

    <div class="section-title">
        بيانات الممثلين القانونيين
    </div>

    @for($i = 0; $i < 7; $i++)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-bold">
            الممثل رقم {{ $i+1 }}
        </div>

        <div class="card-body">

            <div class="row g-3" dir="rtl">

                <div class="col-md-6">
                    <label class="form-label">الاسم واللقب</label>
                    <input type="text"
                           name="full_name[]"
                           class="form-control"
                           value="{{ old('full_name.'.$i) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">رقم التعريف الوطني</label>
                    <input type="text"
                           name="representative_NIN[]"
                           class="form-control"
                           value="{{ old('NIN.'.$i) }}">
                </div>

                <div class="col-md-4">
    <label class="form-label">الصفة</label>

    <select name="representative_adjectif[]" class="form-select">

        <option value="">اختر الصفة</option>

        <option value="مسير"
            {{ old('adjectif.'.$i)=='مسير' ? 'selected' : '' }}>
            مسير
        </option>

        <option value="مسير غير شريك"
            {{ old('adjectif.'.$i)=='مسير غير شريك' ? 'selected' : '' }}>
            مسير غير شريك
        </option>

    </select>
</div>
                <div class="col-md-4">
                    <label class="form-label">الجنسية</label>
                    <input type="text"
                           name="representative_nationality[]"
                           class="form-control"
                           value="{{ old('nationality.'.$i) }}">
                </div>

                <div class="col-md-4">
                    <label class="form-label">العنوان</label>
                    <input type="text"
                           name="representative_address[]"
                           class="form-control"
                           value="{{ old('address.'.$i) }}">
                </div>
                
                <div class="col-md-4">

    <label>تاريخ الميلاد</label>
    <input type="date" name="representative_date_of_birth[]" class="form-control">
</div>

                <div class="col-md-4">

    <label>مكان الميلاد</label>
    <input type="text" name="representative_place_of_birth[]" class="form-control">
</div>

<div class="col-md-4">
    <label>اسم الأب</label>
    <input type="text" name="representative_father_name[]" class="form-control">
</div>

<div class="col-md-4">
    <label>اسم ولقب  الأم</label>
    <input type="text" name="representative_mother_name[]" class="form-control">
</div>

            </div>

        </div>
    </div>
    @endfor

</div>

            {{-- ===== TAB 9: التعديل والنشاطات ===== --}}
            <div class="tab-pane fade" id="tab9" role="tabpanel">
                <div class="section-title">التعديلات والنشاطات</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-12">
                        <label class="form-label">توضيح التعديلات</label>
                        <textarea name="Modification" class="form-control" rows="3">{{ old('Modification') }}</textarea>
                    </div>
                </div>

                <hr class="field-divider">

                {{-- AR Activities --}}
                <div dir="rtl">
                    <label class="form-label" style="color:#6a0dad; font-weight:700;">النشاطات بالعربية</label>
                    <p class="text-muted" style="font-size:0.8rem;">ملاحظة: أدخل النشاط الرئيسي كأول نشاط</p>
                    <input type="text" id="code" class="form-control activity-search-wrap" placeholder="ابحث بالكود أو الاسم...">
                    <div id="results" class="activity-results"></div>
                    <div id="selectedActivities" class="selected-tags"></div>
                    <div id="hiddenInputs"></div>
                </div>

                <hr class="field-divider">

                {{-- FR Activities --}}
                <div dir="ltr">
                    <label class="form-label fr" style="font-weight:700;">Activités en Français</label>
                    <p class="text-muted" style="font-size:0.8rem;">Note: Entrez l'activité principale en premier</p>
                    <input type="text" id="code-fr" class="form-control" placeholder="Rechercher par code ou nom...">
                    <div id="results-fr" class="activity-results"></div>
                    <div id="selectedActivities-fr" class="selected-tags"></div>
                    <div id="hiddenInputs-fr"></div>
                </div>
            </div>

            {{-- ===== TAB 10: النشاط المصرح ===== --}}
            <div class="tab-pane fade" id="tab10" role="tabpanel">
                <div class="section-title">النشاط التجاري المصرح به</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>إنتاج السلع</label>
                            <select name="production_of_goods" class="form-select">
                                <option value="0" {{ old('production_of_goods','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('production_of_goods')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>توزيع جملة</label>
                            <select name="Wholesale_distribution" class="form-select">
                                <option value="0" {{ old('Wholesale_distribution','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('Wholesale_distribution')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>توزيع تجزئة</label>
                            <select name="Retail_distribution" class="form-select">
                                <option value="0" {{ old('Retail_distribution','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('Retail_distribution')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>الخدمات</label>
                            <select name="Services" class="form-select">
                                <option value="0" {{ old('Services','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('Services')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>التصدير</label>
                            <select name="Export" class="form-select">
                                <option value="0" {{ old('Export','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('Export')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>الإنتاج الحرفي</label>
                            <select name="Craft_production" class="form-select">
                                <option value="0" {{ old('Craft_production','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('Craft_production')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="toggle-card">
                            <label>الاستيراد لإعادة البيع</label>
                            <select name="Import_for_resale_asis" class="form-select">
                                <option value="0" {{ old('Import_for_resale_asis','non')=='non'?'selected':'' }}>Non</option>
                                <option value="1" {{ old('Import_for_resale_asis')=='oui'?'selected':'' }}>Oui</option>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            {{-- ===== TAB 11: الشركة المعنوية (Tmoral extra fields) ===== --}}
            <div class="tab-pane fade" id="tab11" role="tabpanel">
                <div class="section-title">بيانات الشركة المعنوية</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-6">
                        <label class="form-label">التسمية الاجتماعية (عربي)</label>
                        <input type="text" name="Social_label_ar" class="form-control" value="{{ old('Social_label_ar') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fr">Raison Sociale (FR)</label>
                        <input type="text" name="Social_label_fr" class="form-control" value="{{ old('Social_label_fr') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الاسم التجاري (عربي)</label>
                        <input type="text" name="Trade_name_ar" class="form-control" value="{{ old('Trade_name_ar') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fr">Nom Commercial (FR)</label>
                        <input type="text" name="Trade_name_fr" class="form-control" value="{{ old('Trade_name_fr') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الشكل القانوني (عربي)</label>
                        <input type="text" name="Legal_form_of_company_ar" class="form-control" value="{{ old('Legal_form_of_company_ar') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fr">Forme Juridique (FR)</label>
                        <input type="text" name="Legal_form_of_company_fr" class="form-control" value="{{ old('Legal_form_of_company_fr') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رأس المال الاجتماعي</label>
                        <input type="text" name="Social_capital" class="form-control" value="{{ old('Social_capital') }}" placeholder="بالدينار الجزائري">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">العنوان الاجتماعي</label>
                        <input type="text" name="Social_address" class="form-control" value="{{ old('Social_address') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">رمز بلدية المقر</label>
                        <input type="text" name="Municipal_code_social_headquarters" class="form-control" value="{{ old('Municipal_code_social_headquarters') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ولاية المقر</label>
                        <input type="text" name="Social_state" class="form-control" value="{{ old('Social_state') }}">
                    </div>
<div class="col-md-4">
    <label class="form-label">الصفة</label>

    <select name="adjectif" class="form-select">

        <option value="">اختر الصفة</option>

        <option value="مسير"
            {{ old('adjectif.'.$i)=='مسير' ? 'selected' : '' }}>
            مسير
        </option>

        <option value="مسير غير شريك"
            {{ old('adjectif.'.$i)=='مسير غير شريك' ? 'selected' : '' }}>
            مسير غير شريك
        </option>

    </select>
</div>                    <div class="col-md-12">
                        <label class="form-label">رقم شهادة التسمية</label>
                        <input type="text" name="Social_label_institution" class="form-control" value="{{ old('Social_label_institution') }}">
                    </div>
                </div>
            </div>

            {{-- ===== TAB 12: الوثائق ===== --}}
            <div class="tab-pane fade" id="tab12" role="tabpanel">
                <div class="section-title">رفع الوثائق (ما بعد الختم)</div>
                <div class="row g-3" dir="rtl">
                    <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>السجل التجاري (PDF)</label>
                            <input type="file" name="register_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>NIF (PDF)</label>
                            <input type="file" name="nif_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>NIS (PDF)</label>
                            <input type="file" name="nis_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>G 08 (PDF)</label>
                            <input type="file" name="g8_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>تسمية (PDF)</label>
                            <input type="file" name="naming_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>ايجار (PDF)</label>
                            <input type="file" name="rent_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>القانون الأساسي (PDF)</label>
                            <input type="file" name="essential_law_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>Boal (PDF)</label>
                            <input type="file" name="Boal_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>
                      <div class="col-md-12">
                        <div class="file-upload-row">
                            <label>Fiche de navete (PDF)</label>
                            <input type="file" name="fiche_navet_pdf" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        </div>
                    </div>

                </div>
            </div>
                        {{-- ===== TAB 13: الوكالة --}}
            <div class="tab-pane fade" id="tab13" role="tabpanel">
                <div class="section-title">الوكالة</div>
                <div class="row g-3" dir="rtl">
                    <div class="row">

    <div class="col-md-6 mb-3">
        <label>Nom de l'agence</label>
        <input type="text"
               name="name_agence"
               class="form-control"
               value="{{ old('name_agence', 'شيل عبد المالك') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Numéro de la carte</label>
        <input type="text"
               name="number_card_agence"
               class="form-control"
               value="{{ old('number_card_agence', '416227061') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Date de la carte</label>
        <input type="text"
               name="date_card_agence"
               class="form-control"
               value="{{ old('date_card_agence', '3.11.2025') }}">
    </div>

    <div class="col-md-6 mb-3">
        <label>Commune</label>
        <input type="text"
               name="municipality_agence"
               class="form-control"
               value="{{ old('municipality_agence', 'عين ولمان') }}">
    </div>

</div>
    </div>
            </div>
            <div class="tab-pane fade" id="tab14" role="tabpanel">
    <div class="row g-3">

        <div class="col-md-6">
            <label class="form-label">NIF</label>
            <input type="text"
                   name="nif"
                   class="form-control"
                   value="{{ old('nif', $tmoral->nif ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Numéro de registre</label>
            <input type="text"
                   name="number_of_register"
                   class="form-control"
                   value="{{ old('number_of_register', $tmoral->number_of_register ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">CPI</label>
            <select name="cpi" class="form-select">
                <option value="">-- Choisir --</option>
                <option value="CPI Ain Oulmene"
                    {{ old('cpi', $tmoral->cpi ?? '') == 'CPI Ain Oulmene' ? 'selected' : '' }}>
                    CPI Ain Oulmene
                </option>

                <option value="CPI El Eulma"
                    {{ old('cpi', $tmoral->cpi ?? '') == 'CPI El Eulma' ? 'selected' : '' }}>
                    CPI El Eulma
                </option>

                <option value="CDI El Eulma"
                    {{ old('cpi', $tmoral->cpi ?? '') == 'CDI El Eulma' ? 'selected' : '' }}>
                    CDI El Eulma
                </option>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Adresse d'activité G08</label>
            <input type="text"
                   name="activity_address_g08"
                   class="form-control"
                   value="{{ old('activity_address_g08', $tmoral->activity_address_g08 ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Date de début</label>
            <input type="date"
                   name="starting_date"
                   class="form-control"
                   value="{{ old('starting_date', $tmoral->starting_date ?? '') }}">
        </div>

        <div class="col-md-6">
            <label class="form-label">Lieu G08</label>
            <select name="place_g08" class="form-select">
                <option value="">-- Choisir --</option>

                <option value="El Eulma"
                    {{ old('place_g08', $tmoral->place_g08 ?? '') == 'El Eulma' ? 'selected' : '' }}>
                    El Eulma
                </option>

                <option value="Ain Oulmene"
                    {{ old('place_g08', $tmoral->place_g08 ?? '') == 'Ain Oulmene' ? 'selected' : '' }}>
                    Ain Oulmene
                </option>
            </select>
        </div>

    </div>
</div>


        </div>{{-- end tab-content --}}
        </div>{{-- end tab-body --}}

        {{-- FOOTER --}}
        <div class="form-footer">
            <a href="{{ route('tmorals.index') }}" class="btn-cancel">إلغاء</a>
            <button type="submit" class="btn-save">💾 حفظ بيانات التاجر</button>
        </div>

    </form>
</div>
</div>

{{-- ========== SCRIPTS ========== --}}
<script>
document.querySelector('form').addEventListener('submit', function(e) {
    const firstInvalid = this.querySelector(':invalid');
    if (firstInvalid) {
        const pane = firstInvalid.closest('.tab-pane');
        if (pane) {
            const tabBtn = document.querySelector(`[data-bs-target="#${pane.id}"]`);
            if (tabBtn) new bootstrap.Tab(tabBtn).show();
        }
    }
});

/* ======== ACTIVITY SEARCH AR ======== */
let selected = [];

document.getElementById('code').addEventListener('input', function () {
    let code = this.value.trim();
    const box = document.getElementById('results');
    if (code.length < 1) { box.innerHTML = ''; box.classList.remove('open'); return; }

    fetch('/search-activities?code=' + encodeURIComponent(code))
        .then(res => res.json())
        .then(data => {
            box.innerHTML = '';
            if (data.length === 0) { box.classList.remove('open'); return; }
            box.classList.add('open');
            data.forEach(item => {
                let div = document.createElement('div');
                div.innerText = item.code + ' — ' + item.activity;
                div.onclick = () => { addActivity(item); box.innerHTML = ''; box.classList.remove('open'); document.getElementById('code').value = ''; };
                box.appendChild(div);
            });
        });
});

function addActivity(item) {
    if (selected.find(x => x.id === item.id)) return;
    selected.push(item);
    renderSelected();
}
function removeActivity(id) {
    selected = selected.filter(x => x.id !== id);
    renderSelected();
}
function renderSelected() {
    let box = document.getElementById('selectedActivities');
    let inputs = document.getElementById('hiddenInputs');
    box.innerHTML = ''; inputs.innerHTML = '';
    selected.forEach(item => {
        let tag = document.createElement('div');
        tag.className = 'activity-tag';
        tag.innerHTML = `<span>${item.code}</span><span class="remove-tag">✖</span>`;
        tag.onclick = () => removeActivity(item.id);
        box.appendChild(tag);
        let input = document.createElement('input');
        input.type = 'hidden'; input.name = 'activities[]'; input.value = item.id;
        inputs.appendChild(input);
    });
}

/* ======== ACTIVITY SEARCH FR ======== */
let selectedFr = [];

document.getElementById('code-fr').addEventListener('input', function () {
    let code = this.value.trim();
    const box = document.getElementById('results-fr');
    if (code.length < 1) { box.innerHTML = ''; box.classList.remove('open'); return; }

    fetch('/search-activities-fr?code=' + encodeURIComponent(code))
        .then(res => res.json())
        .then(data => {
            box.innerHTML = '';
            if (data.length === 0) { box.classList.remove('open'); return; }
            box.classList.add('open');
            data.forEach(item => {
                let div = document.createElement('div');
                div.innerText = item.code + ' — ' + item.activity;
                div.onclick = () => { addActivityFr(item); box.innerHTML = ''; box.classList.remove('open'); document.getElementById('code-fr').value = ''; };
                box.appendChild(div);
            });
        });
});

function addActivityFr(item) {
    if (selectedFr.find(x => x.id === item.id)) return;
    selectedFr.push(item);
    renderSelectedFr();
}
function removeActivityFr(id) {
    selectedFr = selectedFr.filter(x => x.id !== id);
    renderSelectedFr();
}
function renderSelectedFr() {
    let box = document.getElementById('selectedActivities-fr');
    let inputs = document.getElementById('hiddenInputs-fr');
    box.innerHTML = ''; inputs.innerHTML = '';
    selectedFr.forEach(item => {
        let tag = document.createElement('div');
        tag.className = 'activity-tag';
        tag.innerHTML = `<span>${item.code}</span><span class="remove-tag">✖</span>`;
        tag.onclick = () => removeActivityFr(item.id);
        box.appendChild(tag);
        let input = document.createElement('input');
        input.type = 'hidden'; input.name = 'activities_fr[]'; input.value = item.id;
        inputs.appendChild(input);
    });
}

/* Close dropdowns on outside click */
document.addEventListener('click', function(e) {
    if (!e.target.closest('#code') && !e.target.closest('#results')) {
        document.getElementById('results').classList.remove('open');
    }
    if (!e.target.closest('#code-fr') && !e.target.closest('#results-fr')) {
        document.getElementById('results-fr').classList.remove('open');
    }
});
</script>

@endsection