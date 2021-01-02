<?php
session_start();

require_once 'config/config.php';


$Aantal_beoordelen = 5;

$surveyid = $_GET['selectsurvey'];

$result_survey = mysqli_query($con, 'SELECT attributes,id FROM vragen WHERE surveyid = ' . $surveyid . ' AND bedrijfs_id = ' . $_SESSION['bedrijfs_id']);
$result_employee = mysqli_query($con, 'SELECT id,firstname, lastname FROM users WHERE id != ' . $_SESSION['id'] . ' AND licensie = 1 AND bedrijfs_id = ' . $_SESSION['bedrijfs_id'] . ' ORDER BY Aantal_keer_beoordeelt ASC limit ' . $Aantal_beoordelen);

$employee = [];
while ($row = mysqli_fetch_array($result_employee)) {
    $employees[] = $row;
}

$surveys = [];
while ($row = mysqli_fetch_array($result_survey)) {
    $surveys[] = $row;
}

$vraag = mysqli_fetch_assoc(mysqli_query($con, 'SELECT surveyname FROM surveys WHERE id = ' . $surveyid))['surveyname'];
?>

<!DOCTYPE html>
<html>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
<?php include "assets/lib/libraries_head.php"; ?>
<link href="css/styles.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

<style>
    
    #regForm {
        background-color: #ffffff;
        margin: 100px auto;
        font-family: Raleway;
        padding: 40px;
        width: 70%;
        min-width: 300px;
    }

    h1 {
        text-align: center;
    }

 
    /* Make circles that indicate the steps of the form: */
    .step {
        height: 15px;
        width: 15px;
        margin: 0 2px;
        background-color: #bbbbbb;
        border: none;
        border-radius: 50%;
        display: inline-block;
        opacity: 0.5;
    }

    .step.active {
        opacity: 1;
    }

    /* Mark the steps that are finished and valid: */
    .step.finish {
        background-color: #4CAF50;
    }

    .Beoordeling1 {
        border: none;
        display: flex;
        flex-direction: row;
        justify-content: flex-start;
        break-before: always;
        margin: 0 0 3em 0;
    }

    .Beoordeling1-1 {
        margin: 0 1.81em 0 0;
    }

    label {
        float: left;
        padding: 0 1em;
        text-align: center;
    }

    input[type=radio] {
        display: inline !important;
    }

    input[type=radio]:not(old) {
        width: 2em;
        margin: 0;
        padding: 0;
        font-size: 1em;
        opacity: 1;
    }
</style>

<body class="sb-nav-fixed">

    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand" href="manage.php"><img src="../assets/img/meriate-logo-white.svg" alt="Meriate Logo"></a>
        <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
        <div class="input-group">
        </div>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">

                    <a class="dropdown-item" href="account/logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>



    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                <div class="sb-sidenav-menu">

                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Meriate Test
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <form id="regForm" action="/Einde.php" method="POST">
                        <h1>Survey: <?php echo $vraag ?></h1>
                        <?php
                        foreach ($surveys as $fetch_question) {

                            echo '<div class="tab">' . $fetch_question['attributes'];

                            foreach ($employees as $fetch) {

                        ?>

                                <div class='Beoordeling1'>
                                    <div class='Beoordeling1-1'>
                                        <p><?php echo $fetch['firstname'] . ' ' . $fetch['lastname'] ?></p>
                                    </div>
                                    <div class='Beoordeling1-1'>
                                        <p>Slecht</p>
                                    </div>
                                    <div class='Beoordeling1-1'>
                                        <label for="Choice1">1<br />
                                            <input type="radio" id="Choice1_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>" name="Choice_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>" value="1" oninput="this.className = ''" />
                                        </label>

                                        <label for="Choice2">2<br />
                                            <input type="radio" id="Choice2_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>"" name=" Choice_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>" value="2" oninput="this.className = ''" />
                                        </label>

                                        <label for="Choice3">3<br />
                                            <input type="radio" id="Choice3_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>"" name=" Choice_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>" value="3" oninput="this.className = ''" />
                                        </label>

                                        <label for="Choice4">4<br />
                                            <input type="radio" id="Choice4_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>"" name=" Choice_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>" value="4" oninput="this.className = ''" />
                                        </label>

                                        <label for="Choice5">5<br />
                                            <input type="radio" id="Choice5_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>"" name=" Choice_<?php echo $fetch_question['id'] . '_' . $fetch['id'] ?>" value="5" oninput="this.className = ''" />
                                        </label>
                                    </div>
                                    <div class='Beoordeling1-1'>
                                        <p>Goed</p>
                                    </div>
                                </div>

                        <?php
                            }
                            echo '</div>';
                        }
                        ?>

                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" class="btn-primary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" class="btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            </div>
                        </div>
                        <!-- Circles which indicates the steps of the form: -->

                        <div style="text-align:center;margin-top:40px;">
                            <?php foreach ($surveys as $s) {
                                echo '<span class="step"></span>';
                            } ?>
                        </div>
                        <div>
                            <input type="hidden" id="survey_id" name="survey_id" value="<?php echo $_GET['selectsurvey'] ?>">
                        </div>

                    </form>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Meriate</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm())
                return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>

</body>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>

</html>