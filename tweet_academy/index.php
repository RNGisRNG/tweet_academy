<?php
session_start();
if (isset($_SESSION["user"])) {
    header("Location: ./pages/home.php");
    exit;
}
header("Location: ./pages/login.php");
