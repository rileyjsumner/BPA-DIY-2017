<?php
session_start();
require_once 'init.php';
$conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_POST['action'] == 'follow') {
    User::follow($conn, $_SESSION["name"], $profile);
    echo 'data: ', $_SESSION["name"], '<br>', $profile;
} else {
    echo 'no req';
}

