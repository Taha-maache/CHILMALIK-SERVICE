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
        --res-radius: 16px;
        --res-shadow: 0 4px 18px rgba(60, 66, 130, 0.06);
    }

    .res-wrap {
        background: var(--res-bg);
        border-radius: var(--res-radius);
        padding: 28px;
    }

    .res-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .res-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 800;
        font-size: 1.5rem;
        color: var(--res-text);
        margin: 0;
    }

    .res-title .res-icon {
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #EFF1FE, #E4E7FD);
        border-radius: 14px;
        font-size: 1.4rem;
    }

    .res-btn-add {
        background: var(--res-primary);
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

    .res-btn-add:hover {
        background: var(--res-primary-dark);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(108, 125, 247, 0.4);
    }

    .res-search {
        background: var(--res-card);
        border: 1px solid var(--res-border);
        border-radius: 14px;
        padding: 4px 8px;
        box-shadow: var(--res-shadow);
        display: flex;
        align-items: center;
        margin-bottom: 24px;
        max-width: 480px;
    }

    .res-search .res-search-icon {
        padding: 0 12px;
        color: var(--res-muted);
        font-size: 1.1rem;
    }

    .res-search input {
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
        padding: 14px 6px;
        font-size: 0.98rem;
        color: var(--res-text);
    }

    .res-card-table {
        background: var(--res-card);
        border: 1px solid var(--res-border);
        border-radius: var(--res-radius);
        box-shadow: var(--res-shadow);
        overflow: hidden;
    }

    .res-table {
        margin-bottom: 0;
    }

    .res-table thead th {
        background: #FAFAFD;
        color: var(--res-muted);
        font-weight: 700;
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: .03em;
        border: none;
        padding: 16px 18px;
        border-bottom: 1px solid var(--res-border);
    }

    .res-table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        border-bottom: 1px solid var(--res-border);
        color: var(--res-text);
        font-size: 0.94rem;
    }

    .res-table tbody tr:last-child td {
        border-bottom: none;
    }

    .res-table tbody tr {
        transition: background .15s ease;
    }

    .res-table tbody tr:hover {
        background: #FAFAFF;
    }

    .res-table tbody tr.res-expired {
        background: #FEF3F3;
    }

    .res-table tbody tr.res-expired:hover {
        background: #FDEAEA;
    }

    .res-table tbody tr.res-expired td {
        color: #C6303E;
    }

    .res-name {
        font-weight: 700;
        color: var(--res-text);
    }

    .res-badge {
        display: inline-block;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.78rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .res-badge-expired {
        background: #FDEBEC;
        color: #C6303E;
    }

    .res-badge-valid {
        background: #E4F8ED;
        color: #1E8A54;
    }

    .res-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .res-btn-icon {
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

    .res-btn-edit {
        background: #FFF4E0;
        color: #B4790E;
    }

    .res-btn-edit:hover {
        background: #FCE7C2;
        color: #8C5C09;
    }

    .res-btn-delete {
        background: #FDEBEC;
        color: #C6303E;
    }

    .res-btn-delete:hover {
        background: #FADADC;
        color: #A5232F;
    }

    .res-empty {
        text-align: center;
        padding: 60px 20px;
        color: var(--res-muted);
    }

    .res-empty .res-empty-icon {
        font-size: 2.4rem;
        margin-bottom: 10px;
        display: block;
    }
</style>

<div class="container py-4">

    <div class="res-wrap">

        {{-- HEADER --}}
        <div class="res-header">
            <h3 class="res-title">
                <span class="res-icon">📋</span>
                إدارة المعنيين
            </h3>

            <a href="{{ route('respectes.create') }}" class="res-btn-add">
                <span>+</span> إضافة
            </a>
        </div>

        {{-- SEARCH --}}
        <div class="res-search">
            <span class="res-search-icon">🔍</span>
            <input
                type="text"
                id="search"
                class="form-control"
                placeholder="بحث بالاسم أو الهاتف أو التسمية الاجتماعية..."
            >
        </div>

        {{-- TABLE --}}
        <div class="res-card-table">
            <div class="table-responsive">
                <table class="table res-table align-middle mb-0">

                    <thead>
                        <tr>
                            <th>التسمية الاجتماعية</th>
                            <th>اسم ولقب المسير</th>
                            <th>الهاتف</th>
                            <th>تاريخ الشهادة</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody id="respectesTable">

                    @forelse($respectes as $respecte)

                        @php

                            $isExpired = false;

                            if ($respecte->date_of_this) {

                                $isExpired =
                                    \Carbon\Carbon::parse($respecte->date_of_this)
                                    ->addMonths(23)
                                    ->isPast();

                            }

                        @endphp


                        <tr class="{{ $isExpired ? 'res-expired' : '' }}">

                            <td>
                                {{ $respecte->resaux_social }}
                            </td>

                            <td class="res-name">
                                {{ $respecte->full_name_of_moussayer }}
                            </td>

                            <td>
                                {{ $respecte->phone_of_moussayer }}
                            </td>

                            <td>

                                @if($respecte->date_of_this)

                                    {{ $respecte->date_of_this->format('d/m/Y') }}

                                @else

                                    -

                                @endif

                            </td>

                            <td>

                                @if($isExpired)

                                    <span class="res-badge res-badge-expired">
                                        ⚠️ يجب التجديد
                                    </span>

                                @else

                                    <span class="res-badge res-badge-valid">
                                        ✓ صالح
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="res-actions">

                                    <a href="{{ route('respectes.edit', $respecte->id) }}"
                                       class="res-btn-icon res-btn-edit">
                                        تعديل
                                    </a>

                                    <form action="{{ route('respectes.destroy', $respecte->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="res-btn-icon res-btn-delete"
                                            onclick="return confirm('هل تريد الحذف؟')">
                                            حذف
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                <div class="res-empty">
                                    <span class="res-empty-icon">🗂️</span>
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


{{-- LIVE SEARCH --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('search');

    const tableBody = document.getElementById('respectesTable');

    let timer;


    searchInput.addEventListener('input', function () {

        clearTimeout(timer);


        timer = setTimeout(function () {

            const search = searchInput.value.trim();


            fetch(
                "{{ route('respectes.index') }}?search="
                + encodeURIComponent(search),
                {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }
            )

            .then(response => response.text())

            .then(html => {

                const parser =
                    new DOMParser();

                const doc =
                    parser.parseFromString(
                        html,
                        'text/html'
                    );


                const newTable =
                    doc.querySelector('#respectesTable');


                if (newTable) {

                    tableBody.innerHTML =
                        newTable.innerHTML;

                }

            })

            .catch(error => {

                console.error(
                    'Search error:',
                    error
                );

            });

        }, 250);

    });

});

</script>

@endsection