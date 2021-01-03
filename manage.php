<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:account/login.php');
}elseif ( $_SESSION["licensie"] != 2) {
    echo "<script> window.location.replace('account/permissiondenied.php') </script>";
    exit();
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - Meriate</title>
  <?php include "assets/lib/libraries_head.php";?>
  <link href="css/styles.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>



<body class="sb-nav-fixed">

<?php include('navigation.php');?>

    <div id="layoutSidenav_content">

      <main>
        <div class="container-fluid">

          <div class="row">
              <div class="col-xl-12">
                  <div class="card mb-4 header-card">
                    <div class="header-text left">
                      <h1>Recent updates</h1>

                      <div class="icon-box">
                        <div><h6>8.2<h6></div>
                        <h5>Total involvement score</h5>
                        <p>+0.3 since last month</p>
                      </div>
                      <div class="icon-box">
                        <div><h6>21</h6></div>
                        <h5>Employees surveyed</h5>
                        <p>out of 28 employees</p>
                      </div>

                    </div>
                    <div class="header-img office">
                      <img src="/assets/img/office-illustration.png" width="100%">
                    </div>
                  </div>
              </div>
          </div>

          <div class="row">
              <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-area mr-1"></i>
                        Area Chart Example
                    </div>
                    <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-chart-bar mr-1"></i>
                        Bar Chart Example
                    </div>
                    <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                </div>
              </div>
          </div>

        </div>
      </main>

    </div>
</div>



  <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/datatables-demo.js"></script>
</body>
</html>
