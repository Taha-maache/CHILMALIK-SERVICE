@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ route('casnos.index') }}" class="btn btn-light shadow-sm rounded-pill px-4">
            <i class="fas fa-arrow-right me-2"></i> العودة للقائمة الرئيسية
        </a>
    </div>

    {{-- الحواف باللون الأزرق --}}
    <div class="card shadow-lg border-0 border-top border-primary border-5" style="border-radius: 20px;">
        <div class="card-header bg-white py-4 text-center">
            <h3 class="fw-bold text-primary mb-0">
                <i class="fas fa-user-plus me-2"></i> قائمة الدفع الزائد (المستحقات)
            </h3>
            <p class="text-muted mb-0">هؤلاء الأشخاص دفعوا مبالغ تفوق المطلوب منهم</p>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    {{-- رأس الجدول أزرق --}}
                    <thead class="table-primary text-primary">
                        <tr>
                            <th>الإسم واللقب</th>
                            <th>Matricule</th>
                            <th>المبلغ المدفوع</th>
                            <th>المبلغ المطلوب</th>
                            <th>الزيادة (لنا)</th>
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
                            {{-- قيمة الزيادة بالأزرق --}}
                            <td class="text-primary fw-bold">{{ number_format($client->montant_rest, 2) }} دج</td>
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