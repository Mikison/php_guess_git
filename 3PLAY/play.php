<?php
global $theme;
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
include "../!NAVBAR/navbar.php";
include "../connection.php";
include "../updatePointsAndLevel.php";
global $conn;
$user_id = $_SESSION['user_id'];
?>

<!doctype html>
<html lang="en">
<head>
    <link href="../3PLAY/css/<?php echo $theme ?>.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Play - Choose gamemode</title>
</head>
<body>
<div class="container">
    <div class="square" id="solo-square" onclick="submitForm('solo-square')">
        <div class="square-text">
            <p>Solo</p></div>
    </div>
    <div class="square" id="graphic-square" onclick="submitForm('graphic-square')">
        <div class="square-text">
            <p>Graficzny</p></div>
    </div>
    <form id="chooseForm" action="" method="post">
        <input type="hidden" name="divClicked" id="divClicked">
    </form>
    <script>
        function submitForm(divId) {
            document.getElementById("divClicked").value = divId;
            document.getElementById("chooseForm").submit();
        }
    </script>
</div>
<?php
if (isset($_POST['divClicked'])) {
    $clickedDiv = $_POST['divClicked'];

    if ($clickedDiv === 'solo-square') {
        header("Location: ../4PLAY_SOLO/game_solo.php");
        exit();
    } elseif ($clickedDiv === 'graphic-square') {
        header("Location: ../5PLAY_GRAPHIC/game_graphic.php");
        exit();
    }
}


?>


</body>
</html>
