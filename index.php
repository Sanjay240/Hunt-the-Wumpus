<!--
    Author: Sam Scott
    This page will accept the user input by selecting table cell as 
    row and column number
-->
<!DOCTYPE html>
<html>

<head>
    <title>HUNT THE WUMPUS</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wumpus.css">
    <style>
        td:hover {
            background-color: silver;
        }
    </style>
</head>

<body>
    <div id="container">
        <h1>Hunt the Wumpus!</h1>
        <table>
            <?php
            for ($r = 0; $r < 5; $r++) {
                echo "<tr>";
                for ($c = 0; $c < 5; $c++) {
                    echo "<td><a href='result.php?row=$r&col=$c'></a></td>";
                }
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>