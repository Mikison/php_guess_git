<?php
session_start();
global $theme;
include "../!NAVBAR/navbar.php";
include "../connection.php";
include "../updatePointsAndLevel.php";
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
            <th>Level</th>
        </tr>
        <?php


        // Pobranie danych z bazy danych
        $sql = "SELECT UG.nickname, UL.all_time_experience_points, UL.level
FROM USERS_GUESS UG
JOIN USERS_LEVELS UL ON UG.user_id = UL.user_id
ORDER BY UL.all_time_experience_points DESC
";
        $result = $conn->query($sql);

        // Wy�wietlenie danych w tabeli
        if ($result->rowCount() > 0) {
            $rank = 1;
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $rank . "</td>";
                echo "<td>" . $row['nickname'] . "</td>";
                echo "<td>" . $row['all_time_experience_points'] . "</td>";
                echo "<td>" . $row['level'] . "</td>";
                echo "</tr>";
                $rank++;
            }
        }
        ?>
    </table>
</div>
</body>
</html>
