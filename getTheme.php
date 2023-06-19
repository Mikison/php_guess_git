<?php
include "connection.php";
$user_id = $_SESSION['user_id'];
global $conn, $theme;
checkTables();
checkLEVELSTABLE($user_id);
$theme = getThemeFROMDATABASE();

function checkTables() {
    global $conn;
    $check_table_statement = "SHOW TABLES LIKE 'SHOP_ITEMS'";
    $table_exists = $conn->query($check_table_statement)->rowCount() !== 0;
    if (!$table_exists) {
        $new_table_statement = "
        CREATE TABLE SHOP_ITEMS (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        price INT NOT NULL,
        icon VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        category VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL)";
        $conn->exec($new_table_statement);


        $stmt = $conn->prepare("INSERT INTO SHOP_ITEMS (name, price, icon, category) VALUES
        ('Default', 0, 'icons/default.png', 'Avatar'),                                            
        ('Bober', 500, 'icons/bober.jpeg', 'Avatar'),
        ('Wiewiór', 2000, 'icons/wiewiór.gif', 'Avatar'),
        ('Czarny', 0, 'icons/BLACK.png', 'Theme'),
        ('Biały', 1000, 'icons/white.png', 'Theme'),
        ('Kolor', 5000, 'icons/rainbow.png', 'Theme'),
        ('Zestaw Postaci', 3000, 'characters/character1.png', 'Champions')
");
        $stmt->execute();
    }

    $check_table_statement_purchase = "SHOW TABLES LIKE 'USERS_PURCHASES'";
    $table_exists_purchase = $conn->query($check_table_statement_purchase)->rowCount() !== 0;
    if (!$table_exists_purchase) {
        $new_table_statement = "CREATE TABLE USERS_PURCHASES (
        purchase_ID INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        item_id INT NOT NULL,
        category VARCHAR(255),
        selected INT NOT NULL,
        purchased_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
        $conn->exec($new_table_statement);
    }



}

function checkLEVELSTABLE($user_id) {
    global $conn;
    $check_table_statement = "SHOW TABLES LIKE 'USERS_LEVELS'";
    $table_exists = $conn->query($check_table_statement)->rowCount() !== 0;
    if (!$table_exists) {
        $new_table_statement = "CREATE TABLE USERS_LEVELS (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    experience_points INT NOT NULL,
    all_time_experience_points INT NOT NULL,
    level INT NOT NULL,
    champion_guessed INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
        $conn->exec($new_table_statement);
    }

    $sql_check_if_record_exists = "SELECT user_id FROM USERS_LEVELS WHERE user_id = '$user_id'";
    $result = $conn->query($sql_check_if_record_exists);

    if ($result->rowCount() == 0) {
        $insert_statment = $conn->prepare("INSERT INTO USERS_LEVELS (user_id, experience_points, all_time_experience_points, level, champion_guessed) VALUES (:user_id, 0,0,1, 0)");
        $insert_statment->bindParam('user_id', $user_id);
        $insert_statment->execute();

    }
}


function getThemeFROMDATABASE(): string {
    global $user_id, $conn;
    $sql = "SELECT COUNT(*) as count FROM USERS_PURCHASES WHERE user_id = :user_id AND item_id IN (1, 4)";
    $result = $conn->prepare($sql);
    $result->bindParam(':user_id', $user_id);
    $result->execute();
    $count = $result->fetchColumn();

    if ($count !== 2) {
        $statment_insert_default_things = $conn->prepare("INSERT INTO USERS_PURCHASES (user_id, item_id, category, selected) VALUES 
    (:user_id, 1, 'Avatar', 1),
    (:user_id, 4, 'Theme', 1)");
        $statment_insert_default_things->bindParam(':user_id', $user_id);
        $statment_insert_default_things->execute();
    }

    $sql = "SELECT UP.*, SI.name
            FROM USERS_PURCHASES UP
            JOIN SHOP_ITEMS SI ON UP.item_id = SI.id
            WHERE UP.user_id = :user_id
            AND UP.category = 'theme'
            AND UP.selected = 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $name = $result['name'];
    return strtolower($name);
}
