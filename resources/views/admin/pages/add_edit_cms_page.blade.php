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
              <li class="breadcrumb-item active">CMS Page</li>
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
          <form id="pageForm" @if(empty($cmspage)) action="{{ url('admin/add-edit-cms-page') }}" @else action="{{ url('admin/add-edit-cms-page/'.$cmspage->id) }}" @endif method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title*</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" @if(!empty($cmspage->title)) value="{{ $cmspage->title }}" @else value="{{ old('title') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="url">Url*</label>
                            <input type="text" class="form-control" name="url" id="url" placeholder="Enter Url" @if(!empty($cmspage->url)) value="{{ $cmspage->url }}" @else value="{{ old('url') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="description">Description*</label>
                            <textarea class="form-control" name="description" rows="3" placeholder="Enter Description">@if(!empty($cmspage->description)) {{ $cmspage->description }} @else {{ old('description') }} @endif</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title" placeholder="Enter Meta Title" @if(!empty($cmspage->meta_title)) value="{{ $cmspage->meta_title }}" @else value="{{ old('meta_title') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <input type="text" class="form-control" name="meta_description" id="meta_description" placeholder="Enter Meta Description" @if(!empty($cmspage->meta_description)) value="{{ $cmspage->meta_description }}" @else value="{{ old('meta_description') }}" @endif>
                        </div>
                        <div class="form-group">
                            <label for="meta_keyword">Meta Keyword</label>
                            <input type="text" class="form-control" name="meta_keyword" id="meta_keyword" placeholder="Enter Meta Keyword" @if(!empty($cmspage->meta_keyword)) value="{{ $cmspage->meta_keyword }}" @else value="{{ old('description') }}" @endif>
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
