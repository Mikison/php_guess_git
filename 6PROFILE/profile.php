<?php
global $theme;
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
$user_id = $_SESSION['user_id'];
include "../!NAVBAR/navbar.php";
include "../connection.php";
global $conn;


$statment_to_get_stats = $conn->prepare("SELECT all_time_experience_points, level, champion_guessed FROM USERS_LEVELS WHERE user_id = :user_id;");
$statment_to_get_stats->bindParam(':user_id', $user_id);
$statment_to_get_stats->execute();

$checkSelectedAvatarStatement = $conn->prepare("
            SELECT SHOP_ITEMS.icon 
            FROM USERS_PURCHASES 
            JOIN SHOP_ITEMS ON USERS_PURCHASES.item_id = SHOP_ITEMS.id 
            WHERE USERS_PURCHASES.user_id = :user_id 
            AND USERS_PURCHASES.category = 'Avatar' 
            AND USERS_PURCHASES.selected = 1
        ");
$checkSelectedAvatarStatement->bindParam(':user_id', $user_id);
$checkSelectedAvatarStatement->execute();
$result = $statment_to_get_stats->fetch(PDO::FETCH_ASSOC);


$resultAvatar = $checkSelectedAvatarStatement->fetch(PDO::FETCH_ASSOC);

if ($resultAvatar) {
    $avatar_name = $resultAvatar['icon'];
} else {
    $avatar_name = 'icons/default.png';
}
$all_time_experience_ponts = $result['all_time_experience_points'];
$level = $result['level'];
$champion_guessed = $result['champion_guessed'];

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/<?php echo $theme?>.css">
    <title>Game Profile</title>
    <style>
        .avatar {
            background-image: url("<?php echo $avatar_name ?>");
        }
    </style>
</head>
<script src="script.js"></script>
<body>
<div class="profile">
    <button class="logout-button" onclick="logout()">Wyloguj</button>
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
