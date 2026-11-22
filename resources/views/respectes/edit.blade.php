@extends('layouts.app')

@section('content')

<style>
    :root {
        --res-primary: #6C7DF7;
        --res-primary-dark: #5567e0;
        --res-bg: #F6F7FB;
        --res-card: #FFFFFF;
        --res-border: #ECEDF5;
        --res-text: #2E3140;
        --res-muted: #8A8FA3;
        --res-radius: 18px;
        --res-shadow: 0 10px 30px rgba(60, 66, 130, 0.08);
    }

    .res-page {
        background: var(--res-bg);
        border-radius: 20px;
        padding: 40px 16px;
    }

    .res-form-card {
        background: var(--res-card);
        border: 1px solid var(--res-border);
        border-radius: var(--res-radius);
        box-shadow: var(--res-shadow);
        overflow: hidden;
    }

    .res-form-header {
        background: linear-gradient(135deg, #FFF3DC, #FDE8C2);
        padding: 26px 32px;
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .res-form-header .res-form-icon {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        box-shadow: 0 4px 10px rgba(180, 121, 14, 0.18);
    }

    .res-form-header h2 {
        margin: 0;
        font-weight: 800;
        color: var(--res-text);
        font-size: 1.25rem;
    }

    .res-form-header p {
        margin: 2px 0 0;
        color: var(--res-muted);
        font-size: 0.88rem;
    }

    .res-form-body {
        padding: 32px;
    }

    .res-section-block {
        background: var(--res-bg);
        border: 1px solid var(--res-border);
        border-radius: 16px;
        padding: 24px;
    }

    .res-section-block h5 {
        color: var(--res-primary);
        font-weight: 700;
        margin-bottom: 22px;
        font-size: 1rem;
    }

    .res-field label {
        font-weight: 700;
        font-size: 0.88rem;
        color: var(--res-text);
        margin-bottom: 8px;
        display: block;
    }

    .res-field .form-control {
        border: 1px solid var(--res-border);
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 0.95rem;
        background: #FAFAFD;
        transition: all .15s ease;
    }

    .res-field .form-control:focus {
        border-color: var(--res-primary);
        box-shadow: 0 0 0 4px rgba(108, 125, 247, 0.12);
        background: #fff;
    }

    .res-form-actions {
        display: flex;
        gap: 12px;
        margin-top: 32px;
    }

    .res-btn-update {
        background: var(--res-primary);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 13px 25px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(108, 125, 247, 0.3);
        transition: all .2s ease;
        flex-grow: 1;
    }

    .res-btn-update:hover {
        background: var(--res-primary-dark);
        color: #fff;
        transform: translateY(-1px);
    }

    .res-btn-cancel {
        background: #fff;
        border: 1.5px solid var(--res-border);
        color: var(--res-muted);
        font-weight: 700;
        padding: 13px 25px;
        border-radius: 12px;
        text-decoration: none;
        transition: all .2s ease;
        display: inline-flex;
        align-items: center;
    }

    .res-btn-cancel:hover {
        background: var(--res-bg);
        color: var(--res-text);
    }
</style>

<div class="container res-page">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="res-form-card">

                {{-- HEADER --}}
                <div class="res-form-header">
                    <span class="res-form-icon">✏️</span>
                    <div>
                        <h2>تعديل شهادة الاحترام</h2>
                        <p>تعديل بيانات: {{ $respecte->full_name_of_moussayer }}</p>
                    </div>
                </div>

                {{-- BODY --}}
                <div class="res-form-body">

                    <form
                        action="{{ route('respectes.update', $respecte->id) }}"
                        method="POST">

                        @csrf
                        @method('PUT')

                        <div class="res-section-block">

                            <h5>📌 معلومات الـ Respecte</h5>

                            <div class="row g-4">

                                {{-- RESEAUX SOCIAL --}}
                                <div class="col-md-6 res-field">
                                    <label>التسمية الاجتماعية</label>
                                    <input
                                        type="text"
                                        name="resaux_social"
                                        class="form-control"
                                        value="{{ old('resaux_social', $respecte->resaux_social) }}"
                                    >
                                    @error('resaux_social')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- FULL NAME --}}
                                <div class="col-md-6 res-field">
                                    <label>اسم ولقب المسير</label>
                                    <input
                                        type="text"
                                        name="full_name_of_moussayer"
                                        class="form-control"
                                        value="{{ old('full_name_of_moussayer', $respecte->full_name_of_moussayer) }}"
                                        required
                                    >
                                    @error('full_name_of_moussayer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- PHONE --}}
                                <div class="col-md-6 res-field">
                                    <label>رقم هاتف المسير</label>
                                    <input
                                        type="text"
                                        name="phone_of_moussayer"
                                        class="form-control"
                                        value="{{ old('phone_of_moussayer', $respecte->phone_of_moussayer) }}"
                                    >
                                    @error('phone_of_moussayer')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- DATE --}}
                                <div class="col-md-6 res-field">
                                    <label>تاريخ الشهادة</label>
                                    <input
                                        type="date"
                                        name="date_of_this"
                                        class="form-control"
                                        value="{{ old(
                                            'date_of_this',
                                            $respecte->date_of_this
                                                ? $respecte->date_of_this->format('Y-m-d')
                                                : ''
                                        ) }}"
                                    >
                                    @error('date_of_this')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        {{-- BUTTONS --}}
                        <div class="res-form-actions">

                            <button type="submit" class="res-btn-update">
                                💾 تحديث
                            </button>

                            <a href="{{ route('respectes.index') }}" class="res-btn-cancel">
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