<?php
session_start();
require_once 'init.php';
$conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if($_POST['action'] == 'follow') {
    User::follow($conn, $_SESSION["name"], $_POST['user']);
    User::page_redirect("/profile.php?User=".$_POST["user"]);
} else if($_POST['action'] == 'unfollow') {
    User::unfollow($conn, $_SESSION["name"], $_POST['user']);
    User::page_redirect("/profile.php?User=".$_POST["user"]);
} else if($_POST['action'] == 'delete') {
    User::deletePost($conn, $_POST["postID"]);
    User::page_redirect("/profile.php?User=".$_POST["user"]);
} else if($_POST['action'] == 'logout') {
    User::logout($conn, $_POST['user']);
    User::page_redirect("/index.php");
} else if($_POST['action'] == 'accept') {
    User::accept($conn, $_POST['id']);
    User::page_redirect("/index.php");
} else if($_POST['action'] == 'decline') {
    User::decline($conn, $_POST['id']);
    User::page_redirect("/index.php");
} else {
    echo 'no req';
}

