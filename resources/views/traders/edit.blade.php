@extends('layouts.app')

@section('content')
<style>
    .Back {
        background-color: #e7a2a2;
}
</style>
<div class="Back">
<div class="container mt-4 mb-5" dir="rtl">

    {{-- الهيدر بنفس الستايل تاع الـ Create --}}
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded-3">
        <div class="logo-box text-center" style="width: 120px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo" class="img-fluid">
        </div>

        <div class="text-center">
            <h2 class="fw-bold text-primary mb-0">{{ isset($trader) ? 'تعديل بيانات التاجر' : 'إضافة تاجر جديد' }}</h2>
            <p class="text-muted small">يرجى مراجعة وتعديل الخانات المطلوبة في التبويبات أدناه</p>
        </div>

        <div class="logo-box text-center" style="width: 120px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo" class="img-fluid">
        </div>
    </div>

    {{-- الفورم بنفس التقسيم --}}
    <form method="POST"
      action="{{ route('traders.update', $trader) }}"
      enctype="multipart/form-data"
      class="card shadow-sm border-0 rounded-3 p-0"
      novalidate>
      @csrf
        @method('PUT')

        <div class="bg-light p-2 rounded-top-3 border-bottom">
            <ul class="nav nav-pills custom-tabs scrollable-tabs" id="traderFormTabs" role="tablist">
                <li class="nav-item"><button class="nav-link active" id="tab1-t" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab">1. الشخصية</button></li>
                <li class="nav-item"><button class="nav-link" id="tab2-t" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab">2. بطاقة التعريف</button></li>
                <li class="nav-item"><button class="nav-link" id="tab3-t" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab">3. تفاصيل إضافية</button></li>
                <li class="nav-item"><button class="nav-link" id="tab4-t" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab">4. الحالة الاجتماعية</button></li>
                <li class="nav-item"><button class="nav-link" id="tab5-t" data-bs-toggle="tab" data-bs-target="#tab5" type="button" role="tab">5. السجل التجاري</button></li>
                <li class="nav-item"><button class="nav-link" id="tab6-t" data-bs-toggle="tab" data-bs-target="#tab6" type="button" role="tab">6. المحل 1</button></li>
                <li class="nav-item"><button class="nav-link" id="tab7-t" data-bs-toggle="tab" data-bs-target="#tab7" type="button" role="tab">7. المحل 2</button></li>
                <li class="nav-item"><button class="nav-link" id="tab8-t" data-bs-toggle="tab" data-bs-target="#tab8" type="button" role="tab">8. التجارة غير القارة</button></li>
                <li class="nav-item"><button class="nav-link" id="tab9-t" data-bs-toggle="tab" data-bs-target="#tab9" type="button" role="tab">9. التعديل</button></li>
                <li class="nav-item"><button class="nav-link" id="tab10-t" data-bs-toggle="tab" data-bs-target="#tab10" type="button" role="tab">10. النشاط المصرح</button></li>
                <li class="nav-item"><button class="nav-link" id="tab12-t" data-bs-toggle="tab" data-bs-target="#tab12" type="button" role="tab">12. الوثائق(مابعد الختم)</button></li>
                <li class="nav-item"><button class="nav-link" id="tab13-t" data-bs-toggle="tab" data-bs-target="#tab13" type="button" role="tab">13. الوكالة</button></li>
                <li class="nav-item"><button class="nav-link" id="tab14-t" data-bs-toggle="tab" data-bs-target="#tab14" type="button" role="tab">14. G08</button></li>
                <li class="nav-item"><button class="nav-link" id="tab15-t" data-bs-toggle="tab" data-bs-target="#tab15" type="button" role="tab">15. الحساب</button></li>

            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="traderFormTabsContent">

                {{-- 1. الشخصية --}}
                <div class="tab-pane fade show active" id="tab1" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">الاسم</label><input type="text" name="first_name" value="{{ $trader->first_name }}" class="form-control" required placeholder="الاسم بالعربي"></div>
                        <div class="col-md-6"><label class="form-label">اللقب</label><input type="text" name="last_name" value="{{ $trader->last_name }}" class="form-control" placeholder="اللقب بالعربي"></div>
                        <div class="col-md-6"><label class="form-label text-primary">First Name (FR)</label><input type="text" name="first_nameFR" value="{{ $trader->first_nameFR }}" class="form-control fw-bold" placeholder="PRENOM"></div>
                        <div class="col-md-6"><label class="form-label text-primary">Last Name (FR)</label><input type="text" name="last_nameFR" value="{{ $trader->last_nameFR }}" class="form-control fw-bold" placeholder="NOM"></div>
                        <div class="col-md-6"><label class="form-label">تاريخ الميلاد</label><input type="date" name="date_of_birth" value="{{ $trader->date_of_birth }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">مكان الميلاد</label><input type="text" name="place_of_birth" value="{{ $trader->place_of_birth }}" class="form-control"></div>
                    </div>
                </div>

                {{-- 2. بطاقة التعريف --}}
                <div class="tab-pane fade" id="tab2" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">رقم التعريف الوطني (NIN)</label><input type="text" name="NIN" value="{{ $trader->NIN }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">رقم بطاقة التعريف</label><input type="text" name="number_card" value="{{ $trader->number_card }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">تاريخ الإصدار</label><input type="date" name="date1_card" value="{{ $trader->date1_card }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">تاريخ الانتهاء</label><input type="date" name="date2_card" value="{{ $trader->date2_card }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">مكان الإصدار</label><input type="text" name="place_card" value="{{ $trader->place_card }}" class="form-control"></div>
                    </div>
                </div>

                {{-- 3. تفاصيل إضافية --}}
                <div class="tab-pane fade" id="tab3" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6"><label class="form-label">اسم الأب</label><input type="text" name="father_name" value="{{ $trader->father_name }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">اسم ولقب الأم</label><input type="text" name="mother_name" value="{{ $trader->mother_name }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">الجنسية</label><input type="text" name="nationality" value="{{ $trader->nationality }}" class="form-control" required></div>
                        <div class="col-md-4"><label class="form-label">رمز البلدية</label><input type="text" name="county_code" value="{{ $trader->county_code }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">الولاية</label><input type="text" name="state" value="{{ $trader->state }}" class="form-control"></div>
                    </div>
                </div>

                {{-- 4. الحالة الاجتماعية --}}
                <div class="tab-pane fade" id="tab4" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">الجنس</label>
                            <select name="gender" class="form-select" required>
                                <option value="ذكر" {{ $trader->gender == 'ذكر' ? 'selected' : '' }}>ذكر</option>
                                <option value="أنثى" {{ $trader->gender == 'أنثى' ? 'selected' : '' }}>أنثى</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">الحالة الاجتماعية</label>
                            <select name="marital_status" class="form-select">
                                <option value="أعزب" {{ $trader->marital_status == 'أعزب' ? 'selected' : '' }}>أعزب</option>
                                <option value="متزوج" {{ $trader->marital_status == 'متزوج' ? 'selected' : '' }}>متزوج</option>
                                <option value="مطلق" {{ $trader->marital_status == 'مطلق' ? 'selected' : '' }}>مطلق</option>
                            </select>
                        </div>
                        <div class="col-md-6"><label class="form-label">عنوان السكن</label><textarea name="address" class="form-control" rows="2">{{ $trader->address }}</textarea></div>
                        <div class="col-md-6"><label class="form-label">Adresse (Français)</label><input type="text" name="address_fr" class="form-control" value="{{ $trader->address_fr }}" placeholder="L'adresse en français..."></div>
                        <div class="col-md-4"><label class="form-label">الهاتف</label><input type="text" name="phone" value="{{ $trader->phone }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">البريد الإلكتروني</label><input type="email" name="email" value="{{ $trader->email }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">رقم عقد الترشيد</label><input type="text" name="Rationalization_contract_number" value="{{ $trader->Rationalization_contract_number }}" class="form-control"></div>
                    </div>
                </div>

                {{-- 5. السجل التجاري --}}
                <div class="tab-pane fade" id="tab5" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">طبيعة النشاط</label><select name="nature_RC" class="form-select"><option value="قيد جديد" {{ $trader->nature_RC == 'قيد جديد' ? 'selected' : '' }}>قيد جديد</option><option value="تعديل" {{ $trader->nature_RC == 'تعديل' ? 'selected' : '' }}>تعديل</option></select></div>
                        <div class="col-md-4"><label class="form-label">شكل النشاط</label><select name="form_BA" class="form-select"><option value="تجارة قارة" {{ $trader->form_BA == 'تجارة قارة' ? 'selected' : '' }}>تجارة قارة</option><option value="تجارة غير قارة" {{ $trader->form_BA == 'تجارة غير قارة' ? 'selected' : '' }}>تجارة غير قارة</option></select></div>
                        <div class="col-md-4"><label class="form-label">طبيعة المحل</label><select name="nature_local" class="form-select"><option value="رئيسي" {{ $trader->nature_local == 'رئيسي' ? 'selected' : '' }}>رئيسي</option><option value="ثانوي" {{ $trader->nature_local == 'ثانوي' ? 'selected' : '' }}>ثانوي</option></select></div>
                    <div class="mb-4">
    <label for="Date_of_this_register" class="form-label">تاريخ السجل</label>
    <input
        type="date"
        name="Date_of_this_register"
        id="Date_of_this_register"
        class="form-control"
        @if(isset($trader))
            value="{{ old('Date_of_this_register', $trader->Date_of_this_register) }}"
        @else
            value="{{ old('Date_of_this_register', date('Y-m-d')) }}"
        @endif
    >
</div>
                    </div>
                </div>

                {{-- 6. المحل 1 --}}
                <div class="tab-pane fade" id="tab6" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label">عنوان المحل التجاري</label><input type="text" name="Business_address" value="{{ $trader->Business_address }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">رمز البلدية</label><input type="text" name="Municipality_code_Business" value="{{ $trader->Municipality_code_Business }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">الولاية</label><input type="text" name="state_Business" value="{{ $trader->state_Business }}" class="form-control"></div>
                        <div class="col-md-12"><label class="form-label">تاريخ بداية النشاط</label><input type="date" name="Activity_start_date" value="{{ $trader->Activity_start_date }}" class="form-control"></div>
                    </div>
                </div>

                {{-- 7. المحل 2 --}}
                <div class="tab-pane fade" id="tab7" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-4"><label class="form-label">مدة الإيجار</label><input type="text" name="Rental_period" value="{{ $trader->Rental_period }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">من تاريخ</label><input type="date" name="date1" value="{{ $trader->date1 }}" class="form-control"></div>
                        <div class="col-md-4"><label class="form-label">إلى تاريخ</label><input type="date" name="date2" value="{{ $trader->date2 }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">اسم ولقب المؤجر</label><input type="text" name="Name_surname_landlord" value="{{ $trader->Name_surname_landlord }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">طبيعة المحل القانونية</label><select name="legal_nature_CP" class="form-select"><option value="ملكية" {{ $trader->legal_nature_CP == 'ملكية' ? 'selected' : '' }}>ملكية</option><option value="ايجار" {{ $trader->legal_nature_CP == 'ايجار' ? 'selected' : '' }}>ايجار</option></select></div>
                        <div class="col-md-6"><label class="form-label">تبعية المحل التجاري</label><input type="text" name="Subordination_CP" value="{{ $trader->Subordination_CP }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">تبعية القاعدة التجارية</label><input type="text" name="Commercial_base_dependency" value="{{ $trader->Commercial_base_dependency }}" class="form-control"></div>

                    </div>
                </div>

                {{-- 8. التجارة غير القارة --}}
                <div class="tab-pane fade" id="tab8" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-12"><label class="form-label">مكان ممارسة النشاط (غير قار)</label><input type="text" name="place_activity_Non_permanent_trade" value="{{ $trader->place_activity_Non_permanent_trade }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">رمز البلدية</label><input type="text" name="Municipality_code_Business_Non_permanent_trade" value="{{ $trader->Municipality_code_Business_Non_permanent_trade }}" class="form-control"></div>
                        <div class="col-md-6"><label class="form-label">الولاية</label><input type="text" name="state_Non_permanent_trade" value="{{ $trader->state_Non_permanent_trade }}" class="form-control"></div>
                    </div>
                </div>

                {{-- 9. التعديل + النشاطات --}}
                <div class="tab-pane fade" id="tab9" role="tabpanel">
                    <div class="col-md-12"><label class="form-label">توضيح التعديلات</label><textarea name="Modification" class="form-control" rows="3">{{ $trader->Modification }}</textarea></div>

<label class="form-label fw-bold">اختيار نموذج النشاط</label>

<select id="activity-template" class="form-select mb-3">
    <option value="">-- اختر النموذج --</option>
    <option value="food_mobile">نموذج 1 - تاجر متنقل مواد غذائية</option>
    <option value="template_2">نموذج 2 - تاجر متنقل في مواد التجميل</option>
    <option value="template_3">نموذج 3 - صناعة مواد التجميل و الصابون</option>
    <option value="template_4">نموذج 4 - اشغال عمومية</option>
    <option value="template_5">نموذج 5 - مقهى وبيتزيريا </option>
    <option value="template_6">نموذج 6 - تجارة بالتجزئة للبقالة </option>
    <option value="template_7">نموذج 7 - صناعة المواد الغذائية </option>
    <option value="template_8">نموذج 8 - مؤسسة خاصة للتعليم والتربية</option>
    <option value="template_9">نموذج 9 - تجارة بالجملة</option>
</select>

<div id="template-message" class="text-muted small mb-3">
    اختر نموذجاً لتحميل الـ Codes الافتراضية.
</div>

<label class="form-label mt-3">النشاطات المختارة</label>
<input type="text" id="code" class="form-control" placeholder="اكتب code...(ملاحظة: ادخل النشاط الرئيسي كاول نشاط )">
<div id="results" class="border mt-2"></div>
<div id="selectedActivities" class="mt-3 d-flex flex-wrap gap-2"></div>
<div id="hiddenInputs">
    @foreach($trader->activities as $activity)
        <input type="hidden"
               name="activities[]"
               value="{{ $activity->id }}">
    @endforeach
</div>

<label class="form-label mt-4 text-primary">Selected Activities (FR)</label>
<input type="text" id="code-fr" class="form-control" placeholder="اكتب code...(ملاحظة: ادخل النشاط الرئيسي كاول نشاط )">
<div id="results-fr" class="border mt-2"></div>
<div id="selectedActivities-fr" class="mt-3 d-flex flex-wrap gap-2"></div>
<div id="hiddenInputs-fr">
    @foreach($trader->activitiesFr as $activity)
        <input type="hidden"
               name="activities_fr[]"
               value="{{ $activity->id }}">
    @endforeach
</div>

</div>

                {{-- 10. النشاط المصرح --}}
                <div class="tab-pane fade" id="tab10" role="tabpanel">
                    <div class="row g-3 text-center">
                        @php
                            $authorizedFields = [
                                'production_of_goods'    => 'إنتاج السلع',
                                'Wholesale_distribution' => 'توزيع جملة',
                                'Retail_distribution'    => 'توزيع تجزئة',
                                'Services'               => 'الخدمات',
                                'Export'                 => 'التصدير',
                            ];
                        @endphp
                        @foreach($authorizedFields as $field => $fieldLabel)
                        <div class="col-md-2">
                            <label class="d-block mb-2">{{ $fieldLabel }}</label>
                            <select name="{{ $field }}" class="form-select">
                                <option value="non" {{ $trader->$field == 'non' ? 'selected' : '' }}>Non</option>
                                <option value="oui" {{ $trader->$field == 'oui' ? 'selected' : '' }}>Oui</option>
                            </select>
                        </div>
                        @endforeach
                    </div>
                </div>


                {{-- 12. الوثائق (مابعد الختم) --}}
                <div class="tab-pane fade" id="tab12" role="tabpanel">
                    <div class="row g-3">

                        @php
                            $documents = [
                                'register_pdf'          => 'Register PDF',
                                'nif_pdf'               => 'NIF PDF',
                                'nis_pdf'               => 'NIS PDF',
                                'g8_pdf'                => 'G8 PDF',
                                'rent_pdf'              => 'ايجار PDF',
                                'birth_certificate_pdf' => 'شهادة الميلاد PDF',
                                'cart_pdf'              => 'بطاقة التعريف PDF',
                                'residence_pdf'         => 'اقامة PDF',
                            ];
                        @endphp

                        @foreach($documents as $field => $docLabel)
                            <div class="col-md-6">
                                <label class="form-label">{{ $docLabel }}</label>

                                @if($trader->$field)
                                    <a href="{{ asset('storage/'.$trader->$field) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-success mb-2">
                                        فتح الملف الحالي
                                    </a>
                                @endif

                                <input type="file" name="{{ $field }}" class="form-control">
                            </div>
                        @endforeach

                    </div>
                </div>


                {{-- 13. الوكالة --}}
                <div class="tab-pane fade" id="tab13" role="tabpanel">
                    <div class="row g-3" dir="rtl">
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label>Nom de l'agence</label>
                                <input type="text"
                                       name="name_agence"
                                       class="form-control"
                                       value="{{ old('name_agence', $trader->name_agence) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Numéro de la carte</label>
                                <input type="text"
                                       name="number_card_agence"
                                       class="form-control"
                                       value="{{ old('number_card_agence', $trader->number_card_agence) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Date de la carte</label>
                                <input type="text"
                                       name="date_card_agence"
                                       class="form-control"
                                       value="{{ old('date_card_agence', $trader->date_card_agence) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Commune</label>
                                <input type="text"
                                       name="municipality_agence"
                                       class="form-control"
                                       value="{{ old('municipality_agence', $trader->municipality_agence) }}">
                            </div>

                        </div>
                    </div>
                </div>


                {{-- 14. G08 --}}
                @php
                    $g08Known   = ['تاجر متنقل', 'نقل عمومي للبضائع'];
                    $g08Current = old('activity_address_g08', $trader->activity_address_g08);
                    $g08IsOther = filled($g08Current) && !in_array($g08Current, $g08Known);
                @endphp

                <div class="tab-pane fade" id="tab14" role="tabpanel">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">NIF</label>
                            <input type="text"
                                   name="nif"
                                   class="form-control"
                                   value="{{ old('nif', $trader->nif) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Numéro de registre</label>
                            <input type="text"
                                   name="number_of_register"
                                   class="form-control"
                                   value="{{ old('number_of_register', $trader->number_of_register) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">CPI</label>
                            <select name="cpi" class="form-select">
                                <option value="">-- Choisir --</option>
                                <option value="CPI Ain Oulmene" {{ old('cpi', $trader->cpi) == 'CPI Ain Oulmene' ? 'selected' : '' }}>CPI Ain Oulmene</option>
                                <option value="CPI El ELEUMA" {{ old('cpi', $trader->cpi) == 'CPI El ELEUMA' ? 'selected' : '' }}>CPI El ELEUMA</option>
                                <option value="CDI El ELEUMA" {{ old('cpi', $trader->cpi) == 'CDI El ELEUMA' ? 'selected' : '' }}>CDI El ELEUMA</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Adresse d'activité G08</label>

                            <select name="activity_address_g08"
                                    id="activity_address_g08"
                                    class="form-select">
                                <option value="">-- Choisir --</option>
                                <option value="تاجر متنقل" {{ $g08Current == 'تاجر متنقل' ? 'selected' : '' }}>تاجر متنقل</option>
                                <option value="نقل عمومي للبضائع" {{ $g08Current == 'نقل عمومي للبضائع' ? 'selected' : '' }}>نقل عمومي للبضائع</option>
                                <option value="other" {{ $g08IsOther ? 'selected' : '' }}>أخرى</option>
                            </select>

                            <input type="text"
                                   name="activity_address_other"
                                   id="activity_address_other"
                                   class="form-control mt-2"
                                   placeholder="اكتب النشاط"
                                   value="{{ $g08IsOther ? $g08Current : '' }}"
                                   style="{{ $g08IsOther ? '' : 'display:none;' }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Starting Date</label>
                            <input type="date"
                                   name="starting_date"
                                   class="form-control"
                                   value="{{ old('starting_date', $trader->starting_date) }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lieu G08</label>

                            <select name="place_g08" class="form-select">
                                <option value="">-- Choisir --</option>
                                <option value="El Eulma" {{ old('place_g08', $trader->place_g08) == 'El Eulma' ? 'selected' : '' }}>El Eulma</option>
                                <option value="Ain Oulmene" {{ old('place_g08', $trader->place_g08) == 'Ain Oulmene' ? 'selected' : '' }}>Ain Oulmene</option>
                            </select>
                        </div>

                    </div>
                </div>


                {{-- 15. الحساب --}}
                @php
                    $selectedOps = (array) old('operation_type', $trader->operation_type ?? []);

                    // [value, id, label]
                    $operations = [
                        ['kadamat',          'kadamat', 'خدمات (2912 DA)'],
                        ['ta3dil',           'ta3dil',  'تعديل (2912 DA)'],
                        ['tejir_moutana9il', 'tejir',   'تاجر متنقل (1000 DA)'],
                        ['tajziaa',          'tajziaa', 'تجزئة (3712 DA)'],
                        ['sina3a',           'sina3a',  'صناعة (3712 DA)'],
                        ['jemla',            'jemla',   'الجملة (2472 DA)'],
                    ];
                @endphp

                <div class="tab-pane fade" id="tab15" role="tabpanel">
                    <div class="row g-3">
                        <div class="row">

                            <div class="col-md-12 mb-4">

                                <label class="form-label fw-bold">
                                    Type d'opération
                                </label>

                                <div class="row">

                                    @foreach($operations as [$opValue, $opId, $opLabel])
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">

                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       name="operation_type[]"
                                                       value="{{ $opValue }}"
                                                       id="{{ $opId }}"
                                                       {{ in_array($opValue, $selectedOps) ? 'checked' : '' }}>

                                                <label class="form-check-label" for="{{ $opId }}">
                                                    {{ $opLabel }}
                                                </label>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label fw-bold">
                                    Nombre de codes
                                </label>

                                <input
                                    type="number"
                                    class="form-control"
                                    name="number_of_codes"
                                    min="0"
                                    value="{{ old('number_of_codes', $trader->number_of_codes) }}">

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card-footer bg-white border-top-0 p-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('traders.index') }}" class="btn btn-outline-secondary px-4 shadow-sm">إلغاء</a>
            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow">تحديث بيانات التاجر</button>
        </div>
    </form>
</div>
</div>

<style>
    .scrollable-tabs { display: flex; flex-wrap: nowrap; overflow-x: auto; white-space: nowrap; padding-bottom: 5px; }
    .scrollable-tabs::-webkit-scrollbar { height: 4px; }
    .scrollable-tabs::-webkit-scrollbar-thumb { background: #0d6efd; border-radius: 10px; }
    .custom-tabs .nav-link { border-radius: 20px; margin-right: 5px; color: #444; font-size: 0.85rem; border: 1px solid #ddd; }
    .custom-tabs .nav-link.active { background-color: #0d6efd !important; color: white !important; border-color: #0d6efd; }
    .logo-box { border: 1px dashed #ddd; border-radius: 10px; padding: 5px; display: flex; align-items: center; justify-content: center; }
.scrollable-tabs {
    gap: 8px;               /* مسافة بين tabs */
    padding-bottom: 10px;
}

.scrollable-tabs::-webkit-scrollbar {
    height: 12px;
}

.scrollable-tabs::-webkit-scrollbar-thumb {
    background: #0d6efd;
    border-radius: 10px;
}

/* ===== نتائج البحث + tags النشاطات (نفس create) ===== */

#results div,
#results-fr div {
    transition: 0.2s;
    border-radius: 6px;
}

#results div:hover,
#results-fr div:hover {
    background: #d1e7dd;
    transform: scale(1.01);
}

#selectedActivities,
#selectedActivities-fr {
    margin-top: 10px;
}

.activity-tag {
    background: #198754;
    color: white;
    padding: 6px 10px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    transition: 0.2s;
}

.activity-tag:hover {
    background: #157347;
    transform: scale(1.05);
}

.activity-tag span {
    cursor: pointer;
    font-weight: bold;
}
</style>

{{-- الانتقال للتبويب اللي فيه خطأ --}}
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const firstInvalid = this.querySelector(':invalid');
        if (firstInvalid) {
            const pane = firstInvalid.closest('.tab-pane');
            const tabBtn = document.querySelector(`[data-bs-target="#${pane.id}"]`);
            new bootstrap.Tab(tabBtn).show();
        }
    });
</script>

{{-- ===== النشاطات (عربي) ===== --}}
<script>
let selected = @json(
    $trader->activities
        ->map(fn ($a) => ['id' => $a->id, 'code' => $a->code, 'activity' => $a->activity])
        ->values()
);

renderSelected();

// 🔍 search
document.getElementById('code').addEventListener('input', function () {

    let code = this.value;

    if (code.length < 1) {
        document.getElementById('results').innerHTML = '';
        return;
    }

    fetch('/search-activities?code=' + code)
        .then(res => res.json())
        .then(data => {

            let box = document.getElementById('results');
            box.innerHTML = '';

            data.forEach(item => {

                let div = document.createElement('div');
                div.innerText = item.code + ' - ' + item.activity;
                div.classList.add('p-2', 'border', 'bg-white', 'cursor-pointer');

                div.style.cursor = 'pointer';

                div.onclick = function () {
                    addActivity(item);
                };

                box.appendChild(div);
            });
        });
});

// ➕ add
function addActivity(item) {

    if (selected.find(x => x.id === item.id)) return;

    selected.push(item);
    renderSelected();
}

// ❌ remove
function removeActivity(id) {
    selected = selected.filter(x => x.id !== id);
    renderSelected();
}

// 🎨 render
function renderSelected() {

    let box = document.getElementById('selectedActivities');
    let inputs = document.getElementById('hiddenInputs');

    box.innerHTML = '';
    inputs.innerHTML = '';

    selected.forEach(item => {

        // tag UI
        let tag = document.createElement('div');
        tag.className = "activity-tag";

        tag.innerHTML = `
            ${item.code}
            <span>✖</span>
        `;
        tag.onclick = function () {
            removeActivity(item.id);
        };

        box.appendChild(tag);

        // hidden input for backend
        let input = document.createElement('input');
        input.type = "hidden";
        input.name = "activities[]";
        input.value = item.id;

        inputs.appendChild(input);
    });
}
</script>

{{-- ===== النشاطات (فرنسي) + النشاط الرئيسي ===== --}}
<script>
let selectedFr = @json(
    $trader->activitiesFr
        ->map(fn ($a) => ['id' => $a->id, 'code' => $a->code, 'activity' => $a->activity])
        ->values()
);

// النشاط الرئيسي المحفوظ سابقاً (إن وُجد)
let selectedMainActivityFrId = @json(data_get($trader, 'main_activity_fr_id'));

// 🔍 search FR
document.getElementById('code-fr').addEventListener('input', function () {

    let code = this.value;

    if (code.length < 1) {
        document.getElementById('results-fr').innerHTML = '';
        return;
    }

    fetch('/search-activities-fr?code=' + code)
        .then(res => res.json())
        .then(data => {

            let box = document.getElementById('results-fr');
            box.innerHTML = '';

            data.forEach(item => {

                let div = document.createElement('div');
                div.innerText = item.code + ' - ' + item.activity;
                div.classList.add('p-2', 'border', 'bg-white');

                div.style.cursor = 'pointer';

                div.onclick = function () {
                    addActivityFr(item);
                };

                box.appendChild(div);
            });
        });
});

// ➕ add FR
function addActivityFr(item) {

    if (selectedFr.find(x => x.id === item.id)) return;

    selectedFr.push(item);
    renderSelectedFr();
}

// ❌ remove FR
function removeActivityFr(id) {
    selectedFr = selectedFr.filter(x => x.id !== id);
    renderSelectedFr();
}

// 🎨 render FR
function renderSelectedFr() {
    let box = document.getElementById('selectedActivities-fr');
    let inputs = document.getElementById('hiddenInputs-fr');

    box.innerHTML = '';
    inputs.innerHTML = '';

    // إذا ما بقاش النشاط الرئيسي ضمن النشاطات المختارة، اختار الأول تلقائياً
    if (!selectedFr.some(item =>
        String(item.id) === String(selectedMainActivityFrId)
    )) {
        selectedMainActivityFrId = selectedFr.length
            ? selectedFr[0].id
            : null;
    }

    selectedFr.forEach(item => {
        let tag = document.createElement('div');
        tag.className = 'activity-tag';
        tag.style.cursor = 'default';

        let code = document.createElement('span');
        code.textContent = item.code + ' - ' + item.activity;
        code.style.cursor = 'default';
        tag.appendChild(code);

        let mainLabel = document.createElement('label');
        mainLabel.style.display = 'flex';
        mainLabel.style.alignItems = 'center';
        mainLabel.style.gap = '4px';
        mainLabel.style.cursor = 'pointer';

        let radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = 'main_activity_choice';
        radio.value = item.id;
        radio.checked =
            String(item.id) === String(selectedMainActivityFrId);

        radio.addEventListener('change', function () {
            selectedMainActivityFrId = item.id;
            renderSelectedFr();
        });

        let labelText = document.createElement('small');
        labelText.textContent = 'رئيسي';

        mainLabel.appendChild(radio);
        mainLabel.appendChild(labelText);
        tag.appendChild(mainLabel);

        let removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.textContent = '✖';
        removeBtn.style.cssText =
            'border:0;background:transparent;color:white;font-weight:bold;cursor:pointer;';

        removeBtn.addEventListener('click', function () {
            removeActivityFr(item.id);
        });

        tag.appendChild(removeBtn);
        box.appendChild(tag);

        let input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'activities_fr[]';
        input.value = item.id;
        inputs.appendChild(input);
    });

    // إرسال النشاط الرئيسي إلى Laravel
    let mainInput = document.createElement('input');
    mainInput.type = 'hidden';
    mainInput.name = 'main_activity_fr_id';
    mainInput.value = selectedMainActivityFrId ?? '';
    inputs.appendChild(mainInput);
}

renderSelectedFr();
</script>

{{-- ===== G08: خانة "أخرى" ===== --}}
<script>
document.getElementById('activity_address_g08').addEventListener('change', function () {

    let other = document.getElementById('activity_address_other');

    if (this.value === 'other') {
        other.style.display = 'block';
    } else {
        other.style.display = 'none';
        other.value = '';
    }

});
</script>

{{-- ===== نماذج النشاط (Templates) ===== --}}
<script>
const activityTemplates = {
    food_mobile: [
        '618002',
        '618005',
        '618009',
        '511132',
        '511301',
        '511309',
        '511154',
        '511104',
        '511105',
        '511106',
        '511302',
        '511303',
        '511305',
        '618004',
        '618003',
        '511101',
        '511202',
        '511111'
    ],

    template_2: [
        '511331',
        '511334',
        '511327',
        '511335',
        '511318',
        '511336',
        '511137',
        '511113',
        '511131',
        '511316',
        '511311',
        '511313',
    ],

    template_3: [
        '104213',
        '104218',
        '105702',
        '111310',
        '104225',
        '104221',
        '111312',

    ],
    template_4: [
        '109201',
        '109209',
        '109202',
        '109203',
        '109204',
        '109210',
        '109213',
        '109206',
        '109211',
        '109215',
        '101103',
        '109221',
        '105509',
        '109214',
    ],
    template_5: [
        '601204',
        '601301',
        '601212',
        '601213',
        '501202',
        '601202',
    ],
    template_6: [
        '501119',
        '501108',
        '501118',
        '502304',
        '501208',
        '505007',
        '501107',
        '501111',

    ],
    template_7: [
        '107101',
        '107103',
        '107108',
        '107109',
        '107601',
        '107605',
        '107609',
        '107611',
        '107612',
        '107301',
    ],
    template_8: [
        '301104',
        '301105',
        '301106',
        '301108',
        '301109',
        '301110',
        '301111',
        '301113',
        '301114',
        '301401',
    ],
    template_9: [
        '605035',
        '607014',
        '607040',
        '607030',
        '607018',
        '607049',
        '607001',
        '607069',

    ],
};
let templateCodes = [];
let templateCodesFr = [];

document.getElementById('activity-template').addEventListener('change', async function () {
    const codes = activityTemplates[this.value];
    const message = document.getElementById('template-message');

    // نحّي أكواد النموذج السابق فقط
    selected = selected.filter(
        item => !templateCodes.includes(String(item.code))
    );

    selectedFr = selectedFr.filter(
        item => !templateCodesFr.includes(String(item.code))
    );

    templateCodes = [];
    templateCodesFr = [];

    renderSelected();
    renderSelectedFr();

    if (!codes || codes.length === 0) {
        message.textContent = 'هذا النموذج مازال ما فيه حتى كود.';
        return;
    }

    message.textContent = 'جاري تحميل الأكواد...';

    try {
        const params = new URLSearchParams();
        codes.forEach(code => params.append('codes[]', code));

        const response = await fetch('/activities-by-codes?' + params.toString());

        if (!response.ok) throw new Error('HTTP ' + response.status);

        const data = await response.json();

        data.ar.forEach(item => {
            if (!selected.some(x => String(x.id) === String(item.id))) {
                selected.push(item);
                templateCodes.push(String(item.code));
            }
        });

        data.fr.forEach(item => {
            if (!selectedFr.some(x => String(x.id) === String(item.id))) {
                selectedFr.push(item);
                templateCodesFr.push(String(item.code));
            }
        });

        renderSelected();
        renderSelectedFr();

        message.textContent =
            'العربية: ' + data.ar.length +
            ' كود — الفرنسية: ' + data.fr.length + ' كود';

    } catch (error) {
        message.textContent = 'صار خطأ في تحميل الأكواد.';
        console.error(error);
    }
});
</script>
@endsection