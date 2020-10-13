<?php


// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
}elseif ( $_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');

}


$tabelnaam = 'users';
$showcolumn = array('username','email');

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
<head>
<style>
.table-wrapper { 
    overflow-x:scroll;
    overflow-y:visible;
    width:250px;
    margin-left: 120px;
}


td, th {
    padding: 5px 20px;
    width: 100px;
    
}

th:first-child {
    position: fixed;

}



</style>





<div class="table_wrapper">
    <table class="personeelstable" id="perstabel" width="100%">
        <!-- Tabel headers -->
        <thead>
        <tr class="tr_header" >
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
            $sql = 'SELECT '.implode(', ',$showcolumn).',id FROM ' . $tabelnaam.' where bedrijfs_id = '.$bedrijfsid.' and licensie = 1';
            
            $result = mysqli_query($con, $sql);
            while ($fetch = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                foreach ($fetch as $key => $value) {
                    
                    if($key == 'username'){
                        echo '<th>' . $value . '</th>';
                    }elseif($key == 'email'){
                        echo '<td>' . $value . '</td>';
                    }else{
                        foreach ($bedrijfs_surveys as $survey_key => $columnname) {
                            
                            if(in_array($value.'_'.$survey_key, $bedrijfs_completed_surveys)){
                                echo '<td><i class="fas fa-check-circle" style="color:green;"></i></td>';
                            }else{
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