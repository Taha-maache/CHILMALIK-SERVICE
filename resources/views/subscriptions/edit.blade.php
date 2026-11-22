@extends('layouts.app')

@section('content')

<style>
body{background:#f1f5f9}
.box{
    max-width:600px;
    margin:40px auto;
    background:white;
    padding:25px;
    border-radius:16px;
    box-shadow:0 10px 25px rgba(0,0,0,0.05);
}
input{
    width:100%;
    padding:12px;
    margin-bottom:12px;
    border-radius:10px;
    border:1px solid #ccc;
}
.btn{
    width:100%;
    padding:12px;
    background:#f59e0b;
    color:white;
    border:none;
    border-radius:10px;
}
</style>

<div class="box">

<h3>✏️ تعديل / تجديد الاشتراك</h3>

<form method="POST" action="{{ route('subscriptions.update',$subscription->id) }}">
@csrf
@method('PUT')
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">الاسم :</label>
<input type="text" name="full_name" value="{{ $subscription->full_name }}">
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">الهاتف :</label>
<input type="text" name="phone" value="{{ $subscription->phone }}">
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">تاريخ بداية الاشتراك :</label>
<input type="date" name="start_date" value="{{ $subscription->start_date }}">
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">تاريخ نهاية الاشتراك :</label>
<input type="date" name="end_date" value="{{ $subscription->end_date }}">

<button class="btn">تحديث</button>

</form>

</div>

@endsection