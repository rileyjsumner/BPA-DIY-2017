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
        <?php
            
        ?>
     
 <form action="">
  Project name :<br>
  <input type="text" name="project name" value=" ">
  <br>
  Materials:<br>
  <input type="text" name="Materials" value="">
  <br>
 cost :<br>
  <input type="text" name="cost
  " value=" "><br>
 <input type="submit" value="Submit">
</form> 
  
</form>
    </body>
    
</html>
