@extends('layouts.app')

@section('content')

<style>
    :root {
        --art-primary: #6C7DF7;
        --art-primary-dark: #5567e0;
        --art-success: #2FB673;
        --art-success-dark: #26985F;
        --art-bg: #F6F7FB;
        --art-card: #FFFFFF;
        --art-border: #ECEDF5;
        --art-text: #2E3140;
        --art-muted: #8A8FA3;
        --art-radius: 18px;
        --art-shadow: 0 10px 30px rgba(60, 66, 130, 0.08);
    }

    .art-page {
        background: var(--art-bg);
        border-radius: 20px;
        padding: 40px 16px;
    }

    .art-form-card {
        background: var(--art-card);
        border: 1px solid var(--art-border);
        border-radius: var(--art-radius);
        box-shadow: var(--art-shadow);
        overflow: hidden;
    }

    .art-form-header {
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        padding: 26px 32px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .art-form-header .art-form-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        box-shadow: 0 4px 10px rgba(108, 125, 247, 0.18);
    }

    .art-form-header h4 {
        margin: 0;
        font-weight: 800;
        color: var(--art-text);
    }

    .art-form-header p {
        margin: 2px 0 0;
        color: var(--art-muted);
        font-size: 0.88rem;
    }

    .art-form-body {
        padding: 32px;
    }

    .art-field label {
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--art-text);
        margin-bottom: 8px;
        display: block;
    }

    .art-field .form-control {
        border: 1px solid var(--art-border);
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.95rem;
        background: #FAFAFD;
        transition: all .15s ease;
    }

    .art-field .form-control:focus {
        border-color: var(--art-primary);
        box-shadow: 0 0 0 4px rgba(108, 125, 247, 0.12);
        background: #fff;
    }

    .art-form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--art-border);
    }

    .art-btn-save {
        background: var(--art-success);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(47, 182, 115, 0.3);
        transition: all .2s ease;
    }

    .art-btn-save:hover {
        background: var(--art-success-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .art-btn-cancel {
        background: #F1F2F6;
        border: none;
        color: var(--art-text);
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        text-decoration: none;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
    }

    .art-btn-cancel:hover {
        background: #E5E6EE;
        color: var(--art-text);
    }
</style>

<div class="container art-page">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="art-form-card">

                <div class="art-form-header">
                    <span class="art-form-icon">➕</span>
                    <div>
                        <h4>إضافة حرفي جديد</h4>
                        <p>أدخل بيانات الحرفي الجديد ثم اضغط حفظ</p>
                    </div>
                </div>

                <div class="art-form-body">

                    <form action="{{ route('artisans.store') }}"
                          method="POST">

                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6 art-field">
                                <label>الاسم الكامل</label>
                                <input type="text"
                                       name="full_name"
                                       class="form-control"
                                       value="{{ old('full_name') }}"
                                       required>
                            </div>

                            <div class="col-md-6 art-field">
                                <label>NIN</label>
                                <input type="text"
                                       name="NIN"
                                       class="form-control"
                                       value="{{ old('NIN') }}"
                                       required>
                            </div>

                            <div class="col-md-6 art-field">
                                <label>رقم الهاتف</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control"
                                       value="{{ old('phone') }}">
                            </div>

                            <div class="col-md-6 art-field">
                                <label>رقم التسجيل (البطاقة)</label>
                                <input type="text"
                                       name="number_of_registration"
                                       class="form-control"
                                       value="{{ old('number_of_registration') }}">
                            </div>

                            <div class="col-md-6 art-field">
                                <label>رقم CASNOS</label>
                                <input type="text"
                                       name="number_of_casnos"
                                       class="form-control"
                                       value="{{ old('number_of_casnos') }}">
                            </div>

                        </div>

                        <div class="art-form-actions">

                            <button type="submit" class="art-btn-save">
                                حفظ
                            </button>

                            <a href="{{ route('artisans.index') }}" class="art-btn-cancel">
                                رجوع
                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection