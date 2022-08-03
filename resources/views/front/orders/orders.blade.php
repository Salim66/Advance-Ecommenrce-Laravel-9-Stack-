@extends('layouts.front_layout.front_layout')

@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active">ORDERS</li>
    </ul>
    <h3> ORDERS</h3>
    <hr class="soft"/>

    <div class="row">
        <div class="span8">
           <table class="table table-striped table-bordered">
                <tr>
                    <th>Order ID</th>
                    <th>Order Products</th>
                    <th>Payment Method</th>
                    <th>Grand Total</th>
                    <th>Created On</th>
                </tr>
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>
                        @foreach($order->order_products as $pro)
                        {{ $pro->product_code }} <br />
                        @endforeach
                    </td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->grand_total }}</td>
                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                </tr>
                @endforeach
           </table>
        </div>
    </div>
</div>
@endsection
