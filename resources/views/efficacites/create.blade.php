@extends('layouts.app')

@section('content')

<style>
    :root {
        --eff-primary: #6C7DF7;
        --eff-primary-dark: #5567e0;
        --eff-success: #2FB673;
        --eff-success-dark: #26985F;
        --eff-bg: #F6F7FB;
        --eff-card: #FFFFFF;
        --eff-border: #ECEDF5;
        --eff-text: #2E3140;
        --eff-muted: #8A8FA3;
        --eff-radius: 18px;
        --eff-shadow: 0 10px 30px rgba(60, 66, 130, 0.08);
    }

    .eff-page {
        background: var(--eff-bg);
        border-radius: 20px;
        padding: 40px 16px;
    }

    .eff-form-card {
        background: var(--eff-card);
        border: 1px solid var(--eff-border);
        border-radius: var(--eff-radius);
        box-shadow: var(--eff-shadow);
        overflow: hidden;
    }

    .eff-form-header {
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        padding: 26px 32px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .eff-form-header .eff-form-icon {
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

    .eff-form-header h3 {
        margin: 0;
        font-weight: 800;
        color: var(--eff-text);
        font-size: 1.25rem;
    }

    .eff-form-header p {
        margin: 2px 0 0;
        color: var(--eff-muted);
        font-size: 0.88rem;
    }

    .eff-form-body {
        padding: 32px;
    }

    .eff-field label {
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--eff-text);
        margin-bottom: 8px;
        display: block;
    }

    .eff-field .form-control {
        border: 1px solid var(--eff-border);
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.95rem;
        background: #FAFAFD;
        transition: all .15s ease;
    }

    .eff-field .form-control:focus {
        border-color: var(--eff-primary);
        box-shadow: 0 0 0 4px rgba(108, 125, 247, 0.12);
        background: #fff;
    }

    .eff-form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid var(--eff-border);
    }

    .eff-btn-save {
        background: var(--eff-success);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(47, 182, 115, 0.3);
        transition: all .2s ease;
    }

    .eff-btn-save:hover {
        background: var(--eff-success-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .eff-btn-cancel {
        background: #F1F2F6;
        border: none;
        color: var(--eff-text);
        font-weight: 700;
        padding: 12px 28px;
        border-radius: 12px;
        text-decoration: none;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
    }

    .eff-btn-cancel:hover {
        background: #E5E6EE;
        color: var(--eff-text);
    }
</style>

<div class="container eff-page">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="eff-form-card">

                <div class="eff-form-header">
                    <span class="eff-form-icon">➕</span>
                    <div>
                        <h3>إضافة Efficacité</h3>
                        <p>أدخل بيانات الملف الجديد ثم اضغط حفظ</p>
                    </div>
                </div>

                <div class="eff-form-body">

                    <form action="{{ route('efficacites.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">

                            <div class="col-md-6 eff-field">
                                <label>الاسم الكامل</label>
                                <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    required
                                >
                            </div>

                            <div class="col-md-6 eff-field">
                                <label>الهاتف</label>
                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-md-6 eff-field">
                                <label>تاريخ دفع الملف</label>
                                <input
                                    type="date"
                                    name="date_Paiment_fichier"
                                    class="form-control"
                                >
                            </div>

                        </div>

                        <div class="eff-form-actions">

                            <button type="submit" class="eff-btn-save">
                                حفظ
                            </button>

                            <a href="{{ route('efficacites.index') }}" class="eff-btn-cancel">
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