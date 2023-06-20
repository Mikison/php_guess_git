<?php
include "connection.php";
global $conn;

class User {

    private $user_id;

    public function __construct($user_id) {
        $this->user_id = $user_id;
    }

    public function updatePonts($number) {
        global $conn;
        $updateSql = "UPDATE USERS_LEVELS SET experience_points = experience_points + $number WHERE user_id = '$this->user_id'";

        if ($conn->query($updateSql) === TRUE) {
            echo "Punkty zaktualizowane.";
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }
}