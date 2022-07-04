@extends('layouts.admin_layout.admin_layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <!-- left column -->
            <div class="col-md-6">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Update Admin Details</h3>
                </div>

                @if(session()->has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                  {{ session()->get('error_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif

                @if(session()->has('success_message'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                  {{ session()->get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger mt-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- /.card-header -->
                <!-- form start -->
                <form method="POST" action="{{ url('/admin/update-admin-details') }}" id="updateAdminDetails" enctype="multipart/form-data">
                    @csrf
                  <div class="card-body">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Admin Email</label>
                      <input type="email" class="form-control" readonly value="{{ Auth::guard('admin')->user()->email }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Admin Type</label>
                      <input type="email" class="form-control" readonly value="{{ Auth::guard('admin')->user()->type }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Admin Name</label>
                      <input type="text" class="form-control" placeholder="Enter Admin Name" name="admin_name" id="admin_name" value="{{ Auth::guard('admin')->user()->name }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Admin Mobile</label>
                      <input type="text" class="form-control" placeholder="Enter Admin Mobile" name="admin_mobile" id="admin_mobile" value="{{ Auth::guard('admin')->user()->mobile }}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Image</label>
                      <input type="file" class="form-control" name="admin_image" accept="image/*">
                      @if(!empty(Auth::guard('admin')->user()->image))
                          <a href="{{ url('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                        <input type="hidden" name="current_admin_image" value="{{ Auth::guard('admin')->user()->image }}">
                      @endif
                    </div>
                  </div>
                  <!-- /.card-body -->

                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            <!--/.col (left) -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

  </div>
  <!-- /.content-wrapper -->
@endsection
