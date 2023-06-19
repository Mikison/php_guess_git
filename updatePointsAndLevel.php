<?php
$user_id = $_SESSION['user_id'];
global $conn;
if (isset($_COOKIE['points'])) {
    $points = $_COOKIE['points'];
    $statement_points = $conn->prepare("UPDATE USERS_LEVELS SET experience_points = experience_points + :points, all_time_experience_points = all_time_experience_points + :points, champion_guessed = champion_guessed + 1 WHERE user_id = :user_id");
    $statement_points->bindParam(':points', $points);
    $statement_points->bindParam(':user_id', $user_id);
    $statement_points->execute();
    setcookie('points', '', time() - 3600, '/');

    $statement = $conn->prepare("SELECT all_time_experience_points, level FROM USERS_LEVELS WHERE user_id = :user_id");
    $statement->bindParam(':user_id', $user_id);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    $all_time_experience_points = $result['all_time_experience_points'];
    $level = $result['level'];

    if ($all_time_experience_points > 2000) {
        $levelup = intval($all_time_experience_points / 1000);
        $updateStatement = $conn->prepare("UPDATE USERS_LEVELS SET level = :new_level WHERE user_id = :user_id");
        $updateStatement->bindParam(':new_level', $levelup);
        $updateStatement->bindParam(':user_id', $user_id);
        $updateStatement->execute();
    }

}