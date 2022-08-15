@extends('layouts.front_layout.front_layout')

@section('content')
@php
    $getOrderStatus = \App\Models\Order::getOrderStatus($orderDetails->id);
@endphp
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
        <li class="active"><a href="{{ url('orders') }}">ORDERS</a></li>
    </ul>
    <h3> ORDERS #{{ $orderDetails->id }} Details</h3>
    @if($getOrderStatus == "New")
    <span><a href="{{ url('/orders/'.$orderDetails->id.'/cancel') }}" class="btnCancelOrder"><button type="button" class="btn btn-inline-block" style="float: right">Cancel Order</button></a></span> <br>
    @endif
    <hr class="soft"/>

    <div class="row">
        <div class="span4">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th colspan="2">Order Details</th>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td>{{ date('d-m-Y', strtotime($orderDetails->created_at)) }}</td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td>{{ $orderDetails->order_status }}</td>
                    </tr>
                    @if(!empty($orderDetails->courier_name))
                    <tr>
                        <td>Courier Name</td>
                        <td>{{ $orderDetails->courier_name }}</td>
                    </tr>
                    @endif
                    @if(!empty($orderDetails->tracking_number))
                    <tr>
                        <td>Tracking Number</td>
                        <td>{{ $orderDetails->tracking_number }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td>Order Total</td>
                        <td>{{ $orderDetails->grand_total }}</td>
                    </tr>
                    <tr>
                        <td>Shipping Charges</td>
                        <td>{{ $orderDetails->shipping_charges }}</td>
                    </tr>
                    <tr>
                        <td>Coupon Code</td>
                        <td>{{ $orderDetails->coupon_code }}</td>
                    </tr>
                    <tr>
                        <td>Coupon Amount</td>
                        <td>{{ $orderDetails->coupon_amount }}</td>
                    </tr>
                    <tr>
                        <td>Payment Method</td>
                        <td>{{ $orderDetails->payment_method }}</td>
                    </tr>
                </tbody>
           </table>
        </div>
        <div class="span4">
            <table class="table table-striped table-bordered">
                <tbody>
                    <tr>
                        <th colspan="2">Delivery Address</th>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>{{ $orderDetails->name }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ $orderDetails->address }}</td>
                    </tr>
                    <tr>
                        <td>City</td>
                        <td>{{ $orderDetails->city }}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>{{ $orderDetails->state }}</td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>{{ $orderDetails->country }}</td>
                    </tr>
                    <tr>
                        <td>Pincode</td>
                        <td>{{ $orderDetails->pincode }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>{{ $orderDetails->mobile }}</td>
                    </tr>
                </tbody>
           </table>
        </div>
    </div>

    <div class="row">
        <div class="span8">
           <table class="table table-striped table-bordered">
                <tr>
                    <th>Product Image</th>
                    <th>Product Code</th>
                    <th>Product Name</th>
                    <th>Product Size</th>
                    <th>Product Color</th>
                    <th>Product Qty</th>
                </tr>
                @foreach($orderDetails->order_products as $pro)
                <tr>
                    <td>
                        @php
                            $getProductImage = \App\Models\Product::getProductImage($pro->id);
                        @endphp
                        @if(isset($getProductImage))
                        <a target="_blank" href="{{ url('/product/'.$pro->id) }}"><img style="width: 50px;" src="{{ URL::to('images/product_images/small/'.$getProductImage->main_image) }}" alt=""></a>
                        @endif
                    </td>
                    <td>{{ $pro->product_code }}</td>
                    <td>{{ $pro->product_name }}</td>
                    <td>{{ $pro->product_size }}</td>
                    <td>{{ $pro->product_color }}</td>
                    <td>{{ $pro->product_qty }}</td>
                </tr>
                @endforeach
           </table>
        </div>
    </div>
</div>
@endsection
