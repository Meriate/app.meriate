<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
}elseif ( $_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');

}

?>
