<?php

require_once("config/config.php");
$show_columns = array('attributes', 'created_at');





?>

<!DOCTYPE html>
<html>

<head>

  <style>
    /* Style the input field */
    #surveyDropdownInput {
      padding: 20px;
      margin-top: -6px;
      border: 0;
      border-radius: 0;
      background: #f1f1f1;
    }


    .dropdown-menu li.hovered { background-color: #A9A9A9; }
  </style>
  <script type="text/javascript">
    $(document).ready(function() {

      var Survey = $("li .selectsurvey").last().text();
      var Surveyid = $("li .selectsurvey").last().attr('id').split("_")[1];
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

    $(document).ready(function() {
      $(".dropdown-menu li").mouseover(function() {
        if (!$(this).hasClass('hovered')) {
            $('.dropdown-menu li.hovered').removeClass('hovered');
            $(this).addClass('hovered');
        }
      });
    });
  </script>
</head>

<body>


  <div class="container row">
    <div class="dropdown col-md-9">
      <button class="btn btn-primary dropdown-toggle" id="dropdown_survey" type="button" data-toggle="dropdown">Select Survey
        <span class="caret"></span></button>
      <ul class="dropdown-menu">
        <input class="form-control" id="surveyDropdownInput" type="text" placeholder="Search..">

        <?php
        $sql = 'SELECT id,surveyname FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'] . ' ORDER BY created_at DESC';

        $result = mysqli_query($con, $sql);
        $i = 1;
        while ($fetch = mysqli_fetch_assoc($result)) {

          echo '<li><a class="selectsurvey" id="surveyid_' . $fetch['id'] . '"> ' . $fetch['surveyname'] . '</a></li> ';
        }
        ?>

      </ul>
    </div>
    
  </div>
  <br>

  <div id="tablecontainer"></div>
  <div class="col-md-3">
      <a href="addattributes.php" class="btn btn-primary">Add new attributes</a>
    </div>

  <script>
    $(document).ready(function() {

      $("#surveyDropdownInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".dropdown-menu li").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });




    $(".dropdown-menu li").click(function() {
      var Survey = $(this.firstChild).text();
      var Surveyid = $(this.firstChild).attr('id').split("_")[1];
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
  </script>

</body>

</html>
