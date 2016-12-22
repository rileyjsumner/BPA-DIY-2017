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
        <link rel="stylesheet" href="diy.css" type="text/css">
        <meta charset="UTF-8">
        <title>Home</title>
    </head>
    <body>
         
        <nav class="nav">
             <ul id="menu">
            <li><a href="">Home</a></li> 
            <li><a href="">About</a> 
              <ul>
                <li><a href="">The Team</a></li>
                <li><a href="">History</a></li> 
                <li><a href="">Vision</a></li> 
              </ul> 
            </li> 
            <li><a href="">Products</a> 
              <ul> 
                <li><a href="">Cozy Couch</a></li> 
                <li><a href="">Great Table</a></li> 
                <li><a href="">Small Chair</a></li> 
                <li><a href="">Shiny Shelf</a></li> 
                <li><a href="">Invisible Nothing</a></li> 
              </ul> 
            </li>
            <li><a href="">Contact</a> 
              <ul> 
                <li><a href="">Online</a></li> 
                <li><a href="">Right Here</a></li> 
                <li><a href="">Somewhere Else</a></li> 
              </ul> 
            </li> 
        </ul>   
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
            </ul>
        </nav>
        <?php
            
        ?>
    </body>
</html>
