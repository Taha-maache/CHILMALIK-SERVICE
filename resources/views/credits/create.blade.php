@extends('layouts.app')

@section('content')
<div class="container py-4">

<div class="card shadow-sm">
<div class="card-body">

    <h4 class="mb-3">Créer Crédit</h4>

    <div class="mb-2">
        <b>Client:</b> {{ $service->full_name }}
    </div>

    <div class="mb-2">
        <b>Phone:</b> {{ $service->phone }}
    </div>

    <div class="mb-2">
        <b>Total:</b> {{ number_format($service->total_price) }}
    </div>

    <hr>

    <form method="POST" action="{{ route('credits.store', $service->id) }}">
        @csrf

        <div class="mb-3">
            <label>Amount Paid</label>
            <input type="number" name="amount_paid"
                   class="form-control"
                   placeholder="Enter amount paid">
        </div>

        <button class="btn btn-success w-100">
            Save Credit
        </button>
    </form>

</div>
</div>

</div>
@endsection