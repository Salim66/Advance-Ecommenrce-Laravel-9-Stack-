@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users</li>
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
                <h3 class="card-title">All Users | <a href="{{ url('/admin/view-users-charts') }}">Users Report</a> | <a href="{{ url('/admin/view-users-countries') }}">Users Countires Report</a></h3>
                <a href="{{ url('/admin/users-export') }}" class="btn btn-primary float-right">Export</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>city</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Pincode</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $data)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->address }}</td>
                        <td>{{ $data->city }}</td>
                        <td>{{ $data->state }}</td>
                        <td>{{ $data->country }}</td>
                        <td>{{ $data->pincode }}</td>
                        <td>{{ $data->mobile }}</td>
                        <td>{{ $data->email }}</td>
                        <td>
                            @if($data->status == 1)
                                <a class="updateUsersStatus" id="user-{{ $data->id }}" user_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                            @else
                            <a class="updateUsersStatus" id="user-{{ $data->id }}" user_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
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
