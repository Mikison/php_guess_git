<?php
session_start();
include "connection.php";
global $conn;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function generateJavaScript($message, $color) {
    $jsCode = "
        <script>
            function updateDiv() {
                var div = document.getElementById('message');
                div.innerHTML = '$message';
                div.style.color = '$color';
            }
            window.addEventListener('load', updateDiv);
        </script>
    ";
    echo $jsCode;
}

$user_id = $_SESSION['user_id'];
$query = "SELECT nickname, password FROM USERS_GUESS WHERE user_id = :userID";
$stmt = $conn->prepare($query);
$stmt->bindParam(':userID', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['submitNickname'])) {
    $newNickname = $_POST['newNickname'];

    $checkSql = "SELECT * FROM USERS_GUESS WHERE nickname = '$newNickname' AND user_id != '$user_id'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->rowCount() > 0) {
        generateJavaScript("Ten nickname jest zajęty" , 'red');
    } else {
        $update_stmt = $conn->prepare("UPDATE USERS_GUESS SET nickname = :new_nickname WHERE user_id = :user_id");
        $update_stmt->bindParam(':new_nickname', $newNickname);
        $update_stmt->bindParam(':user_id', $user_id);
        if ($update_stmt->execute()) {
            generateJavaScript("Zmieniles nickname" , 'green');
        } else {
            echo "Wystąpił błąd podczas zmiany nickname'u.";
        }
    }

}

if (isset($_POST['submitPassword'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    if (password_verify($currentPassword, $user['password'])) {
        if ($newPassword === $confirmNewPassword) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE USERS_GUESS SET password = :newPassword WHERE user_id = :userID";
            $updatePasswordStmt = $conn->prepare($updatePasswordQuery);
            $updatePasswordStmt->bindParam(':newPassword', $hashedPassword, PDO::PARAM_STR);
            $updatePasswordStmt->bindParam(':userID', $user_id, PDO::PARAM_INT);
            $updatePasswordStmt->execute();
            generateJavaScript('Hasło zostało zmienione', 'green');
        } else {
            generateJavaScript('Nowe hasła nie są identyczne', 'red');
        }
    } else {
        generateJavaScript('Wprowadzone aktualne hasło jest nieprawidłowe', 'red');

    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edycja konta</title>
    <style>
        body {
            background-color: #0e0e0e;
            color: #ffffff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0;
        }

        h1, h2 {
            color: #ffffff;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            padding: 5px;
            margin-bottom: 10px;
            width: 200px;
        }

        input[type="submit"] {
            background-color: #62ce19;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #333333;
        }

        .message {
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Edycja konta</h1>
    <div class="message" id="message"></div>

    <h2>Zmiana nickname'u</h2>
    <form method="post" action="">
        <label for="newNickname">Nowy nickname:</label>
        <input type="text" name="newNickname" required><br>

        <input type="submit" name="submitNickname" value="Zmień nickname">
    </form>

    <h2>Zmiana hasła</h2>
    <form method="post" action="">
        <label for="currentPassword">Aktualne hasło:</label>
        <input type="password" name="currentPassword" required><br>

        <label for="newPassword">Nowe hasło:</label>
        <input type="password" name="newPassword" required><br>

        <label for="confirmNewPassword">Potwierdź nowe hasło:</label>
        <input type="password" name="confirmNewPassword" required><br>

        <input type="submit" name="submitPassword" value="Zmień hasło">
        <a href="./3PLAY/play.php">Powrót do głównej</a>
    </form>
</div>
</body>
</html>
