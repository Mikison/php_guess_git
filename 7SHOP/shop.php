<?php
global $conn;
session_start();
if (!isset($_SESSION['user_id'])) header("Location: ../2LOGIN/login.php");
$user_id = $_SESSION['user_id'];
include "../!NAVBAR/navbar.php";
include "../connection.php";
checkTable();
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["item_id"])) {
    $item_id = $_GET["item_id"];
    // Pobranie odpowiedniego itemka z SQL i zapisanie jego ceny do zmiennej
    $getItemPrice_sql = $conn->prepare("SELECT id, name, price, icon, category FROM SHOP_ITEMS WHERE id = :item_id");
    $getItemPrice_sql->bindParam('item_id', $item_id);
    $getItemPrice_sql->execute();
    $rows = $getItemPrice_sql->fetch(PDO::FETCH_ASSOC);

    //Zmienne
    $price_in_points = $rows['price'];
    $category = $rows['category'];
    $icon = $rows['icon'];
    // Zabranie za kupioną rzecz punktów użytkownikowi
    $statement_points = $conn->prepare("UPDATE USERS_LEVELS SET experience_points = experience_points - :points  WHERE user_id = :user_id");
    $statement_points->bindParam(':points', $price_in_points);
    $statement_points->bindParam(':user_id', $user_id);
    $statement_points->execute();
    // Wpisanie w bazę danych zakupu użytkownika
    $statment_insert_purchases = $conn->prepare("INSERT INTO USERS_PURCHASES (user_id, item_id) VALUES (:user_id, :item_id)");
    $statment_insert_purchases->bindParam(':user_id', $user_id);
    $statment_insert_purchases->bindParam(':item_id', $item_id);
    $statment_insert_purchases->execute();

    if ($category == 'Avatar') {
        setcookie('avatar', $icon, time() + 60 * 60 * 24 * 7, '/');
    }


    header("Location: ../7SHOP/shop.php");
    exit();
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["select_item_id"])) {
    $selectItemId = $_GET["select_item_id"];
    $getItemPrice_sql = $conn->prepare("SELECT id, name, price, icon, category FROM SHOP_ITEMS WHERE id = :item_id");
    $getItemPrice_sql->bindParam('item_id', $selectItemId);
    $getItemPrice_sql->execute();
    $rows = $getItemPrice_sql->fetch(PDO::FETCH_ASSOC);

    $category = $rows['category'];
    $icon = $rows['icon'];
    if ($category == 'Avatar') {
        setcookie('avatar', $icon, time() + 60 * 60 * 24 * 7, '/');
    } elseif ($category == 'Theme') {
        setcookie('theme', $icon, time() + 60 * 60 * 24 * 7, '/');
    } elseif ($category == 'Champions') {
        setcookie('champs', 'yes', time() + 60 * 60 * 24 * 7, '/');
    }
    header("Location: ../7SHOP/shop.php");
    exit();
}



function checkTable() {
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
        category VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
        selected INT NOT NULL)";
        $conn->exec($new_table_statement);



        $stmt = $conn->prepare("INSERT INTO SHOP_ITEMS (name, price, icon, category) VALUES
        ('Bober', 500, 'icons/bober.jpeg', 'Avatar'),
        ('Wiewiór', 2000, 'icons/wiewiór.gif', 'Avatar'),
        ('Motyw Biały', 1000, 'icons/white.png', 'Theme'),
        ('Motyw Kolor', 5000, 'icons/rainbow.png', 'Theme'),
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
        purchased_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
        $conn->exec($new_table_statement);
    }

}
function checkIfAlreadyPurchased($user_id, $item_id) {
    global $conn;
    $check_statement = $conn->prepare("SELECT COUNT(*) as count FROM USERS_PURCHASES WHERE user_id = :user_id AND item_id = :item_id");
    $check_statement->bindParam(':user_id', $user_id);
    $check_statement->bindParam(':item_id', $item_id);
    $check_statement->execute();

    $result = $check_statement->fetch(PDO::FETCH_ASSOC);
    $count = $result['count'];

    if ($count > 0) {
        return true;
    }
    return false;
}


function console_log($data)
{
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}


$statement = $conn->prepare("SELECT experience_points FROM USERS_LEVELS WHERE user_id = :user_id");
$statement->bindParam(':user_id', $user_id);
$statement->execute();

$result_statment = $statement->fetch(PDO::FETCH_ASSOC);
$user_points_to_spend = $result_statment['experience_points'];

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
            user-select: none;
        }

        .item {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 300px;
            height: 275px;
            padding: 10px;
            background-color: #1a1a1a;
            border-radius: 20px;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .item-icon {
            width: 150px;
            height: 150px;
            background-color: lightgray;
            margin-bottom: 10px;
            margin-top: 10px;
            background-image: url("icons/wiewiór.gif");
            background-size: cover;
            background-position: center;
        }

        .item-name {
            font-weight: bold;
            text-align: center;
        }

        .item-price {
            margin: 6px;
        }

        .buy-button,
        .select-button{
            padding: 5px 10px;
            background-color: #2ecc71;
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
            user-select: none;
        }

        .selected-text {
            margin: 4px;
        }

        .buy-button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Sklepik</h1>
    <h3>Punkty: <?php echo $user_points_to_spend ?></h3>

    <?php
    $sql = "SELECT id, name, price, icon, category FROM SHOP_ITEMS";
    $result = $conn->query($sql);
    $category_now = '';




    if ($result->rowCount() > 0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $name = $row["name"];
            $price = $row["price"];
            $icon = $row["icon"];
            $category = $row["category"];
            if ($category_now != $category) {
                if ($category_now != '') {
                    echo "</div>";
                    echo "</div>";
                }
                $category_now = $category;
                echo "<div class='category'>";
                echo "<div class='category-title'>$category</div>";
                echo "<div class='items-container'>";
            }
            ?>
            <div class="item">
                <div class="item-icon" style="background-image: url('<?php echo $icon; ?>')"></div>
                <div class="item-name"><?php echo $name; ?></div>
                <div class="item-price"><?php echo $price; ?></div>
                <?php
                if (isset($_COOKIE['avatar']) || isset($_COOKIE['theme'])) {
                    $avatar = $_COOKIE['avatar'];
                    $theme = $_COOKIE['theme'];
                    if ($avatar == $icon || $theme == $icon) {
                        echo "<div class='selected-text'>Selected</div>";
                    }
                }
                if (checkIfAlreadyPurchased($user_id, $id)) {
                    if ($category == 'Champions') {
                        echo '<button class="select-button">✓</button>';
                    } else {
                        echo '<button class="select-button" onclick="location.href=\'../7SHOP/shop.php?select_item_id=' . $id . '\'">Select</button>';
                    }
                } else {
                    echo '<button class="buy-button" onclick="location.href=\'../7SHOP/shop.php?item_id=' . $id . '\'" name="item_id" value="' . $id . '">Buy</button>';
                }
                ?>
            </div>
            <?php
        }
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>
</body>
</html>
