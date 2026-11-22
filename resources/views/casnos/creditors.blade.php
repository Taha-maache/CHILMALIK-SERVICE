@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('casnos.index') }}" class="btn btn-light shadow-sm rounded-pill px-4">
            <i class="fas fa-arrow-right me-2"></i> العودة للقائمة الرئيسية
        </a>
    </div>

    {{-- الحواف باللون الأحمر --}}
    <div class="card shadow-lg border-0 border-top border-danger border-5" style="border-radius: 20px;">
        <div class="card-header bg-white py-4 text-center">
            <h3 class="fw-bold text-danger mb-0">
                <i class="fas fa-user-minus me-2"></i> قائمة المدينين (الديون المتبقية)
            </h3>
            <p class="text-muted mb-0">هؤلاء الأشخاص لم يكملوا مبالغ الدفع المطلوبة</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    {{-- رأس الجدول أحمر --}}
                    <thead class="table-danger text-danger">
                        <tr>
                            <th>الإسم واللقب</th>
                            <th>Matricule</th>
                            <th>المبلغ المدفوع</th>
                            <th>المبلغ المطلوب</th>
                            <th>الباقي (دين)</th>
                            <th>الهاتف</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                        <tr>
                            <td><div class="fw-bold">{{ $client->nom }} {{ $client->prenom }}</div></td>
                            <td><span class="badge bg-light text-dark border">{{ $client->matricule }}</span></td>
                            <td class="text-dark">{{ number_format($client->montant_versse, 2) }} دج</td>
                            <td class="text-dark">{{ number_format($client->montant_enkissi, 2) }} دج</td>
                            {{-- قيمة الدين بالأحمر --}}

                            <td class="text-danger fw-bold">
    {{ number_format($client->getAdjustedRemaining(), 2, ',', ' ') }} دج
</td>
<td>{{ $client->phone ?? '---' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
