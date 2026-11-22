@extends('layouts.app')

@section('content')
<style>
    .Back { background-color: #46b39b; min-height: 100vh; padding-top: 20px; }
    .logo-box { border: 1px dashed #ddd; border-radius: 10px; padding: 5px; display: flex; align-items: center; justify-content: center; background: #f9f9f9; }
</style>

<div class="Back">
<div class="container mb-5" dir="rtl">
    
    <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 shadow-sm rounded-3 border-bottom">
        <div class="logo-box text-center" style="width: 110px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo" class="img-fluid">
        </div>
        <div class="text-center">
            <h2 class="fw-bold text-primary mb-0">إضافة ضرائب جديدة (G12)</h2>
            <p class="text-muted small mb-0">يرجى ملء بيانات الضريبة للتاجر المعني</p>
        </div>
        <div class="logo-box text-center" style="width: 110px;">
            <img src="{{ asset('images/CHM.png') }}" alt="Logo" class="img-fluid">
        </div>
    </div>

    <form method="POST" action="{{ route('trader_taxes.store') }}" class="card shadow-sm border-0 rounded-3 p-4">
        @csrf

        <div class="row g-3">
            {{-- اختيار التاجر --}}
            <div class="col-md-12">
                <label class="form-label fw-bold text-primary">اختيار التاجر (البحث بالاسم أو NIN)</label>
                <select name="trader_id" id="trader_select" class="form-control" required>
                    <option value="">اكتب اسم التاجر أو رقم التعريف (NIN)...</option>
                    @foreach($traders as $trader)
                        <option value="{{ $trader->id }}" {{ old('trader_id') == $trader->id ? 'selected' : '' }}>
                            [{{ $trader->NIN }}] - {{ $trader->first_name }} {{ $trader->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- الحقول الجديدة --}}
            <div class="col-md-4">
                <label class="form-label">BP (صندوق البريد)</label>
                <input type="text" name="BP" class="form-control" placeholder="مثلا: 19000">
            </div>
            <div class="col-md-4">
                <label class="form-label">NIF (الرقم الجبائي)</label>
                <input type="text" name="Nif" class="form-control" placeholder="رقم التعريف الجبائي">
            </div>
            <div class="col-md-4">
                <label class="form-label">Structure (المصلحة)</label>
                <select name="structure" class="form-select">
                    <option value="CPI AIN OULMENE">CPI AIN OULMENE</option>
                    <option value="CPI ELEUMA">CPI ELEUMA</option>
                    <option value="CDI ELEUMA">CDI ELEUMA</option>
                </select>
            </div>


            <div class="col-md-4">
                <label class="form-label">رقم السجل التجاري</label>
                <input type="text" name="number_of_commerce" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">تاريخ بداية النشاط</label>
                <input type="date" name="date_start" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">المكان (Place)</label>
                <select name="place" class="form-select">
                    <option value="AIN OULMENE">AIN OULMENE</option>
                    <option value="ELEUMA">ELEUMA</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">اسم المستخدم</label>
                <input type="text" name="username" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">كلمة المرور</label>
                <input type="text" name="password" class="form-control">
                </div>
                
            <div class="col-md-4">
                <label class="form-label">رقم المادة (Numero Matière)</label>
                <input type="text" name="numero_matiere" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">matricule</label>
                <input type="text" name="matricule" class="form-control">
            </div>
<div class="col-md-4">
    <label class="form-label">عنوان النشاط</label>
    
    <select id="address_presets" class="form-select mb-2">
        <option value="">-- اختر عنواناً جاهزاً (أو اكتب يدوياً بالأسفل) --</option>
        <option value="تاجر متنقل" >تاجر متنقل</option>
        <option value="نقل عمومي للبضائع" >نقل عمومي للبضائع</option>
    </select>

    <input type="text" name="adrress_activity" id="adrress_activity" class="form-control" placeholder="اكتب العنوان هنا إذا لم تختار من القائمة">
</div>
            <div class="col-12"><hr></div>

            <div class="col-md-6">
                <label class="form-label">السنة المالية</label>
                <input type="number" name="tax_year" class="form-control" value="{{ now()->year }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">قيمة الضريبة (%)</label>
                <select name="tax_value" class="form-select" required>
                    <option value="">-- اختر --</option>
                    @foreach(['12','5','0.5'] as $val)
                        <option value="{{ $val }}">{{ $val }}%</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
    <label class="form-label">طريقة الدفع</label>
    <select name="pay_type" id="pay_type_select" class="form-select">
    <option value="credit">دين</option>
    <option value="total">كامل</option>
    </select>
</div>

<div class="col-md-3 credit-fields" style="display: none;">
    <label class="form-label text-warning">تاريخ استحقاق الباقي</label>
    <input type="date" name="credit_date" class="form-control border-warning">
</div>

<div class="col-md-3 credit-fields" style="display: none;">
    <label class="form-label text-danger fw-bold">المبلغ المالي (DA)</label>
    <input type="number" step="0.01" name="amount" class="form-control border-danger" placeholder="0.00">
</div>
        </div>

        <div class="mt-4 d-flex justify-content-between">
            <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">حفظ البيانات</button>
            <a href="{{ route('trader_taxes.index') }}" class="btn btn-outline-secondary px-4">إلغاء</a>
        </div>
    </form>
</div>
</div>

{{-- Scripts --}}
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
    } else {
        inputField.value = ""; // إذا رجع للخيار الأول يفرغ الـ input
    }
});
</script>
@endsection 