@extends('layouts.app')

@section('content')

<style>
    :root {
        --eff-primary: #6C7DF7;
        --eff-primary-dark: #5567e0;
        --eff-bg: #F6F7FB;
        --eff-card: #FFFFFF;
        --eff-border: #ECEDF5;
        --eff-text: #2E3140;
        --eff-muted: #8A8FA3;
        --eff-radius: 16px;
        --eff-shadow: 0 4px 18px rgba(60, 66, 130, 0.06);
    }

    .eff-wrap {
        background: var(--eff-bg);
        border-radius: var(--eff-radius);
        padding: 28px;
    }

    .eff-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .eff-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--eff-text);
        margin: 0;
    }

    .eff-title .eff-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        border-radius: 14px;
        font-size: 1.4rem;
    }

    .eff-btn-add {
        background: var(--eff-primary);
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

    .eff-btn-add:hover {
        background: var(--eff-primary-dark);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(108, 125, 247, 0.4);
    }

    .eff-search {
        background: var(--eff-card);
        border: 1px solid var(--eff-border);
        border-radius: 14px;
        padding: 4px 8px;
        box-shadow: var(--eff-shadow);
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        max-width: 480px;
    }

    .eff-search .eff-search-icon {
        padding: 0 12px;
        color: var(--eff-muted);
        font-size: 1.1rem;
    }

    .eff-search input {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
        padding: 14px 6px;
        font-size: 0.98rem;
        color: var(--eff-text);
    }

    .eff-card-table {
        background: var(--eff-card);
        border: 1px solid var(--eff-border);
        border-radius: var(--eff-radius);
        box-shadow: var(--eff-shadow);
        overflow: hidden;
    }

    .eff-table {
        margin-bottom: 0;
    }

    .eff-table thead th {
        background: #FAFAFD;
        color: var(--eff-muted);
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none;
        padding: 16px 18px;
        border-bottom: 1px solid var(--eff-border);
    }

    .eff-table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        border-bottom: 1px solid var(--eff-border);
        color: var(--eff-text);
        font-size: 0.94rem;
    }

    .eff-table tbody tr:last-child td {
        border-bottom: none;
    }

    .eff-table tbody tr {
        transition: background .15s ease;
    }

    .eff-table tbody tr:hover {
        background: #FAFAFF;
    }

    .eff-name {
        font-weight: 700;
        color: var(--eff-text);
    }

    .eff-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .eff-badge-none {
        background: #F1F2F6;
        color: #767A8C;
    }

    .eff-badge-warning {
        background: #FFF4E0;
        color: #B4790E;
    }

    .eff-badge-info {
        background: #E6F5FC;
        color: #157DA6;
    }

    .eff-badge-success {
        background: #E4F8ED;
        color: #1E8A54;
    }

    .eff-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .eff-btn-icon {
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

    .eff-btn-edit {
        background: #FFF4E0;
        color: #B4790E;
    }

    .eff-btn-edit:hover {
        background: #FCE7C2;
        color: #8C5C09;
    }

    .eff-btn-delete {
        background: #FDEBEC;
        color: #C6303E;
    }

    .eff-btn-delete:hover {
        background: #FADADC;
        color: #A5232F;
    }

    .eff-select {
        border: 1px solid var(--eff-border);
        border-radius: 10px;
        padding: 8px 10px;
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--eff-text);
        background-color: #FAFAFD;
        min-width: 190px;
    }

    .eff-select:focus {
        border-color: var(--eff-primary);
        box-shadow: 0 0 0 3px rgba(108, 125, 247, 0.15);
    }

    .eff-empty {
        text-align: center;
        padding: 60px 20px;
        color: var(--eff-muted);
    }

    .eff-empty .eff-empty-icon {
        font-size: 2.4rem;
        margin-bottom: 10px;
        display: block;
    }
</style>

<div class="container py-4">

    <div class="eff-wrap">

        <div class="eff-header">
            <h3 class="eff-title">
                <span class="eff-icon">📋</span>
                capacité
            </h3>

            <a href="{{ route('efficacites.create') }}" class="eff-btn-add">
                <span>+</span> إضافة
            </a>
        </div>

        {{-- LIVE SEARCH (AJAX) --}}
        <div class="eff-search">
            <span class="eff-search-icon">🔍</span>
            <input
                type="text"
                id="searchEfficacite"
                class="form-control"
                placeholder="بحث بالاسم أو رقم الهاتف..."
                autocomplete="off"
            >
        </div>

        <div class="eff-card-table">
            <div class="table-responsive">
                <table class="table eff-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>الاسم الكامل</th>
                            <th>الهاتف</th>
                            <th>تاريخ دفع الملف</th>
                            <th>الحالة</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="efficacitesTable">

                        @forelse($efficacites as $efficacite)

                            <tr>

                                <td class="eff-name">
                                    {{ $efficacite->full_name }}
                                </td>

                                <td>
                                    {{ $efficacite->phone }}
                                </td>

                                <td>
                                    {{ $efficacite->date_Paiment_fichier?->format('Y-m-d') }}
                                </td>

                                {{-- ETAT --}}
                                <td>

                                    @if($efficacite->etat === 'transferer_au_ecole')

                                        <span class="eff-badge eff-badge-warning">
                                            Transféré à l'école
                                        </span>

                                    @elseif($efficacite->etat === 'recuperer_du_ecole')

                                        <span class="eff-badge eff-badge-info">
                                            Récupéré de l'école
                                        </span>

                                    @elseif($efficacite->etat === 'livrer_au_client')

                                        <span class="eff-badge eff-badge-success">
                                            Livré au client
                                        </span>

                                    @else

                                        <span class="eff-badge eff-badge-none">
                                            Non défini
                                        </span>

                                    @endif

                                </td>

                                {{-- ACTIONS --}}
                                <td>

                                    <div class="eff-actions">

                                        {{-- EDIT --}}
                                        <a href="{{ route('efficacites.edit', $efficacite->id) }}"
                                           class="eff-btn-icon eff-btn-edit">
                                            EDIT
                                        </a>

                                        {{-- DELETE --}}
                                        <form
                                            action="{{ route('efficacites.destroy', $efficacite->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="eff-btn-icon eff-btn-delete">
                                                DELETE
                                            </button>

                                        </form>

                                        {{-- ETAT --}}
                                        <form
                                            action="{{ route('efficacites.updateEtat', $efficacite->id) }}"
                                            method="POST"
                                            class="d-flex">

                                            @csrf
                                            @method('PUT')

                                            <select
                                                name="etat"
                                                class="eff-select"
                                                onchange="this.form.submit()">

                                                <option value="">
                                                    -- اختر الحالة --
                                                </option>

                                                <option value="transferer_au_ecole"
                                                    {{ $efficacite->etat === 'transferer_au_ecole' ? 'selected' : '' }}>
                                                    Transféré à l'école
                                                </option>

                                                <option value="recuperer_du_ecole"
                                                    {{ $efficacite->etat === 'recuperer_du_ecole' ? 'selected' : '' }}>
                                                    Récupéré de l'école
                                                </option>

                                                <option value="livrer_au_client"
                                                    {{ $efficacite->etat === 'livrer_au_client' ? 'selected' : '' }}>
                                                    Livré au client
                                                </option>

                                            </select>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5">
                                    <div class="eff-empty">
                                        <span class="eff-empty-icon">🗂️</span>
                                        لا توجد ملفات حالياً
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

    const searchInput = document.getElementById('searchEfficacite');
    const tableBody = document.getElementById('efficacitesTable');

    let timer;

    searchInput.addEventListener('input', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {

            const search = searchInput.value.trim();

            fetch("{{ route('efficacites.index') }}?search=" + encodeURIComponent(search), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {

                const parser = new DOMParser();

                const doc = parser.parseFromString(html, 'text/html');

                const newTableBody =
                    doc.querySelector('#efficacitesTable');

                if (newTableBody) {
                    tableBody.innerHTML = newTableBody.innerHTML;
                }

            })
            .catch(error => {
                console.error('Search error:', error);
            });

        }, 250);

    });

});

</script>

@endsection