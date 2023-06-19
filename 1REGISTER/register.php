<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Guess - Register </title>

    <link rel="stylesheet" href="../1REGISTER/css/style.css">
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<section class="container forms">
    <div class="form signup">
        <div class="form-content">
            <header>Signup</header>
            <div id="error-message"></div>
            <form method="post">
                <div class="field input-field">
                    <input type="text" placeholder="Nickname" class="input" name="nickname" required>
                </div>

                <div class="field input-field">
                    <input type="password" placeholder="Create password" class="password" name="password" required>
                </div>

                <div class="field input-field">
                    <input type="password" placeholder="Confirm password" class="password" name="confirm_password" required>
                    <i class='bx bx-hide eye-icon'></i>
                </div>

                <div class="field button-field">
                    <input type="submit" value="Sign up" name="register"/>
                </div>
            </form>

            <div class="form-link">
                <span>Already have an account? <a href="../2LOGIN/login.php" class="link signup-link">Sign in</a></span>
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
                <img src="images/google.png" alt="" class="google-img">
                <span>Login with Google</span>
            </a>
        </div>

    </div>
</section>
<!-- JavaScript -->
<script src="js/script.js"></script>
<?php
include "../connection.php";
global  $conn;

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

$check_table_statement = "SHOW TABLES LIKE 'USERS_GUESS'";
$table_exists = $conn->query($check_table_statement)->rowCount() > 0;

if (!$table_exists) {
    $new_table_statement = "CREATE TABLE USERS_GUESS (
        user_id INT AUTO_INCREMENT,
        nickname VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        PRIMARY KEY (user_id)
    )";
    $conn->exec($new_table_statement);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["register"])) {
        $nickname = $_POST['nickname'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];


        if (empty($nickname)  || empty($password) || empty($confirm_password)) {
            $errMsg = "Błąd! Jedno z pól jest puste";
            generateJavaScript($errMsg, "red");
            exit();
        }

        if (!preg_match("/^[a-zA-Z0-9]*$/", $nickname)) {
            $errMsg = "Błąd! W polu nickname znajdować się mogą tylko litery i cyfry ";
            generateJavaScript($errMsg, "red");
            exit();
        }


        $sql_check_if_username_exists = "SELECT nickname FROM USERS_GUESS WHERE nickname = '$nickname'";
        $result = $conn->query($sql_check_if_username_exists);

        if ($result->rowCount() > 0) {
            $errMsg = "Błąd! Konto o takim nickname już istnieje. Wybierz inny";
            generateJavaScript($errMsg, "red");
            exit();
        }


        if ($password == $confirm_password) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $errMsg = "Hasła nie są jednakowe";
            generateJavaScript($errMsg, "red");
            exit();
        }
        $stmt = $conn->prepare("INSERT INTO USERS_GUESS (nickname, password) VALUES (:nickname, :password)");
        $stmt->bindParam(':nickname', $nickname);
        $stmt->bindParam(':password', $hashed_password);

        if ($stmt->execute()) {
            generateJavaScript("Rejestracja przebiegła pomyślnie!", "green");
        } else {
            echo "Błąd podczas rejestracji.";
        }

    }
}
    ?>
</body>
</html>
