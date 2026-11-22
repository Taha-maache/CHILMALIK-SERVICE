@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="dm-header">
        <div class="dm-header-icon"><i class="fas fa-laptop"></i></div>
        <div>
            <h2>Gestion Damancom</h2>
            <p>Gestion des comptes Damancom</p>
        </div>
    </div>

    {{-- TOP BAR --}}
    <div class="dm-topbar">
        <a href="{{ route('damancoms.create') }}" class="dm-add">
            <i class="fas fa-plus-circle"></i>
            Ajouter Nouveau
        </a>

        <div class="dm-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Rechercher par nom ou téléphone...">
        </div>
    </div>

    {{-- TABLE --}}
    <div class="dm-card">
        <div class="table-responsive">
            <table class="dm-table align-middle">
                <thead>
                    <tr>
                        <th>Nom Complet</th>
                        <th>Téléphone</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @if($damancoms->count())
                        @foreach($damancoms as $damancom)
                        <tr>
                            <td class="fw-semibold">{{ $damancom->full_name }}</td>
                            <td><span class="dm-badge-phone">{{ $damancom->phone }}</span></td>
                            <td>{{ $damancom->code }}</td>
                            <td>
                                <div class="dm-actions">
                                    <a href="{{ route('damancoms.edit', $damancom->id) }}" class="dm-btn dm-btn-edit" title="Modifier">
                                        Modifier
                                    </a>
                                    <form action="{{ route('damancoms.destroy', $damancom->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="dm-btn dm-btn-delete" onclick="return confirm('Supprimer cet élément ?')" title="Supprimer">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3">
                                <div class="dm-empty">
                                    <i class="fas fa-folder-open"></i>
                                    <h4>Aucune donnée disponible</h4>
                                    <p>Aucun compte Damancom n'a encore été ajouté.</p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
:root {
    --dm-blue: #3b82f6;
    --dm-blue-dark: #2563eb;
    --dm-blue-soft: #eff6ff;
    --dm-border: #e5e7eb;
    --dm-bg-soft: #f8fafc;
    --dm-text: #1e293b;
    --dm-muted: #64748b;
}

body { background: #f1f5f9; }

/* HEADER */
.dm-header {
    display: flex;
    align-items: center;
    gap: 16px;
    background: var(--dm-blue-soft);
    border: 1px solid #bfdbfe;
    border-radius: 16px;
    padding: 22px 26px;
    margin-bottom: 24px;
}
.dm-header-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--dm-blue);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.dm-header h2 { margin: 0; font-weight: 800; font-size: 1.3rem; color: var(--dm-text); }
.dm-header p { margin: 4px 0 0; color: var(--dm-muted); font-size: 0.88rem; }

/* TOP BAR */
.dm-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.dm-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--dm-blue);
    color: #fff;
    padding: 11px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: opacity .15s ease;
}
.dm-add:hover { opacity: .88; color: #fff; }

.dm-search { position: relative; width: 360px; max-width: 100%; }
.dm-search > i {
    position: absolute;
    left: 16px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.dm-search input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    border-radius: 10px;
    border: 1px solid var(--dm-border);
    background: #fff;
    color: var(--dm-text);
    font-size: 0.9rem;
}
.dm-search input::placeholder { color: #94a3b8; }
.dm-search input:focus {
    outline: none;
    border-color: var(--dm-blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* CARD / TABLE */
.dm-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--dm-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}
.dm-table { width: 100%; margin: 0; border-collapse: collapse; }
.dm-table thead { background: var(--dm-bg-soft); }
.dm-table th {
    padding: 14px 20px;
    color: var(--dm-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid var(--dm-border);
}
.dm-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--dm-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.dm-table tbody tr:hover { background: var(--dm-bg-soft); }
.dm-table tbody tr:last-child td { border-bottom: none; }

.dm-badge-phone {
    display: inline-block;
    background: var(--dm-blue-soft);
    color: var(--dm-blue-dark);
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
}

/* ACTIONS */
.dm-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.dm-btn {
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
.dm-btn-edit { background: var(--dm-blue-soft); color: var(--dm-blue-dark); border-color: #bfdbfe; }
.dm-btn-edit:hover { background: var(--dm-blue); color: #fff; }

.dm-btn-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.dm-btn-delete:hover { background: #dc2626; color: #fff; }

/* EMPTY */
.dm-empty { padding: 70px 20px; text-align: center; color: #94a3b8; }
.dm-empty i { font-size: 3rem; margin-bottom: 16px; color: #cbd5e1; display: block; }
.dm-empty h4 { color: var(--dm-text); font-weight: 700; font-size: 1rem; margin-bottom: 6px; }
.dm-empty p { font-size: 0.85rem; margin: 0; }

@media (max-width: 768px) {
    .dm-topbar { flex-direction: column; align-items: stretch; }
    .dm-add { justify-content: center; }
    .dm-search { width: 100%; }
}
</style>

<script>
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    let rows = document.querySelectorAll('#tableBody tr');
    rows.forEach(function (row) {
        let text = row.innerText.toLowerCase();
        row.style.display = text.indexOf(value) > -1 ? '' : 'none';
    });
});
</script>
@endsection