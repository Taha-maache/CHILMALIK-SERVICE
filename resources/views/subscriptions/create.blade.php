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
    background:#16a34a;
    color:white;
    border:none;
    border-radius:10px;
}
</style>

<div class="box">

<h3>➕ إضافة اشتراك</h3>

<form method="POST" action="{{ route('subscriptions.store') }}">
@csrf
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">الاسم :</label>
<input type="text" name="full_name" placeholder="full name">
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">الهاتف :</label>
<input type="text" name="phone" placeholder="phone">
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">تاريخ بداية الاشتراك :</label>
<input type="date" name="start_date">
<label style="display:block; margin-bottom:8px; color: blue; font-weight: 500; font-size: 18px;">تاريخ نهاية الاشتراك :</label>
<input type="date" name="end_date">

<button class="btn">حفظ</button>

</form>

</div>

@endsection