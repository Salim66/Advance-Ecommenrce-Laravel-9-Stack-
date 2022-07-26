@extends('layouts.front_layout.front_layout')


@section('content')
<div class="span9">
    <ul class="breadcrumb">
        <li><a href="index.html">Home</a> <span class="divider">/</span></li>
        <li class="active"> SHOPPING CART</li>
    </ul>
    <h3>  SHOPPING CART [ <small>3 Item(s) </small>]<a href="products.html" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Continue Shopping </a></h3>
    <hr class="soft"/>
    <table class="table table-bordered">
        <tr><th> I AM ALREADY REGISTERED  </th></tr>
        <tr>
        <td>
            <form class="form-horizontal">
                <div class="control-group">
                <label class="control-label" for="inputUsername">Username</label>
                <div class="controls">
                    <input type="text" id="inputUsername" placeholder="Username">
                </div>
                </div>
                <div class="control-group">
                <label class="control-label" for="inputPassword1">Password</label>
                <div class="controls">
                    <input type="password" id="inputPassword1" placeholder="Password">
                </div>
                </div>
                <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">Sign in</button> OR <a href="register.html" class="btn">Register Now!</a>
                </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                    <a href="forgetpass.html" style="text-decoration:underline">Forgot password ?</a>
                    </div>
                </div>
            </form>
        </td>
        </tr>
    </table>
    @if(session()->has('success_message'))
    <div class="alert alert-success" role="alert">
        {{ session()->get('success_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if(session()->has('error_message'))
    <div class="alert alert-danger" role="alert">
        {{ session()->get('error_message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <table class="table table-bordered">
            <thead>
                <tr>
                <th>Product</th>
                <th colspan="2">Description</th>
                <th>Quantity/Update</th>
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
                    <td>{{ $item->product->product_name }}<br/>Color : {{ $item->product->product_color }}</td>
                    <td colspan="2">
                        <div class="input-append">
                            <input class="span1" style="max-width:34px" value="{{ $item->quantity }}" id="appendedInputButtons" size="16" type="text">
                            <button class="btn" type="button"><i class="icon-minus"></i></button>
                            <button class="btn" type="button"><i class="icon-plus"></i></button>
                            <button class="btn btn-danger" type="button"><i class="icon-remove icon-white"></i></button>
                        </div>
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
                <td colspan="6" style="text-align:right">Voucher Discount:	</td>
                <td> Rs.0.00</td>
                </tr>
                <tr>
                <td colspan="6" style="text-align:right"><strong>TOTAL (Rs.3000 - Rs.0) =</strong></td>
                <td class="label label-important" style="display:block"> <strong> Rs.{{ $total_price }} </strong></td>
                </tr>
                </tbody>
            </table>


            <table class="table table-bordered">
            <tbody>
                <tr>
                <td>
                <form class="form-horizontal">
                <div class="control-group">
                <label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
                <div class="controls">
                <input type="text" class="input-medium" placeholder="CODE">
                <button type="submit" class="btn"> ADD </button>
                </div>
                </div>
                </form>
                </td>
                </tr>

            </tbody>
            </table>

            <!-- <table class="table table-bordered">
            <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
            <tr>
            <td>
                <form class="form-horizontal">
                <div class="control-group">
                    <label class="control-label" for="inputCountry">Country </label>
                    <div class="controls">
                    <input type="text" id="inputCountry" placeholder="Country">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="inputPost">Post Code/ Zipcode </label>
                    <div class="controls">
                    <input type="text" id="inputPost" placeholder="Postcode">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                    <button type="submit" class="btn">ESTIMATE </button>
                    </div>
                </div>
                </form>
            </td>
            </tr>
            </table> -->
    <a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
    <a href="login.html" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>

</div>
@endsection
