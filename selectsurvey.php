<?php
session_start();
// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:account/login.php');
}elseif ( $_SESSION["licensie"] != 1) {
    echo "<script> window.location.replace('account/permissiondenied.php') </script>";
    exit();

}

require_once 'config/config.php';


$show_columns = array('surveyname', 'created_at');

$sql = 'SELECT id,' . implode(', ', $show_columns) . ' FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

$result = mysqli_query($con, $sql);


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Survey - SB Admin</title>
  <?php include "assets/lib/libraries_head.php";?>
  <link href="css/styles.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
    <body>

      <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="selectsurvey.php">Meriate</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
          <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
            <div class="input-group-append">
              <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
          </div>
        </form>

        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
              <a class="dropdown-item" href="#">Settings</a>
              <a class="dropdown-item" href="#">Activity Log</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="account/logout.php">Logout</a>
            </div>
          </li>
        </ul>
      </nav>

        <form action="/survey.php" method="get">
            <table class="perstabel" id="vragentabel">
                <!-- Tabel headers -->
                <tr class="tr_header" >
                    <th></th>
                    <th>#</th>
                    <?php
                    foreach ($show_columns as $columnname) {
                        echo '<th>' . $columnname . '</th>';
                    }
                    ?>

                <tr>

                    <?php
                    $i = 1;
                    while ($fetch = mysqli_fetch_assoc($result)) {

                        echo '<tr>';

                        $sql = "SELECT * FROM vragenlijst where survey_id = ".$fetch['id'].""
                                . " AND Beoordelaar_id = ".$_SESSION['id'].""
                                . " AND bedrijfs_id = ".$_SESSION['bedrijfs_id'];

                        if(mysqli_num_rows(mysqli_query($con, $sql)) == 0){
                            echo '<td> <input type="radio" id="survey-' . $fetch['id'] . '" name="selectsurvey" value='.$fetch['id'].'> </td>';
                        }else{
                            echo '<td> <i class="fa fa-check"></i></td>';
                        }
                        echo '<td>' . $i++ . '</td>';

                        foreach ($fetch as $value) {
                            if ($value != $fetch['id']) {
                                echo '<td>' . $value . '</td>';
                            }
                        }
                        echo '</tr>';
                    }
                    ?>


            </table>

            <input type="submit" value="Go to survey">
        </form>





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
