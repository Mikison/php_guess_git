<?php
session_start();
session_destroy();


header("Location: ../2LOGIN/login.php");