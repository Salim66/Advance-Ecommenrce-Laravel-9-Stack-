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
              <li class="breadcrumb-item active">Product Attribute</li>
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
            <h3 class="card-title">Add Attribute</h3>

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
            @if(session()->has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
                    {{ session()->get('error_message') }}
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
          <form id="productForm" @if(empty($product_data)) action="{{ url('admin/add-attribute') }}" @endif method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="product_name">Product Name: </label>
                            {{ $product_data->product_name }}
                        </div>
                        <div class="form-group">
                            <label for="product_code">Product Code: </label>
                            {{ $product_data->product_code }}
                        </div>
                        <div class="form-group">
                            <label for="product_color">Product Color: </label>
                            {{ $product_data->product_color }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            @if(!empty($product_data->main_image))
                                <img style="width: 120px;" src="{{ URL::to('images/product_images/small/'.$product_data->main_image) }}" alt="">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="field_wrapper">
                                <div>
                                    <input type="text" name="size[]" value="" placeholder="Size" style="width: 120px" required />
                                    <input type="text" name="sku[]" value="" placeholder="SKU" style="width: 120px" required />
                                    <input type="number" name="price[]" value="" placeholder="Price" style="width: 120px" required />
                                    <input type="number" name="stock[]" value="" placeholder="Stock" style="width: 120px" required />
                                    <a href="javascript:void(0);" title="Add" class="add_button btn btn-rounded btn-success btn-sm" title="Add field"><i class="fas fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">Add Attribute</button>
            </div>
          </form>

          <form action="{{ url('admin/edit-attribute') }}" method="POST">
            @csrf
            <div class="card">
                <div class="card-header">
                <h3 class="card-title">Added Product Attributes</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                    <th>ID</th>
                    <th>Size</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    {{-- <th>Status</th> --}}
                    <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($product_data->attributes as $data)
                    <input type="text" style="display: none;" name="attrId[]" value="{{ $data->id }}">
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->size }}</td>
                        <td>{{ $data->sku }}</td>
                        <td>
                            <input type="number" name="price[]" value="{{ $data->price }}">
                        </td>
                        <td>
                            <input type="number" name="stock[]" value="{{ $data->stock }}">
                        </td>
                        {{-- <td>
                            @if($data->status == 1)
                                <a class="updateProductStatus" id="product-{{ $data->id }}" product_id="{{ $data->id }}" href="javascript:void(0)">Active</a>
                            @else
                            <a class="updateProductStatus" id="product-{{ $data->id }}" product_id="{{ $data->id }}" href="javascript:void(0)">Inactive</a>
                            @endif
                        </td> --}}
                        <td>
                            <a title="Add Attribute" href="{{ url('admin/add-attribute/'. $data->id) }}"><i class="fas fa-plus"></i></a>
                            <a title="Edit Product" href="{{ url('admin/add-edit-product/'. $data->id) }}"><i class="fas fa-edit"></i></a>
                            <a title="Delete Product" href="javascript:void(0)" <?php /* href="{{ url('admin/delete-product/'. $data->id) }}" */ ?> class="confirmDelete" record="product" recordId="{{ $data->id }}"><i class="fas fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">Update Attribute</button>
                </div>
                </div>
                <!-- /.card-body -->
            </div>
          </form>

        </div>
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
