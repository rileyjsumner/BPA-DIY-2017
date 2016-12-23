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
        <img src="Pictures/DIY header.jpg" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li class="active"><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
            </ul>   
        </nav>
        <?php
            
        ?>
     
        <form class="smart-green" action="" method="post">
            <p>Project Name</p><br>
                <input type="text" name="projectname" value=""><br>
            <p>Description</p> 
                <textarea name="description" value=" "></textarea><br>
                <input name="submit" type="submit" value="Submit">
        </form>  
 
   <?php
   if(Input::get("submit")) {
       $name = Input::get("projectname");
       $description = Input::get("description");

       $sql="INSERT INTO `ideas` (`user`, `name`, `description`) VALUES ('$userName','$name','$description');";
       $result=  mysqli_query($conn, $sql);
   }
    ?>
</body>
    
</html>
