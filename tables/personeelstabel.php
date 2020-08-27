<?php


// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
}elseif ( $_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');

}


$tabelnaam = 'users';
$showcolumn = array('username','email','created_at');

$bedrijfsid = $_SESSION['bedrijfs_id'];

?>

<table class="table table-bordered perstabel" id="perstabel" width="100%" cellspacing="0">
    <!-- Tabel headers -->
    <tr class="tr_header" >
        <?php

        foreach ($showcolumn as $columnname) {
            echo '<th>' . $columnname . '</th>';
        }
        ?>
    <tr>

        <?php
        $sql = 'SELECT '.implode(', ',$showcolumn).' FROM ' . $tabelnaam.' where bedrijfs_id = '.$bedrijfsid.' and licensie = 1';

        $result = mysqli_query($con, $sql);
        while ($fetch = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            foreach ($fetch as $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '</tr>';
        }
        ?>

</table>
