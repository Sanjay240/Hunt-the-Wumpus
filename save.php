<!--
    Author:Sanjay Kumar, 000811237
    This page will accept the parameter the email-id and result and
    then display the table for the top 10 players in descending order
    of the number of wins
-->
<?php
date_default_timezone_set('America/Toronto');
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$result = filter_input(INPUT_POST, "result", FILTER_SANITIZE_STRING);
$mydate = getdate(date("U"));
$todayDate = "$mydate[year]-$mydate[mon]-$mydate[mday]";
include "connect.php";
$counter = true;
if ($email === '') {
    $counter = false;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>HUNT THE WUMPUS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
    <style>
        #container {
            width: 90%;
            text-align: left;
        }

        .button {
            width: 200px;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
            color: greenyellow;
        }

        .button:hover {
            background-color: silver;
        }
    </style>
</head>

<body>
    <?php
    if ($counter) {
        $command = "SELECT email_id, $result FROM players WHERE email_id = ?";
        $stmt = $dbh->prepare($command);
        $param = [$email];
        $sucess = $stmt->execute($param);
        if ($row = $stmt->fetch()) {
            $result2 = $row[$result]; // gets the wins or losses from the table
            $command = "UPDATE players SET $result = ?, date_played = ? WHERE email_id = ?";
            $stmt = $dbh->prepare($command);
            $param = [$result2 + 1, $todayDate, $row['email_id']];
            $sucess = $stmt->execute($param);
        } else {
            $command = "INSERT INTO players(email_id, $result, date_played) VALUES(?,?,?)";
            $stmt = $dbh->prepare($command);
            $param = [$email, 1, $todayDate];
            $sucess = $stmt->execute($param);
        }
        $command = "SELECT email_id, wins, losses, date_played FROM players ORDER BY wins desc LIMIT 10";
        $stmt = $dbh->prepare($command);
        $sucess = $stmt->execute();
        echo ("<div id ='container'>
            <table>
                <tr>
                    <th>Email-ID</th>
                    <th>Wins</th>
                    <th>Losses</th>
                    <th>LastPlayed Date</th>
                </tr>");
        while ($row2 = $stmt->fetch()) {
            echo ("<tr>
                    <td>" . $row2['email_id'] . "</td>
                    <td>" . $row2['wins'] . "</td>
                    <td>" . $row2['losses'] . "</td>
                    <td>" . $row2['date_played'] . "</td>
                </tr>");
        }
        echo ("</table>
            </div>");
    } else {
        echo "BAD PARAMETER";
    }
    ?>
    <a href="index.php" class="button">Play Again</a>
</body>

</html>