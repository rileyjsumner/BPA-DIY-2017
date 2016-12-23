<!DOCTYPE html>
<?php 
    require_once 'init.php';
    $conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user = new User();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
            </ul>
        </nav>
        <div class="card">
            <h2><?php echo $_SESSION['title']; ?></h2>
            <p><?php echo $_SESSION['description']; ?></p>
            <p><?php echo $_SESSION['facebook']; ?></p>
            <p>@<?php echo $_SESSION['twitter']; ?></p>
            <p>@<?php echo $_SESSION['instagram']; ?></p>
            <p><?php echo $_SESSION['pinterest']; ?></p>
            <p>@<?php echo $_SESSION['snapchat']; ?></p>
            <p>+<?php echo $_SESSION['google']; ?></p>
        </div>
        <?php
            
        ?>
    </body>
</html>
