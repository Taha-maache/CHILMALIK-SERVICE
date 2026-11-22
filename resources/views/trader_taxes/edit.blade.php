@extends('layouts.app')

@section('content')
<style>
    .Back { background-color: #324ea9; min-height: 100vh; padding-top: 20px; }
    .logo-box { border: 1px dashed #ddd; border-radius: 10px; padding: 5px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; }
</style>

<div class="Back">
<div class="container mb-5" dir="rtl">
    
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded-3 border-bottom border-primary">
        <div class="logo-box text-center" style="width: 110px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo" class="img-fluid">
        </div>
        <div class="text-center">
            <h2 class="fw-bold text-primary mb-0">تعديل بيانات الضريبة</h2>
            <p class="text-muted small mb-0">تحديث سجل الضريبة الخاص بالتاجر</p>
        </div>
        <div class="logo-box text-center" style="width: 110px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo" class="img-fluid">
        </div>
    </div>

    <form method="POST" action="{{ route('trader_taxes.update', $trader_tax) }}" enctype="multipart/form-data" class="card shadow-sm border-0 rounded-3 p-4">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label fw-bold">التاجر (البحث بالاسم أو NIN)</label>
                <select name="trader_id" id="trader_select" class="form-control" required>
                    @foreach($traders as $trader)
                        <option value="{{ $trader->id }}" {{ $trader_tax->trader_id == $trader->id ? 'selected' : '' }}>
                            [{{ $trader->NIN }}] - {{ $trader->first_name }} {{ $trader->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">BP</label>
                <input type="text" name="BP" class="form-control" value="{{ $trader_tax->BP }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">NIF</label>
                <input type="text" name="Nif" class="form-control" value="{{ $trader_tax->Nif }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Structure (المصلحة)</label>
                <select name="structure" class="form-select">
                    <option value="CPI AIN OULMENE" {{ $trader_tax->structure == 'CPI AIN OULMENE' ? 'selected' : '' }}>CPI AIN OULMENE</option>
                    <option value="CPI ELEUMA" {{ $trader_tax->structure == 'CPI ELEUMA' ? 'selected' : '' }}>CPI ELEUMA</option>
                    <option value="CDI ELEUMA" {{ $trader_tax->structure == 'CDI ELEUMA' ? 'selected' : '' }}>CDI ELEUMA</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">رقم السجل التجاري</label>
                <input type="text" name="number_of_commerce" class="form-control" value="{{ $trader_tax->number_of_commerce }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ البداية</label>
                <input type="date" name="date_start" class="form-control" value="{{ $trader_tax->date_start }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">المكان (Place)</label>
                <select name="place" class="form-select">
                    <option value="AIN OULMENE" {{ $trader_tax->place == 'AIN OULMENE' ? 'selected' : '' }}>AIN OULMENE</option>
                    <option value="ELEUMA" {{ $trader_tax->place == 'ELEUMA' ? 'selected' : '' }}>ELEUMA</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">اسم المستخدم</label>
                <input type="text" name="username" class="form-control" value="{{ $trader_tax->username }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">كلمة المرور</label>
                <input type="text" name="password" class="form-control" value="{{ $trader_tax->password }}">
            </div>
            
            <div class="col-md-4">
                <label class="form-label">رقم المادة</label>
                <input type="text" name="numero_matiere" class="form-control" value="{{ $trader_tax->numero_matiere }}">
            </div>
                <div class="col-md-4">
                    <label class="form-label">matricule</label>
                    <input type="text" name="matricule" class="form-control" value="{{ $trader_tax->matricule }}">
                </div>
           <div class="col-md-4">
    <label class="form-label">عنوان النشاط</label>
    
    <select id="address_presets" class="form-select mb-2">
        <option value="">-- اختر عنواناً جاهزاً (أو عدل يدوياً بالأسفل) --</option>
        
        <option value="تاجر متنقل" 
            {{ $trader_tax->adrress_activity == 'تاجر متنقل' ? 'selected' : '' }}>
            تاجر متنقل 
        </option>
        
        <option value="نقل عمومي للبضائع" 
            {{ $trader_tax->adrress_activity == 'نقل عمومي للبضائع' ? 'selected' : '' }}>
           نقل عمومي للبضائع
        </option>
    
    <input type="text" name="adrress_activity" id="adrress_activity" 
           class="form-control" 
           value="{{ $trader_tax->adrress_activity }}" 
           placeholder="اكتب العنوان هنا...">
</div>

            <div class="col-12"><hr></div>

            <div class="col-md-6">
                <label class="form-label">السنة المالية</label>
                <input type="number" name="tax_year" class="form-control" value="{{ $trader_tax->tax_year }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">قيمة الضريبة (%)</label>
                <select name="tax_value" class="form-select" required>
                    @foreach(['12','5','0.5'] as $val)
                        <option value="{{ $val }}" {{ $trader_tax->tax_value == $val ? 'selected' : '' }}>{{ $val }}%</option>
                    @endforeach
                </select>
            </div>
         <div class="col-md-3">
    <label class="form-label">طريقة الدفع</label>
    <select name="pay_type" id="pay_type_select" class="form-select">
        <option value="total" {{ $trader_tax->pay_type == 'total' ? 'selected' : '' }}>كامل</option>
        <option value="credit" {{ $trader_tax->pay_type == 'credit' ? 'selected' : '' }}>دين</option>
    </select>
</div>

<div class="col-md-3 credit-fields" style="display: none;">
    <label class="form-label text-warning">تاريخ استحقاق الباقي</label>
    <input type="date" name="credit_date" class="form-control border-warning" value="{{ $trader_tax->credit_date }}">
</div>

<div class="col-md-3 credit-fields" style="display: none;">
    <label class="form-label text-danger fw-bold">المبلغ المالي (DA)</label>
    <input type="number" step="0.01" name="amount" class="form-control border-danger"  value="{{ $trader_tax->amount }}">
</div>
        </div>
        <hr class="my-4">

<h5 class="mb-3">📄 الوثائق</h5>

<div class="row">
   
    <div class="col-md-4 mb-3">
        <label class="form-label">G12 PDF</label>

        @if($trader_tax->g12_pdf)
            <div class="mb-2">
                <a href="{{ asset('storage/'.$trader_tax->g12_pdf) }}" target="_blank"
                   class="btn btn-sm btn-outline-primary">
                    عرض الملف الحالي
                </a>
            </div>
        @endif

        <input type="file" name="g12_pdf" class="form-control" >
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">G12 BIS PDF</label>

        @if($trader_tax->g12bis_pdf)
            <div class="mb-2">
                <a href="{{ asset('storage/'.$trader_tax->g12bis_pdf) }}" target="_blank"
                   class="btn btn-sm btn-outline-primary">
                    عرض الملف الحالي
                </a>
            </div>
        @endif

        <input type="file" name="g12bis_pdf" class="form-control">
    </div>
</div>

        <div class="mt-4 d-flex justify-content-between">
            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">تحديث البيانات</button>
            <a href="{{ route('trader_taxes.index') }}" class="btn btn-outline-secondary px-4">رجوع</a>
        </div>
    </form>
</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#trader_select').select2({ dir: "rtl", width: '100%' });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const payTypeSelect = document.getElementById('pay_type_select');
        
        function toggleCredit() {
            const fields = document.querySelectorAll('.credit-fields');
            const isCredit = payTypeSelect.value === 'credit';
            
            fields.forEach(div => {
                div.style.display = isCredit ? 'block' : 'none';
                const input = div.querySelector('input');
                if (input) {
                    isCredit ? input.setAttribute('required', 'required') : input.removeAttribute('required');
                }
            });
        }

        payTypeSelect.addEventListener('change', toggleCredit);
        toggleCredit(); // لتفعيل الحالة الابتدائية
    });
</script>

<script>
    document.getElementById('address_presets').addEventListener('change', function() {
        var selectedValue = this.value;
        var inputField = document.getElementById('adrress_activity');
        
        if (selectedValue !== "") {
            inputField.value = selectedValue;
        }
        // ملاحظة: في الـ Edit مانفرغوش الـ input إذا خيّر "خيار فارغ" 
        // باش ما يروحش العنوان القديم اللي كان مكتوب يدوياً
    });
</script>
@endsection