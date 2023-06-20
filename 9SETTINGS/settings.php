<?php
global $theme;
session_start();
include "../!NAVBAR/navbar.php";
include "../updatePointsAndLevel.php";
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suwak głośności</title>
    <link rel="stylesheet" href="css/<?php echo $theme?>.css">
</head>
<body>
<h1>Suwak głośności</h1>

<div class="slider">
    <input type="range" min="0" max="100" value="50" step="1" id="volumeSlider" oninput="updateVolume()">
    <span id="volumeValue">50</span>
</div>

<script>
    function createCookie(name, value, minutes) {
        var expires;
        if (minutes) {
            var date = new Date();
            date.setTime(date.getTime() + (minutes * 60 * 60 ));
            expires = "; expires=" + date.toGMTString();
        }
        else {
            expires = "";
        }
        document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
    }
    function updateVolume() {
        var volumeSlider = document.getElementById("volumeSlider");
        var volumeValue = document.getElementById("volumeValue");
        volumeValue.textContent = volumeSlider.value;
        createCookie('volume', volumeSlider.value/100, 180, '/')
    }
</script>
</body>
</html>
