@props([
    'data',
    'columns',
    'tableName',
    'title' => null,
    'masterData' => null,
    'foreignKey' => null,
    'isMaster' => false,
    'detailTableId' => null,
    'lateIds' => [],
])

@php
    $isDetailTable = !is_null($masterData);
    if ($isDetailTable && is_null($foreignKey)) {
        $foreignKey = 'trader_id';
    }
    $tableId = $tableName . '_' . uniqid();
@endphp

@once
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    :root {
        --dt-ground: #f3f5f7;
        --dt-surface: #ffffff;
        --dt-ink: #1b2430;
        --dt-muted: #697586;
        --dt-line: #e3e8ee;
        --dt-accent: #0f6b5c;
        --dt-accent-soft: #e3f2ef;
        --dt-late: #b42318;
        --dt-late-soft: #fdeceb;
    }

    .dt { font-family: 'IBM Plex Sans Arabic', system-ui, sans-serif; color: var(--dt-ink); }

    /* Page-level navigation buttons (use class="dt-nav-btn" on the links above the table) */
    .dt-nav { display: flex; flex-wrap: wrap; gap: .5rem; margin-bottom: 1rem; }
    .dt-nav-btn {
        display: inline-flex; align-items: center; gap: .5rem;
        padding: .55rem 1rem; border-radius: 10px;
        background: var(--dt-surface); color: var(--dt-ink);
        border: 1px solid var(--dt-line); font-weight: 500; text-decoration: none;
        transition: border-color .15s, color .15s;
    }
    .dt-nav-btn:hover { border-color: var(--dt-accent); color: var(--dt-accent); }

    /* Shell */
    .dt-card { background: var(--dt-surface); border: 1px solid var(--dt-line); border-radius: 14px; overflow: hidden; }
    .dt-toolbar {
        display: flex; flex-wrap: wrap; align-items: center; gap: .75rem 1rem;
        padding: 1rem 1.25rem; border-bottom: 1px solid var(--dt-line);
    }
    .dt-title { font-size: 1.15rem; font-weight: 600; margin: 0; }
    .dt-count { color: var(--dt-muted); font-size: .85rem; margin-inline-start: .5rem; font-weight: 400; }
    .dt-spacer { flex: 1; }

    .dt-search { position: relative; min-width: 260px; }
    .dt-search i { position: absolute; inset-inline-start: .85rem; top: 50%; transform: translateY(-50%); color: var(--dt-muted); }
    .dt-search input {
        width: 100%; padding: .55rem 2.2rem; border-radius: 10px;
        border: 1px solid var(--dt-line); background: var(--dt-ground); font: inherit;
    }
    .dt-search input:focus { outline: none; border-color: var(--dt-accent); background: var(--dt-surface); box-shadow: 0 0 0 3px var(--dt-accent-soft); }
    .dt-search button {
        position: absolute; inset-inline-end: .4rem; top: 50%; transform: translateY(-50%);
        border: 0; background: none; color: var(--dt-muted); padding: .25rem .5rem;
    }

    .dt-add {
        display: inline-flex; align-items: center; gap: .45rem; padding: .55rem 1.1rem;
        background: var(--dt-accent); color: #fff; border-radius: 10px; font-weight: 500; text-decoration: none;
    }
    .dt-add:hover { background: #0b574b; color: #fff; }

    .dt-filter {
        display: flex; align-items: center; gap: .75rem; padding: .6rem 1.25rem;
        background: var(--dt-accent-soft); color: var(--dt-accent); font-size: .9rem;
    }
    .dt-filter button { margin-inline-start: auto; border: 0; background: none; color: inherit; text-decoration: underline; }

    /* Table */
    .dt-scroll { overflow-x: auto; }
    .dt-table { width: 100%; border-collapse: collapse; }
    .dt-table th {
        padding: .75rem 1.25rem; font-size: .85rem; font-weight: 500; color: var(--dt-muted);
        background: #fafbfc; border-bottom: 1px solid var(--dt-line); text-align: start; white-space: nowrap;
    }
    .dt-table th a { color: inherit; text-decoration: none; display: inline-flex; align-items: center; gap: .35rem; }
    .dt-table th a:hover { color: var(--dt-ink); }
    .dt-table td { padding: .85rem 1.25rem; border-bottom: 1px solid var(--dt-line); vertical-align: middle; }
    .dt-table tbody tr { cursor: pointer; transition: background .12s; }
    .dt-table tbody tr:hover { background: #f7f9fa; }
    .dt-table tbody tr:last-child td { border-bottom: 0; }
    .dt-table tr.is-selected { background: var(--dt-accent-soft) !important; box-shadow: inset 3px 0 0 var(--dt-accent); }
    .dt-table tr.is-late { background: var(--dt-late-soft); box-shadow: inset 3px 0 0 var(--dt-late); }
    .dt-table tr.is-late:hover { background: #fbe0de; }

    .dt-late-tag {
        display: inline-block; margin-inline-start: .5rem; padding: .1rem .5rem; border-radius: 999px;
        background: var(--dt-late); color: #fff; font-size: .72rem; font-weight: 500;
    }

    /* Status */
    .dt-status { display: inline-flex; align-items: center; gap: .4rem; font-size: .85rem; font-weight: 500; white-space: nowrap; }
    .dt-status::before { content: ''; width: 8px; height: 8px; border-radius: 50%; background: currentColor; }
    .dt-status.new { color: #697586; }
    .dt-status.sent { color: #1d5fd1; }
    .dt-status.back { color: #b25e09; }
    .dt-status.done { color: var(--dt-accent); }

    /* Actions */
    .dt-actions { display: flex; flex-wrap: wrap; align-items: center; gap: .35rem; }
    .dt-btn {
        display: inline-flex; align-items: center; gap: .35rem; padding: .3rem .7rem;
        border-radius: 8px; border: 1px solid var(--dt-line); background: var(--dt-surface);
        color: var(--dt-ink); font-size: .82rem; text-decoration: none; cursor: pointer;
        transition: border-color .15s, color .15s, background .15s;
    }
    .dt-btn:hover { border-color: var(--dt-accent); color: var(--dt-accent); }
    .dt-btn.primary { background: var(--dt-accent); border-color: var(--dt-accent); color: #fff; }
    .dt-btn.primary:hover { background: #0b574b; color: #fff; }
    .dt-btn.danger:hover { border-color: var(--dt-late); color: var(--dt-late); background: var(--dt-late-soft); }
    .dt-form { display: inline; margin: 0; }

    .dt-empty { padding: 2.5rem 1rem; text-align: center; color: var(--dt-muted); }
    .dt-foot { padding: .9rem 1.25rem; border-top: 1px solid var(--dt-line); display: flex; justify-content: center; }

    /* Keep Laravel's default paginator tidy */
    .dt-foot svg { width: 1rem !important; height: 1rem !important; display: inline !important; }
    .dt-foot nav > div:first-child { display: none !important; }

    @media (prefers-reduced-motion: reduce) { .dt * { transition: none !important; } }
</style>
@endonce

<div
    class="dt"
    :id="tableId"
    x-data="{
        items: @js($data->items()),
        allItems: @js($data->items()),
        columns: @js(array_keys($columns)),
        columnLabels: @js($columns),
        lateIds: @js($lateIds),
        title: @js($title ?? ucfirst(str_replace('_', ' ', $tableName))),
        tableName: '{{ $tableName }}',
        tableId: '{{ $tableId }}',
        csrf: '{{ csrf_token() }}',
        searchQuery: '',
        selectedId: null,
        selectedItem: null,

        isMaster: @js($isMaster),
        isDetail: @js($isDetailTable),
        foreignKey: '{{ $foreignKey }}',
        masterSelectedId: null,
        masterSelectedInfo: null,

        statusMap: {
            nouveau: ['Nouveau', 'new'],
            transfere_cnrc: ['Transféré au CNRC', 'sent'],
            recupere_cnrc: ['Récupéré du CNRC', 'back'],
            livre_client: ['Livré au client', 'done'],
        },

        init() {
            if (this.isMaster && this.items.length > 0) this.selectRow(this.items[0]);
            if (this.isDetail) this.listenForMasterSelection();
        },

        isLate(item) {
            if (this.lateIds.includes(item.id)) return true;
            return item.pay_type === 'tranche'
                && item.receipt1_number !== 'oui'
                && new Date(item.date_tranche1) < new Date();
        },

        filteredItems() {
            let rows = this.allItems;
            if (this.isDetail && this.masterSelectedId) {
                rows = rows.filter(i => String(i[this.foreignKey]) === String(this.masterSelectedId));
            }
            const q = this.searchQuery.trim().toLowerCase();
            if (q) {
                const fields = this.tableName === 'traders'
                    ? ['first_name', 'last_name', 'NIN']
                    : ['full_name', 'NIN'];
                rows = rows.filter(i => {
                    const hay = fields.map(f => String(i[f] ?? '')).join(' ').toLowerCase();
                    const full = (String(i.first_name ?? '') + ' ' + String(i.last_name ?? '')).toLowerCase();
                    return hay.includes(q) || full.includes(q);
                });
            }
            return rows;
        },

        selectRow(item) {
            const same = this.selectedId === item.id;
            this.selectedId = same ? null : item.id;
            this.selectedItem = same ? null : item;
            if (this.isMaster) {
                window.dispatchEvent(new CustomEvent('master-selection-changed', {
                    detail: { masterItem: same ? null : item, masterTableName: this.tableName, foreignKey: this.foreignKey }
                }));
            }
            this.$dispatch('row-selected', { item: item, tableName: this.tableName });
        },

        listenForMasterSelection() {
            window.addEventListener('master-selection-changed', (e) => {
                const m = e.detail.masterItem;
                this.masterSelectedId = m ? m.id : null;
                this.masterSelectedInfo = m;
                this.selectedId = null;
                this.selectedItem = null;
            });
        },

        sortUrl(field) {
            const p = new URLSearchParams(window.location.search);
            const dir = p.get('sort') === field && p.get('direction') === 'asc' ? 'desc' : 'asc';
            p.set('sort', field);
            p.set('direction', dir);
            return '?' + p.toString();
        },

        createUrl() {
            return this.isDetail && this.masterSelectedId
                ? `/${this.tableName}/create?${this.foreignKey}=${this.masterSelectedId}`
                : `/${this.tableName}/create`;
        },

        masterLabel() {
            const m = this.masterSelectedInfo;
            if (!m) return '';
            return m[this.columns[0]] || m.name || `#${m.id}`;
        }
    }"
    @keydown.escape.window="selectedId = null; selectedItem = null"
>
    <div class="dt-card">

        <div class="dt-toolbar">
            <h5 class="dt-title">
                <span x-text="title"></span>
                <span class="dt-count"><span x-text="filteredItems().length"></span> / <span x-text="allItems.length"></span></span>
            </h5>

            <div class="dt-spacer"></div>

            <div class="dt-search">
                <i class="fas fa-search"></i>
                <input type="text" x-model="searchQuery" placeholder="ابحث بالاسم أو اللقب أو رقم التعريف">
                <button type="button" x-show="searchQuery" @click="searchQuery = ''" aria-label="Effacer">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <a :href="createUrl()" class="dt-add">
                <i class="fas fa-plus"></i> إضافة
            </a>
        </div>

        <div class="dt-filter" x-show="isDetail && masterSelectedInfo" x-cloak>
            <i class="fas fa-filter"></i>
            <span x-text="masterLabel()"></span>
            <button type="button" @click="masterSelectedId = null; masterSelectedInfo = null">إلغاء التصفية</button>
        </div>

        <div class="dt-scroll">
            <table class="dt-table">
                <thead>
                    <tr>
                        <template x-for="(label, field) in columnLabels" :key="field">
                            <th>
                                <a :href="sortUrl(field)">
                                    <span x-text="label"></span>
                                    <i class="fas fa-sort" style="opacity:.4;font-size:.75rem"></i>
                                </a>
                            </th>
                        </template>
                        <th>الإجراءات</th>
                    </tr>
                </thead>

                <tbody>
                    <template x-for="item in filteredItems()" :key="item.id">
                        <tr
                            @click="selectRow(item)"
                            :class="{ 'is-selected': selectedId === item.id, 'is-late': isLate(item) }"
                        >
                            <template x-for="(field, index) in columns" :key="field">
                                <td>
                                    <template x-if="field !== 'status'">
                                        <span>
                                            <span x-text="item[field] || '-'"></span>
                                            <span class="dt-late-tag" x-show="index === 0 && isLate(item)">متأخر</span>
                                        </span>
                                    </template>
                                    <template x-if="field === 'status'">
                                        <span class="dt-status" :class="(statusMap[item.status] || ['', 'new'])[1]"
                                              x-text="(statusMap[item.status] || [item.status])[0]"></span>
                                    </template>
                                </td>
                            </template>

                            <td @click.stop>
                                <div class="dt-actions">

                                    <template x-if="tableName === 'traders' && item.status !== 'livre_client'">
                                        <form class="dt-form" :action="`/traders/${item.id}/change-status`" method="POST"
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir changer le statut ?')">
                                            <input type="hidden" name="_token" :value="csrf">
                                            <input type="hidden" name="_method" value="PATCH">
                                            <button class="dt-btn primary">
                                                <span x-show="item.status == 'nouveau'"><i class="fas fa-paper-plane"></i> Transférer au CNRC</span>
                                                <span x-show="item.status == 'transfere_cnrc'"><i class="fas fa-download"></i> Récupérer du CNRC</span>
                                                <span x-show="item.status == 'recupere_cnrc'"><i class="fas fa-check"></i> Livrer au client</span>
                                            </button>
                                        </form>
                                    </template>

                                    <template x-if="tableName === 'trader_taxes'">
                                        <a :href="`/trader-taxes/${item.id}/payments`" class="dt-btn primary">
                                            <i class="fas fa-money-bill-wave"></i> Paiements
                                        </a>
                                    </template>

                                    <template x-if="tableName === 'traders'">
                                        <span class="dt-actions">
                                            <a :href="`/${tableName}/${item.id}/pdf/full/?color=blue`" class="dt-btn" target="_blank" title="السجل التجاري الكامل (ملوّن)">
                                                <i class="fas fa-file-pdf"></i> RC ازرق
                                            </a>
                                            <a :href="`/${tableName}/${item.id}/pdf/full/?color=black`" class="dt-btn" target="_blank" title="السجل التجاري الكامل (أسود)">
                                                <i class="fas fa-file-pdf"></i> RC أسود
                                            </a>
                                            <a :href="`/${tableName}/${item.id}/pdf/g08`" class="dt-btn" target="_blank">
                                                <i class="fas fa-file-signature"></i> G08
                                            </a>
                                        </span>
                                    </template>
                                    <template
    x-if="item.status === 'recupere_cnrc' && !item.whatsapp_register_reminded_at"
>
    <a
        :href="`/traders/${item.id}/whatsapp-register-reminder`"
        class="dt-btn"
        style="border-color:#25D366;color:#128C7E"
        title="تذكير الزبون عبر WhatsApp"
    >
        <i class="fab fa-whatsapp"></i>
        WhatsApp
    </a>
</template>

                                    <template x-if="tableName === 'trader_taxes'">
                                        <span class="dt-actions">
                                            <a :href="`/${tableName}/${item.id}/pdf/full`" class="dt-btn" target="_blank">
                                                <i class="fas fa-file-pdf"></i> G12
                                            </a>
                                            <a :href="`/trader_taxes/${item.id}/pdf/g12bis`" class="dt-btn" target="_blank">
                                                <i class="fas fa-file-signature"></i> G12 Bis
                                            </a>
                                        </span>
                                    </template>

                                    <a :href="`/${tableName}/${item.id}/edit`" class="dt-btn" title="تعديل">
                                        <i class="fas fa-edit"></i>edit
                                    </a>

                                    <form class="dt-form" :action="`/${tableName}/${item.id}`" method="POST">
                                        <input type="hidden" name="_token" :value="csrf">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="dt-btn danger" title="حذف"
                                                onclick="return confirm('هل أنت متأكد من الحذف؟')">
                                            <i class="fas fa-trash"></i>delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div class="dt-empty" x-show="filteredItems().length === 0" x-cloak>
                <span x-show="searchQuery">لا توجد نتائج لـ "<span x-text="searchQuery"></span>"</span>
                <span x-show="!searchQuery && isDetail && !masterSelectedId">اختر سجلًا لعرض تفاصيله</span>
                <span x-show="!searchQuery && !(isDetail && !masterSelectedId)">لا توجد بيانات بعد</span>
            </div>
        </div>

        <div class="dt-foot">
            {{ $data->links() }}
        </div>
    </div>
</div>