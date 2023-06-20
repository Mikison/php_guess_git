<?php
session_start();
include "../connection.php";
include "../!NAVBAR/navbar-homeless-solo.php";
include "../User.php";
global $conn;

if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");

$user_id = $_SESSION['user_id'];


function console_log($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

$stmt = $conn->prepare("SELECT isAdmin FROM USERS_GUESS WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();


if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $isAdmin = $row['isAdmin'];

    if ($isAdmin !== 1) {
        header("Location: ../3PLAY/play.php");
        console_log("nie admin");
    }
}

if (isset($_POST['submit_description'])) {
    $championName = $_POST['champion_name'];
    $championHint1 = $_POST['champion_hint1'];
    $championHint2 = $_POST['champion_hint2'];
    $championHint3 = $_POST['champion_hint3'];

    $sql = "INSERT INTO CHAMPIONS (CHAMPION_NAME, CHAMPION_HINT1, CHAMPION_HINT2, CHAMPION_HINT3) VALUES ('$championName', '$championHint1', '$championHint2', '$championHint3')";

    if ($conn->query($sql) === TRUE) {
        echo "Champion description added successfully.";
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}


if (isset($_POST['submit_graphics'])) {
    $championName = $_POST['champion_name'];
    $fileName = $_FILES['champion_image']['name'];
    $fileTmpName = $_FILES['champion_image']['tmp_name'];
    $fileType = $_FILES['champion_image']['type'];
    $fileError = $_FILES['champion_image']['error'];

    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    if (in_array($fileExtension, $allowedExtensions)) {
        if ($fileError === 0) {
            $newFileName = $championName . '.jpg';
            $destination = '../5PLAY_GRAPHIC/champs/' . $newFileName;

            // Przenoszenie przesłanego pliku do folderu z nową nazwą
            if (move_uploaded_file($fileTmpName, $destination)) {
                echo 'Champion graficzny został dodany.';
                header("Location: ".$_SERVER['PHP_SELF']);
                exit();
            } else {
                echo 'Wystąpił błąd podczas dodawania championa graficznego.';
            }
        } else {
            echo 'Wystąpił błąd podczas przesyłania pliku.';
        }
    } else {
        echo 'Przesłany plik nie jest obsługiwanym obrazem.';
    }
}

if (isset($_POST['update_points'])) {
    $userId = $_POST['user_id'];
    $points = $_POST['points'];
    $checkSql = "SELECT * FROM USERS_LEVELS WHERE user_id = '$userId'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->rowCount() > 0) {
        $USER = new User($userId);
        $USER->updatePonts($points);
    } else {
        echo "Użytkownik nie istnieje.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel administracyjny</title>
</head>
<style>
    body {
        background-color: #0e0e0e;
        color: #fff;
        font-family: Arial, sans-serif;
    }

    .container {
        max-width: 600px;
        margin: 20px auto;
        padding: 20px;
    }

    h1 {
        color: #fff;
        font-size: 24px;
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        margin-bottom: 20px;
    }

    label {
        display: block;
        font-size: 16px;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
        padding: 10px;
        border: none;
        background-color: #333;
        color: #fff;
        margin-bottom: 15px;
        width: 100%;
    }

    input[type="submit"] {
        padding: 10px 20px;
        border: none;
        background-color: #555;
        color: #fff;
        cursor: pointer;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #777;
    }

    th {
        background-color: #333;
        color: #fff;
    }

    a {
        color: #fff;
        text-decoration: none;
    }

    .search-results {
        margin-top: 20px;
        border-collapse: collapse;
        width: 100%;
    }

    .search-results th,
    .search-results td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .search-results th {
        background-color: #f2f2f2;
    }

    .search-results tr:hover {
        background-color: #f5f5f5;
    }
</style>
<body>
<div class="container">
    <h1>Panel Administracyjny</h1>
<!-- Formularz dodawania championów opisowych -->
<h3>Dodawanie championów opisowych</h3>
<form method="post" action="">
    <input type="text" name="champion_name" placeholder="Nazwa mistrza" required><br>
    <input type="text" name="champion_hint1" placeholder="Wskazówka 1" required><br>
    <input type="text" name="champion_hint2" placeholder="Wskazówka 2" required><br>
    <input type="text" name="champion_hint3" placeholder="Wskazówka 3" required><br>
    <input type="submit" name="submit_description" value="Dodaj">
</form>

<!-- Formularz dodawania championów graficznych -->
<h3>Dodawanie championów graficznych</h3>
<form method="post" action="" enctype="multipart/form-data">
    <input type="text" name="champion_name" placeholder="Nazwa mistrza" required><br>
    <input type="file" name="champion_image" required><br>
    <input type="submit" name="submit_graphics" value="Dodaj">
</form>

<!-- Formularz wyszukiwania użytkownika i edycji -->
<h3>Wyszukiwanie użytkownika i edycja</h3>
<form method="post" action="">
    <input type="text" name="search_query" placeholder="Wyszukaj użytkownika" required>
    <input type="submit" name="search_user" value="Szukaj">
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Użytkownik</th>
        <th>Punkty doświadczenia</th>
        <th>Poziom</th>
        <th>Akcje</th>
    </tr>
    <?php
    if (isset($_POST['search_user'])) {
        $searchQuery = $_POST['search_query'];

        $sql = "SELECT USERS_LEVELS.user_id, USERS_GUESS.nickname, USERS_LEVELS.experience_points, USERS_LEVELS.level, USERS_GUESS.isAdmin
        FROM USERS_LEVELS
        JOIN USERS_GUESS ON USERS_LEVELS.user_id = USERS_GUESS.user_id
        WHERE USERS_GUESS.nickname = '$searchQuery';";
        $result = $conn->query($sql);

        if ($result->rowCount() > 0) {
            echo "<table class='search-results'>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Użytkownik</th>";
            echo "<th>Punkty doświadczenia</th>";
            echo "<th>Poziom</th>";
            echo "</tr>";

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['nickname'] . "</td>";
                echo "<td>" . $row['experience_points'] . "</td>";
                echo "<td>" . $row['level'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "Brak pasujących wyników.";
        }
    }
    ?>
</table>

<!-- Formularz dodawania i odejmowania punktów -->
<h3>Dodawanie i odejmowanie punktów</h3>
<form method="post" action="">
    <input type="text" name="user_id" placeholder="ID użytkownika" required><br>
    <input type="number" name="points" placeholder="Liczba punktów" required><br>
    <input type="submit" name="update_points" value="Aktualizuj">
</form>
</div>
</body>
</html>
