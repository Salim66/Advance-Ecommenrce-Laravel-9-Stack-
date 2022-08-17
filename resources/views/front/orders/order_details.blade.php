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
    <h3> ORDERS #{{ $orderDetails->id }} Details
        @if($getOrderStatus == "New")
            <!-- Button trigger modal -->
            <button style="float: right" type="button" class="btn btn-primary" data-toggle="modal" data-target="#cancelModalCenter">
                Cancel Order
            </button>
        @endif
        @if($getOrderStatus == "Delivered")
            <!-- Button trigger modal -->
            <button style="float: right" type="button" class="btn btn-primary" data-toggle="modal" data-target="#returnModalCenter">
                Return/Exchange Order
            </button>
        @endif
    </h3>


    @if(Session::has('success_message'))
    <div class="alert alert-success" role="alert">
      {{ Session::get('success_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
        @php Session::forget('success_message') @endphp
    @endif

    @if(Session::has('error_message'))
    <div class="alert alert-warning" role="alert">
      {{ Session::get('error_message') }}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @php Session::forget('error_message') @endphp
    @endif

     @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
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
                    <th>Item Status</th>
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
                    <td>{{ $pro->item_status }}</td>
                </tr>
                @endforeach
           </table>
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModalCenter" tabindex="-1" role="dialog"            aria-labelledby="cancelModalCenterTitle" aria-hidden="true">
    <form action="{{ url('/orders/'.$orderDetails->id.'/cancel') }}" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLongTitle">Reason for Cancelletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
              <div class="modal-body">
                <select name="reason" id="cancelReason">
                    <option value="">Select Reason</option>
                    <option value="Order Created By Mistake">Order Created By Mistake</option>
                    <option value="Item Not Arrive on Time">Item Not Arrive on Time</option>
                    <option value="Shipping Cost to High">Shipping Cost to High</option>
                    <option value="Found Cheaper Somewhere Else">Found Cheaper Somewhere Else</option>
                    <option value="Others">Others</option>
                </select>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnCancelOrder">Cancel Order</button>
              </div>
            </div>
          </div>
    </form>
</div>

<!-- Return Modal -->
<div class="modal fade" id="returnModalCenter" tabindex="-1" role="dialog"            aria-labelledby="returnModalCenterTitle" aria-hidden="true" style="width: 380px;">
    <form action="{{ url('/orders/'.$orderDetails->id.'/return') }}" method="POST">
        @csrf
        <div class="modal-dialog modal-dialog-centered" role="document" align="center">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="returnModalLongTitle">Reason for Return/Exchange</h5>
              </div>
              <div class="modal-body">
                <select name="return_exchange" id="returnExchange">
                    <option value="">Select Return/Exchange</option>
                    <option value="Return">Return</option>
                    <option value="Exchange">Exchange</option>
                </select>
              </div>
              <div class="modal-body">
                <select name="product_info" id="returnProduct">
                    <option value="">Select Product</option>
                    @foreach ($orderDetails->order_products as $product)
                        @if($product->item_status != 'Return Initiated')
                        <option value="{{ $product->product_code }}-{{ $product->product_size }}">{{ $product->product_code }}-{{ $product->product_size }}</option>
                        @endif
                    @endforeach
                </select>
              </div>
              <div class="modal-body">
                <select name="product_size" class="productSize">
                    <option value="">Select Exchange Size</option>
                    <option value="Return">Return</option>
                </select>
              </div>
              <div class="modal-body">
                <select name="return_reason" id="returnReason">
                    <option value="">Select Reason</option>
                    <option value="Performance for quality not adequate">Performance for quality not adequate</option>
                    <option value="Product Damaged but Shiping Box Ok">Product Damaged but Shiping Box Ok</option>
                    <option value="Item arrived too late">Item arrived too late</option>
                    <option value="Wrong item was send">Wrong item was send</option>
                    <option value="Item deffective or doesn't work">Item deffective or doesn't work</option>
                    <option value="Require Smaller Size">Require Smaller Size</option>
                    <option value="Require Large Size">Require Large Size</option>
                </select>
              </div>
              <div class="modal-body">
                <textarea name="comment" placeholder="Comment"></textarea>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btnReturnOrder">Return Order</button>
              </div>
            </div>
          </div>
    </form>
</div>
@endsection
