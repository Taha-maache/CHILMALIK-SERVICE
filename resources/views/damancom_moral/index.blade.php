@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="mo-card">

        {{-- HEADER --}}
        <div class="mo-header">
            <div class="mo-header-icon"><i class="fas fa-building"></i></div>
            <div>
                <h3>Damancom Moral</h3>
                <p>Gestion des comptes Damancom Moral</p>
            </div>
            <a href="{{ route('damancom-moral.create') }}" class="mo-add">
                <i class="fas fa-plus"></i> Add New
            </a>
        </div>

        <div class="mo-body">

            @if(session('success'))
            <div class="mo-alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            {{-- SEARCH --}}
            <div class="mo-searchbar">
                <div class="mo-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search by Label Name, NIN or Phone...">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="mo-table-wrap">
                <table class="mo-table" id="damancomTable">
                    <thead>
                        <tr>
                            <th>التسمية الاجتماعية</th>
                            <th>NIN</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($damancoms as $item)
                        <tr>
                            <td class="fw-semibold">{{ $item->label_name }}</td>
                            <td><span class="mo-code">{{ $item->NIN }}</span></td>
                            <td class="text-muted">{{ $item->phone }}</td>
                            <td>
                                <div class="mo-actions">
                                    <a href="{{ route('damancom-moral.edit', $item->id) }}" class="mo-btn mo-btn-edit">
                                        Modifier
                                    </a>
                                    <form action="{{ route('damancom-moral.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cet enregistrement ?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="mo-btn mo-btn-delete">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="mo-empty">
                                <i class="fas fa-folder-open"></i>
                                Aucun enregistrement.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<style>
:root {
    --mo-blue: #3b82f6;
    --mo-blue-dark: #2563eb;
    --mo-blue-soft: #eff6ff;
    --mo-border: #e5e7eb;
    --mo-bg-soft: #f8fafc;
    --mo-text: #1e293b;
    --mo-muted: #64748b;
}

body { background: #f1f5f9; }

.mo-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--mo-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* HEADER */
.mo-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: var(--mo-bg-soft);
    border-bottom: 1px solid var(--mo-border);
}
.mo-header-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: var(--mo-blue);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.mo-header h3 { margin: 0; font-weight: 700; font-size: 1.15rem; color: var(--mo-text); }
.mo-header p { margin: 3px 0 0; color: var(--mo-muted); font-size: 0.85rem; }
.mo-add {
    margin-inline-start: auto;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--mo-blue);
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.88rem;
    transition: opacity .15s ease;
    white-space: nowrap;
}
.mo-add:hover { opacity: .88; color: #fff; }

.mo-body { padding: 22px 24px; }

/* ALERT */
.mo-alert-success {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #16a34a;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.88rem;
    font-weight: 600;
    margin-bottom: 18px;
}

/* SEARCH */
.mo-searchbar { margin-bottom: 18px; }
.mo-search { position: relative; max-width: 400px; }
.mo-search > i {
    position: absolute;
    left: 14px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.mo-search input {
    width: 100%;
    padding: 10px 14px 10px 38px;
    border-radius: 10px;
    border: 1px solid var(--mo-border);
    background: #fff;
    color: var(--mo-text);
    font-size: 0.9rem;
}
.mo-search input::placeholder { color: #94a3b8; }
.mo-search input:focus {
    outline: none;
    border-color: var(--mo-blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* TABLE */
.mo-table-wrap { overflow-x: auto; border: 1px solid var(--mo-border); border-radius: 12px; }
.mo-table { width: 100%; border-collapse: collapse; }
.mo-table thead { background: var(--mo-bg-soft); }
.mo-table th {
    padding: 13px 18px;
    text-align: right;
    color: var(--mo-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid var(--mo-border);
}
.mo-table td {
    padding: 13px 18px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--mo-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.mo-table tbody tr:hover { background: var(--mo-bg-soft); }
.mo-table tbody tr:last-child td { border-bottom: none; }

.mo-code {
    font-family: 'Courier New', monospace;
    background: var(--mo-bg-soft);
    border: 1px solid var(--mo-border);
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 0.8rem;
    color: var(--mo-muted);
}

/* ACTIONS */
.mo-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.mo-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    text-decoration: none;
    border: 1.5px solid transparent;
    cursor: pointer;
    transition: all .15s ease;
    white-space: nowrap;
}
.mo-btn-edit { background: var(--mo-blue-soft); color: var(--mo-blue-dark); border-color: #bfdbfe; }
.mo-btn-edit:hover { background: var(--mo-blue); color: #fff; }

.mo-btn-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.mo-btn-delete:hover { background: #dc2626; color: #fff; }

/* EMPTY */
.mo-empty { text-align: center !important; padding: 50px 20px !important; color: #94a3b8; }
.mo-empty i { font-size: 2.2rem; margin-bottom: 12px; opacity: .4; display: block; }

@media (max-width: 768px) {
    .mo-header { flex-wrap: wrap; }
    .mo-add { width: 100%; justify-content: center; margin-inline-start: 0; }
    .mo-search { max-width: 100%; }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('searchInput');
    const table = document.getElementById('damancomTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

    input.addEventListener('keyup', function () {

        const value = this.value.toLowerCase().trim();

        for (let i = 0; i < rows.length; i++) {

            const row = rows[i];

            const label = row.cells[0]?.textContent.toLowerCase() || '';
            const nin   = row.cells[1]?.textContent.toLowerCase() || '';
            const phone = row.cells[2]?.textContent.toLowerCase() || '';

            if (
                label.includes(value) ||
                nin.includes(value) ||
                phone.includes(value)
            ) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }

    });

});
</script>
@endpush
@endsection