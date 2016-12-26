<!DOCTYPE html>
<?php 
session_start();
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
        <div class="header">
            <img src="Pictures/header.png" width="100%" alt=""/>
        </div>
        <nav class="nav">
            <ul>
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="upload-project.php">Upload Project</a></li>
                <li><a href="submit-idea.php">Submit an Idea</a></li>
                <li><a href="login-register.php">Login/Register</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>   
        </nav>
        <div class='row'>
            <div class='col-1'>
                <?php 
                    $sql = "SELECT `follow` FROM `follows` WHERE `user`='".$_SESSION['name']."';";
                    $result = mysqli_query($conn, $sql); 
                    $following = array();
                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $following[] = $row["follow"];
                        }
                    }
                    $posts = array();
                    foreach($following as $userFollow) {
                        $sql2 = "SELECT * FROM `posts` WHERE `user` = '$userFollow';";
                        $result2 = mysqli_query($conn, $sql2);
                        if(mysqli_num_rows($result2) > 0) {
                            while($row2 = mysqli_fetch_assoc($result2)) {
                                $posts[$row2["timestamp"]] = array("title"=>$row2["title"], 
                                                                    "user"=>$row2["user"], 
                                                                    "description"=>$row2["description"], 
                                                                    "steps"=>$row2["steps"],
                                                                    "materials"=>$row2["materials"],
                                                                    "tips"=>$row2["tips"],
                                                                    "time"=>$row2["estTime"],
                                                                    "cost"=>$row2["estCost"],
                                                                    "reviews"=>$row2["ratings"],
                                                                    "rating"=>$row2["rated"],
                                                                    "tags"=>$row2["tags"]);
                                
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </body>
</html>

