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
              <li class="breadcrumb-item active">Brands</li>
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
          <form id="bannerForm" @if(empty($banner_data)) action="{{ url('admin/add-edit-banner') }}" @else action="{{ url('admin/add-edit-banner/'.$banner_data->id) }}" @endif method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="banner_image">Banner Image</label>
                            <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="banner_image">
                                <label class="custom-file-label" for="banner_image">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                           </div>
                          <div>Recommended Image Size( Width:1170px, Height:480px )</div>
                            @if(!empty($banner_data->image) && file_exists('images/banner_images/'.$banner_data->image))
                                <img style="width: 220px; margin-top: 10px;" src="{{ URL::to('images/banner_images/'.$banner_data->image) }}" alt="">
                                <a class="confirmDelete" href="javascript:void(0)" record="banner-image" recordId="{{ $banner_data->id }}">Delete Image</a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Banner Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Banner Title" @if(!empty($banner_data->title)) value="{{ $banner_data->title }}" @else value="{{ old('title') }}" @endif>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="link">Banner Link</label>
                            <input type="text" class="form-control" name="link" id="link" placeholder="Enter Banner Link" @if(!empty($banner_data->link)) value="{{ $banner_data->link }}" @else value="{{ old('link') }}" @endif>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alt">Banner Alternate Text</label>
                            <input type="text" class="form-control" name="alt" id="alt" placeholder="Enter Banner Alt Text" @if(!empty($banner_data->alt)) value="{{ $banner_data->alt }}" @else value="{{ old('alt') }}" @endif>
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
