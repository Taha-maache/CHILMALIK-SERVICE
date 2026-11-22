@extends('layouts.app')

@section('content')
<div class="main-wrapper py-4" style="background: #f0f2f5; min-height: 100vh; direction: rtl;">
    <div class="container">
        
        <div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-4 border-0">
            <h4 class="fw-bold m-0 text-dark"><i class="fas fa-id-card-alt me-2 text-primary"></i> إدارة ملفات الزبائن</h4>
            
            <div class="d-flex align-items-center gap-3">
                @php 
                    $readyClients = $clients->filter(fn($c) => \Carbon\Carbon::parse($c->registration_date)->addMonths(6)->isPast());
                    $count = $readyClients->count();
                @endphp


                <button class="btn-notif-label @if($count > 0) has-alerts @endif" data-bs-toggle="offcanvas" data-bs-target="#notifSidebar">
                    <div class="d-flex align-items-center gap-2">
                        <div class="icon-bell-wrapper">
                            <i class="fas fa-bell"></i>
                            @if($count > 0) <span class="notif-dot-pulse"></span> @endif
                        </div>
                        <span class="notif-text">NOTIFICATIONS</span>
                        @if($count > 0) 
                            <span class="notif-count-pill">{{ $count }}</span> 
                        @endif
                    </div>
                </button>

                <a href="{{ route('clients.create') }}" class="btn btn-primary fw-bold px-4 py-2 rounded-3 shadow-sm border-0">
                    <i class="fas fa-plus-circle me-1"></i> ADD CLIENT
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
<div class="search-form shadow-sm">

    <div class="input-group">

        <span class="input-group-text border-0 bg-white ps-3">
            <i class="fas fa-search text-muted"></i>
        </span>

        <input type="text"
               id="search"
               class="form-control border-0 py-3 ps-1"
               placeholder="ابحث بالاسم، اللقب أو رقم السجل...">

    </div>

</div>
            </div>
            @if(request('search'))
            <div class="col-md-6 d-flex align-items-center">
                <a href="{{ route('clients.index') }}" class="text-danger fw-bold text-decoration-none">
                    <i class="fas fa-times-circle"></i> إلغاء البحث
                </a>
            </div>
            @endif
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 bg-white text-end">
                    <thead style="background: #1e293b; color: white;">
                        <tr>
                            <th class="p-3 ps-4">المعلومات الشخصية</th>
                            <th>رقم السجل</th>
                            <th>تاريخ الإيداع</th>
                            <th>الوضعية</th>
                            <th class="text-center">إجراءات التحكم</th>
                        </tr>
                    </thead>
                    <tbody id="clientsTable">
                        @foreach($clients as $client)
                        @php $isReady = \Carbon\Carbon::parse($client->registration_date)->addMonths(6)->isPast(); @endphp
                        <tr>
                            <td class="ps-4 fw-bold text-dark text-end">
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="avatar-circle ms-2">{{ strtoupper(substr($client->first_name, 0, 1)) }}</div>
                                    {{ $client->first_name }} {{ $client->last_name }}
                                </div>
                            </td>
                            <td><span class="badge bg-light text-primary border px-2 py-2 fs-6 fw-bold shadow-none">{{ $client->number_of_registration }}</span></td>
                            <td class="text-muted fw-bold small">{{ $client->registration_date }}</td>
                            <td>
                                @if($isReady)
                                    <span class="status-pill status-ready"><i class="fas fa-check-double me-1"></i> جاهزة للاستلام</span>
                                @else
                                    <span class="status-pill status-pending"><i class="fas fa-hourglass-half me-1"></i> في الانتظار</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('clients.edit', $client->id) }}" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i> EDIT
                                    </a>
                                    <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" onclick="return confirm('حذف؟')">
                                            <i class="fas fa-trash-alt"></i> DELETE
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-end border-0 shadow-lg" tabindex="-1" id="notifSidebar" style="width: 400px; background: #f8fafc;">
    <div class="offcanvas-header bg-white border-bottom p-4">
        <h5 class="offcanvas-title fw-bold text-dark"><i class="fas fa-bell text-warning me-2"></i> التنبيهات الجاهزة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-3 text-end">
        @forelse($readyClients as $notif)
            <div class="notif-card mb-3 p-3 shadow-sm rounded-3 bg-white border-end border-success border-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-1 fw-bold text-dark">{{ $notif->first_name }} {{ $notif->last_name }}</h6>
                        <p class="small text-muted mb-2">هذا الملف تجاوز مدة 6 أشهر (تاريخ الإيداع: {{ $notif->registration_date }})</p>
                        <a href="{{ route('clients.edit', $notif->id) }}" class="btn btn-sm btn-outline-primary fw-bold">عرض الملف <i class="fas fa-external-link-alt ms-1"></i></a>
                    </div>
                    <span class="badge bg-success-soft text-success">READY</span>
                </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="fas fa-bell-slash fa-3x text-light mb-3"></i>
                <p class="text-muted">لا توجد تنبيهات حالياً</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    /* زر الرجوع HOME */
    .btn-back-traders {
        background-color: #64748b;
        color: white !important;
        padding: 8px 18px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.8rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 0 #475569;
        border: none;
    }

    /* زر النوتيفيكاسيون مع الكلمة */
    .btn-notif-label {
        background: #ffffff;
        border: 2px solid #e2e8f0;
        border-radius: 50px;
        padding: 6px 18px 6px 12px;
        color: #64748b;
        transition: 0.3s;
        box-shadow: 0 4px 0 #e2e8f0;
        cursor: pointer;
        border: none;
    }
    .btn-notif-label.has-alerts {
        border: 2px solid #fecaca;
        color: #dc2626;
        box-shadow: 0 4px 0 #fecaca;
    }
    .notif-text { font-weight: 900; font-size: 0.75rem; letter-spacing: 0.5px; }
    .notif-count-pill { background: #dc2626; color: white; font-size: 0.7rem; font-weight: 900; padding: 2px 8px; border-radius: 20px; margin-right: 5px; }

    /* أنيميشن الجرس */
    .notif-dot-pulse {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        border: 2px solid white;
        animation: bell-pulse 1.5s infinite;
    }
    @keyframes bell-pulse {
        0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7); }
        70% { transform: scale(1.2); box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
        100% { transform: scale(1); }
    }

    /* الـ Buttons الصلبة */
    .btn-action {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border-radius: 10px;
        font-weight: 900;
        font-size: 0.85rem;
        box-shadow: 0 4px 0 rgba(0,0,0,0.1);
        text-decoration: none;
        border: none;
    }
    .btn-edit { background: #0d6efd; color: white !important; }
    .btn-delete { background: #dc3545; color: white !important; }

    /* الـ Search Form */
    .search-form { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
    .search-form .btn-primary { border-radius: 10px 0 0 10px !important; margin: 5px; font-weight: 900; }

    /* الحالة والأفاتار */
    .status-pill { padding: 6px 14px; border-radius: 30px; font-weight: 800; font-size: 0.75rem; }
    .status-ready { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; }
    .status-pending { background: #fef3c7; color: #d97706; border: 1px solid #fde68a; }
    .avatar-circle { width: 35px; height: 35px; background: #e0f2fe; color: #0369a1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; }
    .notif-card { border-right: 4px solid #16a34a !important; border-left: none !important; }
</style>
<script>

document.getElementById('search').addEventListener('keyup', function () {

    let search = this.value;

    fetch('/clients?search=' + search)

    .then(response => response.text())

    .then(data => {

        let parser = new DOMParser();

        let html = parser.parseFromString(data, 'text/html');

        let newTable = html.querySelector('#clientsTable').innerHTML;

        document.getElementById('clientsTable').innerHTML = newTable;

    });

});

</script>

@endsection