@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="bf-card">

        {{-- HEADER --}}
        <div class="bf-header">
            <div class="bf-header-icon"><i class="fas fa-users"></i></div>
            <div>
                <h3>Liste des bénéficiaires</h3>
                <p>Gestion des bénéficiaires</p>
            </div>
            <a href="{{ route('beneficiaries.create') }}" class="bf-add">
                <i class="fas fa-plus"></i> Nouveau bénéficiaire
            </a>
        </div>

        <div class="bf-body">

            @if(session('success'))
            <div class="bf-alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            {{-- SEARCH --}}
            <div class="bf-searchbar">
                <div class="bf-search">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Rechercher...">
                </div>
            </div>

            {{-- TABLE --}}
            <div class="bf-table-wrap">
                <table class="bf-table text-center" id="myTable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Nationalité</th>
                            <th>Pourcentage</th>
                            <th style="width:420px">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beneficiaries as $beneficiary)
                        <tr>
                            <td class="fw-semibold text-start">
                                @if($beneficiary->mentioned=="oui")
                                    {{ $beneficiary->full_identity }}
                                @else
                                    {{ $beneficiary->full_name }}
                                @endif
                            </td>
                            <td class="text-muted">{{ $beneficiary->nationalities }}</td>
                            <td><span class="bf-badge">{{ $beneficiary->percentage }} %</span></td>
                            <td>
                                <div class="bf-actions">
                                    <a href="{{ route('beneficiaries.pdf_ar', $beneficiary->id) }}" target="_blank" class="bf-btn bf-btn-warning">
                                        PDF AR
                                    </a>
                                    <a href="{{ route('beneficiaries.pdf_fr', $beneficiary->id) }}" target="_blank" class="bf-btn bf-btn-info">
                                        PDF FR
                                    </a>
                                    <a href="{{ route('beneficiaries.edit', $beneficiary->id) }}" class="bf-btn bf-btn-primary">
                                        Modifier
                                    </a>
                                    <form action="{{ route('beneficiaries.destroy', $beneficiary->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bf-btn bf-btn-danger" onclick="return confirm('Supprimer ?')">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="bf-empty">
                                <i class="fas fa-folder-open"></i>
                                Aucun bénéficiaire trouvé
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
    --bf-blue: #3b82f6;
    --bf-blue-dark: #2563eb;
    --bf-blue-soft: #eff6ff;
    --bf-border: #e5e7eb;
    --bf-bg-soft: #f8fafc;
    --bf-text: #1e293b;
    --bf-muted: #64748b;
}

body { background: #f1f5f9; }

.bf-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--bf-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    overflow: hidden;
}

/* HEADER */
.bf-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px 24px;
    background: var(--bf-bg-soft);
    border-bottom: 1px solid var(--bf-border);
    flex-wrap: wrap;
}
.bf-header-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    background: var(--bf-blue);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.bf-header h3 { margin: 0; font-weight: 700; font-size: 1.15rem; color: var(--bf-text); }
.bf-header p { margin: 3px 0 0; color: var(--bf-muted); font-size: 0.85rem; }
.bf-add {
    margin-inline-start: auto;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--bf-blue);
    color: #fff;
    padding: 10px 20px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.88rem;
    transition: opacity .15s ease;
    white-space: nowrap;
}
.bf-add:hover { opacity: .88; color: #fff; }

.bf-body { padding: 22px 24px; }

/* ALERT */
.bf-alert-success {
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
.bf-searchbar { margin-bottom: 18px; }
.bf-search { position: relative; max-width: 380px; }
.bf-search > i {
    position: absolute;
    left: 14px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.bf-search input {
    width: 100%;
    padding: 10px 14px 10px 38px;
    border-radius: 10px;
    border: 1px solid var(--bf-border);
    background: #fff;
    color: var(--bf-text);
    font-size: 0.9rem;
}
.bf-search input::placeholder { color: #94a3b8; }
.bf-search input:focus {
    outline: none;
    border-color: var(--bf-blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* TABLE */
.bf-table-wrap { overflow-x: auto; border: 1px solid var(--bf-border); border-radius: 12px; }
.bf-table { width: 100%; border-collapse: collapse; }
.bf-table thead { background: var(--bf-bg-soft); }
.bf-table th {
    padding: 13px 18px;
    color: var(--bf-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid var(--bf-border);
}
.bf-table td {
    padding: 13px 18px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--bf-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.bf-table tbody tr:hover { background: var(--bf-bg-soft); }
.bf-table tbody tr:last-child td { border-bottom: none; }

.bf-badge {
    display: inline-block;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    background: var(--bf-blue-soft);
    color: var(--bf-blue-dark);
}

/* ACTIONS */
.bf-actions { display: flex; justify-content: center; gap: 6px; flex-wrap: wrap; }
.bf-btn {
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
.bf-btn-warning { background: #fffbeb; color: #b45309; border-color: #fde68a; }
.bf-btn-warning:hover { background: #d97706; color: #fff; }

.bf-btn-info { background: #ecfeff; color: #0e7490; border-color: #a5f3fc; }
.bf-btn-info:hover { background: #0891b2; color: #fff; }

.bf-btn-primary { background: var(--bf-blue-soft); color: var(--bf-blue-dark); border-color: #bfdbfe; }
.bf-btn-primary:hover { background: var(--bf-blue); color: #fff; }

.bf-btn-danger { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.bf-btn-danger:hover { background: #dc2626; color: #fff; }

/* EMPTY */
.bf-empty { padding: 50px 20px !important; color: #94a3b8; }
.bf-empty i { font-size: 2.2rem; margin-bottom: 12px; opacity: .4; display: block; }

@media (max-width: 768px) {
    .bf-header { flex-direction: column; align-items: flex-start; }
    .bf-add { width: 100%; justify-content: center; margin-inline-start: 0; }
    .bf-search { max-width: 100%; }
}
</style>

<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll("#myTable tbody tr");
    rows.forEach(function (row) {
        row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
    });
});
</script>
@endsection