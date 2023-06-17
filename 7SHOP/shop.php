<?php
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
include "../!NAVBAR/navbar.php";
include "../connection.php";


function checkTable() {
    global $conn;
    $check_table_statement = "SHOW TABLES LIKE 'SHOP'";
    $table_exists = $conn->query($check_table_statement)->rowCount() !== 0;
    if (!$table_exists) {
        $new_table_statement = "
    CREATE TABLE shop_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    icon VARCHAR(255) NOT NULL,
    category VARCHAR(255) NOT NULL);";
        $conn->exec($new_table_statement);
    }

    $stmt = $conn->prepare("INSERT INTO items (name, price, icon, category) VALUES
    ('Bober', 500, 'icons/bober.jpeg', 'Avatary'),
    ('Wiewiór', 2000, 'icons/wiewiór.gif', 'Avatary'),
    ('Motyw 1', 1000, 'icons/white.png', 'Motywy'),
    ('Motyw 2', 5000, 'themes/theme2.png', 'Motywy'),
    ('Postać 1', 30.00, 'characters/character1.png', 'Postacie'),
");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shop</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #eee;
            padding: 20px;
        }

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100vh;
            justify-content: center;
        }

        .category {
            margin-bottom: 30px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .category-title {
            margin: 10px 0 10px 0;
            font-size: 24px;
            font-weight: bold;
        }

        .items-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 200px;
            height: 150px;
            padding: 10px;
            background-color: #1a1a1a;
            border-radius: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .item-icon {
            width: 50px;
            height: 50px;
            background-color: lightgray;
            margin-bottom: 10px;
            margin-top: 10px;
            background-image: url("../7SHOP/icons/wiewiór.gif");
            background-size: cover;
            background-position: center;
        }

        .item-name {
            font-weight: bold;
            text-align: center;
        }

        .item-price {
            margin: 10px;
        }

        .buy-button {
            padding: 5px 10px;
            background-color: #2ecc71;
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
        }

        .buy-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Sklepik</h1>

    <div class="category">
        <div class="category-title">Avatary</div>
        <div class="items-container">
            <div class="item">
                <div class="item-icon"></div>
                <div class="item-name">Avatar 1</div>
                <div class="item-price">$10</div>
                <button class="buy-button">Kup</button>
            </div>
            <div class="item">
                <div class="item-icon"></div>
                <div class="item-name">Avatar 2</div>
                <div class="item-price">$15</div>
                <button class="buy-button">Kup</button>
            </div>
        </div>
    </div>

    <div class="category">
        <div class="category-title">Motywy</div>
        <div class="items-container">
            <div class="item">
                <div class="item-icon"></div>
                <div class="item-name">Motyw 1</div>
                <div class="item-price">$20</div>
                <button class="buy-button">Kup</button>
            </div>
            <div class="item">
                <div class="item-icon"></div>
                <div class="item-name">Motyw 2</div>
                <div class="item-price">$25</div>
                <button class="buy-button">Kup</button>
            </div>
        </div>
    </div>

    <div class="category">
        <div class="category-title">Postacie</div>
        <div class="items-container">
            <div class="item">
                <div class="item-icon"></div>
                <div class="item-name">Postać 1</div>
                <div class="item-price">$30</div>
                <button class="buy-button">Kup</button>
            </div>
            <div class="item">
                <div class="item-icon"></div>
                <div class="item-name">Postać 2</div>
                <div class="item-price">$35</div>
                <button class="buy-button">Kup</button>
            </div>
        </div>
    </div>
</div>
</body>
</html>
