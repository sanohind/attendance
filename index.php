<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Attendance Report</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- datatables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand-md navbar-dark navbar-inverse">
      <div class="container">
        <a href="#" class="navbar-brand">
          <img src="assets/img/sanoh3.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .9">
          <span class="brand-text font-weight-light text-primary">PT. SANOH INDONESIA</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!--  -->

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <!-- Messages Dropdown Menu -->
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0"> ATTENDANCE REPORT <small></SMALL></h1>
            </div><!-- /.col -->
            <div class="col-sm-6 h3">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item h3"><a href="#"><?= date('d M Y ') ?></a></li>
                <!-- <li class="breadcrumb-item"><span id="timer"></span></li> -->
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-12">

              <!-- <div class="card card-primary card-outline">
                <div class="card-body">
                  <form class="form-horizontal">
                    <h5 class="mt-4 mb-2">Date range :</h5>
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text">
                              <i class="fas fa-calendar"></i>
                            </span>
                          </div>
                          <input type="date" name="dateFrom" id="dateFrom" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                          </div>
                          <input type="date" name="dateTo" id="dateTo" class="form-control">
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <button class="btn btn-info" onclick="getData()">Show</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div> -->

            </div>
            <div class="col-lg-6">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="card-title m-0">TOP 20 OVT By Employee <span class="small"> Periode : September 2024</span></h5>
                </div>
                <div class="card-body">
                  <canvas id="otPersonChart" height="85px"></canvas>
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="card-title m-0">TOP 10 OVT By Section <span class="small"> Periode : September 2024</span></h5>
                </div>
                <div class="card-body">
                  <canvas id="otSectionChart" height="85px"></canvas>
                </div>
              </div>
            </div>
            <!-- /.col-md-6 -->

            <div class="col-lg-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h5 class="card-title m-0 text-info">EMPLOYEE ATTENDANCE > 06:47</h5>
                </div>
                <?php
                include 'data/employeeClass.php';
                include 'data/AttendanceClass.php';
                include 'data/connection.php';
                include 'data/cekToken.php';
                include 'test1.php';
                ?>
                <div class="card-body">
                  <table class="table table-hover table-bordered" id="tableLate">
                    <thead class="bg-info">
                      <th>Date</th>
                      <th>Employee No.</th>
                      <th>Employee Name</th>
                      <th>Section</th>
                      <th>Shift</th>
                      <th>Actual In</th>
                    </thead>
                    <tbody>
                      <?php
                      $emp = new Employee($db);
                      foreach (json_decode($result)->data as $row) {
                        if ($row->shiftdailyCode == "SHREGULAR" or $row->shiftdailyCode == "SHREGULAR_JUMAT") {
                          if (date("Y-m-d", strtotime("$row->starttime")) != '1970-01-01') {
                            if ($row->actualIn < 13) {
                              $detail = $emp->getEmployee($row->empId);
                              if ($detail->empDept_posName != 'Security') {
                      ?>
                                <tr>
                                  <td><?= date("Y-m-d", strtotime("$row->starttime")) ?></td>
                                  <td><?= $row->empNo ?></td>
                                  <td><?= $detail->fullName ?></td>
                                  <td><?= $detail->empDept_posName ?></td>
                                  <td><?= $row->shiftdailyCode ?></td>
                                  <td><?= date("H:i:s", strtotime("$row->starttime")) ?></td>
                                </tr>
                      <?php
                              }
                            }
                          }
                        }
                      }

                      $attn = new Attendance($db);

                      $otPerson = $attn->getTotalOtbyPerson();
                      $otSection = $attn->getTotalOtbySection();

                      $labelOp = array();
                      $dataOp = array();
                      $labelOs = array();
                      $dataOs = array();

                      foreach ($otPerson as $otp) {
                        array_push($labelOp, $otp->empName);
                        array_push($dataOp, $otp->sum_ot);
                      }
                      foreach ($otSection as $ots) {
                        array_push($labelOs, $ots->empsection);
                        array_push($dataOs, $ots->sum_ot);
                      }

                      ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
      </div>
      <strong>Copyright &copy; <?= date('Y') ?> <a href="http://www.sanohindonesia.co.id/">PT. Sanoh Indonesia</a>.</strong> All rights reserved.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- datatables -->
  <script src="plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
  <!-- AdminLTE App -->
  <script src="assets/js/adminlte.min.js"></script>
  <!-- date-range-picker -->
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- date-range-picker -->
  <script src="plugins/chartjs/dist1/chart.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      //getData();
      $('#tableLate').DataTable({
        order: [
          [0, 'desc'],
          [5, 'desc']
        ]
      });

      var labelOp = <?= json_encode($labelOp) ?>;
      var dataOp = <?= json_encode($dataOp) ?>;
      drawChart('OT by Person (Hour)', labelOp, dataOp, 'otPersonChart');

      var labelOs = <?= json_encode($labelOs) ?>;
      var dataOs = <?= json_encode($dataOs) ?>;
      drawChart('OT by Section (Hour)', labelOs, dataOs, 'otSectionChart');

      var minutes, seconds, count, counter, timer;
      count = 120; //seconds
      counter = setInterval(timer, 1000);

      function checklength(i) {
        "use strict";
        if (i < 10) {
          i = "0" + i;
        }
        return i;
      }

      function timer() {
        "use strict";
        count = count - 1;
        minutes = checklength(Math.floor(count / 60));
        seconds = checklength(count - minutes * 60);
        if (count < 0) {
          clearInterval(counter);
          return;
        }
        // document.getElementById("timer").innerHTML =
        //   "Refresh in " + minutes + ":" + seconds + " ";
        if (count === 0) {
          location.reload();
        }
      }

      function drawChart(title, label, data, element) {
        var ctx = document.getElementById(element).getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: label,
            datasets: [{
              label: title,
              data: data,
              borderColor: 'rgb( 70, 100, 107 )',
              backgroundColor: 'rgb(185, 221, 229)',
              tension: 0.1
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            },
            plugins: {
              legend: {
                display: true,
                labels: {
                  color: 'rgb(13, 13, 14)'
                }
              }
            }
          }
        });
      }

    })
  </script>
</body>

</html>