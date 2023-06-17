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
            background-color: #0e0e0e;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        .profile {
            max-width: 600px;
            margin: 120px auto;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 20px;
            background-color: #555;
        }

        .stat {
            margin-bottom: 10px;
        }

        .stat strong {
            color: #bbb;
        }

        .stat span {
            color: #fff;
            font-weight: bold;
        }

        .achievements {
            margin-top: 20px;
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

    <div class="stat">
        <strong>Punkty doświadczenia:</strong> <span id="experience">0</span>
    </div>

    <div class="stat">
        <strong>Level:</strong> <span id="level">1</span>
    </div>

    <div class="stat">
        <strong>Ilość zgadniętych postaci:</strong> <span id="characters">0</span>
    </div>

    <div class="achievements">
        <h2>Achievementy</h2>

        <div class="achievement">
            <img src="achievement1.jpg" alt="Achievement 1">
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
