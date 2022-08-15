@extends('layouts.admin_layout.admin_layout')

@section('content')
<?php

    foreach ($getUsersCountries as $key => $value) {
        $dataPoints[$key]['label'] = $getUsersCountries[$key]['country'];
        $dataPoints[$key]['y'] = $getUsersCountries[$key]['count'];
    }

?>

<script>
    window.onload = function() {


    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        title: {
            text: "Registered Users Countries Report"
        },
        data: [{
            type: "pie",
            yValueFormatString: "#,##0\" Users\"",
            indexLabel: "{label} ({y})",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    }
</script>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Users</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Users Countries Report</li>
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

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Users Countries Report</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
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
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection
