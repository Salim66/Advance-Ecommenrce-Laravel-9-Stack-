@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Return Request</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Return Request</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if(session()->has('success_message'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session()->get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Return Request</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Product Size</th>
                    <th>Product Code</th>
                    <th>Return Reason</th>
                    <th>Return Status</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th>Approve/Reject</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($return_request as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td><a target="_blank" href="{{ url('/admin/orders/'.$data->order_id) }}">{{ $data->order_id }}</a></td>
                        <td>{{ $data->user_id }}</td>
                        <td>{{ $data->product_size }}</td>
                        <td>{{ $data->product_code }}</td>
                        <td>{{ $data->return_reason }}</td>
                        <td>{{ $data->return_status }}</td>
                        <td>{{ $data->comment }}</td>
                        <td>{{ date('d m Y, h:i:s', strtotime($data->created_at)) }}</td>
                        <td>
                            <select name="return_status" class="form-control">
                                <option @if($data->return_status == 'Approved') selected @endif value="Approved">Approved</option>
                                <option @if($data->return_status == 'Rejected') selected @endif value="Rejected">Rejected</option>
                                <option @if($data->return_status == 'Pending') selected @endif value="Pending">Pending</option>
                            </select>
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
