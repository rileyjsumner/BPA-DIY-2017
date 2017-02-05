<!DOCTYPE html>
<?php 
    require_once 'init.php';
    session_start();
    $conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user = new User();
?>
<html>
    <head>
        <link rel="stylesheet" href="diy.css" type="text/css">
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <div class="header">
        <img src="Pictures/header.png" width="100%" alt=""/>
        </div>
         <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="View/ideas.php">View/Ideas</a></li>
            </ul>   
        </nav>
        <div class="card">
            <!--<h2><?php echo $_SESSION["title"]; ?></h2>
            <p><?php echo $_SESSION["description"]; ?></p>
            <p><?php echo $_SESSION["facebook"]; ?></p>
            <p>@<?php echo $_SESSION["twitter"]; ?></p>
            <p>@<?php echo $_SESSION["instagram"]; ?></p>
            <p><?php echo $_SESSION["pinterest"]; ?></p>
            <p>@<?php echo $_SESSION["snapchat"]; ?></p>
            <p>+<?php echo $_SESSION["google"]; ?></p>-->
        </div>
        <?php
            
        ?>
    </body>
</html>
