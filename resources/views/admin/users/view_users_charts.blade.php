@extends('layouts.admin_layout.admin_layout')

@section('content')
<?php

    $months = [];
    $count = 0;
    while ($count <= 3) {
        $months[] = date('M Y', strtotime("-".$count." month"));
        $count++;
    }

$dataPoints = array(
	array("y" => $userCount[3], "label" => $months[3]),
	array("y" => $userCount[2], "label" => $months[2]),
	array("y" => $userCount[1], "label" => $months[1]),
	array("y" => $userCount[0], "label" => $months[0]),
);

?>

<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
        title: {
            text: "Users Report"
        },
        axisY: {
            title: "Number of Users"
        },
        data: [{
            type: "line",
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
              <li class="breadcrumb-item active">Users Report</li>
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
                <h3 class="card-title">Users Report</h3>
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