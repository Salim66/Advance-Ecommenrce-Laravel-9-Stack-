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
              <li class="breadcrumb-item active">Shopping Charges</li>
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
                <h3 class="card-title">All Shopping Charge</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Country</th>
                    <th>Shipping Charge</th>
                    <th>Status</th>
                    <th>Updated At</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($shipping_charges as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->country }}</td>
                        <td>{{ $data->shipping_charges }}</td>
                        <td>
                            @if($data->status == 1)
                                <a class="updateShippingStatus" id="shipping-{{ $data->id }}" shipping_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                            @else
                            <a class="updateShippingStatus" id="shipping-{{ $data->id }}" shipping_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                            @endif
                        </td>
                        <td>{{ date('d-m-Y', strtotime($data->updated_at)) }}</td>
                        <td style="width: 120px;">
                            <a title="Update Shipping Charges" href="{{ url('admin/edit-shipping-charges/'. $data->id) }}"><i class="fas fa-edit"></i></a>
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
