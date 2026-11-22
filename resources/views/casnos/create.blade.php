@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 25px;">
                <div class="card-body p-5">

                    <h3 class="text-center fw-bold mb-4" style="color: #3498db;">
                        <i class="fas fa-user-plus"></i> إضافة تسجيل جديد
                    </h3>

                    @if($errors->any())
                        <div class="alert alert-danger border-0" style="border-radius: 12px;">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('casnos.store') }}" method="POST">
                        @csrf

                        {{-- 1) المعلومات الشخصية --}}
                        <h6 class="section-title"><i class="fas fa-user me-2"></i>المعلومات الشخصية</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">اللقب</label>
                                <input type="text" name="nom" value="{{ old('nom') }}" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الإسم</label>
                                <input type="text" name="prenom" value="{{ old('prenom') }}" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">رقم الهاتف</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control custom-input">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">العنوان</label>
                                <input type="text" name="address" value="{{ old('address') }}" class="form-control custom-input">
                            </div>
                        </div>

                        {{-- 2) حساب CASNOS --}}
                        <h6 class="section-title"><i class="fas fa-id-card me-2"></i>حساب CASNOS</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Matricule</label>
                                <input type="text" name="matricule" value="{{ old('matricule') }}" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">اسم المستخدم</label>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control custom-input" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">كلمة المرور</label>
                                <input type="password" name="password" class="form-control custom-input" required>
                            </div>
                        </div>

                        {{-- 3) الدفع --}}
                        <h6 class="section-title"><i class="fas fa-money-bill-wave me-2"></i>الدفع</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">نوع الدفع</label>
                                <select name="pay_type" class="form-select custom-input" required>
                                    <option value="كامل" {{ old('pay_type') == 'كامل' ? 'selected' : '' }}>كامل</option>
                                    <option value="دين" {{ old('pay_type') == 'دين' ? 'selected' : '' }}>دين</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ التصريح</label>
                                <input type="date" name="date_paiement" value="{{ old('date_paiement') }}" class="form-control custom-input">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-primary">المبلغ المستحق</label>
                                <input type="number" step="0.01" name="montant_enkissi" value="{{ old('montant_enkissi') }}" class="form-control custom-input border-primary" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-success">المبلغ المدفوع</label>
                                <input type="number" step="0.01" name="montant_versse" value="{{ old('montant_versse') }}" class="form-control custom-input border-success" required>
                            </div>
                        </div>

                        {{-- 4) خيارات إضافية --}}
                        <h6 class="section-title"><i class="fas fa-sliders-h me-2"></i>خيارات إضافية</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Carte Chifa</label>
                                <div class="d-flex gap-3">
                                    <input type="radio" class="btn-check" name="carte_chifa" id="oui" value="1" autocomplete="off"
                                        {{ old('carte_chifa') === '1' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success" for="oui">Oui</label>

                                    <input type="radio" class="btn-check" name="carte_chifa" id="non" value="0" autocomplete="off"
                                        {{ old('carte_chifa', '0') === '0' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger" for="non">Non</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Recours</label>
                                <div class="d-flex gap-3">
                                    <input type="radio" class="btn-check" name="recours" id="recours_oui" value="1" autocomplete="off"
                                        {{ old('recours') === '1' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-success" for="recours_oui">Oui</label>

                                    <input type="radio" class="btn-check" name="recours" id="recours_non" value="0" autocomplete="off"
                                        {{ old('recours', '0') === '0' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-danger" for="recours_non">Non</label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">تاريخ Recours</label>
                                <input type="datetime-local" name="recours_date" value="{{ old('recours_date') }}" class="form-control custom-input">
                            </div>
                        </div>

                        <div class="text-center mt-5">
                            <button type="submit" class="btn btn-warning text-white fw-bold px-5 py-2 shadow" style="border-radius: 50px;">
                                <i class="fas fa-save me-2"></i> حفظ البيانات
                            </button>
                            <a href="{{ route('casnos.index') }}" class="btn btn-light fw-bold px-5 py-2 border ms-2" style="border-radius: 50px;">إلغاء</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-input {
        border-radius: 12px;
        padding: 12px;
        border: 2px solid #f1f1f1;
        transition: 0.3s;
    }
    .custom-input:focus {
        border-color: #e67e22;
        box-shadow: none;
    }
    .section-title {
        color: #3498db;
        font-weight: 700;
        padding-bottom: .5rem;
        margin-bottom: 1rem;
        border-bottom: 2px solid #fdf0e4;
    }
</style>
@endsection