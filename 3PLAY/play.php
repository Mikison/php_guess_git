<?php
session_start();
include "../!NAVBAR/navbar.php";
include "../connection.php";
global $conn;
$user_id = $_SESSION['user_id'];
checkTable($user_id);
if (isset($_COOKIE['points'])) {
    $points = $_COOKIE['points'];
    $statement_points = $conn->prepare("UPDATE USERS_LEVELS SET experience_points = experience_points + :points, all_time_experience_points = all_time_experience_points + :points WHERE user_id = :user_id");
    $statement_points->bindParam(':points', $points);
    $statement_points->bindParam(':user_id', $user_id);
    $statement_points->execute();
    setcookie('points', '', time() - 3600, '/');



}
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Zagraj</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .square {
            width: 150px;
            height: 150px;
            margin: 70px;
            padding: 100px;
            border-radius: 30px;
            text-align: center;
            transition: transform 0.3s ease;
            display: flex;
            justify-content: center;
            -webkit-user-select: none;
            cursor: pointer;
            align-items: center;
            background-color: #1a1a1a;
        }

        .square:hover {
            transform: scale(1.1);
        }

        .square p {
            font-size: 24px;
            color: white;
        }

    </style>

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

function console_log($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


function checkTable($user_id) {
    global $conn;
    $check_table_statement = "SHOW TABLES LIKE 'USERS_LEVELS'";
    $table_exists = $conn->query($check_table_statement)->rowCount() !== 0;
    if (!$table_exists) {
        $new_table_statement = "CREATE TABLE USERS_LEVELS (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    experience_points INT NOT NULL,
    all_time_experience_points INT NOT NULL,
    level INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
        $conn->exec($new_table_statement);
    }

    $sql_check_if_record_exists = "SELECT user_id FROM USERS_LEVELS WHERE user_id = '$user_id'";
    $result = $conn->query($sql_check_if_record_exists);

    if ($result->rowCount() == 0) {
        $insert_statment = $conn->prepare("INSERT INTO USERS_LEVELS (user_id, experience_points, all_time_experience_points, level) VALUES (:user_id, 0,0, 1)");
        $insert_statment->bindParam('user_id', $user_id);
        $insert_statment->execute();

    }
}

if (isset($_POST['divClicked'])) {
    $clickedDiv = $_POST['divClicked'];

    if ($clickedDiv === 'solo-square') {
        header("Location: ../4PLAY_SOLO/game.php");
        exit();
    } elseif ($clickedDiv === 'graphic-square') {
//        header("Location: podstrona2.php"); //TODO GRAPHIC SOLUTION
        exit();
    }
}


?>


</body>
</html>
