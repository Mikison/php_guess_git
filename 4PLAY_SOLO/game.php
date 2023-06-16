<?php
session_start();
include "../connection.php";
global $conn;
include "../!NAVBAR/navbar-homeless.php";
include "../updatePointsAndLevel.php";
?>


<!doctype html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Play - Solo Mode</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #0e0e0e;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .square-for-description {
            position: relative;
            width: 800px;
            height: 200px;
            padding: 20px;
            top: -150px;
            border-radius: 30px;
            text-align: center;
            transition: transform 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background-color: #1a1a1a;
            -webkit-user-select: none;
            margin-bottom: 20px;
        }



        .square-text,
        .square-hint1,
        .square-hint2{
            font-size: 25px;
            color: white;
            width: 700px;
            height: 100px;
            margin: 8px;
        }

        .champion-input-form {
            display: flex;
            position: relative;
            flex-direction: row;
            align-items: center;
            top: -100px;
            left: 25px;
            user-select: none;

        }

        .champion-input {
            width: 250px;
            height: 40px;
            padding: 5px;
            border-radius: 10px;
            border: none;
            background-color: #f1f1f1;
            font-size: 16px;
        }

        .champion-submit {
            margin-left: 10px;
            position: relative;
            width: 100px;
            height: 40px;
            padding: 5px;
            border-radius: 10px;
            border: none;
            background-color: #2ecc71;
            color: white;
            font-size: 16px;
            cursor: pointer;
            -webkit-user-select: none;
        }

        .champion-givehint {
            margin-left: 10px;
            width: 100px;
            height: 40px;
            padding: 5px;
            border-radius: 10px;
            border: none;
            background-color: #096bec;
            color: white;
            font-size: 16px;
            cursor: pointer;
            -webkit-user-select: none;
        }

        .showBoxes {
            margin-left: 10px;
            width: 150px;
            height: 40px;
            padding: 5px;
            border-radius: 10px;
            border: none;
            background-color: #e71010;
            color: white;
            font-size: 16px;
            cursor: pointer;
            -webkit-user-select: none;
        }

        .container .boxes {
            display: flex;
            margin: 0 auto;
            position: relative;

        }

        .container .boxes .element {
            color: #fff;
            font-size: 25px;
            font-weight: bold;
            background: #1a1a1a;
            border: 1px solid #535353;
            width: 64px;
            height: 64px;
            display: flex;
            aspect-ratio: 1/1 !important;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 5px;
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-user-select: none;
            margin: -1px;
            z-index: 3;
            transition: background-color .05s;
            text-transform: uppercase
        }

        .message {
            color: white;
            position: relative;
            top: -134px;
        }
        .points,
        .guessess {
            color: white;
            position: relative;
            width: 200px;
            height: 50px;
            user-select: none;
            border-radius: 40px;
            background-color: #1a1a1a;
            text-align: center;
            margin-bottom: 10px;
            top: -150px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

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