<?php
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
}elseif ( $_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');

}
require_once 'config/config.php';

$surveyname = $surveyname_err = '';

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["surveyname"]))) {
        $surveyname_err = "Please enter a surveyname.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM surveys WHERE bedrijfs_id = ? AND surveyname = ?";

        if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $parem_bedrijfs_id, $param_surveyname);

            // Set parameters
            $param_surveyname = trim($_POST["surveyname"]);
            $param_bedrijfs_id = $_POST['bedrijfs_id'];
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                /* store result */
                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $surveyname_err = "This surveyname already exist.";
                } else {
                    $surveyname = trim($_POST["surveyname"]);
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }

     if (empty($surveyname_err)){
         echo 'oke';
         $sql = "INSERT INTO surveys (bedrijfs_id, surveyname) VALUES (?,?)";

         if ($stmt = mysqli_prepare($con, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $param_bedrijfs_id, $param_surveyname);

            // Set parameters
            $param_surveyname = $surveyname;
            $param_bedrijfs_id = $_POST['bedrijfs_id'];

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {

                // Redirect to login page
                header("location: Manage.php");
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
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
</head>
    <body>
        <?php include('navigation.php'); ?>
        <h1>New survey</h1>
        <br><br>
        <form action="" method="post">
            <div class="form-group">
                <label>Survey naam</label>
                <input type="text" name="surveyname" class="form-control" value="<?php echo $surveyname; ?>">
                <span class="help-block"><?php echo $surveyname_err; ?></span>
            </div>
            <div class="form-group">
                <input type="hidden" name="bedrijfs_id" value="<?php echo $_SESSION['bedrijfs_id'] ?>">
                <input type="submit" class="btn btn-primary" value="submit">
            </div>

        </form>
    </body>
    
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>

        <script src="js/scripts.js"></script>


</html>
