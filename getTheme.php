<?php
session_start();
include "./connection.php";
$user_id = $_SESSION['user_id'];
global $conn;
function getTheme() {
    global $user_id, $conn;
    $sql = "SELECT UP.*, SI.name 
            FROM USERS_PURCHASES UP 
            JOIN SHOP_ITEMS SI ON UP.item_id = SI.id 
            WHERE UP.user_id = :user_id 
            AND UP.category = 'theme' 
            AND UP.selected = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Pobranie wyników zapytania
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $result['name'];
    return strtolower($name);
}
