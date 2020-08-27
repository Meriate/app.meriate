
<?php

// Check if the user is already logged in, if yes then redirect him to welcome page
if (!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === false) {
    header('header:login.php');
} elseif ($_SESSION["licensie"] != 2) {
    header('header:permissiondenied.php');
}



$show_columns = array('attributes', 'created_at');

$sql = 'SELECT id FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

$result_add = mysqli_query($con, $sql);

while ($fetch_add = mysqli_fetch_assoc($result_add)) {

    if (isset($_POST['ADD_rows_vragen_' . $fetch_add['id']])) {

        foreach ($_POST as $name => $value) {

            if (substr($name, 0, 9) == $fetch_add['id'] . '_vragen-') {
                $sql = "INSERT INTO vragen (attributes, bedrijfs_id,surveyid) VALUES (?,?,?)";

                if ($stmt = mysqli_prepare($con, $sql)) {
                    // Bind variables to the prepared statement as parameters

                    if (!empty($value)) {
                        mysqli_stmt_bind_param($stmt, "sii", $param_value, $param_bedrijfs_id, $param_surveyid);

                        $param_value = $_POST[$name];
                        $param_bedrijfs_id = $_SESSION['bedrijfs_id'];
                        $param_surveyid = $fetch_add['id'];

                        if (mysqli_stmt_execute($stmt)) {
                            echo "<meta http-equiv='refresh' content='0'>";
                        }
                    } else {

                        echo 'Empty row';
                    }
                }
            }
        }
    }
}
?>






<html>
    <head>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <style>
            .multiselect {
                width: 200px;
            }

            .selectBox {
                position: relative;
            }

            .selectBox select {
                width: 100%;
                font-weight: bold;
            }

            .overSelect {
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
            }

            #checkboxes {
                display: none;
                border: 1px #dadada solid;
            }

            #checkboxes label {
                display: block;
            }

            #checkboxes label:hover {
                background-color: #1e90ff;
            }
        </style>
    </head>
    <body>
        <form action="createsurvey.php">
            <input type="submit" value="Create survey">
        </form>
        <form>
            <div class="dropdown">
                <div class="selectBox" onclick="showCheckboxes()">
                    <select class="browser-default custom-select">
                        <option>Select a survey</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="checkboxes">
                    <?php
                    $sql = 'SELECT id,surveyname FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

                    $result = mysqli_query($con, $sql);
                    $i = 1;
                    while ($fetch = mysqli_fetch_assoc($result)) {

                        echo '<label for ="surveychoice">'
                        . '<input type="radio" id="surveychoice" name="surveychoice" value="' . $fetch['id'] . '" /> ' . $fetch['surveyname'] . '</label> ';
                    }
                    ?>

                </div>
            </div>
        </form>

        <?php
        $sql = 'SELECT id FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

        $result = mysqli_query($con, $sql);

        while ($fetch = mysqli_fetch_assoc($result)) {
            ?>
            <div>
                <div>
                    <form action="" method="post">
                      <table class="table table-bordered perstabel" style="display:none" id="vragentabel_<?php echo $fetch['id'] ?>" width="100%" cellspacing="0">
                            <!-- Tabel headers -->
                            <tr class="tr_header" >
                                <th></th>
                                <?php
                                foreach ($show_columns as $columnname) {
                                    echo '<th>' . $columnname . '</th>';
                                }
                                ?>
                            </tr>

                            <?php
                            $sql = 'SELECT ' . implode(', ', $show_columns) . ' FROM vragen where surveyid =' . $fetch['id'];

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

                        </table>
                        <div>
                            <input type="button" id= "addrow_<?php echo $fetch['id'] ?>" value="row +" onClick="addRow_vragen_<?php echo $fetch['id'] ?>()" border=0 style="display:none">
                            <input name='ADD_rows_vragen_<?php echo $fetch['id'] ?>' id='ADD_rows_vragen_<?php echo $fetch['id'] ?>' type="submit" value="submit" style="display:none" />
                        </div>
                    </form>
                </div>

            </div>
        <?php } ?>

    </body>

    <script>
        var expanded = false;

        function showCheckboxes() {
            var checkboxes = document.getElementById("checkboxes");
            if (!expanded) {
                checkboxes.style.display = "block";
                expanded = true;
            } else {
                checkboxes.style.display = "none";
                expanded = false;
            }
        }
<?php
$sql = 'SELECT id FROM surveys where bedrijfs_id = ' . $_SESSION['bedrijfs_id'];

$result_hide = mysqli_query($con, $sql);

while ($fetch_hide = mysqli_fetch_assoc($result_hide)) {
    ?>
            $("input[type='radio']").on('change', function () {
                if ($(this).val() == <?php echo $fetch_hide['id']; ?>)
                {
                    $('#vragentabel_<?php echo $fetch_hide['id']; ?>').show('slow');
                    $('#addrow_<?php echo $fetch_hide['id']; ?>').show('slow');
                    $('#ADD_rows_vragen_<?php echo $fetch_hide['id']; ?>').show('slow');
                } else
                {
                    $('#vragentabel_<?php echo $fetch_hide['id']; ?>').hide();
                    $('#addrow_<?php echo $fetch_hide['id']; ?>').hide();
                    $('#ADD_rows_vragen_<?php echo $fetch_hide['id']; ?>').hide();
                }

            });

            function addRow_vragen_<?php echo $fetch_hide['id']; ?>() {
                var table = document.getElementById('vragentabel_<?php echo $fetch_hide['id']; ?>');
                var e = table.rows.length - 1;
                var x = table.insertRow(e + 1);
                var l = table.rows[0].cells.length;
                //x.innerHTML = "&nbsp;";
                table.rows[e + 1].insertCell(0);
                //table.rows[e + 1].cells[0].innerHTML = "<input type='text' value='' name= vragen-" + e + " />";
                for (var c = 1, m = l; c + 1 < m; c++) {
                    table.rows[e + 1].insertCell(c);
                    table.rows[e + 1].cells[c].innerHTML = "<input type='text' value='' name= <?php echo $fetch_hide['id']; ?>_vragen-" + e + "-" + c + " />";
                }
            }
            ;

<?php } ?>
    </script>
</html>
