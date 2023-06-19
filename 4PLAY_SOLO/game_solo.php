<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
include "../connection.php";
global $conn;
include "../!NAVBAR/navbar-homeless-solo.php";
include "../updatePointsAndLevel.php";
?>


<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/czarny.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Play - Solo Mode</title>
</head>
<body>
<?php

function console_log($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function createBOXES($chmapion_length)
{
    $js = "
           <script>
        document.addEventListener('DOMContentLoaded', function() {
            const boxes = document.querySelector('.boxes');
            let length = $chmapion_length;
            function createBox(length) {
                boxes.innerHTML = '';

                for (var i = 0; i < length; i++) {
                    const box = document.createElement('div');
                    box.classList.add('element');
                    boxes.append(box);
                }
            }
            
            createBox(length);
        });
    </script>";
    echo $js;
}



$query = "SELECT CHAMPION_NAME, CHAMPION_HINT1, CHAMPION_HINT2, CHAMPION_HINT3 FROM CHAMPIONS ORDER BY RAND() LIMIT 1";
$stmt = $conn->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$championName = $row['CHAMPION_NAME'];
$championHint1 = $row['CHAMPION_HINT1'];
$championHint2 = $row['CHAMPION_HINT2'];
$championHint3 = $row['CHAMPION_HINT3'];
console_log($championName);
createBOXES(strlen($championName));



?>
<div class="container">
    <div class="square-for-description">
        <div class="square-text"><?php echo $championHint1 ?></div>
        <div class="square-hint1" id="square-hint1" style="display: none"><?php echo $championHint2 ?></div>
        <div class="square-hint2" id="square-hint2" style="display: none"><?php echo $championHint3 ?></div>
    </div>
    <div class="points" id="points">Punkty:   <span id="points-value" data-initial-points="150"> 150</span></div>
    <div class="guessess" id="guessess">Pozostało prób:   <span id="guessess-value" data-initial-guessess="5"> 5</span></div>
    <div id="message" class="message"></div>
    <div class="champion-input-form">
        <input type="text" name="champion-input" id="champion-input" class="champion-input"/>
        <input type="submit" name="champion-submit" id="champion-submit" class="champion-submit" value="Zatwierdź" onclick="checkGuess('<?php echo $championName ?>'); "/>
        <input type="button" name="champion-givehint" class="champion-givehint" id="champion-givehint" value="Podpowiedź" onclick="showHint()">
        <input type="button" name="showBoxes" class="showBoxes" id="showBoxes" value="Schowaj pomocnika" onclick="toggleBoxes()"/>

    </div>
    <div class="boxes" id="boxes"></div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./script.js"></script>



    </body>
    </html>