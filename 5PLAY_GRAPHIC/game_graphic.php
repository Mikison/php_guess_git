<?php
global $theme;
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
include "../connection.php";
global $conn;
include "../!NAVBAR/navbar-homeless-graphic.php";
include "../updatePointsAndLevel.php";
?>


<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../5PLAY_GRAPHIC/css/<?php echo $theme?>.css">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Play - Graphic Mode</title>
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
$champs_directory_path = "./champs";
$champs = array();

if (is_dir($champs_directory_path)) {
    if ($dir_handle = opendir($champs_directory_path)) {
        while (($file = readdir($dir_handle)) !== false) {
            if ($file != '.' && $file != '..') {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                $champs[] = $filename;
            }
        }

        // Zamknij folder
        closedir($dir_handle);
    }
}

$championName = $champs[rand(0, sizeof($champs) -1)];
$graphicalPath = "champs/" . $championName. ".jpg";


console_log($championName);
createBOXES(strlen($championName));



?>
<div class="container">
    <div class="square-for-description">
        <div class="image" style='background-image: url("<?php echo $graphicalPath; ?>")'></div>
    </div>
    <div class="points" id="points">Punkty:   <span id="points-value" data-initial-points="250"> 250</span></div>
    <div class="guessess" id="guessess">Pozostało prób:   <span id="guessess-value" data-initial-guessess="5"> 5</span></div>
    <div id="message" class="message"></div>
    <div class="champion-input-form">
        <input type="text" name="champion-input" id="champion-input" class="champion-input"/>
        <input type="submit" name="champion-submit" id="champion-submit" class="champion-submit" value="Zatwierdź" onclick="checkGuess('<?php echo $championName ?>'); "/>
        <input type="button" name="showBoxes" class="showBoxes" id="showBoxes" value="Schowaj pomocnika" onclick="toggleBoxes()"/>

    </div>
    <div class="boxes" id="boxes"></div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="./script.js"></script>



    </body>
    </html>