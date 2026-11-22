
@extends('layouts.app')

@section('content')

<style>
body{
    background:#f1f5f9;
}

.box{
    max-width:600px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}

.info{
    background:#ecfdf5;
    border:1px solid #bbf7d0;
    color:#166534;
    padding:15px;
    border-radius:12px;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    border:1px solid #ccc;
    box-sizing:border-box;
}

.btn{
    width:100%;
    padding:12px;
    background:#16a34a;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-size:16px;
    font-weight:600;
}
</style>

<div class="box">

    <h3>🔄 تجديد الاشتراك</h3>

    <div class="info">
        <strong>{{ $subscription->full_name }}</strong>
        <br>
        📱 {{ $subscription->phone }}
        <br><br>
        💰 مبلغ التجديد:
        <strong>5000 DA</strong>
    </div>

    <form method="POST"
          action="{{ route('subscriptions.processRenew', $subscription->id) }}">

        @csrf

        <label>تاريخ بداية الاشتراك الجديد :</label>

        <input
            type="date"
            name="start_date"
            value="{{ now()->format('Y-m-d') }}"
            required
        >

        <label>تاريخ نهاية الاشتراك الجديد :</label>

        <input
            type="date"
            name="end_date"
            required
        >

        <button class="btn">
            🔄 تأكيد التجديد
        </button>

    </form>

</div>

@endsection
