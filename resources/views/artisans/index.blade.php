@extends('layouts.app')

@section('content')

<style>
    :root {
        --art-primary: #6C7DF7;
        --art-primary-dark: #5567e0;
        --art-bg: #F6F7FB;
        --art-card: #FFFFFF;
        --art-border: #ECEDF5;
        --art-text: #2E3140;
        --art-muted: #8A8FA3;
        --art-radius: 16px;
        --art-shadow: 0 4px 18px rgba(60, 66, 130, 0.06);
    }

    .art-wrap {
        background: var(--art-bg);
        border-radius: var(--art-radius);
        padding: 28px;
    }

    .art-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .art-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--art-text);
        margin: 0;
    }

    .art-title .art-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        border-radius: 14px;
        font-size: 1.4rem;
    }

    .art-btn-add {
        background: var(--art-primary);
        border: none;
        color: #fff;
        font-weight: 700;
        padding: 12px 22px;
        border-radius: 12px;
        box-shadow: 0 6px 16px rgba(108, 125, 247, 0.35);
        transition: all .2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .art-btn-add:hover {
        background: var(--art-primary-dark);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(108, 125, 247, 0.4);
    }

    .art-alert-success {
        background: #EAFBF1;
        border: 1px solid #CFF3DE;
        color: #1E8A54;
        border-radius: 12px;
        padding: 14px 18px;
        font-weight: 600;
        margin-bottom: 22px;
    }

    .art-search {
        background: var(--art-card);
        border: 1px solid var(--art-border);
        border-radius: 14px;
        padding: 4px 8px;
        box-shadow: var(--art-shadow);
        display: flex;
        align-items: center;
        margin-bottom: 24px;
    }

    .art-search .art-search-icon {
        padding: 0 12px;
        color: var(--art-muted);
        font-size: 1.1rem;
    }

    .art-search input {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
        padding: 14px 6px;
        font-size: 0.98rem;
        color: var(--art-text);
    }

    .art-card-table {
        background: var(--art-card);
        border: 1px solid var(--art-border);
        border-radius: var(--art-radius);
        box-shadow: var(--art-shadow);
        overflow: hidden;
    }

    .art-table {
        margin-bottom: 0;
    }

    .art-table thead th {
        background: #FAFAFD;
        color: var(--art-muted);
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none;
        padding: 16px 18px;
        border-bottom: 1px solid var(--art-border);
    }

    .art-table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        border-bottom: 1px solid var(--art-border);
        color: var(--art-text);
        font-size: 0.94rem;
    }

    .art-table tbody tr:last-child td {
        border-bottom: none;
    }

    .art-table tbody tr {
        transition: background .15s ease;
    }

    .art-table tbody tr:hover {
        background: #FAFAFF;
    }

    .art-name {
        font-weight: 700;
        color: var(--art-text);
    }

    .art-id-pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        background: #F0F1FA;
        color: var(--art-muted);
        font-weight: 700;
        font-size: 0.82rem;
        border-radius: 8px;
    }

    .art-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .art-badge-none {
        background: #F1F2F6;
        color: #767A8C;
    }

    .art-badge-warning {
        background: #FFF4E0;
        color: #B4790E;
    }

    .art-badge-info {
        background: #E6F5FC;
        color: #157DA6;
    }

    .art-badge-success {
        background: #E4F8ED;
        color: #1E8A54;
    }

    .art-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .art-btn-icon {
        border: none;
        border-radius: 10px;
        padding: 8px 14px;
        font-weight: 700;
        font-size: 0.82rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all .15s ease;
    }

    .art-btn-edit {
        background: #FFF4E0;
        color: #B4790E;
    }

    .art-btn-edit:hover {
        background: #FCE7C2;
        color: #8C5C09;
    }

    .art-btn-delete {
        background: #FDEBEC;
        color: #C6303E;
    }

    .art-btn-delete:hover {
        background: #FADADC;
        color: #A5232F;
    }

    .art-select {
        border: 1px solid var(--art-border);
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--art-text);
        background-color: #FAFAFD;
        min-width: 175px;
    }

    .art-select:focus {
        border-color: var(--art-primary);
        box-shadow: 0 0 0 3px rgba(108, 125, 247, 0.15);
    }

    .art-empty {
        text-align: center;
        padding: 60px 20px;
        color: var(--art-muted);
    }

    .art-empty .art-empty-icon {
        font-size: 2.4rem;
        margin-bottom: 10px;
        display: block;
    }
</style>

<div class="container py-4">

    <div class="art-wrap">

        <div class="art-header">
            <h3 class="art-title">
                <span class="art-icon">👨‍🔧</span>
                قائمة الحرفيين
            </h3>

            <a href="{{ route('artisans.create') }}" class="art-btn-add">
                <span>+</span> إضافة حرفي
            </a>
        </div>

        @if(session('success'))
            <div class="art-alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- LIVE SEARCH --}}
        <div class="art-search">
            <span class="art-search-icon">🔍</span>
            <input
                type="text"
                id="artisanSearch"
                class="form-control"
                placeholder="ابحث بالاسم أو NIN أو الهاتف..."
                autocomplete="off"
            >
        </div>

        <div class="art-card-table">
            <div class="table-responsive">
                <table class="table art-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم الكامل</th>
                            <th>NIN</th>
                            <th>الهاتف</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody id="artisansTable">

                        @forelse($artisans as $artisan)

                            <tr>

                                <td>
                                    <span class="art-id-pill">{{ $artisan->id }}</span>
                                </td>

                                <td class="artisan-name art-name">
                                    {{ $artisan->full_name }}
                                </td>

                                <td class="artisan-nin">
                                    {{ $artisan->NIN }}
                                </td>

                                <td class="artisan-phone">
                                    {{ $artisan->phone }}
                                </td>

                                {{-- ETAT --}}
                                <td>
                                    @if($artisan->etat === null)

                                        <span class="art-badge art-badge-none">
                                            لم تتم أي عملية
                                        </span>

                                    @elseif($artisan->etat === 'transfere_au_char')

                                        <span class="art-badge art-badge-warning">
                                            Transféré au CHAR
                                        </span>

                                    @elseif($artisan->etat === 'recuperer_du_char')

                                        <span class="art-badge art-badge-info">
                                            Récupéré du CHAR
                                        </span>

                                    @elseif($artisan->etat === 'livrer_au_client')

                                        <span class="art-badge art-badge-success">
                                            Livré au client
                                        </span>

                                    @endif
                                </td>

                                {{-- ACTIONS --}}
                                <td>

                                    <div class="art-actions">

                                        <a href="{{ route('artisans.edit', $artisan->id) }}"
                                           class="art-btn-icon art-btn-edit">
                                            Modifier
                                        </a>

                                        <form action="{{ route('artisans.destroy', $artisan->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('هل تريد حذف هذا الحرفي؟')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="art-btn-icon art-btn-delete">
                                                حذف
                                            </button>

                                        </form>

                                        <form action="{{ route('artisans.updateEtat', $artisan->id) }}"
                                              method="POST"
                                              class="d-flex">

                                            @csrf
                                            @method('PUT')

                                            <select name="etat"
                                                    class="art-select"
                                                    onchange="this.form.submit()">

                                                <option value="">
                                                    -- اختر الحالة --
                                                </option>

                                                <option value="transfere_au_char"
                                                    {{ $artisan->etat == 'transfere_au_char' ? 'selected' : '' }}>
                                                    Transféré au CHAR
                                                </option>

                                                <option value="recuperer_du_char"
                                                    {{ $artisan->etat == 'recuperer_du_char' ? 'selected' : '' }}>
                                                    Récupéré du CHAR
                                                </option>

                                                <option value="livrer_au_client"
                                                    {{ $artisan->etat == 'livrer_au_client' ? 'selected' : '' }}>
                                                    Livré au client
                                                </option>

                                            </select>
                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">
                                    <div class="art-empty">
                                        <span class="art-empty-icon">🗂️</span>
                                        لا توجد بيانات
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>
        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('artisanSearch');

    searchInput.addEventListener('input', function () {

        const search = this.value.toLowerCase().trim();

        document.querySelectorAll('#artisansTable tr').forEach(function (row) {

            const name = row.querySelector('.artisan-name')?.textContent.toLowerCase() || '';
            const nin = row.querySelector('.artisan-nin')?.textContent.toLowerCase() || '';
            const phone = row.querySelector('.artisan-phone')?.textContent.toLowerCase() || '';

            const found =
                name.includes(search) ||
                nin.includes(search) ||
                phone.includes(search);

            row.style.display = found ? '' : 'none';
        });

    });

});
</script>

@endsection