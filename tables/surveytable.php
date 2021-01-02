<?php
session_start();
require_once('../config/config.php');
// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
} elseif ($_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');
}

$surveyid = $_POST['Surveyid'];

$show_columns = array('attributes', 'created_at');

$sql = 'SELECT id FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

$result_add = mysqli_query($con, $sql);

?>

    <div>
        <div>
            <form action="" method="post">
                <table class="table table-striped table-bordered" id="vragentabel" width="100%">
                    <!-- Tabel headers -->
                    <thead>
                        <tr class="tr_header">
                            <th></th>
                            <?php
                            foreach ($show_columns as $columnname) {
                                echo '<th>' . $columnname . '</th>';
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = 'SELECT ' . implode(', ', $show_columns) . ' FROM vragen where surveyid = ' . $surveyid . '';

                        $values = mysqli_query($con, $sql);
                        $i = 1;
                        while ($fetch_row = mysqli_fetch_assoc($values)) {
                            echo '<tr>';
                            echo '<td>' . $i++ . '</td>';
                            foreach ($fetch_row as $value) {
                                echo '<td>' . $value . '</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>

    </div>


<script>
    $(document).ready(function() {
        $('#vragentabel').DataTable();
    });
</script>
