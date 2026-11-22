@extends('layouts.app')

@section('content')
<div class="container py-4">

<div class="card shadow-sm">
<div class="card-body">

    <h4>Edit Credit</h4>

    <form method="POST" action="{{ route('credits.update', $credit->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-2">
            <b>Client:</b> {{ $credit->service->full_name }}
        </div>

        <div class="mb-3">
            <label>Amount Paid</label>
            <input type="number"
                   name="amount_paid"
                   value="{{ $credit->amount_paid }}"
                   class="form-control">
        </div>

        <button class="btn btn-primary w-100">
            Update
        </button>
    </form>

</div>
</div>

</div>
@endsection