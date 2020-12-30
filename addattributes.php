<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
} elseif ($_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');
}
require_once 'config/config.php';

$attr = $attr_err = '';
$selected_id = $selected_id_err = '';

$attribute_saved = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["attrname"]))) {
        $attr_err = "Please enter a attribute name";
    } 
    elseif($_POST["selected_survey"] == 0){
        $selected_id_err = "Please select a survey";
    }else {
        // Prepare a select statement
        $sql = "SELECT id FROM vragen WHERE bedrijfs_id = ? AND attributes = ? AND surveyid = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "iss", $param_bedrijfs_id, $param_attr, $param_surveyid);

            // Set parameters
            $param_attr = trim($_POST["attrname"]);
            $param_bedrijfs_id = $_POST['bedrijfs_id'];
            $param_surveyid = $_POST['selected_survey'];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) >= 1) {
                    $attr_err = "This attribute already exist.";
                } else {
                    $attr = trim($_POST["attrname"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

    if ((empty($attr_err)) & (empty($selected_id_err))) {
        
        $sql = "INSERT INTO vragen (bedrijfs_id, attributes, surveyid) VALUES (?,?,?)";
        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isi", $param_bedrijfs_id, $param_attr,$param_surveyid);

            // Set parameters
            $param_attr = $attr;
            $param_bedrijfs_id = $_POST['bedrijfs_id'];
            $param_surveyid = $_POST['selected_survey'];

            // Attempt to execute the prepared statement
  
            if (mysqli_stmt_execute($stmt)) {
                
                // Redirect to login page
                if ($_POST["button_choice"] == 1){
                    header("location: Manage.php");
                }else{
                    $attr = '';
                    $attribute_saved = "Attributed saved";
                    $_POST = array();

                }
            } else {
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
}


?>

<html lang="en">
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - Create Survey</title>
    <?php include "assets/lib/libraries_head.php"; ?>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>


    <style>
        .dropdown-menu li.hovered {
            background-color: #A9A9A9;
        }
    </style>
    <script>
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

<body class="sb-nav-fixed">

    <?php include('navigation.php'); ?>
    <div id="layoutSidenav_content">
        <div class="container">
            <h1 class="mt-4">New attribute</h1>
            <span><?php echo $attribute_saved ?></span>
            <div class="row">
                <form action="" method="post">


                    <div class="dropdown col-md-12">
                        <button class="btn btn-primary dropdown-toggle" id="dropdown_survey" type="button" data-toggle="dropdown">Select Survey</button>
                            
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
                    <span class="caret help-block"><?php echo $selected_id_err ?></span>
                    <br>                             
                    <div class="form-group col-md-12">
                        <label>Attribute name</label>
                        <input type="text" name="attrname" class="form-control" value="<?php echo $attr; ?>">
                        <span class="help-block"><?php echo $attr_err; ?></span>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="hidden" name="bedrijfs_id" value="<?php echo $_SESSION['bedrijfs_id'] ?>">
                        <input type="hidden" id="selected_survey" name="selected_survey" value="">
                        <input type="hidden" id="button_choice" name="button_choice" value = "0">
                        <input type="submit" class="btn btn-primary" id="btn_primary" value="Save">
                        <input type="submit" class="btn btn-success" value="Save & add new attribute">
                    </div>

                </form>
            </div>
        </div>




    </div>
</body>


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>


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
        $("#selected_survey").val(Surveyid)
    });


    $("#btn_primary").click(function(){
        $("#button_choice").val('1')
    });
</script>

</html>
