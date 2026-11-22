{{-- resources/views/casnosPayment/overpaid.blade.php --}}

@extends('layouts.app')

@section('content')

<div class="main-wrapper py-4" style="background: #f0f2f5; min-height: 100vh; direction: rtl;">

<div class="container">

```
<div class="d-flex justify-content-between align-items-center mb-4 p-3 bg-white shadow-sm rounded-4">

    <h4 class="fw-bold m-0 text-primary">
        🔵 OVERPAID CLIENTS
    </h4>

    <a href="{{ route('casnos-payments.index') }}"
       class="btn btn-dark fw-bold">
        الرجوع
    </a>

</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0 text-end">

            <thead style="background:#0d6efd; color:white;">
                <tr>
                    <th>التاجر</th>
                    <th>Matricule</th>
                    <th>المبلغ المدفوع</th>
                    <th>المبلغ المستحق</th>
                    <th>الرصيد</th>
                    <th>الحالة</th>
                </tr>
            </thead>

            <tbody>

            @foreach($payments as $p)

            <tr>

                <td class="fw-bold">
                    {{ $p->trader->first_name ?? '' }}
                    {{ $p->trader->last_name ?? '' }}
                    <br>
                    <small class="text-muted">
                        {{ $p->trader->nin ?? '' }}
                    </small>
                </td>

                <td>
                    <span class="badge bg-light text-dark border">
                        {{ $p->matricule }}
                    </span>
                </td>

                <td class="text-success fw-bold">
                    {{ number_format($p->montant_versse, 2) }} DA
                </td>

                <td class="text-dark fw-bold">
                    {{ number_format($p->montant_enkissi, 2) }} DA
                </td>

                <td class="text-primary fw-bold">
                    {{ number_format($p->balance, 2) }} DA
                </td>

                <td>
                    <span class="badge bg-primary">
                        OVERPAID
                    </span>
                </td>

            </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>
```

</div>

</div>

@endsection
