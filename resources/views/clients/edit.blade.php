@extends('layouts.app')

@section('content')

<div class="client-wrapper">
    <div class="container-fluid py-4">

        <!-- HEADER -->
        <div class="cl-header">
            <div class="cl-title">
                <div class="cl-icon">
                    <i class="fas fa-user-edit"></i>
                </div>
                <div>
                    <h1>تعديل بيانات الزبون</h1>
                    <span>{{ $client->first_name }} {{ $client->last_name }}</span>
                </div>
            </div>
            <a href="{{ route('clients.index') }}" class="cl-close">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <!-- FORM CARD -->
        <div class="cl-card">
            <form action="{{ route('clients.update', $client->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- SECTION 1 -->
                <div class="cl-section">
                    <div class="cl-section-title">
                        <span>البيانات الشخصية</span>
                    </div>
                    <div class="cl-row">
                        <div class="cl-field">
                            <label>الاسم </label>
                            <input type="text" name="first_name" value="{{ $client->first_name }}" required>
                        </div>
                        <div class="cl-field">
                            <label>اللقب</label>
                            <input type="text" name="last_name" value="{{ $client->last_name }}" required>
                        </div>
                    </div>
                    <div class="cl-row">
                        <div class="cl-field">
                            <label>البريد الإلكتروني</label>
                            <input type="email" name="email" value="{{ $client->email }}" required>
                        </div>
                        <div class="cl-field">
                            <label>رقم الهاتف</label>
                            <input type="text" name="phone" value="{{ $client->phone }}" placeholder="05/06/07...">
                        </div>
                    </div>
                </div>

                <!-- SECTION 2 -->
                <div class="cl-section">
                    <div class="cl-section-title">
                        <span>بيانات السجل والملف</span>
                    </div>
                    <div class="cl-row">
                        <div class="cl-field">
                            <label>رقم الحفظ</label>
                            <input type="text" name="number_of_registration" value="{{ $client->number_of_registration }}" required>
                        </div>
                            <div class="cl-field">
                                <label> class</label>
                                <input type="text" name="client_class" value="{{ $client->client_class }}" placeholder="فئة الزبون">
                        <div class="cl-field">
                            <label>تاريخ إيداع الملف</label>
                            <input type="date" name="registration_date" value="{{ $client->registration_date }}" required>
                        </div>
                    </div>
                    <div class="cl-row">
                        <div class="cl-field">
                            <label>رقم الطلب</label>
                            <input type="text" name="number_of_demande" value="{{ $client->number_of_demande }}" placeholder="رقم الطلب">
                        </div>
                        <div class="cl-field">
                            <label>كلمة المرور الحالية</label>
                            <input type="text" name="password" value="{{ $client->password }}" readonly style="opacity: 0.5;">
                        </div>
                    </div>
                </div>

                <!-- PASSWORD NOTE -->
                <div class="cl-note">
                    <i class="fas fa-info-circle"></i>
                    <span>ملاحظة: اترك حقل كلمة المرور فارغاً إذا كنت لا ترغب في تغييرها.</span>
                </div>

                <div class="cl-row">
                    <div class="cl-field">
                        <label>كلمة مرور جديدة (اختياري)</label>
                        <input type="password" name="password" placeholder="••••••••">
                    </div>
                </div>

                <!-- ACTIONS -->
                <div class="cl-actions">
                    <button type="submit" class="cl-btn cl-save">
                        <i class="fas fa-check"></i>
                        تحديث البيانات
                    </button>
                    <a href="{{ route('clients.index') }}" class="cl-btn cl-cancel">
                        إلغاء
                    </a>
                </div>

            </form>
        </div>

    </div>
</div>

<style>
.client-wrapper {
    min-height: 100vh;
    background: #0f172a;
    padding-bottom: 40px;
}

/* ===== HEADER ===== */
.cl-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 10px 0;
}

.cl-title {
    display: flex;
    align-items: center;
    gap: 15px;
}

.cl-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.3rem;
}

.cl-title h1 {
    color: #fff;
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0;
}

.cl-title span {
    color: #64748b;
    font-size: 0.85rem;
}

.cl-close {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.cl-close:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    border-color: rgba(239, 68, 68, 0.3);
}

/* ===== CARD ===== */
.cl-card {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 24px;
    padding: 30px;
}

/* ===== SECTION ===== */
.cl-section {
    margin-bottom: 30px;
}

.cl-section-title {
    margin-bottom: 20px;
}

.cl-section-title span {
    display: inline-block;
    font-size: 0.85rem;
    font-weight: 700;
    color: #0ea5e9;
    background: rgba(14, 165, 233, 0.1);
    padding: 6px 16px;
    border-radius: 10px;
    border: 1px solid rgba(14, 165, 233, 0.2);
}

/* ===== ROWS ===== */
.cl-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 20px;
}

.cl-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.cl-field label {
    color: #94a3b8;
    font-size: 0.9rem;
    font-weight: 600;
}

.cl-field input {
    padding: 14px 16px;
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    color: #fff;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.cl-field input::placeholder {
    color: #475569;
}

.cl-field input:focus {
    outline: none;
    border-color: #0ea5e9;
    background: rgba(255,255,255,0.05);
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
}

.cl-field input[readonly] {
    opacity: 0.5;
    cursor: not-allowed;
}

/* ===== NOTE ===== */
.cl-note {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(14, 165, 233, 0.05);
    border: 1px solid rgba(14, 165, 233, 0.1);
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 20px;
    color: #0ea5e9;
    font-size: 0.85rem;
}

.cl-note i {
    font-size: 1rem;
}

/* ===== ACTIONS ===== */
.cl-actions {
    display: flex;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.05);
}

.cl-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 14px 28px;
    border-radius: 14px;
    font-size: 1rem;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.cl-save {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
    color: #fff;
    box-shadow: 0 8px 25px rgba(14, 165, 233, 0.3);
}

.cl-save:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(14, 165, 233, 0.4);
}

.cl-cancel {
    background: rgba(255,255,255,0.05);
    color: #94a3b8;
    border: 1px solid rgba(255,255,255,0.1);
}

.cl-cancel:hover {
    background: rgba(255,255,255,0.08);
    color: #fff;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .cl-row {
        grid-template-columns: 1fr;
    }
    
    .cl-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .cl-actions {
        flex-direction: column;
    }
    
    .cl-btn {
        justify-content: center;
    }
}
</style>

@endsection