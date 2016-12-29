<?php
session_start();
require_once 'init.php';
$conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_POST['action'] == 'follow') {
    User::follow($conn, $_SESSION["name"], $_POST['user']);
} else if($_POST['action'] == 'unfollow') {
    User::unfollow($conn, $_SESSION["name"], $_POST['user']);
} else if($_POST['action'] == 'delete') {
    User::deletePost($conn, $postID);
} else{
    echo 'no req';
}

