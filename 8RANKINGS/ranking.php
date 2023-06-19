<?php
session_start();
global $theme;
include "../!NAVBAR/navbar.php";
include "../connection.php";
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
global $conn;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ranking</title>
    <link  rel="stylesheet" href="css/<?php echo $theme?>.css">
</head>
<body>
<div class="container">
<h1>Ranking</h1>
<table>
    <tr>
        <th>#</th>
        <th>Nickname</th>
        <th>Ogólna punktacja</th>
    </tr>
    <?php


    // Pobranie danych z bazy danych
    $sql = "SELECT users_guess.nickname, users_levels.all_time_experience_points
            FROM users_guess
            JOIN users_levels ON users_guess.user_id = users_levels.user_id
            ORDER BY users_levels.all_time_experience_points DESC
";
    $result = $conn->query($sql);

    // Wyświetlenie danych w tabeli
    if ($result->rowCount() > 0) {
        $rank = 1;
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $rank . "</td>";
            echo "<td>" . $row['nickname'] . "</td>";
            echo "<td>" . $row['all_time_experience_points'] . "</td>";
            echo "</tr>";
            $rank++;
        }
    } else {
        echo "<tr><td colspan='3'>No data available</td></tr>";
    }
    ?>
</table>
</div>
</body>
</html>
