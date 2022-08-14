@extends('layouts.admin_layout.admin_layout')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Currencies</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Currencies</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    @if(session()->has('success_message'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session()->get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Currency</h3>
                <a href="{{ url('/admin/add-edit-currency') }}" class="btn btn-primary float-right">Add Currency</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Currency Code</th>
                    <th>Exchange Rate</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($currencies as $data)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $data->currency_code }}</td>
                        <td>{{ $data->exchange_rate }}</td>
                        <td>
                            @if($data->status == 1)
                                <a class="updateCurrenciesStatus" id="currency-{{ $data->id }}" currency_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-on" status="Active"></i></a>
                            @else
                            <a class="updateCurrenciesStatus" id="currency-{{ $data->id }}" currency_id="{{ $data->id }}" href="javascript:void(0)"><i class="fas fa-toggle-off" status="Inactive"></i></a>
                            @endif
                        </td>
                        <td>
                            <a href="{{ url('admin/add-edit-currency/'. $data->id) }}"><i class="fas fa-edit"></i></a>&nbsp;&nbsp;
                            <a href="javascript:void(0)" class="confirmDelete" record="currency" recordId="{{ $data->id }}"><i class="fas fa-trash"></i></a>
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
