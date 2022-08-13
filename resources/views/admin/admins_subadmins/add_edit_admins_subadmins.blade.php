@extends('layouts.admin_layout.admin_layout')

@section('content')
 <!-- Content Wrapper. Contains page content -->
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
              <li class="breadcrumb-item active">Admins / Subadmins</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
            @if(session()->has('success_message'))
                <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
                    {{ session()->get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               @php Session::forget('success_message') @endphp
            @endif
            @if(session()->has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    {{ session()->get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @php Session::forget('error_message') @endphp
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
          <form id="adminSubadminForm" @if(empty($admindata)) action="{{ url('admin/add-edit-admins-subadmins') }}" @else action="{{ url('admin/add-edit-admins-subadmins/'.$admindata->id) }}" @endif method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="admin_name">Admin Name</label>
                        <input type="text" class="form-control" name="admin_name" id="admin_name" placeholder="Enter Admin Name" @if(!empty($admindata->name)) value="{{ $admindata->name }}" @else value="{{ old('admin_name') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="admin_mobile">Admin Mobile</label>
                        <input type="text" class="form-control" name="admin_mobile" id="admin_mobile" placeholder="Enter Admin Name" @if(!empty($admindata->mobile)) value="{{ $admindata->mobile }}" @else value="{{ old('admin_mobile') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Admin Image</label>
                        <input type="file" class="form-control" name="admin_image" accept="image/*">
                        @if(!empty($admindata->image))
                        <a href="{{ url('images/admin_images/admin_photos/'.$admindata->image) }}">View Image</a>
                        <input type="hidden" name="current_admin_image" value="{{ $admindata->image }}">
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    @if(!empty($admindata->email))
                    <div class="form-group">
                        <label for="admin_email">Admin Email</label>
                        <input type="email" class="form-control" value="{{ $admindata->email }}" readonly disabled>
                    </div>
                    @else
                    <div class="form-group">
                        <label for="admin_email">Admin Email</label>
                        <input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="Enter Email" @if(!empty($admindata->email)) readonly value="{{ $admindata->email }}" @else value="{{ old('admin_email') }}" @endif>
                    </div>
                    @endif
                    <div class="form-group">
                        <label>Admin Type</label>
                        <select class="form-control select2" name="admin_type" id="admin_type" style="width: 100%;">
                            <option selected disabled>Select</option>
                            <option value="admin" @if(!empty(@old('admin_type')) && "admin" == @old('admin_type')) selected @elseif(!empty($admindata->type) && $admindata->type=="admin") selected @endif>Admin</option>
                            <option value="sub admin" @if(!empty(@old('admin_type')) && "sub admin" == @old('admin_type')) selected @elseif(!empty($admindata->type) && $admindata->type=="sub admin") selected @endif>Sub Admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="admin_password">Admin Password</label>
                        <input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Enter Admin Password">
                    </div>
                </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
