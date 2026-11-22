@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="jb-header">
        <div class="jb-header-icon"><i class="fas fa-laptop"></i></div>
        <div>
            <h2>Gestion Jibayatic</h2>
            <p>Gestion des comptes Jibayatic</p>
        </div>
    </div>

    {{-- TOP BAR --}}
    <div class="jb-topbar">
        <a href="{{ route('jibayatics.create') }}" class="jb-add">
            <i class="fas fa-plus-circle"></i>
            Ajouter Nouveau
        </a>

        <div class="jb-search">
            <i class="fas fa-search"></i>
            <input type="text" id="searchInput" placeholder="Rechercher par nom ou téléphone...">
        </div>
    </div>

    {{-- TABLE --}}
    <div class="jb-card">
        <div class="table-responsive">
            <table class="jb-table align-middle">
                <thead>
                    <tr>
                        <th>Nom Complet</th>
                        <th>Téléphone</th>
                        <th>Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @if($jibayatics->count())
                        @foreach($jibayatics as $jibayatic)
                        <tr>
                            <td class="fw-semibold">{{ $jibayatic->full_name }}</td>
                            <td><span class="jb-badge-phone">{{ $jibayatic->phone }}</span></td>
                            <td>{{ $jibayatic->code }}</td>
                            <td>
                                <div class="jb-actions">
                                    <a href="{{ route('jibayatics.edit', $jibayatic->id) }}" class="jb-btn jb-btn-edit" title="Modifier">
                                        Modifier
                                    </a>
                                    <form action="{{ route('jibayatics.destroy', $jibayatic->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="jb-btn jb-btn-delete" onclick="return confirm('Supprimer cet élément ?')" title="Supprimer">
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
                                <div class="jb-empty">
                                    <i class="fas fa-folder-open"></i>
                                    <h4>Aucune donnée disponible</h4>
                                    <p>Aucun compte Jibayatic n'a encore été ajouté.</p>
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
    --jb-blue: #3b82f6;
    --jb-blue-dark: #2563eb;
    --jb-blue-soft: #eff6ff;
    --jb-border: #e5e7eb;
    --jb-bg-soft: #f8fafc;
    --jb-text: #1e293b;
    --jb-muted: #64748b;
}

body { background: #f1f5f9; }

/* HEADER */
.jb-header {
    display: flex;
    align-items: center;
    gap: 16px;
    background: var(--jb-blue-soft);
    border: 1px solid #bfdbfe;
    border-radius: 16px;
    padding: 22px 26px;
    margin-bottom: 24px;
}
.jb-header-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: var(--jb-blue);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.jb-header h2 { margin: 0; font-weight: 800; font-size: 1.3rem; color: var(--jb-text); }
.jb-header p { margin: 4px 0 0; color: var(--jb-muted); font-size: 0.88rem; }

/* TOP BAR */
.jb-topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 20px;
}
.jb-add {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--jb-blue);
    color: #fff;
    padding: 11px 22px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 0.9rem;
    transition: opacity .15s ease;
}
.jb-add:hover { opacity: .88; color: #fff; }

.jb-search { position: relative; width: 360px; max-width: 100%; }
.jb-search > i {
    position: absolute;
    left: 16px; top: 50%; transform: translateY(-50%);
    color: #94a3b8; font-size: 0.85rem;
}
.jb-search input {
    width: 100%;
    padding: 11px 16px 11px 42px;
    border-radius: 10px;
    border: 1px solid var(--jb-border);
    background: #fff;
    color: var(--jb-text);
    font-size: 0.9rem;
}
.jb-search input::placeholder { color: #94a3b8; }
.jb-search input:focus {
    outline: none;
    border-color: var(--jb-blue);
    box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
}

/* CARD / TABLE */
.jb-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid var(--jb-border);
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    overflow: hidden;
}
.jb-table { width: 100%; margin: 0; border-collapse: collapse; }
.jb-table thead { background: var(--jb-bg-soft); }
.jb-table th {
    padding: 14px 20px;
    color: var(--jb-muted);
    font-weight: 600;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: .4px;
    border-bottom: 1px solid var(--jb-border);
}
.jb-table td {
    padding: 14px 20px;
    border-bottom: 1px solid #f1f5f9;
    color: var(--jb-text);
    font-size: 0.9rem;
    vertical-align: middle;
}
.jb-table tbody tr:hover { background: var(--jb-bg-soft); }
.jb-table tbody tr:last-child td { border-bottom: none; }

.jb-badge-phone {
    display: inline-block;
    background: var(--jb-blue-soft);
    color: var(--jb-blue-dark);
    padding: 5px 14px;
    border-radius: 20px;
    font-size: 0.82rem;
    font-weight: 600;
}

/* ACTIONS */
.jb-actions { display: flex; gap: 6px; flex-wrap: wrap; }
.jb-btn {
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
.jb-btn-edit { background: var(--jb-blue-soft); color: var(--jb-blue-dark); border-color: #bfdbfe; }
.jb-btn-edit:hover { background: var(--jb-blue); color: #fff; }

.jb-btn-delete { background: #fef2f2; color: #dc2626; border-color: #fecaca; }
.jb-btn-delete:hover { background: #dc2626; color: #fff; }

/* EMPTY */
.jb-empty { padding: 70px 20px; text-align: center; color: #94a3b8; }
.jb-empty i { font-size: 3rem; margin-bottom: 16px; color: #cbd5e1; display: block; }
.jb-empty h4 { color: var(--jb-text); font-weight: 700; font-size: 1rem; margin-bottom: 6px; }
.jb-empty p { font-size: 0.85rem; margin: 0; }

@media (max-width: 768px) {
    .jb-topbar { flex-direction: column; align-items: stretch; }
    .jb-add { justify-content: center; }
    .jb-search { width: 100%; }
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