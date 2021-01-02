<?php


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
    #perstabel.thead.th,
    #perstabel.tbody.td {

        white-space: nowrap;
    }

    #perstabel_wrapper {
        width: 100%;
        height: 100%;
        margin: 0 0 0 0;
    }

    .DTFC_LeftBodyLiner {
  overflow: hidden;
}

</style>


        <div class="container-fluid">
            <div class="col-md-12">
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

</body>

<script>
    $(document).ready(function() {
        $('#perstabel').DataTable({
            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {"headerOffset": 75}
        });
    });
</script>

</html>