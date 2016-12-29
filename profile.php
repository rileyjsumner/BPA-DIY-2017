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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
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
                <li class="active"><a href="profile.php">Profile</a></li>
        </nav>
        <div class="row">
            <div class='col-1' id='profile'>
                <?php
                    if(Token::check(Verify::get('token'))) { 
                        
                        if(!(isset($_GET["User"]))) {
                            $profile = $_SESSION["name"];
                        } else {
                            $profile = $_GET["User"];
                        }

                        $sql = "SELECT * FROM `users` WHERE `username`='$profile';";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            if($row = mysqli_fetch_assoc($result)) { ?>
                                <h1><?php echo $row["username"];?></h1>
                                <ul>
                                    <?php if(($row["facebook"]) !== "") { ?><li><a href="http://www.facebook.com/<?php echo $row["facebook"]; ?>" target="_blank">Facebook</a></li><?php } ?>
                                    <?php if(($row["twitter"]) !== "") { ?><li><a href="http://www.twitter.com/<?php echo $row["twitter"];?>" target="_blank">Twitter</a></li><?php } ?>
                                    <?php if(($row["instagram"]) !== "") { ?><li><a href="http://www.instagram.com/<?php echo $row["instagram"]; ?>" target="_blank">Instagram</a></li><?php } ?>
                                    <?php if(($row["pinterest"]) !== "") { ?><li><a href="http://www.pinterest.com/<?php echo $row["pinterest"]; ?>" target="_blank">Pinterest</a></li><?php } ?>
                                    <?php if(($row["snapchat"]) !== "") { ?><li><a href="http://www.snapchat.com/add/<?php echo $row["snapchat"]; ?>" target="_blank">Snapchat</a></li><?php } ?>
                                    <?php if(($row["google"]) !== "") { ?><li><a href="http://plus.google.com/<?php echo $row["google"]; ?>" target="_blank">Google+</a></li><?php } ?>
                                </ul>
                            <?php }
                        } ?>
                        <script>
                        function follow(a) {
                            $.ajax({
                                type: "POST",
                                url: '/ajax.php',
                                data:{action: 'follow', user: a},
                                success: function() {
                                    console.log("calledF");
                                }
                            });
                        }
                        function unfollow(a) {
                            $.ajax({
                                type: "POST",
                                url: '/ajax.php',
                                data:{action: 'unfollow', user: a},
                                success: function() {
                                    console.log("calledUF");
                                }
                            });
                        }
                        function del(a) {
                            $.ajax({
                                type: "POST",
                                url: '/ajax.php',
                                data: {action: 'delete', postID: a},
                                success: function() {
                                    console.log("called del()");
                                }
                            });
                        }
                        </script>
                        <?php 
                            $sqlF = "SELECT `follows` FROM `users` WHERE `user`='".$_SESSION['name']."';";
                            $resultF = mysqli_query($conn, $sqlF);
                            $followers = mysqli_num_rows($resultF);
                            if($followers > 0) {
                                while($rowF = mysqli_fetch_assoc($resultF)) {
                                    if($profile == $rowF["follows"]) {
                                        $foll = true;
                                        break;
                                    } else {
                                        $foll = false;
                                    }
                                }
                            }
                            if($profile == $_SESSION["name"]) { ?>
                                
                            <?php } else if($foll) { ?>
                                <button type='button' name='unfollow' id='unfollow' onclick='unfollow(<?php echo "\"$profile\""; ?>)'>unfollow @<?php echo $profile ?></button>
                            <?php } else { ?>
                                <button type='button' name='follow' id='follow' onclick='follow(<?php echo "\"$profile\""; ?>)'>Follow @<?php echo $profile ?></button>
                            <?php }
                            }
                        ?>
            </div>
            <div class='col-1'>
             <?php   
              $sql2 = "SELECT * FROM `posts` WHERE `user` = '$profile';";
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
                                                                    "tags"=>$row2["tags"],
                                                                    "postID"=>$row2["postID"]);
                                
                            }
                        }   
                        ksort($posts);
                    foreach(array_reverse($posts) as $elem) { ?>
                        <div class='project'>
                            <h2><?php echo $elem["title"]; ?></h2>
                            <p><?php echo $elem["description"]; ?></p>
                            
                            <a class="expander" href="#">click me</a>
                            <div class='hidden' id='details'>
                                <?php echo $elem["steps"]; ?>
                            </div>
                            <button type='button' name='delete' id='delete' onclick='del(<?php echo $elem["postID"]; ?>)'>Delete Post</button>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </body>
</html>
