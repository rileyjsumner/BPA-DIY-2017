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
        $sql = "SELECT `username` FROM `users` WHERE `userID`=$userID;";
        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $userName = $row['username'];
            }
        }
        
    }
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
        <?php
            
        ?>
     
 <form action="">
  Project name :<br>
  <input type="text" name="project name" value=" ">
  <br>
  Description 
  <textarea name="Description" value=" "></textarea>
  <br>
 <input type="submit" value="Submit">
</form>  
  
</form>
   <?php 
    $name = "Project name";
    $description = "";
    
    echo $name, '<br>', $description;
    ?>
</body>
    
</html>
