@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admins / Subadmins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admins / Subadmins</li>
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
                <h3 class="card-title">All Admins / Subadmins</h3>
                <a href="{{ url('/admin/add-edit-admins-subadmins') }}" class="btn btn-primary float-right">Add Admin / Subadmin</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Type</th>
                    @if(Auth::guard('admin')->user()->type == "super admin")
                    <th>Status</th>
                    <th>Action</th>
                    @endif
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($admins as $data)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{ $data->mobile }}</td>
                        <td>{{ $data->email }}</td>
                        <td>{{ $data->type }}</td>
                        @if(Auth::guard('admin')->user()->type == "super admin")
                        <td>
                            @if($data->status == 1)
                                <a class="updateAdminsSubAdminsStatus" id="admin-{{ $data->id }}" admin_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                            @else
                            <a class="updateAdminsSubAdminsStatus" id="admin-{{ $data->id }}" admin_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                            @endif
                        </td>
                        <td style="width: 120px;">
                            <a title="Add Roles and Permission" href="{{ url('admin/update-roles/'. $data->id) }}"><i class="fas fa-unlock"></i></a>&nbsp;&nbsp;
                            <a title="Edit Admins Subadmins" href="{{ url('admin/add-edit-admins-subadmins/'. $data->id) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                            <a title="Delete Admins Subadmins" href="javascript:void(0)" class="confirmDelete" record="admins-subadmins" recordId="{{ $data->id }}"><i class="fas fa-trash"></i></a>
                        </td>
                        @endif
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
