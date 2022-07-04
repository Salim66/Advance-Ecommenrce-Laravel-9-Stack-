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
              <li class="breadcrumb-item active">Categories</li>
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
            <h3 class="card-title">Add Category</h3>

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
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
          <form id="categoryForm" action="{{ url('admin/add-edit-category') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter Category Name">
                    </div>
                    <div id="appendCategoryLevel">
                        @include('admin.categories.append_category_level')
                    </div>
                    <div class="form-group">
                        <label for="category_discount">Category Discount</label>
                        <input type="text" class="form-control" name="category_discount" id="category_discount" placeholder="Enter Category Discount">
                    </div>
                    <div class="form-group">
                        <label>Category Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Enter Category Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="3" placeholder="Enter Meta Description"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                    <label>Select Section</label>
                    <select class="form-control select2" name="section_id" id="section_id" style="width: 100%;">
                        <option selected disabled>Select</option>
                        @foreach($all_section as $section)
                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="form-group">
                        <label for="categroy_image">Category Image</label>
                        <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="category_image" class="custom-file-input" id="categroy_image">
                            <label class="custom-file-label" for="categroy_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="url">Category URL</label>
                        <input type="text" class="form-control" name="url" id="url" placeholder="Enter Category URL">
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <textarea class="form-control" name="meta_title" rows="3" placeholder="Enter Meta Title"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Keyword</label>
                        <textarea class="form-control" name="meta_keyword" rows="3" placeholder="Enter Meta Keyword"></textarea>
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
