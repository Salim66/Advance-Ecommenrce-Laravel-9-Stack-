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
              <li class="breadcrumb-item active">Coupons</li>
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
          <form id="couponForm" @if(empty($coupon_data)) action="{{ url('admin/add-edit-coupon') }}" @else action="{{ url('admin/add-edit-banner/'.$coupon_data->id) }}" @endif method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="coupon_option">Coupon Option</label><br>
                            <input type="radio" id="automatic_option" name="coupon_option" name="coupon_option" id="coupon_option" value="Automatic">&nbsp;Automatic&nbsp;&nbsp;
                            <input type="radio" id="manual_option" name="coupon_option" name="coupon_option" id="coupon_option" value="Manual">&nbsp;Manual
                        </div>
                        <div class="form-group" style="display: none;" id="coupon_manual_code">
                            <label for="coupon_code">Coupon Code</label>
                            <input type="text" class="form-control" name="coupon_code" id="coupon_code" placeholder="Enter Coupon Code">
                        </div>
                        <div class="form-group">
                            <label>Select Categories</label>
                            <select class="form-control select2" name="categories[]" style="width: 100%;" multiple>
                                <option selected disabled>Select Categories</option>
                                @foreach($categories as $section)
                                    <optgroup label="{{ $section->name }}"></optgroup>
                                    @foreach ($section->categories as $category)
                                        <option value="{{ $category->id }}" @if(!empty(@old('category_id')) && $category->id==@old('category_id')) selected @elseif(!empty($product_data->category_id) && $product_data->category_id==$category->id) selected @endif>&nbsp;&nbsp;--&nbsp;&nbsp;{{ $category->category_name }}</option>
                                        @foreach ($category->sub_categories as $sub)
                                            <option value="{{ $sub->id }}" @if(!empty(@old('category_id')) && $sub->id==@old('category_id')) selected @elseif(!empty($product_data->category_id) && $product_data->category_id==$sub->id) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $sub->category_name }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
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
