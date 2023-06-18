<?php
session_start();
include "../connection.php";
global $conn;

$user_id = $_SESSION['user_id'];

$sql1 = "DELETE FROM users_guess WHERE user_id = :user_id";
$stmt1 = $conn->prepare($sql1);
$stmt1->bindParam(':user_id', $user_id);
$stmt1->execute();

$sql2 = "DELETE FROM users_levels WHERE user_id = :user_id";
$stmt2 = $conn->prepare($sql2);
$stmt2->bindParam(':user_id', $user_id);
$stmt2->execute();

$sql3 = "DELETE FROM users_purchases WHERE user_id = :user_id";
$stmt3 = $conn->prepare($sql3);
$stmt3->bindParam(':user_id', $user_id);
$stmt3->execute();
header("Location: logout.php");
exit;
?>