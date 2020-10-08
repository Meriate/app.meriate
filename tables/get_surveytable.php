<?php

require_once("config/config.php");
$show_columns = array('attributes', 'created_at');

$sql = 'SELECT id FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

$result_add = mysqli_query($con, $sql);



?>

<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style>
  /* Style the input field */
  #surveyDropdownInput {
    padding: 20px;
    margin-top: -6px;
    border: 0;
    border-radius: 0;
    background: #f1f1f1;
  }

  </style>
  <script type="text/javascript">

  $(document).ready(function(){
    $("li .selectsurvey").click(function(){
        var Survey = $(this).text();
        var Surveyid = $(this).attr('id').split("_")[1];
        $("#dropdown_survey").text(Survey);


        $.ajax({ /* THEN THE AJAX CALL */
        type: "POST", /* TYPE OF METHOD TO USE TO PASS THE DATA */
        url: "tables/surveytable.php", /* PAGE WHERE WE WILL PASS THE DATA */
        data: {'Surveyname':Survey,'Surveyid':Surveyid}, /* THE DATA WE WILL BE PASSING */
        success: function(result){ /* GET THE TO BE RETURNED DATA */
            $("#tablecontainer").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
        }
        });

    });
  });



</script>
</head>
<body>


<div class="container">
  <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" id="dropdown_survey" type="button" data-toggle="dropdown">Select Survey
    <span class="caret"></span></button>
    <ul class="dropdown-menu">
      <input class="form-control" id="surveyDropdownInput" type="text" placeholder="Search..">

      <?php
                    $sql = 'SELECT id,surveyname FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

                    $result = mysqli_query($con, $sql);
                    $i = 1;
                    while ($fetch = mysqli_fetch_assoc($result)) {

                        echo '<li><a class="selectsurvey" id="surveyid_'.$fetch['id'].'"> ' . $fetch['surveyname'] . '</a></li> ';
                    }
                    ?>

    </ul>
  </div>
  <div>
  <a href="createsurvey.php" class="btn btn-primary">Create new survey</a>
  </div>
</div>
<br>

<div id="tablecontainer"></div>

<script>
$(document).ready(function(){
  $("#surveyDropdownInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $(".dropdown-menu li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

</body>
</html>
