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
        <link href="https://fonts.googleapis.com/css?family=Arimo|Bahiana|Barrio|Indie+Flower|Lobster" rel="stylesheet">
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
                <li><a href="view-ideas.php">View Ideas</a></li>
        </nav>
        <div class="row">
            <div class='col-1' >
                <div class="project">
                <?php
                function page_redirect($location)
                {
                  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='.$location.'">';
                  exit; 
                }
                    if(Token::check(Verify::get('token'))) { 
                        ?> 
                <form action="#" method="post">
                    <input type="text" name="search" id="search" placeholder="Search for a user" value="">
                    <input type="submit" name="searchUser" value="Search">
                </form>   
                <script type='text/javascript'>
                    function expander(x){
                        var tempScrollTop = $(window).scrollTop();
                        console.log(tempScrollTop);
                        console.log(x);
                        $(window).scrollTop(tempScrollTop);
                        $("#"+x).toggleClass("hidden");
                    }
                </script>
                        <?php
                        if($_POST["searchUser"]) {
                            $sqlSearch = "SELECT `username` FROM `users` WHERE `username` = '".$_POST["search"]."';";
                            $resultSearch = mysqli_query($conn, $sqlSearch);
                            if(mysqli_num_rows($resultSearch) > 0) {
                                while($rowSearch = mysqli_fetch_assoc($resultSearch)) {
                                    $goto = $rowSearch["username"];
                                    page_redirect("?User=".$goto);
                                }
                            } else {
                                echo "Your search did not return any results";
                            }
                        }
                        
                        if(!(isset($_GET["User"]))) {
                            $profile = $_SESSION["name"];
                        } else {
                            $profile = $_GET["User"];
                        }

                        $sql = "SELECT * FROM `users` WHERE `username`='$profile';";
                        $result = mysqli_query($conn, $sql);
                        if(mysqli_num_rows($result) > 0) {
                            if($row = mysqli_fetch_assoc($result)) { ?>
                                <h2><?php echo $row["username"];?></h2>
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
                                    console.log("called del("+a+ ")");
                                }
                            });
                        }
                        function logout(a) {
                            $.ajax({
                                type: "POST",
                                url: '/ajax.php',
                                data: {action: 'logout', user: a},
                                success: function() {
                                    console.log("called logout("+a+ ")");
                                }
                            });
                        }
                        </script>
                        <?php 
                            $sqlF = "SELECT `follow` FROM `follows` WHERE `user`='".$_SESSION['name']."';";
                            $resultF = mysqli_query($conn, $sqlF);
                            $followers = mysqli_num_rows($resultF);
                            $foll = false;
                            if($followers > 0) {
                                while($rowF = mysqli_fetch_assoc($resultF)) {
                                    if($profile == $rowF["follow"]) {
                                        $foll = true;
                                    }
                                }
                            }
                            if($profile == $_SESSION["name"]) { ?>
                                <button type="button" name="logout" id="logout" onclick='logout(<?php echo "\"$profile\""; ?>)'>logout</button>
                            <?php } else if($foll) { ?>
                                <button type='button' name='unfollow' id='unfollow' onclick='unfollow(<?php echo "\"$profile\""; ?>)'>unfollow @<?php echo $profile ?></button>
                            <?php } else { ?>
                                <button type='button' name='follow' id='follow' onclick='follow(<?php echo "\"$profile\""; ?>)'>Follow @<?php echo $profile ?></button>
                            <?php }
                            }
                        ?>
                </div>
            </div>
            <div class='col-3'>
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
                                                                    "postID"=>$row2["postID"],
                                                                    "stamp"=>$row2["timestamp"]);
                                
                            }
                        }   
                        ksort($posts);
                    foreach(array_reverse($posts) as $elem) { 
                        $photoSQL = "SELECT * FROM `upload` WHERE `postID`=" . $elem["postID"] . ";";
                        $resultPhoto = mysqli_query($conn, $photoSQL);
                        $photoURL = "";
                        if (mysqli_num_rows($resultPhoto) > 0) {
                            while ($row3 = mysqli_fetch_assoc($resultPhoto)) {
                                $photoURL = $row3["imgLoc"];
                            }
                        }

                    ?>
                        <div class='project'>
                            <h2><?php echo $elem["title"]; ?></h2>
                            <p><?php echo $elem["description"]; ?></p>
                            <p>Rating: <?php if($elem["rating"] !== null){ echo $elem["rating"], " stars"; } else { echo "This project has not yet been rated"; } ?></p>
                            <p><?php echo "<a href=profile.php?User=".$elem["user"].">".$elem["user"]."</a>"; ?></p>
                            <?php if($photoURL !== ""){ ?>
                            <img src="uploads/<?php echo $photoURL; ?>"/>
                            <?php } ?>
                            <p>Estimated Time: <?php echo $elem["time"], " minutes"; ?></p>
                            <p>Estimated Cost: <?php echo "$", $elem["cost"]; ?></p>
                            <a id="expander<?php echo $x;?>" onclick="expander('details<?php echo $x; ?>')" href="javascript:void(0)">see more details...</a>
                            <div class='hidden' id='details<?php echo $x; ?>'>
                                <p>Materials List:</p>
                                <?php 
                                    $steps = explode("~", $elem["steps"]);
                                    $items = explode("~", $elem["materials"]);
                                    echo '<ul>';
                                    for($z = 1; $z < sizeof($items); $z++) {
                                        $contents = explode(",", $items[$z]);
                                        echo "<li><a href='".$contents[0]."' target='_blank'>".$contents[1]."</a></li>";
                                    }
                                    echo '</ul>';
                                ?>
                                <p>Procedure:</p>
                                <?php 

                                    echo '<ol>';
                                    for($y = 1; $y < sizeof($steps); $y++) {
                                        echo '<li>'.$steps[$y].'</li>';
                                    }
                                    echo '</ol>';
                                ?>
                                <p>Tips: <?php echo $elem["tips"]; ?></p>
                                
                                <p><?php echo date("F j, Y @ g:i a", strtotime($elem["stamp"])); ?></p>

                            </div>
                            <?php if(Token::check(Verify::get('token')) && $profile == $user->getName($conn, $_SESSION["name"])) { ?>
                            <button type='button' name='delete' id='delete' onclick='del(<?php echo $elem["postID"]; ?>)'>Delete Post</button>
                            <?php } ?>
                        </div>
                    <?php } ?>
            </div>
        </div>
    </body>
</html>
