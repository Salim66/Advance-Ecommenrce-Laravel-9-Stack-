@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coupon</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupon</li>
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
                <h3 class="card-title">All Coupon</h3>
                <a href="{{ url('/admin/add-edit-coupon') }}" class="btn btn-primary float-right">Add Coupon</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Code</th>
                    <th>Coupon Type</th>
                    <th>Acount</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($all_data as $data)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>
                            {{ $data->coupon_code }}
                        </td>
                        <td>{{ $data->coupon_type }}</td>
                        <td>
                            {{ $data->amount }}
                            @if ($data->amount_type == 'Percentage')
                                %
                            @else
                                INR
                            @endif

                        </td>
                        <td>{{ $data->expiry_date }}</td>
                        <td>
                            @if($couponModule->edit_access == 1 || $couponModule->full_access == 1)
                            @if($data->status == 1)
                                <a class="updateCouponsStatus" id="coupon-{{ $data->id }}" coupon_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                            @else
                            <a class="updateCouponsStatus" id="coupon-{{ $data->id }}" coupon_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                            @endif
                            @endif
                        </td>
                        <td>
                            @if($couponModule->edit_access == 1 || $couponModule->full_access == 1)
                            <a href="{{ url('admin/add-edit-coupon/'. $data->id) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                            @endif
                            @if($couponModule->full_access == 1)
                            <a href="javascript:void(0)" class="confirmDelete" record="coupon" recordId="{{ $data->id }}"><i class="fas fa-trash"></i></a>
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
