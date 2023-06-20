<?php
session_start();
include "../connection.php";
include "../CHAMPIONS/champs.php";
global $conn;


$check_table_statement = "SHOW TABLES LIKE 'USERS_GUESS'";
$table_exists = $conn->query($check_table_statement)->rowCount() > 0;

if (!$table_exists) {
    $new_table_statement = "CREATE TABLE USERS_GUESS (
        user_id INT AUTO_INCREMENT,
        nickname VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        isAdmin INT NOT NULL,
        PRIMARY KEY (user_id)
    )";
    $conn->exec($new_table_statement);
}

function generateJavaScript($message, $color) {
    $jsCode = "
        <script>
            function updateDiv() {
                var div = document.getElementById('error-message');
                div.innerHTML = '$message';
                div.style.color = '$color';
            }
            // Call the function when the page finishes loading
            window.addEventListener('load', updateDiv);
        </script>
    ";
    echo $jsCode;
}

if (isset($_POST["login"])) {
    if (isset($_POST['nickname']) && isset($_POST['password'])) {
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM USERS_GUESS WHERE nickname = :nickname");
        $stmt->bindParam(':nickname', $nickname);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            generateJavaScript("Zalogowano pomyślnie, przekierowywanie...", "green");
            header("Location: ../3PLAY/play.php");

        } else {
            generateJavaScript("Nieprawidłowe dane do logowania", "red");
        }
    } else {
        generateJavaScript("Jedno z pól jest puste, spróbuj ponownie", "red");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Guess - Login </title>

    <link rel="stylesheet" href="../2LOGIN/css/style.css">

    <!-- Boxicons CSS -->
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<section class="container forms">
    <div class="form login">
        <div class="form-content">
            <header>Login</header>
            <div id="error-message"></div>
            <form action="#" method="post">
                <div class="field input-field">
                    <input type="text" placeholder="Nickname" class="input" name="nickname" required>
                </div>

                <div class="field input-field">
                    <input type="password" placeholder="Password" class="password" name="password" required>
                    <i class='bx bx-hide eye-icon'></i>
                </div>

                <div class="form-link">
                    <a href="#" class="forgot-pass">Forgot password?</a>
                </div>

                <div class="field button-field">
                    <input type="submit" name="login" value="Login"/>
                </div>
            </form>

            <div class="form-link">
                <span>Don't have an account? <a href="../1REGISTER/register.php" class="link signup-link">Signup</a></span>
            </div>
        </div>

        <div class="line"></div>

        <div class="media-options">
            <a href="#" class="field facebook">
                <i class='bx bxl-facebook facebook-icon'></i>
                <span>Login with Facebook</span>
            </a>
        </div>

        <div class="media-options">
            <a href="#" class="field google">
                <img src="../2LOGIN/images/google.png" alt="" class="google-img">
                <span>Login with Google</span>
            </a>
        </div>

    </div>
</section>

<!-- JavaScript -->
<script src="/2LOGIN/js/script.js"></script>
</body>
</html>