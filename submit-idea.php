<!DOCTYPE html>
<?php 
session_start();
    require_once 'init.php';
    $conn = mysqli_connect("localhost", "rileyODS", "riley4ODS!", "bpa2017");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $user = new User();
    if(Token::check(Verify::get('token'))) {
        $userID = $_SESSION["id"];
        $userName = $_SESSION["name"];
        
    }
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
                <li class="active"><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>   
        </nav>
        <?php
            if(Token::check(Verify::get('token'))) {
        ?>
        <div class="row">
            <div class="col-2">
                <form class="smart-green" action="" method="post">
                    <p>Project Name</p><br>
                        <input type="text" name="projectname" placeholder="Project Name" value=""><br>
                    <p>Description</p> 
                        <textarea name="description" placeholder="Be sure to include any specifications (ie. cost, time, materials, etc.)" value=""></textarea><br>
                        <input name="submit" type="submit" value="Submit">
                </form>  

                    <?php } else {
                        echo "<p>You are not <a href='login-register.php'>logged in</a></p>";
                    }
                    if(Input::get("submit")) {
                        $name = Input::get("projectname");
                        $description = Input::get("description");

                        $sql="INSERT INTO `ideas` (`user`, `name`, `description`) VALUES ('$userName','$name','$description');";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            echo "<p>Your idea was submitted!</p>";
                        } else {
                            echo "<p>An error occured. Please try again.</p>";
                        }
                    }
                    ?>
            </div>
        </div>
</body>
    
</html>
