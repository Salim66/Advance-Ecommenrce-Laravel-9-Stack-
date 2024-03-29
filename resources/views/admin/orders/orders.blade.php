@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogues</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Orders</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if(session()->has('success_message'))
            <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
              {{ session()->get('success_message') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @endif
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Order | <a href="{{ url('/admin/view-orders-charts') }}">Orders Report</a></h3>
                <a href="{{ url('/admin/orders-export') }}" class="btn btn-primary float-right">Orders Export</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Ordered Products</th>
                    <th>Order Amount</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            @foreach ($data->order_products as $pro)
                                {{ $pro->product_code }} ({{ $pro->product_qty }})
                            @endforeach
                        </td>
                        <td>{{ $data->grand_total }}</td>
                        <td>{{ $data->order_status }}</td>
                        <td>{{ $data->payment_method }}</td>
                        <td style="width: 120px;">
                            @if($orderModule['edit_access'] == 1 || $orderModule['full_access'] == 1)
                            <a title="View Details" href="{{ url('admin/orders/'. $data->id) }}"><i class="fas fa-file"></i></a> &nbsp;
                            @if($data->order_status == "Shipped" || $data->order_status == "Delivered")
                            <a title="Print Order Invoice" href="{{ url('admin/view-order-invoice/'. $data->id) }}"><i class="fas fa-print"></i></a> &nbsp;
                            <a title="Print PDF Invoice" href="{{ url('admin/print-pdf-invoice/'. $data->id) }}"><i class="far fa-file-pdf"></i></a> &nbsp;
                            @endif
                            @endif
                        </td>
                    </tr>
                    @endforeach
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
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
