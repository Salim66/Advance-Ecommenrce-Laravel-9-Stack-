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
              <li class="breadcrumb-item active">Product</li>
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
          <form id="productForm" @if(empty($product_data)) action="{{ url('admin/add-edit-product') }}" @else action="{{ url('admin/add-edit-product/'.$product_data->id) }}" @endif method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Select Category</label>
                        <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;">
                            <option selected disabled>Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter product Name" @if(!empty($product_data->product_name)) value="{{ $product_data->product_name }}" @else value="{{ old('product_name') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_price">Product Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price" placeholder="Enter product price" @if(!empty($product_data->product_price)) value="{{ $product_data->product_price }}" @else value="{{ old('product_price') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_discount">Product Discount</label>
                        <input type="text" class="form-control" name="product_discount" id="product_discount" placeholder="Enter product Discount" @if(!empty($product_data->product_discount)) value="{{ $product_data->product_discount }}" @else value="{{ old('product_discount') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_video">product Video</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="product_image" class="custom-file-input" id="product_video">
                                <label class="custom-file-label" for="product_video">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>product Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Enter product Description">@if(!empty($product_data->description)) {{ $product_data->description }} @else {{ old('description') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="3" placeholder="Enter Meta Description">@if(!empty($product_data->meta_description)) {{ $product_data->meta_description }} @else {{ old('meta_description') }} @endif</textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="product_code">Product Code</label>
                        <input type="text" class="form-control" name="product_code" id="product_code" placeholder="Enter product code" @if(!empty($product_data->product_code)) value="{{ $product_data->product_code }}" @else value="{{ old('product_code') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_color">Product Color</label>
                        <input type="text" class="form-control" name="product_color" id="product_color" placeholder="Enter product color" @if(!empty($product_data->product_color)) value="{{ $product_data->product_color }}" @else value="{{ old('product_color') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_weight">Product Weight</label>
                        <input type="text" class="form-control" name="product_weight" id="product_weight" placeholder="Enter product weight" @if(!empty($product_data->product_weight)) value="{{ $product_data->product_weight }}" @else value="{{ old('product_weight') }}" @endif>
                    </div>
                    <div class="form-group">
                        <label for="product_main_image">product Main Image</label>
                        <div class="input-group">
                        <div class="custom-file">
                            <input type="file" name="product_image" class="custom-file-input" id="product_main_image">
                            <label class="custom-file-label" for="product_main_image">Choose file</label>
                        </div>
                        <div class="input-group-append">
                            <span class="input-group-text">Upload</span>
                        </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Wash Care</label>
                        <textarea class="form-control" name="wash_care" rows="3" placeholder="Enter Meta Title">@if(!empty($product_data->wash_care)) {{ $product_data->wash_care }} @else {{ old('wash_care') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Title</label>
                        <textarea class="form-control" name="meta_title" rows="3" placeholder="Enter Meta Title">@if(!empty($product_data->meta_title)) {{ $product_data->meta_title }} @else {{ old('meta_title') }} @endif</textarea>
                    </div>
                    <div class="form-group">
                        <label>Meta Keyword</label>
                        <textarea class="form-control" name="meta_keyword" rows="3" placeholder="Enter Meta Keyword">@if(!empty($product_data->meta_keyword)) {{ $product_data->meta_keyword }} @else {{ old('meta_keyword') }} @endif</textarea>
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
