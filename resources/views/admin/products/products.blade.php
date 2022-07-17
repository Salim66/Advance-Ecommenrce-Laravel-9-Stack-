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
              <li class="breadcrumb-item active">Products</li>
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
                <h3 class="card-title">All Products</h3>
                <a href="{{ url('/admin/add-edit-product') }}" class="btn btn-primary float-right">Add Product</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Product Code</th>
                    <th>Product Color</th>
                    <th>Product Image</th>
                    <th>Category</th>
                    <th>Section</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($all_data as $data)
                    {{-- @if(!isset($data->parentCategory->category_name))
                        @php $parent_category = 'Root'; @endphp
                    @else
                        @php $parent_category = $data->parentCategory->category_name; @endphp
                    @endif --}}
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->product_name }}</td>
                        <td>{{ $data->product_code }}</td>
                        <td>{{ $data->product_color }}</td>
                        <td>
                            @if (file_exists('images/product_images/small/'.$data->main_image) && !empty($data->main_image))
                                <img width="100px" src="{{ URL::to('images/product_images/small/'. $data->main_image) }}" alt="">
                            @else
                                <img width="100px" src="{{ URL::to('/images/product_images/small/no_image.jpg') }}" alt="">
                            @endif
                        </td>
                        <td>{{ $data->category->category_name }}</td>
                        <td>{{ $data->section->name }}</td>
                        <td>
                            @if($data->status == 1)
                                <a class="updateProductStatus" id="product-{{ $data->id }}" product_id="{{ $data->id }}" href="javascript:void(0)">Active</a>
                            @else
                            <a class="updateProductStatus" id="product-{{ $data->id }}" product_id="{{ $data->id }}" href="javascript:void(0)">Inactive</a>
                            @endif
                        </td>
                        <td style="width: 120px;">
                            <a title="Add Attribute" href="{{ url('admin/add-attribute/'. $data->id) }}"><i class="fas fa-plus"></i></a>
                            <a title="Add Images" href="{{ url('admin/add-images/'. $data->id) }}"><i class="fas fa-plus-circle"></i></a>
                            <a title="Edit Product" href="{{ url('admin/add-edit-product/'. $data->id) }}"><i class="fas fa-edit"></i></a>
                            <a title="Delete Product" href="javascript:void(0)" <?php /* href="{{ url('admin/delete-product/'. $data->id) }}" */ ?> class="confirmDelete" record="product" recordId="{{ $data->id }}"><i class="fas fa-trash"></i></a>
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
