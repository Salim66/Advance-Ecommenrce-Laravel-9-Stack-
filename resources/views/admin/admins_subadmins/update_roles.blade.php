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
              <li class="breadcrumb-item active">Admins/Subadmins</li>
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
            <h3 class="card-title">{!! $title !!}</h3>

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
          <form id="brandForm" action="{{ url('admin/update-roles/'.$admindata->id) }}" method="POST">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if(isset($adminRoles))
                            @foreach($adminRoles as $role)
                                @if($role->module == 'categories')
                                    @if($role->view_access == 1)
                                        @php $viewCategories = 'checked'; @endphp
                                    @else
                                        @php $viewCategories = ''; @endphp
                                    @endif
                                    @if($role->edit_access == 1)
                                        @php $editCategories = 'checked'; @endphp
                                    @else
                                        @php $editCategories = ''; @endphp
                                    @endif
                                    @if($role->full_access == 1)
                                        @php $fullCategories = 'checked'; @endphp
                                    @else
                                        @php $fullCategories = ''; @endphp
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        <div class="form-group">
                            <label>Categories</label><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="categories[view]" id="categories_view" value="1" @if(isset($viewCategories)) {{ $viewCategories }} @endif>&nbsp;<label for="categories_view" class="font-weight-normal">View Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="categories[edit]" id="categories_edit" value="1" @if(isset($editCategories)) {{ $editCategories }} @endif>&nbsp;<label for="categories_edit" class="font-weight-normal">Edit Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="categories[full]" id="categories_full" value="1" @if(isset($fullCategories)) {{ $fullCategories }} @endif>&nbsp;<label for="categories_full" class="font-weight-normal">Full Access</label>
                        </div>
                        @if(isset($adminRoles))
                            @foreach($adminRoles as $role)
                                @if($role->module == 'products')
                                    @if($role->view_access == 1)
                                        @php $viewProducts = 'checked'; @endphp
                                    @else
                                        @php $viewProducts = ''; @endphp
                                    @endif
                                    @if($role->edit_access == 1)
                                        @php $editProducts = 'checked'; @endphp
                                    @else
                                        @php $editProducts = ''; @endphp
                                    @endif
                                    @if($role->full_access == 1)
                                        @php $fullProducts = 'checked'; @endphp
                                    @else
                                        @php $fullProducts = ''; @endphp
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        <div class="form-group">
                            <label>Products</label><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="products[view]" id="products_view" value="1" @if(isset($viewProducts)) {{ $viewProducts }} @endif>&nbsp;<label for="products_view" class="font-weight-normal">View Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="products[edit]" id="products_edit" value="1" @if(isset($editProducts)) {{ $editProducts }} @endif>&nbsp;<label for="products_edit" class="font-weight-normal">Edit Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="products[full]" id="products_full" value="1" @if(isset($fullProducts)) {{ $fullProducts }} @endif>&nbsp;<label for="products_full" class="font-weight-normal">Full Access</label>
                        </div>
                        @if(isset($adminRoles))
                            @foreach($adminRoles as $role)
                                @if($role->module == 'coupons')
                                    @if($role->view_access == 1)
                                        @php $viewCoupons = 'checked'; @endphp
                                    @else
                                        @php $viewCoupons = ''; @endphp
                                    @endif
                                    @if($role->edit_access == 1)
                                        @php $editCoupons = 'checked'; @endphp
                                    @else
                                        @php $editCoupons = ''; @endphp
                                    @endif
                                    @if($role->full_access == 1)
                                        @php $fullCoupons = 'checked'; @endphp
                                    @else
                                        @php $fullCoupons = ''; @endphp
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        <div class="form-group">
                            <label>Coupons</label><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="coupons[view]" id="coupons_view" value="1" @if(isset($viewCoupons)) {{ $viewCoupons }} @endif>&nbsp;<label for="coupons_view" class="font-weight-normal">View Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="coupons[edit]" id="coupons_edit" value="1" @if(isset($editCoupons)) {{ $editCoupons }} @endif>&nbsp;<label for="coupons_edit" class="font-weight-normal">Edit Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="coupons[full]" id="coupons_full" value="1" @if(isset($fullCoupons)) {{ $fullCoupons }} @endif>&nbsp;<label for="coupons_full" class="font-weight-normal">Full Access</label>
                        </div>
                        @if(isset($adminRoles))
                            @foreach($adminRoles as $role)
                                @if($role->module == 'orders')
                                    @if($role->view_access == 1)
                                        @php $viewOrders = 'checked'; @endphp
                                    @else
                                        @php $viewOrders = ''; @endphp
                                    @endif
                                    @if($role->edit_access == 1)
                                        @php $editOrders = 'checked'; @endphp
                                    @else
                                        @php $editOrders = ''; @endphp
                                    @endif
                                    @if($role->full_access == 1)
                                        @php $fullOrders = 'checked'; @endphp
                                    @else
                                        @php $fullOrders = ''; @endphp
                                    @endif
                                @endif
                            @endforeach
                        @endif
                        <div class="form-group">
                            <label>Orders</label><br>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="orders[view]" id="orders_view" value="1" @if(isset($viewOrders)) {{ $viewOrders }} @endif>&nbsp;<label for="orders_view" class="font-weight-normal">View Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="orders[edit]" id="orders_edit" value="1" @if(isset($editOrders)) {{ $editOrders }} @endif>&nbsp;<label for="orders_edit" class="font-weight-normal">Edit Access</label>
                            &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="orders[full]" id="orders_full" value="1" @if(isset($fullOrders)) {{ $fullOrders }} @endif>&nbsp;<label for="orders_full" class="font-weight-normal">Full Access</label>
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
