@extends('layouts.front_layout.front_layout')


@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active"> CHECKOUT</li>
    </ul>
    <h3>  CHECKOUT [ <small><span class="totalCartItems">{{ totalCartItems() }}</span> Item(s) </small>]<a href="{{ url('/cart') }}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> BACK To CART </a></h3>
    <hr class="soft"/>
    @if(session()->has('success_message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @php
        Session::forget('success_message');
    @endphp
    @endif
    @if(session()->has('error_message'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @php
        Session::forget('error_message');
    @endphp
    @endif
    <hr class="soft"/>

    <form id="checkoutForm" action="{{ url('checkout') }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <tr><th> <strong>DELIVERY ADDRESSES</strong> | <a href="{{ url('add-edit-delivery-address') }}">Add</a>  </th></tr>
            @foreach($deliveryAddresses as $address)
            <tr>
                <td>
                    <div class="control-group" style="float: left; margin-top: -2px; margin-right: 5px;">
                        <input type="radio" id="address{{ $address->id }}" name="address_id" value="{{ $address->id }}">
                    </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">{{ $address->name }}, {{ $address->address }}, {{ $address->city }} - {{ $address->pincode }}, {{ $address->state }}, {{ $address->country }}, (M: {{ $address->mobile }})</label>
                    </div>
                </td>
                <td>
                    <a href="{{ url('add-edit-delivery-address/'.$address->id) }}">Edit</a> | <a href="{{ url('delete-delivery-address/'.$address->id) }}" id="delete_delivery_address">Delete</a>
                </td>
            </tr>
            @endforeach
        </table>
        <table class="table table-bordered">
            <thead>
                <tr>
                <th>Product</th>
                <th colspan="2">Description</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Product/Categrey <br>Discount</th>
                <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_price = 0;
                @endphp
                @foreach($user_cart_items as $item)
                    @php
                        $get_attr_price = \App\Models\Product::getDiscountedAttrPrice($item->product->id, $item->size);
                    @endphp
                <tr>
                    <td> <img width="60" src="{{ URL::to('images/product_images/small/'.$item->product->main_image) }}" alt=""/></td>
                    <td>{{ $item->product->product_name }} ({{ $item->product->product_code }})<br/>Color : {{ $item->product->product_color }}</td>
                    <td colspan="2">
                        {{ $item->quantity }}
                    </td>
                    <td>Rs.{{ $get_attr_price['product_price'] }}</td>
                    <td>Rs.{{ $get_attr_price['discount'] }}</td>
                    <td>Rs.{{ $item->quantity * $get_attr_price['final_price'] }}</td>
                </tr>
                @php
                    $total_price = $total_price + ( $item->quantity * $get_attr_price['final_price'] );
                @endphp
                @endforeach

                <tr>
                <td colspan="6" style="text-align:right">Total Price:	</td>
                <td> Rs.{{ $total_price }}</td>
                </tr>
                <tr>
                <td colspan="6" style="text-align:right">Coupon Discount:	</td>
                <td class="coupon_amount">
                    @if(Session::get('coupon_amount'))
                    Rs. {{ Session::get('coupon_amount') }}
                    @else
                    Rs. 0.00
                    @endif
                </td>
                </tr>
                <tr>
                <td colspan="6" style="text-align:right"><strong>TOTAL (Rs.{{ $total_price }} - <span class="coupon_amount">Rs.0</span>) =</strong></td>
                <td class="label label-important" style="display:block"> <strong class="grand_total">
                    Rs. {{ $grand_total = $total_price - Session::get('coupon_amount') }}
                    @php Session::put('grand_total', $grand_total); @endphp
                </strong></td>
                </tr>
            </tbody>
        </table>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <div class="control-group">
                            <label class="control-label"><strong> PAYMENT METHOD: </strong> </label>
                            <div class="controls">
                                <input type="radio" name="payment_gateway" id="COD" class="input-medium" value="COD" style="margin-top: -6px; margin-right: 4px;"><strong>COD</strong>&nbsp;&nbsp;
                                <input type="radio" name="payment_gateway" id="Paypal" class="input-medium" value="Paypal" style="margin-top: -6px; margin-right: 4px;"><strong>Paypal</strong>
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>


        <a href="{{ url('/cart') }}" class="btn btn-large"><i class="icon-arrow-left"></i> BACK TO CART</a>
        <button type="submit" class="btn btn-large pull-right">Order Place <i class="icon-arrow-right"></i></button>
    </form>

</div>
@endsection
