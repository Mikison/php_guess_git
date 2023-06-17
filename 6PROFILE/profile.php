<?php
include "../!NAVBAR/navbar.php";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Gracza</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
            height: 100vh; /* Dodana wysokość strony */
            display: flex; /* Dodane właściwości flexbox */
            justify-content: center;
            align-items: center;
        }

        .profile {
            width: 60%;
            height: 600px;
            padding: 40px;
            background-color: #1a1a1a;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            overflow: auto;
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        .avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background-color: #555;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stats-item {
            flex-basis: 33%;
            text-align: center;
            padding: 14px;
            border-radius: 8px;
            margin: 10px;
            background-color: #0e0e0e;
        }

        .stats-item strong {
            color: #bbb;
        }

        .stats-item span {
            color: #fff;
            font-weight: bold;
        }

        .achievements {
            margin-top: 30px;
        }

        .achievement {
            display: inline-block;
            width: 100px;
            text-align: center;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .achievement img {
            width: 80px;
            height: 80px;
        }
    </style>
</head>
<body>
<div class="profile">
    <h1>Profil Gracza</h1>

    <div class="avatar"></div>

    <div class="stats">
        <div class="stats-item">
            <strong>Punkty doświadczenia:</strong><br>
            <span id="experience">0</span>
        </div>

        <div class="stats-item">
            <strong>Level:</strong><br>
            <span id="level">1</span>
        </div>

        <div class="stats-item">
            <strong>Zgadniętych postaci:</strong><br>
            <span id="characters">0</span>
        </div>
    </div>

    <div class="achievements">
        <h2>Achievementy</h2>

        <div class="achievement">
            <img src="down.png" alt="Achievement 1">
            <div>Achievement 1</div>
        </div>

        <div class="achievement">
            <img src="achievement2.jpg" alt="Achievement 2">
            <div>Achievement 2</div>
        </div>

        <div class="achievement">
            <img src="achievement3.jpg" alt="Achievement 3">
            <div>Achievement 3</div>
        </div>
    </div>
</div>
</body>
</html>
