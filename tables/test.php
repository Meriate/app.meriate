<?php

session_start();
require_once('../config/config.php');

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:../login.php');
} elseif ($_SESSION["licensie"] != 2) {
    header('header:../permissiondenied.php');
}


$tabelnaam = 'users';
$showcolumn = array('username', 'email');

$bedrijfsid = $_SESSION['bedrijfs_id'];

$bedrijfs_surveys = array();
$sql = "SELECT id, surveyname FROM surveys where bedrijfs_id = $bedrijfsid";
$result = mysqli_query($con, $sql);
while ($fetch = mysqli_fetch_assoc($result)) {

    $bedrijfs_surveys[$fetch['id']] = $fetch['surveyname'];
}



$bedrijfs_completed_surveys = array();
$sql = "SELECT DISTINCT(CONCAT(Beoordelaar_id,'_', survey_id)) as compelted_surveys FROM vragenlijst where bedrijfs_id = $bedrijfsid";
$result = mysqli_query($con, $sql);
while ($fetch = mysqli_fetch_assoc($result)) {

    $bedrijfs_completed_surveys[] = $fetch['compelted_surveys'];
}

?>


<html>
<style>
    th, td {
        
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 800px;
        margin: auto;
    }
    .DTFC_LeftBodyLiner {
  overflow: hidden;
}
</style>

<head>
    <?php include "../assets/lib/libraries_head.php"; ?>
    <link href="../css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedcolumns/3.3.2/css/fixedColumns.dataTables.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>



</head>

<body class="sb-nav-fixed">
    <br><br><br>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <br><br><br><br><br><br><br><br><br><br><br><br>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <table class="personeelstable stripe row-border order-column" id="perstabel" style="width:100%">
                                <!-- Tabel headers -->
                                <thead>
                                    <tr class="tr_header">
                                        <?php

                                        foreach ($showcolumn as $columnname) {
                                            echo '<th>' . $columnname . '</th>';
                                        }
                                        foreach ($bedrijfs_surveys as $key => $columnname) {
                                            echo '<th>' . $columnname . '</th>';
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sql = 'SELECT ' . implode(', ', $showcolumn) . ',id FROM ' . $tabelnaam . ' where bedrijfs_id = ' . $bedrijfsid . ' and licensie = 1';

                                    $result = mysqli_query($con, $sql);
                                    while ($fetch = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        foreach ($fetch as $key => $value) {

                                            if ($key == 'username') {
                                                echo '<th>' . $value . '</th>';
                                            } elseif ($key == 'email') {
                                                echo '<td>' . $value . '</td>';
                                            } else {
                                                foreach ($bedrijfs_surveys as $survey_key => $columnname) {

                                                    if (in_array($value . '_' . $survey_key, $bedrijfs_completed_surveys)) {
                                                        echo '<td><i class="fas fa-check-circle" style="color:green;"></i></td>';
                                                    } else {
                                                        echo '<td></td>';
                                                    }
                                                }
                                            }
                                        }

                                        echo '</tr>';
                                    }
                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

<script>
    $(document).ready(function() {
        $('#perstabel').DataTable({
            scrollY: 300,
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {"headerOffset": 75}
        });
    });
</script>

<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/3.3.2/js/dataTables.fixedColumns.min.js"></script>

</html>