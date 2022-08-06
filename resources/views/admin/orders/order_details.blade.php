@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            @if(session()->has('success_message'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    {{ session()->get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php Session::forget('success_message'); ?>
            @endif
          </div>
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Order #{{ $orderDetails->id }} Detail</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Order Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Order Date</td>
                            <td>{{ date('d-m-Y', strtotime($orderDetails->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>Order Status</td>
                            <td>{{ $orderDetails->order_status }}</td>
                        </tr>
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
                        <tr>
                            <td>Payment Gateway</td>
                            <td>{{ $orderDetails->payment_gateway }}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Delivery Address</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
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
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Customer Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $customerDetials->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $customerDetials->email }}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Billing Address</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Name</td>
                            <td>{{ $customerDetials->name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $customerDetials->address }}</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>{{ $customerDetials->city }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ $customerDetials->state }}</td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>{{ $customerDetials->country }}</td>
                        </tr>
                        <tr>
                            <td>Pincode</td>
                            <td>{{ $customerDetials->pincode }}</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>{{ $customerDetials->mobile }}</td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>

              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Update Order Status</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td colspan="2">
                                <form action="{{ url('admin/update-order-status') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $orderDetails->id }}">
                                    <select name="order_status" id="">
                                        @foreach($orderStatuses as $order)
                                        <option value="{{ $order->name }}" @if( isset($orderDetails->order_status) && $orderDetails->order_status == $order->name ) selected @endif>{{ $order->name }}</option>
                                        @endforeach
                                    </select>&nbsp;&nbsp;
                                    <button type="submit">Update</button>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                @foreach ($odersLog as $log)
                                    <strong>{{ $log->order_status }}</strong><br />
                                    {{ date('j F, Y, g:i a', strtotime($log->created_at)) }}
                                    <hr>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Product Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>Product Image</th>
                            <th>Product Code</th>
                            <th>Product Name</th>
                            <th>Product Size</th>
                            <th>Product Color</th>
                            <th>Product Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails->order_products as $pro)
                        <tr>
                            <td>
                                @php
                                    $getProductImage = \App\Models\Product::getProductImage($pro->id);
                                @endphp
                                <a target="_blank" href="{{ url('/product/'.$pro->id) }}"><img style="width: 50px;" src="{{ URL::to('images/product_images/small/'.$getProductImage->main_image) }}" alt=""></a>
                            </td>
                            <td>{{ $pro->product_code }}</td>
                            <td>{{ $pro->product_name }}</td>
                            <td>{{ $pro->product_size }}</td>
                            <td>{{ $pro->product_color }}</td>
                            <td>{{ $pro->product_qty }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endsection
