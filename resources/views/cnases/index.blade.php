@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="cn-header">
        <div class="cn-header-icon"><i class="fas fa-laptop"></i></div>
        <div>
            <h2>Gestion Cnas</h2>
            <p>Gestion des comptes Cnas</p>
        </div>
    </div>

    {{-- TOP BAR --}}
    <div class="cn-topbar">
        <a href="{{ route('cnases.create') }}" class="cn-add">
            <i class="fas fa-plus-circle"></i>
            Ajouter Nouveau
        </a>

        <div class="cn-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Rechercher par nom ou téléphone...">
        </div>
    </div>

    {{-- TABLE --}}
    <div class="cn-card">
        <div class="table-responsive">
            <table class="cn-table align-middle">
                <thead>
                    <tr>
                        <th>Nom Complet</th>
                        <th>Téléphone</th>
                        <th>code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @if($cnases->count())
                        @foreach($cnases as $cnas)
                        <tr>
                            <td class="fw-semibold">{{ $cnas->full_name }}</td>
                            <td><span class="cn-badge-phone">{{ $cnas->phone }}</span></td>
                            <td>{{ $cnas->code }}</td>
                            <td>
                                <div class="cn-actions">
                                    <a href="{{ route('cnases.edit', $cnas->id) }}" class="cn-btn cn-btn-edit" title="Modifier">
                                        Modifier
                                    </a>
                                    <form action="{{ route('cnases.destroy', $cnas->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="cn-btn cn-btn-delete" onclick="return confirm('Supprimer cet élément ?')" title="Supprimer">
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
                                <div class="cn-empty">
                                    <i class="fas fa-folder-open"></i>
                                    <h4>Aucune donnée disponible</h4>
                                    <p>Aucun compte Cnas n'a encore été ajouté.</p>
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
    --cn-blue: #3b82f6;
    --cn-blue-dark: #2563eb;
    --cn-blue-soft: #eff6ff;
    --cn-border: #e5e7eb;
    --cn-bg-soft: #f8fafc;
    --cn-text: #1e293b;
    --cn-muted: #64748b;
}

body { background: #f1f5f9; }

/* HEADER */
.cn-header {
    display: flex;
    align-items: center;
    gap: 16px;
    background: var(--cn-blue-soft);
    border: 1px solid #bfdbfe;
    border-radius: 16px;
    padding: 22px 26px;
    margin-bottom: 24px;
}
.cn-header-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--cn-blue);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.cn-header h2 { margin: 0; font-weight: 800; font-size: 1.3rem; color: var(--cn-text); }
.cn-header p { margin: 4px 0 0; color: var(--cn-muted); font-size: 0.88rem; }

/* TOP BAR */
.cn-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.cn-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--cn-blue);
    color: #fff;
    padding: 11px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: opacity .15s ease;
}
.cn-add:hover { opacity: .88; color: #fff; }

.cn-search { position: relative; width: 360px; max-width: 100%; }
.cn-search > i {
    position: absolute;
    left: 16px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.cn-search input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    border-radius: 10px;
    border: 1px solid var(--cn-border);
    background: #fff;
    color: var(--cn-text);
    font-size: 0.9rem;
}
.cn-search input::placeholder { color: #94a3b8; }
.cn-search input:focus {
    outline: none;
    border-color: var(--cn-blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* CARD / TABLE */
.cn-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--cn-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}
.cn-table { width: 100%; margin: 0; border-collapse: collapse; }
.cn-table thead { background: var(--cn-bg-soft); }
.cn-table th {
    padding: 14px 20px;
    color: var(--cn-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid var(--cn-border);
}
.cn-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--cn-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.cn-table tbody tr:hover { background: var(--cn-bg-soft); }
.cn-table tbody tr:last-child td { border-bottom: none; }

.cn-badge-phone {
    display: inline-block;
    background: var(--cn-blue-soft);
    color: var(--cn-blue-dark);
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
}

/* ACTIONS */
.cn-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.cn-btn {
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
.cn-btn-edit { background: var(--cn-blue-soft); color: var(--cn-blue-dark); border-color: #bfdbfe; }
.cn-btn-edit:hover { background: var(--cn-blue); color: #fff; }

.cn-btn-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.cn-btn-delete:hover { background: #dc2626; color: #fff; }

/* EMPTY */
.cn-empty { padding: 70px 20px; text-align: center; color: #94a3b8; }
.cn-empty i { font-size: 3rem; margin-bottom: 16px; color: #cbd5e1; display: block; }
.cn-empty h4 { color: var(--cn-text); font-weight: 700; font-size: 1rem; margin-bottom: 6px; }
.cn-empty p { font-size: 0.85rem; margin: 0; }

@media (max-width: 768px) {
    .cn-topbar { flex-direction: column; align-items: stretch; }
    .cn-add { justify-content: center; }
    .cn-search { width: 100%; }
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