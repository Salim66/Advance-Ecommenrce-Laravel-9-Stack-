@extends('layouts.front_layout.front_layout')


@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active"> SUCCESSED</li>
    </ul>
    <h3>  SUCCESSED </h3>
    <hr class="soft" />

    <div align="center">
        <h3>YOUR PAYMENT HAS BEEN CONFIRMED</h3>
        <p>Thanks for the payment, we will process your order very soon.</p>
        <p>Your order number is {{ Session::get('order_id') }} and total amount paid is INR {{ Session::get('grand_total') }}</p>
    </div>

</div>
@endsection

@php
    Session::forget('grand_total');
    Session::forget('order_id');
    Session::forget('coupon_code');
    Session::forget('coupon_amount');
@endphp
