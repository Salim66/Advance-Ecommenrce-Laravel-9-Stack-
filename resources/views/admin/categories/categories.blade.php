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
              <li class="breadcrumb-item active">Categories</li>
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
                <h3 class="card-title">All Categories</h3>
                <a href="{{ url('/admin/add-edit-category') }}" class="btn btn-primary float-right">Add Category</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Category Name</th>
                    <th>Parent Category</th>
                    <th>Section</th>
                    <th>URL</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($all_data as $data)
                    @if(!isset($data->parentCategory->category_name))
                        @php $parent_category = 'Root'; @endphp
                    @else
                        @php $parent_category = $data->parentCategory->category_name; @endphp
                    @endif
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->category_name }}</td>
                        <td>{{ $parent_category }}</td>
                        <td>{{ $data->section->name }}</td>
                        <td>{{ $data->url }}</td>
                        <td>
                            @if($categoryModule['edit_access'] == 1 || $categoryModule['full_access'] == 1)
                            @if($data->status == 1)
                                <a class="updateCategoryStatus" id="category-{{ $data->id }}" category_id="{{ $data->id }}" href="javascript:void(0)">Active</a>
                            @else
                            <a class="updateCategoryStatus" id="category-{{ $data->id }}" category_id="{{ $data->id }}" href="javascript:void(0)">Inactive</a>
                            @endif
                            @endif
                        </td>
                        <td>
                            @if($categoryModule['edit_access'] == 1 || $categoryModule['full_access'] == 1)
                            <a href="{{ url('admin/add-edit-category/'. $data->id) }}" class="btn btn-info">Edit</a>
                            @endif
                            @if($categoryModule['full_access'] == 1)
                            <a href="javascript:void(0)" <?php /* href="{{ url('admin/delete-category/'. $data->id) }}" */ ?> class="btn btn-danger confirmDelete" record="category" recordId="{{ $data->id }}">Delete</a>
                            @endif
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
