<?php
include "../!NAVBAR/navbar.php";
include "../connection.php";
global $conn;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ranking</title>
    <style>
        body {
            color: #fff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px 0;
            margin-top: 100px;
        }

        .container {
            width: 60%;
            margin: 0 auto;
            user-select: contain;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            text-align: center;
            padding: 10px;
            user-select: none;
        }

        tr:nth-child(even) {
            background-color: #333;
        }

        th {
            background-color: #555;
            color: #fff;
        }
    </style>
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
