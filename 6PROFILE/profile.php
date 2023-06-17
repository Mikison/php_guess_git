<?php
session_start();
$user_id = $_SESSION['user_id'];
include "../!NAVBAR/navbar.php";
include "../connection.php";
global $conn;

$statment_to_get_stats = $conn->prepare("SELECT all_time_experience_points, level, champion_guessed FROM USERS_LEVELS WHERE user_id = :user_id;");
$statment_to_get_stats->bindParam(':user_id', $user_id);
$statment_to_get_stats->execute();

$result = $statment_to_get_stats->fetch(PDO::FETCH_ASSOC);

$all_time_experience_ponts = $result['all_time_experience_points'];
$level = $result['level'];
$champion_guessed = $result['champion_guessed'];


?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Gracza</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile {
            position: relative;
            width: 70%;
            height: 600px;
            padding: 40px;
            background-color: #1a1a1a;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            overflow: auto;
            user-select: none;
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background-image: url("avatars/default.png");
            background-size: cover;
            background-position: center;
            background-color: #555;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stats-item {
            flex-basis: 33%;
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            margin: 10px;
            background-color: #0e0e0e;
        }

        .stats-item strong {
            color: #bbb;
        }

        .stats-item span {
            color: #fff;
            font-weight: bold;
        }

        .achievements {
            margin-top: 30px;
        }

        .achievement {
            display: inline-block;
            width: 100px;
            text-align: center;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .achievement img {
            width: 80px;
            height: 80px;
        }

        .edit-button {
            display: inline;
            top: 10px;
            right: 10px;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #2ecc71;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }
        .delete-button {
            display: inline;
            top: 10px;
            right: 10px;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #e71010;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        #overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 9999;
        }

        #confirmation-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #0e0e0e;

            padding: 20px;
            border-radius: 8px;
            display: none;
            z-index: 10000;
        }

        .confirm-delete-button {
            display: inline;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #e71010;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        .confirm-cancel-button {
            display: inline;
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #2ecc71;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

    </style>
</head>
<script src="script.js"></script>
<body>
<div class="profile">
    <button class="edit-button">Edytuj konto</button>
    <button class="delete-button" onclick="showConfirmationDialog()">Usuń konto</button>

    <div id="overlay" onclick="hideConfirmationDialog()"></div>
    <div id="confirmation-dialog">
        <h2>Czy na pewno chcesz usunąć swoje konto?</h2>
        <p>Ta operacja jest nieodwracalna.</p>
        <button class="confirm-delete-button" onclick="deleteAccount()">Potwierdź</button>
        <button class="confirm-cancel-button" onclick="hideConfirmationDialog()">Anuluj</button>
    </div>

    <h1>Profil Gracza</h1>

    <div class="avatar"></div>

    <div class="stats">
        <div class="stats-item">
            <strong>Punkty doświadczenia:</strong><br>
            <span id="experience"><?php echo $all_time_experience_ponts ?></span>
        </div>

        <div class="stats-item">
            <strong>Level:</strong><br>
            <span id="level"><?php echo $level ?></span>
        </div>

        <div class="stats-item">
            <strong>Zgadniętych postaci:</strong><br>
            <span id="characters"><?php echo $champion_guessed ?></span>
        </div>
    </div>

    <div class="achievements">
        <h2>Achievementy</h2>

        <div class="achievement">
            <img src="achievement1.jpg" alt="Achievement 1">
            <div>Achievement 1</div>
        </div>

        <div class="achievement">
            <img src="achievement2.jpg" alt="Achievement 2">
            <div>Achievement 2</div>
        </div>

        <div class="achievement">
            <img src="achievement3.jpg" alt="Achievement 3">
            <div>Achievement 3</div>
        </div>
    </div>
</div>
</body>
</html>
