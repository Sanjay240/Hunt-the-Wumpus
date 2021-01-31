<!--
    Author: Sanajay kumar, 000811237
    This page accept the row and column number and send the email address
    and hidden result to the save.php page
-->
<?php
$row = filter_input(INPUT_GET, "row", FILTER_VALIDATE_INT);
$column = filter_input(INPUT_GET, "col", FILTER_VALIDATE_INT);
$userResult = ""; // varible to store the result either win or loss
$inputcheck = true; // counter to intiate the process after validation
if ($row === false || $row === '' || $column === false || $column === '') {
    $inputcheck = false;
}
include "connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>HUNT THE WUMPUS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
    <style>
        label {
            float: left;
            clear: left;
        }

        input {
            float: left;
            clear: left;
        }

        #button {
            width: 100%;
        }

        #button:hover {
            background-color: silver;
        }
    </style>
</head>

<body>
    <?php
    if ($inputcheck) {
        $command = "SELECT wumpuses_id FROM wumpuses WHERE (wumpuses_row = ? AND wumpuses_column = ?) ";
        $stmt = $dbh->prepare($command);
        $param = [$row, $column];
        $sucess = $stmt->execute($param);

        if ($row = $stmt->fetch()) {
            $userResult = 'wins';
        } else {
            $userResult = 'losses';
        }
        echo "
            <form action ='save.php' method = 'POST'>
                <fieldset class='resultpicture'>";
        if ($userResult === 'wins') {
            echo " <img src ='images/wins.png' alt = 'Wins'>";
        } else {
            echo " <img src ='images/losses.png' alt = 'Wins'>";
        }
        echo "
                </fieldset>
                <fieldset class ='information'>
                <label for='email'>Enter your E-mail address</label>
                <input type='email' name='email' required placeholder ='someone@example.com'>
                <input type ='hidden' name='result' value =$userResult>
                </fieldset>
                <input type='submit' id='button'>
            </form>";
    } else {
        echo "BAD INPUT PARAMETER";
    }
    ?>
</body>

</html>