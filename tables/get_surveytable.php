<?php

require_once("config/config.php");
$show_columns = array('attributes', 'created_at');





?>

<!DOCTYPE html>
<html>

<head>




    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


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
    $(function() {

      var Survey = $("li .selectsurvey").first().text();
      var Surveyid = $("li .selectsurvey").first().attr('id').split("_")[1];
      $("#dropdown_survey").text(Survey);


      $.ajax({
        /* THEN THE AJAX CALL */
        type: "POST",
        /* TYPE OF METHOD TO USE TO PASS THE DATA */
        url: "tables/surveytable.php",
        /* PAGE WHERE WE WILL PASS THE DATA */
        data: {
          'Surveyname': Survey,
          'Surveyid': Surveyid
        },
        /* THE DATA WE WILL BE PASSING */
        success: function(result) {
          /* GET THE TO BE RETURNED DATA */
          $("#tablecontainer").html(result); /* THE RETURNED DATA WILL BE SHOWN IN THIS DIV */
        }
      });

    });

    


    $("li .selectsurvey").click(function() {
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
        $sql = 'SELECT id,surveyname FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id']. ' ORDER BY created_at DESC';

        $result = mysqli_query($con, $sql);
        $i = 1;
        while ($fetch = mysqli_fetch_assoc($result)) {

          echo '<li><a class="selectsurvey" id="surveyid_' . $fetch['id'] . '"> ' . $fetch['surveyname'] . '</a></li> ';
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
    $(document).ready(function() {

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
